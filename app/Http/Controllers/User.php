<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\SessionController;
use Dompdf\Dompdf;
use Session;
use \CloudConvert\Api;
use Image;



class User extends Controller
{

    public function viewInbox(Request $request,$upgid)
    {
        $user = Auth::user();
        // $inbox = \DB::table('inbox')->where('inbox.upg_id','=',$upgid)
        //             ->join('document','inbox.doc_id','=','document.doc_id')
        //             ->join('userpositiongroup as upg','document.userpositiongroup_upg_id','=','upg.upg_id')
        //             ->join('user as u','upg.user_user_id','=','u.user_id')
        //             ->join('group as g', 'upg.group_group_id','=','g.group_id')
        //             ->orderBy('inbox.date','desc')
        //             ->orderBy('inbox.time','desc')
        //             ->get();
        $inboxArray = array();
        $inboxDetailsArray = array();

        $inboxes = DB::table('inbox')->where('upg_id','=',$upgid)
                                          ->get();

             foreach ($inboxes as $inbox) {
            $inboxLog = DB::table('log as l')->where('l.inbox_id','=',$inbox->inbox_id)
                                        ->join('inbox as i','l.inbox_id','i.inbox_id')
                                        ->join('document as d','i.doc_id','d.doc_id')
                                        ->join('userpositiongroup as upg','d.userpositiongroup_upg_id','upg.upg_id')
                                        ->join('user as u','upg.user_user_id','u.user_id')
                                        ->join('group as g','upg.group_group_id','g.group_id')
                                        ->select('l.datetime', 'd.doc_id', 'd.docname','u.lastname', 'u.firstname','g.groupName','l.status')
                                        ->orderBy('l.datetime','desc')
                                        ->first();
            if($inboxLog!=NULL)
                $inboxArray[] = $inboxLog;

        }


       
        $numunread = getNumberOfUnread($upgid);
        $numinprogress = getNumberofInProgress($upgid);

        // return view("user/test",['inbox'=>$inbox,'User'=>$user,'numUnread'=>$numunread,'upgid'=>$upgid,'numinprogress'=>$numinprogress]);
        return view("user/test",['inboxArray'=>$inboxArray,'User'=>$user,'numUnread'=>$numunread,'upgid'=>$upgid,'numinprogress'=>$numinprogress]);
        // echo "<pre>";
        // var_dump($inboxArray);
    }
       
