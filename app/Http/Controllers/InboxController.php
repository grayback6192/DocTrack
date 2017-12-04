<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    //
    public function filterSent($status)
    {
    	$user = Auth::user();
    	$upg = \Session::get('upgid');
    	$userupg = getUserUPG($upg);

    	$result = array(); //for storing filter results;
    	$pendingdocuments = array(); //for storing pending documents
    	$completeddocuments = array(); //for storing completed documents
    	$rejecteddocuments = array(); //for storing rejected documents
        $alldocuments = array(); //store all documents

    	//get all documents sent by user
    	$sentDocs =\DB::table('document')->where('userpositiongroup_upg_id','=',$upg)->get();

    	foreach ($sentDocs as $sentDoc) {
    		$pendingdocs = $this->checkPending($sentDoc->doc_id);
    		$rejecteddocs  =$this->checkRejected($sentDoc->doc_id);

    		 if($pendingdocs==true && $rejecteddocs==false)
    		 	$pendingdocuments[] = $sentDoc;
    		 else if($pendingdocs==false && $rejecteddocs==false)
    		 	$completeddocuments[] = $sentDoc;
    		 else if($rejecteddocs==true)
    		 	$rejecteddocuments[] = $sentDoc;

    	}

    		 if($status=="pending"){
    		 	foreach ($pendingdocuments as $pendingdocument) {
    		 		$result[] = $pendingdocument;
    		 	}
    		 	
    		 }
    		 else if($status=="rejected")
    		 {
    		 	foreach ($rejecteddocuments as $rejecteddoc) {
    		 		$result[] = $rejecteddoc;
    		 	}
    		 }
    		 else if($status=="approved")
    		 {
    		 	foreach ($completeddocuments as $completeddoc) {
    		 		$result[] = $completeddoc;
    		 	}
    		 }
             else if($status=="all")
             {
                $alldocs = $this->getAllSent($upg);
                foreach ($alldocs as $alldoc) {
                    $result[] = $alldoc;
                }
             }


    	// return view('user/testblade',['User'=>$user,'sentDocs'=>$result]);
    		 return response()->json($result);
    }

    public function checkPending($docid) //check if there's any status of pending in that doc
    {
    	$pending = DB::table('transaction')->where('document_doc_id','=',$docid)->where('status','=','pending')->get();


    	if(count($pending)>0)
    		return true;
    	else if(count($pending)==0)
    		return false;
    }

    public function checkRejected($docid) //check if there's any status of rejected in that doc
    {
    	$rejected = DB::table('transaction')->where('document_doc_id','=',$docid)->where('status','=','rejected')->get();


    	if(count($rejected)>0)
    		return true;
    	else if(count($rejected)==0)
    		return false; 
    }

    public function getAllSent($upgid)
    {

         $documentname =\DB::table('document')
        ->where('document.userpositiongroup_upg_id','=',$upgid)
        ->orderBy('document.sentDate','desc')
        ->orderBy('document.sentTime','desc')
        ->get();

        return $documentname;
    }

    public function filterInbox($status)
    {
    	$user = Auth::user();
    	$upg = \Session::get('upgid');
    	$userupg = getUserUPG($upg);

    	$result = array(); //store result
    	$inboxread = array(); //store read inbox
    	$inboxunread = array(); //store unread inbox

    	//get inbox of user
    	$inbox = DB::table('inbox')->where('inbox.user_id','=',$user->user_id)
    								->join('document','inbox.doc_id','=','document.doc_id')
                    				->join('userpositiongroup as upg','document.userpositiongroup_upg_id','=','upg_id')
                    				->join('user as u','upg.user_user_id','=','u.user_id')
                   				    ->join('group as g', 'upg.group_group_id','=','g.group_id')
                   				    ->get();
        foreach ($inbox as $key) {
        	if($key->istatus=="unread")
        		$inboxunread[] = $key;
        	else if($key->istatus=="read")
        		$inboxread[] = $key;
        }

        if($status=="unread")
        {
        	foreach ($inboxunread as $unread) {
        		$result[] = $unread;
        	}
        }
        else if($status=="read")
        {
        	foreach ($inboxread as $read) {
        		$result[] = $read;
        	}
        }
        else if($status=="all")
        {
            $allInbox = $this->getAllInbox($user->user_id);
            foreach ($allInbox as $inbox) {
                $result[] = $inbox;
            }
        }

         return response()->json($result);
        // return view('user/testblade',['User'=>$user,'sentDocs'=>$result]);

    }

    public function getAllInbox($userid)
    {
         $inbox = \DB::table('inbox')->where('inbox.user_id','=',$userid)
                    ->join('document','inbox.doc_id','=','document.doc_id')
                    ->join('userpositiongroup as upg','document.userpositiongroup_upg_id','=','upg_id')
                    ->join('user as u','upg.user_user_id','=','u.user_id')
                    ->join('group as g', 'upg.group_group_id','=','g.group_id')
                    ->orderBy('inbox.date','desc')
                    ->orderBy('inbox.time','desc')
                    ->get();

        return $inbox;
    } 
}