    public function approvedoc2($upgid, $docid)
    {
         date_default_timezone_set('Asia/Manila');
        $user = Auth::user();
        $datetime = date('M d, Y H:i:s a');
        //$time = date('h:i a');

           //get transaction info of current step
        $currentstepinfos = DB::table('transaction')->where('document_doc_id','=',$docid)->where('upg_id','=',$upgid)->get();

        foreach ($currentstepinfos as $currentstepinfo) {
            $currentsteporder = $currentstepinfo->order;
            $currentsteptranid = $currentstepinfo->tran_id;
        }

        DB::table('log')->insert(['tran_id'=>$currentsteptranid,
                                'status'=>'approved',
                                'datetime'=>$datetime]);

              $signature = DB::table('transaction as t')
                     ->where('t.document_doc_id','=',$docid)
                     // ->where("t.status","=","approved")
                     ->join("log","t.tran_id","log.tran_id")
                     ->where("log.status","approved")
                     ->join("userpositiongroup as upg",'t.upg_id',"=",'upg.upg_id')
                     ->join('position as p','upg.position_pos_id',"=",'p.pos_id')
                     ->join("user as u","upg.user_user_id","=","u.user_id")
                     ->get(); //Added

                //get tran_id approve
                $approvetran = DB::table('log')->where('tran_id','=',$currentsteptranid)
                                                      ->orderBy('datetime')
                                                      ->first();
                 // $signature = DB::table('transaction as t')
                 //     ->where('t.document_doc_id','=',$docid)
                 //     ->join('log as l','t.tran_id','l.tran_id')
                 //     ->where('l.log_id','=',$approvetran->log_id)
                 //     ->where("l.status","=","approved")
                 //     ->join("userpositiongroup as upg",'t.upg_id',"=",'upg.upg_id')
                 //     ->join('position as p','upg.position_pos_id',"=",'p.pos_id')
                 //     ->join("user as u","upg.user_user_id","=","u.user_id")
                 //     ->get(); //Added

        $position = DB::table("position")->get();
        $upg= session()->get('upgid');

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('file/'.$docid.'.docx');
        $variable = $templateProcessor->getVariables();

       
       foreach($signature as $signatures)
        {
            foreach($variable as $variables)
            {
                if($variables == $signatures->posName)
                {
                    if($signatures->signature == NULL)
                    {
                        $templateProcessor->setValue($variables,"Approved");
                        $templateProcessor->setValue($variables."-Name",$signatures->lastname.", ".$signatures->firstname);
                        $templateProcessor->setValue($variables."-Position",$signatures->posName);
                    }
                    else
                    {
                        //Image Resize
                        $img = Image::make($signatures->signature);
                        $img->resize(100, 100);
                        $img->save($signatures->signature);
                        $templateProcessor->setImg($variables, ["src"=>$signatures->signature]);
                        $templateProcessor->setValue($variables."-Name",$signatures->lastname.", ".$signatures->firstname);
                        $templateProcessor->setValue($variables."-Position",$signatures->posName);
                    }
                }
            }
        }
        $templateProcessor->saveAs('temp/'.$docid.'.docx');

    //     done
    //     F1i2XV0-j4T28Ca9Ws8SEoC3vemDk3EHtHbMjhuldxLb76e5Mm6xopi-i4nxtNRG02xOCZ7s-Y5D1ybJSjSRdw
    // Accounts
    // LT0JZLv5hHtw7DLL6Ojo4h4cAfP6W8CBsHdjYAuw1Ki_09T0dApTNS--6vtPMH9BnzSwB5JfiGfiJDAuFZV4ag

    $api = new Api("F1i2XV0-j4T28Ca9Ws8SEoC3vemDk3EHtHbMjhuldxLb76e5Mm6xopi-i4nxtNRG02xOCZ7s-Y5D1ybJSjSRdw");
    $api->convert
    ([
        'inputformat' => 'docx',
        'outputformat' => 'pdf',
        'input' => 'upload',
        'file' => fopen('temp/'.$docid.'.docx', 'r'),
    ])
    ->wait()
    ->download('temp/'.$docid.'.pdf');

        //get next steps of current order where status is still pending
        // $nextsteps = DB::table('transaction as t')->where('t.document_doc_id','=',$docid)
        //                                         ->where('t.order','=',$currentsteporder+1)
        //                                         //->where('t.status','=','pending')
        //                                         ->join('workflowsteps as ws','t.wd_id','ws.ws_id')
        //                                         ->get();

        $nextsteps = DB::table('transaction as t')->where('t.document_doc_id','=',$docid)
                                                ->where('t.order','=',$currentsteporder+1)
                                                ->join('workflowsteps as ws','t.wd_id','ws.ws_id')
                                                ->get();

      
        //get how many transactions that has the same order as current transaction
        $samesteptranscount = DB::table('transaction')->where('document_doc_id','=',$docid)
                                                      ->where('order','=',$currentsteporder)
                                                      ->count();


         //get how many transactions that has the same order as current transaction and is approved     
         // $samesteptranscountapproved = DB::table('transaction as t')->where('t.document_doc_id','=',$docid)
         //                                              ->where('t.order','=',$currentsteporder)
         //                                              ->join('log as l','t.tran_id','log.tran_id')
         //                                              ->where('l.status','=','approved')
         //                                              ->count();   


         $samesteptranscountapproved = 0;
         $samesteptrans = DB::table('transaction')->where('document_doc_id','=',$docid)
                                                ->where('order','=',$currentsteporder)
                                                ->get();
            foreach ($samesteptrans as $value) {
                $samesteptranstran_id = $value->tran_id;
                $samesteptranslog = DB::table('log')->where('tran_id','=',$samesteptranstran_id)
                                            ->orderBy('datetime','desc')
                                             ->first();

                    if($samesteptranslog->status=="approved")
                        $samesteptranscountapproved++;

                 
               
            }

                  
               
          $nextarray = array(); //to store next steps

         if($samesteptranscount==$samesteptranscountapproved){
         foreach ($nextsteps as $nextstep) {

             if($nextstep->action=="cc") //if next step is cc
             {

                //update status to approve if cc
              DB::table('transaction')->where('tran_id','=',$nextstep->tran_id)->update(['status'=>'approved',
                                                                                        'date'=>$date,
                                                                                        'time'=>$time]);


                // $randLog = rand(1,9999);
                 date_default_timezone_set('Asia/Manila');
                $datetime = date('M d, Y H:i:s a');
                DB::table('log')->insert(['tran_id'=>$nextstep->tran_id,
                                            'status'=>'approved',
                                            'datetime'=>$datetime]);
                //count how many steps has the same order as the cc nextstep where action= sign
                $samestepsigncount = DB::table('transaction as t')->where('t.document_doc_id','=',$docid)
                                                        ->where('t.order','=',$nextstep->order)
                                                        ->join('workflowsteps as ws','t.wd_id','ws.ws_id')
                                                        ->where('ws.action','=',"sign")
                                                         ->count();
                if($samestepsigncount==0) //if there are no sign steps then go to next's next step
                {
                    $nextnextarray = array();
                    $finalnextnextarray = array();
                    //get next's next step
                    $nextnextsteps = DB::table('transaction')->where('document_doc_id','=',$docid)
                                            ->where('order','=',$nextstep->order + 1)
                                            ->get();
                    foreach ($nextnextsteps as $nextnextstep) {
                        //insert these to array
                        $nextnextarray[] = $nextnextstep->upg_id;
                    }
                    $finalnextnextarray = array_unique($nextnextarray);
                    $this->insertToNextInbox($docid,$upgid,$finalnextnextarray);
                }
                echo "<pre>";
                var_dump($samestepcount);

            }
            
             //insert these next steps into the array
            $nextarray[] = $nextstep->upg_id; 
         }
     }

            // echo "<pre>";
            //     var_dump($nextarray);

               
          $finalnextarray = array_unique($nextarray); //remove duplicate array values

          //count how many transactions that has the same order as the current transaction
            $currenttranscount = DB::table('transaction')->where('document_doc_id','=',$docid)
                                                        ->where('order','=',$currentsteporder)
                                                        ->count();

            //count how many transactions that has the same order as the current transaction has been approved
             // $transapprovedcount = DB::table('transaction')->where('document_doc_id','=',$docid)
             //                                            ->where('order','=',$currentsteporder)
             //                                            ->where('status','=','approved')
             //                                            ->count(); 



            $transdocinfo = DB::table('transaction')->where('document_doc_id','=',$docid)
                                                        ->where('order','=',$currentsteporder)
                                                        ->get();
            $transapprovedcount = 0;
            foreach ($transdocinfo as $key) {
                $doctran_id = $key->tran_id;

                $transapproved = DB::table('log')->where('tran_id','=',$doctran_id)
                                            ->orderBy('datetime','desc')
                                            ->first();
                if($transapproved->status=="approved")
                    $transapprovedcount++;
            }



                    $userid = $user->user_id;
        $upg_user = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$upgid)
                                                         ->where('upg.user_user_id','=',$userid)
                                                         ->get();
   


            if($currenttranscount==$transapprovedcount){
                 //to get tran_id of next steps for log insert
                foreach ($nextsteps as $nextstep) {
                    $nextsteptran_id = $nextstep->tran_id;

                    // $randLog = rand(1,9999);
                    DB::table('log')->insert(['tran_id'=>$nextsteptran_id,
                                                'inbox_id'=>NULL,
                                                'status'=>'pending',
                                                'datetime'=>$datetime]);
                }
                return $this->insertToNextInbox($docid,$upgid,$finalnextarray);
            }
            else
                return redirect()->route('docView',['upgid'=>$upgid,'docid'=>$docid]);
    }

    public function insertToNextInbox($docid,$upgid,$nextarray)
    {
        // $user = Auth::user();
         date_default_timezone_set('Asia/Manila');
        $datetime = date('M d, Y H:i:s a');

       
       for ($i=0; $i < sizeof($nextarray); $i++) { 

         //check if inbox of upgid already exists
        $upgInboxes = DB::table('inbox')->where('doc_id','=',$docid)
                                      ->where('upg_id','=',$nextarray[$i])
                                      ->get();


        if(count($upgInboxes) == 0){
             DB::table('inbox')->insert(['doc_id'=>$docid,
                                        'upg_id'=>$nextarray[$i]]);

             //get inbox_id of new inbox
             
              $newinbox = DB::table('inbox')->where('doc_id','=',$docid)
                                            ->where('upg_id','=',$nextarray[$i])
                                            ->get();
            
             
                foreach ($newinbox as $inbox) {
                    $inbox_id = $inbox->inbox_id;
                }
          }
          else
          {
            foreach ($upgInboxes as $upgInbox) {
              $inbox_id = $upgInbox->inbox_id;
            }
          }

                //insert to log as unread
                DB::table('log')->insert(['tran_id'=>NULL,
                                            'inbox_id'=>$inbox_id,
                                            'status'=>'unread',
                                            'datetime'=>$datetime]);
              
       }


        // echo "<pre>";
        // var_dump($nextarray);
       // $totalTrans = $this->getTotalTrans($docid);
       //  $currentNumApprove = $this->getTotalApprove($docid); 

        $transaction = DB::table("transaction")->where("document_doc_id",$docid)->get();
        $transactionTotal = DB::table("archive")->where("docid",$docid)->count();
        

        foreach ($transaction as $transactions) 
        {

           
            $transactionstran_id = $transactions->tran_id;
            $transactionlogs = DB::table('log')->where('tran_id','=',$transactionstran_id)
                                            ->orderBy('datetime','desc')
                                             ->first();

                     if($transactionlogs!=NULL)
                     {
                          if($transactionlogs->status == "pending")
                        $temp = 1;
                    else
                        $temp = 0;
                        //  echo "<pre>";
                        // var_dump($transactionlogs->status);

                     }
        
           
        }
      

            if($temp == 0 and $transactionTotal == 0)
            {
                return $this->archive($upgid,$docid);
            }
            else
                return redirect()->route('docView',['upgid'=>$upgid,'id'=>$docid]);
    }
                

    public function rejectdoc($upgid,$docid){
        $user = Auth::user();
        $randArchive = rand(1,9999);
        date_default_timezone_set('Asia/Manila');
        $datetime = date('M d, Y H:i:s a');

        $docTransactions = \DB::table('transaction')->where('document_doc_id','=',$docid)
                                                    ->where('upg_id','=',$upgid)
                                                    ->get();
        foreach ($docTransactions as $docTransaction){
          $tranid = $docTransaction->tran_id;

        }

        // $randforLog = rand(1,99999);
        DB::table('log')->insert(['tran_id'=>$tranid,
                                  'inbox_id'=>NULL,
                                  'status'=>'rejected',
                                  'datetime'=>$datetime]);
      
        $previousReceivers = array();
        $upgtran_id = DB::table('transaction')->where('document_doc_id','=',$docid)
                                            ->where('upg_id','=',$upgid)
                                            ->get();
        foreach ($upgtran_id as $key) {
            $rejecttran_id = $key->tran_id;
            $upgOrder = $key->order;
        }
        // $randLog = rand(1,99999);
        // DB::table('log')->insert(['log_id'=>$randLog,
        //                             'tran_id'=>$rejecttran_id,
        //                             'status'=>'rejected',
        //                             'datetime'=>$datetime]);

        if($upgOrder==1)
            \DB::table('archive')->insert(['idarchive'=>$randArchive, 'docid'=>$docid]);
        else
        {
            $previousTransactions = DB::table('transaction as t')->where('t.document_doc_id','=',$docid)
                                    ->where('t.order','=',$upgOrder-1)
                                    ->join('workflowsteps as ws','t.wd_id','ws.ws_id')
                                    ->get();

            //count number of cc previous transactions
            $numberOfPrevCC = 0;
            foreach ($previousTransactions as $ccprevious) {
                if($ccprevious->action=="cc")
                    $numberOfPrevCC++;
            }

                //if previous transactions are all cc
              if($numberOfPrevCC == count($previousTransactions))
                {
                    $ccPreviousTransactions = DB::table('transaction')->where('document_doc_id','=',$docid)
                                    ->where('order','=',$upgOrder-2)
                                    ->get();

                    foreach ($ccPreviousTransactions as $ccPreviousTransaction) {
                        $previousReceivers[] = $ccPreviousTransaction->tran_id;
                    }
                }
                else
                {
                      foreach ($previousTransactions as $previousTransaction) {
                            if($previousTransaction->action=="sign")
                                $previousReceivers[] = $previousTransaction->tran_id;
                        }
                }

        }

        for($i=0;$i<count($previousReceivers);$i++)
        {
            $prevReceivers = DB::table('transaction')->where('tran_id','=',$previousReceivers[$i])
                                                    ->get();
            foreach ($prevReceivers as $prevReceiver) {
                //pending to previous transaction again
                $previoustransaction = DB::table('transaction')->where('document_doc_id','=',$docid)
                                                            ->where('upg_id','=',$prevReceiver->upg_id)
                                                            ->get();
                foreach ($previoustransaction as $previous) {
                    $tran_id = $previous->tran_id;
                }
                // $randLog = rand(1,99999);
                DB::table('log')->insert(['tran_id'=>$tran_id,
                                            'inbox_id'=>NULL,
                                            'status'=>'pending',
                                            'datetime'=>$datetime]);

                //unread to its inbox
                $previousinbox = DB::table('inbox')->where('doc_id','=',$docid)
                                                ->where('upg_id','=',$prevReceiver->upg_id)
                                                ->get();
                foreach ($previousinbox as $inbox) {
                    $inbox_id = $inbox->inbox_id;
                }
                // $randLog2 = rand(1,9999);
                DB::table('log')->insert(['tran_id'=>NULL,
                                            'inbox_id'=>$inbox_id,
                                            'status'=>'unread',
                                            'datetime'=>$datetime]);
            }
           
        }
            
        // echo "<pre>";
        // var_dump($previousReceivers);

         // return redirect()->route("viewInbox",['groupid'=>Session::get('groupid')]);
         return redirect()->route('docView',['upgid'=>$upgid,'id'=>$docid]);  
    }

    public function archive($upgid,$docid)
    {
       $rand = rand(100,10000);
        $senders = \DB::table('document')->where('doc_id','=',$docid)->get();

        foreach ($senders as $sender) {
           $sendee=$sender->userpositiongroup_upg_id;
        }

        \DB::table('archive')->insert(['idarchive'=>$rand, 'docid'=>$docid]);
        return redirect()->route('docView',['upgid'=>$upgid,'id'=>$docid]);
    }

    public function getTotalTrans($docid){

        $counting=\DB::table('transaction')->where('document_doc_id','=',$docid)->count();
        return $counting;
    }

    public function getTotalApprove($docid){

        $countapprove = 0;
        // $countapprove=\DB::table('transaction')->where('document_doc_id','=',$docid)->where('status','=','approved')->count();
        $doctrans = DB::table('transaction')->where('document_doc_id','=',$docid)->get();
        foreach ($doctrans as $doctran) {
            $doctran_id = $doctran->tran_id;
            $doctranslog = DB::table('log')->where('tran_id','=',$doctran_id)
                                        ->orderBy('datetime','desc')
                                        ->first();
                if($doctranslog->status=="approved")
                    $countapprove++;
        }
        return $countapprove;
    }
     public function getClientId($userid)
    {
        $clientgroup = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                                                            ->distinct()
                                                            ->get();
        return $clientgroup;
    }

    public function insertInboxAfterApprove($docid,$node,$upgid)
    {
        $user = Auth::user();
         date_default_timezone_set('Asia/Manila');
        $date = date('M d, Y');
        $time = date('H:i:sa');
        $rec = array();
        //START HERE
         for ($z=0;$z<count($node);$z++) {
            $send = DB::table('transaction')->where([['document_doc_id','=',$docid],['tran_id','=',$node[$z]]])
                    ->join('userpositiongroup as upg','transaction.upg_id','=','upg.upg_id')
                    ->join('user','upg.user_user_id','=','user.user_id')
                    ->get();

        foreach($send as $sends){
            DB::table('inbox')->insert(["istatus"=>"unread",
                                        "upg_id"=>$sends->upg_id,
                                        "doc_id"=>$sends->document_doc_id,
                                        "time"=>$time,
                                        "date"=>$date]);
            $send = json_decode(json_encode($send),TRUE);
            $rec[] = $send;    

          }
         
            
         }
        
         return redirect()->route('docView',['upgid'=>$upgid,'id'=>$docid]);
         //return "ok.";
    }


    //count all next with the given docu id with the same nexts
    public function countAllNext($docid,$next)//parameter is document id, and $nxt array
    {
        $nxtcount = 0;
        // for($a=0;$a<count($next);$a++){
        $result = DB::table('transaction')->where('document_doc_id','=',$docid)->where('next','=',$next)->get();
        foreach ($result as $res) {
            $nxtcount++;
        }
    // }
        //echo "".$docid.", ".$next;
        return $nxtcount;
    }
    //count all approved with the same nexts and docu id
    public function countAllApproved($docid,$next) //parameter is docu id, and $nxt array
    {
        $appCount = 0;
        // for($b=0;$b<count($next);$b++){
         $result = DB::table('transaction')->where('document_doc_id','=',$docid)->where('next','=',$next)->get();
         foreach ($result as $res) {
             if($res->status=='approved')
                $appCount++;
         }
         return $appCount;
    }

    public function sent($upgid)
    {
                        $user = Auth::user();
    $userid = $user->user_id;


    $view = \DB::table('userpositiongroup')->where('user_user_id','=',$userid)
    ->get();
    foreach($view as $views){
        $upgID= $views->upg_id;
     }

    $view1 =\DB::table('transaction')->where('upg_id','=',$upgID)->get();

    $documentname =\DB::table('document')
    ->where('document.userpositiongroup_upg_id','=',$upgID)
    ->orderBy('document.sentDate','desc')
    ->orderBy('document.sentTime','desc')
    ->get();


    $getarchives = \DB::table('archive')->get();

    $getarchivearray =  array();
    foreach ($getarchives as $getarchive) {
        $getarchivearray[]=$getarchive->docid;
    }
    
    foreach ($documentname as $key) {
        $docid = $key->doc_id;
        //$datetime = \DB::table('inbox')->where('doc_id','=',$docid)->first();    
    }

     $numunread = getNumberOfUnread($upgid);
     $numinprogress = getNumberofInProgress($upgid);

    
    return view('user/sentDocs',['documentname'=>$documentname,'User'=>$user,'upgid'=>$upgid, 'getarchivearray'=>$getarchivearray,'numUnread'=>$numunread,'numinprogress'=>$numinprogress]);
                 
    }

    public function complete($upgid){

        $user = Auth::user();
        $userid = $user->user_id;

        
        $view = \DB::table('document')
        ->where('document.userpositiongroup_upg_id','=',$upgid)
        ->join('archive','document.doc_id','=','archive.docid')
        ->get();

        $numunread = getNumberOfUnread($upgid);
        $numinprogress = getNumberofInProgress($upgid);

        return view('user/completedocs',['completedoc'=>$view, 'User'=>$user, 'upgid'=>$upgid,'numUnread'=>$numunread,'numinprogress'=>$numinprogress]);

    }
    public function completeview($upgid,$id){
               
        $arr = array();
        $user = Auth::user();
        $name= \DB::table("transaction")
                    ->where('document_doc_id','=',$id)
                    ->join('userpositiongroup','transaction.upg_id','=','userpositiongroup.upg_id')
                    ->join('user','userpositiongroup.user_user_id','=','user.user_id')
                    ->get();


     $statuss=\DB::table("transaction")
     ->where('transaction.document_doc_id','=',$id)
    ->join('userpositiongroup','transaction.upg_id','=','userpositiongroup.upg_id')
    ->join('user','userpositiongroup.user_user_id','=','user.user_id')
    ->orderBy('transaction.order')
    ->get();

    $inboxstatus = DB::table('inbox')->where('doc_id','=',$id)
                   ->get();

    $statusarray = array();
    foreach ($statuss as $currentstatus) {
      //for approval status
      $tranApprovalStatus = DB::table('transaction as t')->where('t.tran_id','=',$currentstatus->tran_id)
                                                        ->join('log as l','t.tran_id','=','l.tran_id')
                                                        ->orderBy('l.datetime','desc')
                                                        ->first();
          if($tranApprovalStatus!=NULL)
       {
        $datetime = $tranApprovalStatus->datetime;
        if($tranApprovalStatus->status=="approved")
          $latestStatus = "approved";
        else if($tranApprovalStatus->status=="rejected")
          $latestStatus = "rejected";
        else if($tranApprovalStatus->status=="pending"){
          $latestStatus = "pending";
          $datetime = "";
        }
       } 
        else{
          $latestStatus="";
          $datetime="";
        }
          
          //for seen status
          $tranSeenStatus = DB::table('inbox as i')->where('i.doc_id','=',$id)
                                                  ->where('i.upg_id','=',$currentstatus->upg_id)
                                                  ->join('log as l','i.inbox_id','l.inbox_id')
                                                  ->orderBy('l.datetime','desc')
                                                  ->first();
            if($tranSeenStatus!=NULL)
            {
               if($tranSeenStatus->status=="unread")
               {
                  $latestSeen = "unread";
                  $seendatetime = "";
               }
              else if($tranSeenStatus->status=="read"){
                $latestSeen = "read";
                $seendatetime = $tranSeenStatus->datetime;
              }
            }
            else{
              $latestSeen = "";
              $seendatetime = "";
            }
                


            $statusarray[$currentstatus->order][] = array('lastname'=>$currentstatus->lastname,
                                    'firstname'=>$currentstatus->firstname,
                                    'approvestatus'=>$latestStatus,
                                    'seenstatus'=>$latestSeen,
                                    'datetime'=>$datetime,
                                    'seendatetime'=>$seendatetime);

    }

    // echo "<pre>";
    // var_dump($statusarray);

   //order status 
    $docInfo = \DB::table("document")->where("doc_id",'=',$id)->get();

     if(file_exists($_SERVER['DOCUMENT_ROOT'].'/temp/'.$id.'.pdf'))      
        $pdf = "/temp/".$id.".pdf";   
     else
        $pdf = "/pdf/".$id.".pdf";

    //get maximum order of  document in a transaction
    $last_order = DB::table('transaction')->where('document_doc_id','=',$id)->max('order');

    $numunread = getNumberOfUnread($upgid);
    $numinprogress = getNumberofInProgress($upgid);

    $docwf = sortTransaction($id);

    $comments = \DB::table('comment as c')->where('c.comment_doc_id','=',$id)
                                     ->join('userpositiongroup as upg','c.comment_upg_id','=','upg.upg_id')
                                     ->join('user','upg.user_user_id','=','user.user_id') 
                                     ->get();
  
     //view document logs

    $approveLogsArray = array();
    $readLogsArray = array();
    $readApproveArray = array();

    $approveLogs = DB::table('log as l')->join('transaction as t','l.tran_id','t.tran_id')
                                    ->where('t.document_doc_id','=',$id)
                                    ->join('userpositiongroup as upg','t.upg_id','upg.upg_id')
                                    ->join('user as u','upg.user_user_id','u.user_id')
                                    ->select('l.status','u.lastname','u.firstname','l.datetime','l.log_id')
                                    ->orderBy('l.datetime')
                                    ->get();
      foreach ($approveLogs as $approve) {
        $userInvolved = $approve->firstname." ".$approve->lastname;
        $approveLogsArray[] = array('log_id'=>$approve->log_id,'datetime'=>$approve->datetime,'status'=>$approve->status,'user'=>$userInvolved);
      }

    $readLogs = DB::table('log as l')->join('inbox as i','l.inbox_id','i.inbox_id')
                                    ->where('i.doc_id','=',$id)
                                    ->join('userpositiongroup as upg','i.upg_id','upg.upg_id')
                                    ->join('user as u','upg.user_user_id','u.user_id')
                                    ->select('l.status','u.lastname','u.firstname','l.datetime','l.log_id')
                                    ->orderBy('l.datetime')
                                    ->get();
      foreach ($readLogs as $read) {
        $userInvolved = $read->firstname." ".$read->lastname;
        $readLogsArray[] = array('log_id'=>$read->log_id,'datetime'=>$read->datetime,'status'=>$read->status,'user'=>$userInvolved); 
      }

      //sort merged array
      function cmp($a,$b)
      {
        $ad = strtotime($a['datetime']);
        $bd = strtotime($b['datetime']);
        return ($ad-$bd);
      }
      $readApproveArray = array_merge($readLogsArray,$approveLogsArray);
       usort($readApproveArray,function($item1, $item2){
      return $item2['log_id'] - $item1['log_id'];
    });


    //return $latestStatus." and ".$latestSeen;
    return view("user/archive",["name"=>$name,"statuss"=>$statuss,'User'=>$user,"pdf"=>$pdf,'docinfos'=>$docInfo,'upgid'=>$upgid,'lastOrder'=>$last_order,'numUnread'=>$numunread,'numinprogress'=>$numinprogress,'docwf'=>$docwf,'comments'=>$comments,'statusarray'=>$statusarray,'logsArray'=>$readApproveArray]);

      // echo "<pre>";
      // var_dump($readApproveArray);
    }

    public function track($upgid,$id){
        
        $arr = array();
        $user = Auth::user();
        $name= \DB::table("transaction")
                    ->where('document_doc_id','=',$id)
                    ->join('userpositiongroup','transaction.upg_id','=','userpositiongroup.upg_id')
                    ->join('user','userpositiongroup.user_user_id','=','user.user_id')
                    ->get();


     $statuss=\DB::table("transaction")
     ->where('transaction.document_doc_id','=',$id)
    //->join('document','transaction.document_doc_id','=','document.doc_id')
    //->join('log','transaction.tran_id','log.tran_id')
    ->join('userpositiongroup','transaction.upg_id','=','userpositiongroup.upg_id')
    ->join('user','userpositiongroup.user_user_id','=','user.user_id')
    //->select('log.status','user.lastname','user.firstname','log.datetime','document.template_template_id','transaction.order','userpositiongroup.upg_id')
    ->orderBy('transaction.order')
    ->get();

    $inboxstatus = DB::table('inbox')->where('doc_id','=',$id)
                   ->get();

    $statusarray = array();
    foreach ($statuss as $currentstatus) {
      //for approval status
      $tranApprovalStatus = DB::table('transaction as t')->where('t.tran_id','=',$currentstatus->tran_id)
                                                        ->join('log as l','t.tran_id','=','l.tran_id')
                                                        ->orderBy('l.datetime','desc')
                                                        ->first();
          if($tranApprovalStatus!=NULL)
       {
        $datetime = $tranApprovalStatus->datetime;
        if($tranApprovalStatus->status=="approved")
          $latestStatus = "approved";
        else if($tranApprovalStatus->status=="rejected")
          $latestStatus = "rejected";
        else if($tranApprovalStatus->status=="pending"){
          $latestStatus = "pending";
          $datetime = "";
        }
       } 
        else{
          $latestStatus="";
          $datetime="";
        }
          
          //for seen status
          $tranSeenStatus = DB::table('inbox as i')->where('i.doc_id','=',$id)
                                                  ->where('i.upg_id','=',$currentstatus->upg_id)
                                                  ->join('log as l','i.inbox_id','l.inbox_id')
                                                  ->orderBy('l.datetime','desc')
                                                  ->first();
            if($tranSeenStatus!=NULL)
            {
               if($tranSeenStatus->status=="unread")
               {
                  $latestSeen = "unread";
                  $seendatetime = "";
               }
              else if($tranSeenStatus->status=="read"){
                $latestSeen = "read";
                $seendatetime = $tranSeenStatus->datetime;
              }
            }
            else{
              $latestSeen = "";
              $seendatetime = "";
            }
                


            $statusarray[$currentstatus->order][] = array('lastname'=>$currentstatus->lastname,
                                    'firstname'=>$currentstatus->firstname,
                                    'approvestatus'=>$latestStatus,
                                    'seenstatus'=>$latestSeen,
                                    'datetime'=>$datetime,
                                    'seendatetime'=>$seendatetime);

    }

    // echo "<pre>";
    // var_dump($statusarray);

   //order status 
    $docInfo = \DB::table("document")->where("doc_id",'=',$id)->get();

     if(file_exists($_SERVER['DOCUMENT_ROOT'].'/temp/'.$id.'.pdf'))      
        $pdf = "/temp/".$id.".pdf";   
     else
        $pdf = "/pdf/".$id.".pdf";

    //get maximum order of  document in a transaction
    $last_order = DB::table('transaction')->where('document_doc_id','=',$id)->max('order');

    $numunread = getNumberOfUnread($upgid);
    $numinprogress = getNumberofInProgress($upgid);

    $docwf = sortTransaction($id);

    $comments = \DB::table('comment as c')->where('c.comment_doc_id','=',$id)
                                     ->join('userpositiongroup as upg','c.comment_upg_id','=','upg.upg_id')
                                     ->join('user','upg.user_user_id','=','user.user_id') 
                                     ->get();

    //view document logs

    $approveLogsArray = array();
    $readLogsArray = array();
    $readApproveArray = array();

    $approveLogs = DB::table('log as l')->join('transaction as t','l.tran_id','t.tran_id')
                                    ->where('t.document_doc_id','=',$id)
                                    ->join('userpositiongroup as upg','t.upg_id','upg.upg_id')
                                    ->join('user as u','upg.user_user_id','u.user_id')
                                    ->select('l.status','u.lastname','u.firstname','l.datetime','l.log_id')
                                    ->orderBy('l.datetime')
                                    ->get();
      foreach ($approveLogs as $approve) {
        $userInvolved = $approve->firstname." ".$approve->lastname;
        $approveLogsArray[] = array('log_id'=>$approve->log_id,'datetime'=>$approve->datetime,'status'=>$approve->status,'user'=>$userInvolved);
      }

    $readLogs = DB::table('log as l')->join('inbox as i','l.inbox_id','i.inbox_id')
                                    ->where('i.doc_id','=',$id)
                                    ->join('userpositiongroup as upg','i.upg_id','upg.upg_id')
                                    ->join('user as u','upg.user_user_id','u.user_id')
                                    ->select('l.status','u.lastname','u.firstname','l.datetime','l.log_id')
                                    ->orderBy('l.datetime')
                                    ->get();
      foreach ($readLogs as $read) {
        $userInvolved = $read->firstname." ".$read->lastname;
        $readLogsArray[] = array('log_id'=>$read->log_id,'datetime'=>$read->datetime,'status'=>$read->status,'user'=>$userInvolved); 
      }

      //sort merged array
      function cmp($a,$b)
      {
        $ad = strtotime($a['datetime']);
        $bd = strtotime($b['datetime']);
        return ($ad-$bd);
      }

      $readApproveArray = array_merge($readLogsArray,$approveLogsArray);
      
    usort($readApproveArray,function($item1, $item2){
      return $item2['log_id'] - $item1['log_id'];
    });
     

    return view("user/fileStatus",["name"=>$name,"statuss"=>$statuss,'User'=>$user,"pdf"=>$pdf,'docinfos'=>$docInfo,'upgid'=>$upgid,'lastOrder'=>$last_order,'numUnread'=>$numunread,'numinprogress'=>$numinprogress,'docwf'=>$docwf,'comments'=>$comments,'statusarray'=>$statusarray,'logsArray'=>$readApproveArray]);

          // echo "<pre>";
          // var_dump($readApproveArray);
  
  }

    public function addFile(Request $request)
    {
         $name = Auth::user();
         $clients = $this->getClientId($name->user_id);
        foreach ($clients as $client) 
        {
            $clientId = $client->client_id;
        }
        $rand = rand(1,1000);
        $user = request()->all();
        $title = str_replace(" ", "_", $user['title']);
        $path = "templates/".$title.".docx";
        DB::table("template")->insert(["template_id"=>$rand,
                                       "templatename"=>$title,
                                       "template_path"=>$path,
                                       "group_group_id"=>$request['group'],
                                       "workflow_w_id"=>$request['wf'],
                                       "client_id"=>$clientId,
                                       "status"=>"active"]);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $user['text']);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('templates/'.$title.'.docx');

        //PDF RENDERER
        $dompdf= new Dompdf();
        $dompdf->loadHtml($user['text']);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("pdf/".$title.".pdf", $output);
        return redirect()->route("AdminTemplate");
    }

    

    public function chooseGroups($userid)
    {
        $name = Auth::user();
        $groups = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                    ->where('upg.upg_status','=','active')
                    ->join('group as g','upg.group_group_id','=','g.group_id')
                    ->join('rights as r','upg.rights_rights_id','=','r.rights_id')
                    ->join('position as p','upg.position_pos_id','=','p.pos_id')
                    ->get();
        //get client id
        $userClient = DB::table('userpositiongroup')->where('user_user_id','=',$userid)->get();
        foreach ($userClient as $clientId) {
          $userClientId = $clientId->client_id;
        }
        return view('user/chooseGroup',['User'=>$name,'usergroups'=>$groups,'clientId'=>$userClientId]);
    }
    
    public function index($upgid)
    {
        $clientid = \Session::get('client');
        $admingroup = getAdminGroup($upgid);
        $name = Auth::user();

        if($clientid==$admingroup)
        {
            $users = DB::table('user')->where('user.status','=','active')
                ->join('userpositiongroup as upg','user.user_id','=','upg.user_user_id')
                ->where('upg.client_id','=',$clientid)
                 ->select([DB::raw('DISTINCT(user.user_id)'),'user.lastname','user.firstname'])
                ->get();
        }
        else
        {
            $users = DB::table('user')->where('user.status','=','active')
                ->join('userpositiongroup as upg','user.user_id','=','upg.user_user_id')
                ->where('upg.group_group_id','=',$admingroup)
                ->select([DB::raw('DISTINCT(user.user_id)'),'user.lastname','user.firstname'])
                 ->get();
        }
    	
        $admingroup = getAdminGroup($upgid);
    	return view('admin/usermngmt',['users'=>$users,'User'=>$name,'upgid'=>$upgid,'admingroup'=>$admingroup]);
                
    }

    public function showUserProfile($upgid)
    {
        $user = Auth::user();
        $userinfos = DB::table('user')->where('user_id', $user->user_id)->get();

        $usergroups = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$user->user_id)
                                                    ->where('upg.upg_status','=','active')
                                                    ->join('position as p','upg.position_pos_id','p.pos_id')
                                                    ->join('group as g','upg.group_group_id','g.group_id')
                                                    ->join('rights as r','upg.rights_rights_id','r.rights_id')
                                                    ->get();

        return view('user/userprofile',['userid' => $user->user_id,
                                         'userinfos' => $userinfos,
                                         'User'=>$user,
                                          'usergroups'=>$usergroups,
                                        'upgid'=>$upgid]);

    }

    public function editUserProfile($upgid)
    {
        $name = Auth::user();
        $userinfos = DB::table('user')->where('user_id', $name->user_id)->get();
        return view('user/edituserprofile',['userid' => $name->user_id,
                                         'userinfos' => $userinfos,
                                         'User'=>$name,
                                        'upgid'=>$upgid]);
    }

    public function show($upgid,$id)
    {
        $name = Auth::user();
    	$userinfos = DB::table('user')->where('user_id', $id)->get();

        $usergroups = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$id)
                                                    ->where('upg.upg_status','=','active')
                                                    ->join('position as p','upg.position_pos_id','p.pos_id')
                                                    ->join('group as g','upg.group_group_id','g.group_id')
                                                    ->join('rights as r','upg.rights_rights_id','r.rights_id')
                                                    ->get();
        $admingroup = getAdminGroup($upgid);

    	return view('admin/userprofpage',['userid' => $id,
    									 'userinfos' => $userinfos,
                                         'User'=>$name,
                                          'usergroups'=>$usergroups,
                                        'upgid'=>$upgid,
                                        'admingroup'=>$admingroup]);
       
    }

    public function showForEdit($upgid,$id)
    {
        $name = Auth::user();
        $userinfos = DB::table('user')->where('user_id', $id)->get();
        $admingroup = getAdminGroup($upgid);
        return view('admin/userprofedit',['userid' => $id,
                                         'userinfos' => $userinfos,
                                         'User'=>$name,
                                        'upgid'=>$upgid,
                                        'admingroup'=>$admingroup]);
    }

    public function update(Request $request,$upgid,$id)
    {
        $name = Auth::user();
         if($request->profpic){
            $path = $request->profpic->store('users/pictures');
            $image = $request->profpic->hashName();
            DB::table('user')->where('user_id',$id)->update(['profilepic'=>$image]);
        }

        //get right of upgid
        $upginfos = DB::table('userpositiongroup')->where('upg_id','=',$upgid)->get();
        foreach ($upginfos as $upginfo) {
            $upgright = $upginfo->rights_rights_id;
        }

        //get info of user
        $userinfos = DB::table('user')->where('user_id','=',$id)->get();
        foreach ($userinfos as $userinfo) {
            $usersign = $userinfo->signature;
        }
        
         if(isset($request['sign']))
        {
             Storage::putFileAs("signature",$request['sign'],$id.".png");
             $signpath = "signature/".$id.".png";
        }
        else
            $signpath=$usersign;
        
        DB::table('user')->where('user_id',$id)->update(['firstname'=>$request['fname'],
                                                        'lastname'=>$request['lname'],
                                                        'email'=>$request['email'],
                                                        'gender'=>$request['gender'],
                                                        'address'=>$request['address'],
                                                        'signature'=>$signpath]);
                                                        // 'password'=>bcrypt($request['userpassword'])]);
        if($upgright==1)                                                           
            return $this->show($upgid,$id);
        else
            return redirect()->route('viewUserProfile',['upgid'=>$upgid])->with('edituserprof','User profile edited.');
    }

    public function findUser($groupid,$string)
    {
        $users = DB::table('user')->where('group_group_id','=',$groupid)->where('firstname','LIKE','%'.$string.'%')->orWhere('lastname','LIKE','%'.$string.'%')->get();

        return response()->json($users);
    }

    public function delete(Request $request)
    {
        $name = Auth::user();
        // validate if user is in a upg and is active.
        $upgs = DB::table('userpositiongroup')->where('user_user_id','=',$request['userid'])->where('upg_status','=','active')->get();
        $userUpgCount = count($upgs);

        if($userUpgCount>0)
            return redirect()->route('UserManage',['upgid'=>$request['upgid']])->with("activeuser","User still active in assigned group/s!");
        else
        {
            DB::table('user')->where('user_id',$request['userid'])->update(['status'=>'inactive']);
            // return $this->index($upgid);
             return redirect()->route('UserManage',['upgid'=>$request['upgid']])->with("userremoved","User removed.");
        }


    }

    public function goToGroup($groupid,$rightid)
    {
        $user = Auth::user();
        $userUpg = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$user->user_id)->where('upg.group_group_id','=',$groupid)
                    ->where('upg.rights_rights_id','=',$rightid)
                    ->join('rights as r','upg.rights_rights_id','=','r.rights_id')
                    ->get();

        foreach ($userUpg as $usersUpg) {
            $upgID = $usersUpg->upg_id;
            $rightid = $usersUpg->rights_rights_id;
            $right = $usersUpg->rightsName;
        }

        \Session::put('groupid',$groupid);
        \Session::put('upgid',$upgID);
        \Session::put('rightid',$rightid);
        //\Session::save();

        $gid = \Session::get('groupid');
        $upgid = \Session::get('upgid');
    
        if($right=="User")
            return redirect()->route('viewInbox',['upgid'=>$upgid]);
          // return $right;
        else if($right=="Admin")
           return redirect()->route('AdminDash',['upgid'=>$upgid]);

        // return $upgid;
    }

    public function showUserGroups($userid)
    {
        $groups = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                                                    ->join('position as p','upg.position_pos_id','p.pos_id')
                                                    ->join('group as g','upg.group_group_id','g.group_id')
                                                    ->join('rights as r','upg.rights_rights_id','r.rights_id')
                                                    ->get();

        return response()->json($groups);
    }

    public function showUserAccount($userid)
    {
        $userinfos = DB::table('user')->where('user_id','=',$userid)->get();

        return response()->json($userinfos);
    }
}
