<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\SessionController;
use Dompdf\Dompdf;
use Session;


class User extends Controller
{
    public function countUnread($upgid) //new-- count unread docs in inbox
    {
        $numUnread = DB::table('inbox')->where('inbox.upg_id','=',$upgid)
                    ->where('istatus','=','unread')
                    ->count();

        return $numUnread;
    }

    public function viewInbox(Request $request,$upgid)
    {
        $user = Auth::user();
        $inbox = \DB::table('inbox')->where('inbox.upg_id','=',$upgid)
                    ->join('document','inbox.doc_id','=','document.doc_id')
                    ->join('userpositiongroup as upg','document.userpositiongroup_upg_id','=','upg.upg_id')
                    ->join('user as u','upg.user_user_id','=','u.user_id')
                    ->join('group as g', 'upg.group_group_id','=','g.group_id')
                    ->orderBy('inbox.date','desc')
                    ->orderBy('inbox.time','desc')
                    ->get();

        $numunread = $this->countUnread($upgid);

          return view("user/test",['inbox'=>$inbox,'User'=>$user,'numUnread'=>$numunread,'upgid'=>$upgid]);
    }
   
    public function approvedoc($upgid,$docid)
    {
         date_default_timezone_set('Asia/Manila');
        $user = Auth::user();
        $date = date('m-d-Y');
        $time = date('h:i:sa');

         //get transactions of the document
        $trans = \DB::table("transaction")->where('document_doc_id','=',$docid)->get();
        foreach ($trans as $tran) {
                    // $upgid = \DB::table('userpositiongroup as upg')
                    // ->where('upg.user_user_id','=',$user->user_id)
                    // ->get();
                    // foreach ($upgid as $key) {
                    //     $u_id = $key->upg_id;
                    // }

                    //update transaction status to approve of the signed in approver
            \DB::table('transaction')->where(['document_doc_id'=>$tran->document_doc_id])->where('upg_id','=',$upgid)
                ->update(['status'=>'approved',
                            'time'=>$time,
                            'date'=>$date]);
            }

             //get transactions of document where upg_id = upg_id of signed in approver to determine its next step
            $nxt = array();
                $next = DB::table('transaction')->where(['document_doc_id'=>$tran->document_doc_id])->where('upg_id','=',$upgid)
                    ->get();
                foreach ($next as $key) {
                    $currenttran = $key->tran_id; //current transaction id
                    $currenttranorder = $key->order; //current transaction order
                    $nexts = $key->next;
                    if(strpos($next,',')!== false) //if there are more than one nexts
                    {
                        $nxt = explode(',', $nexts); //result already in array
                    }
                    else //if there's only one next, put it in array 
                    {
                    $next1 = json_decode(json_encode($nexts),TRUE);
                    $nxt[] = $next1;
                }
            }

             $nxt2 = array();

               //get tran_id of the next/s
            for($x=0;$x<count($nxt);$x++){
                    $trans = DB::table('transaction as t')->where(['t.document_doc_id'=>$tran->document_doc_id])->where('t.wd_id','=',$nxt[$x])
                        ->join('workflowsteps as ws','t.wd_id','ws.ws_id')
                        ->get();

                foreach ($trans as $tran) {
                            //if next is cc
                            if($tran->action=="cc")
                            {
                                DB::table('transaction')->where('tran_id','=',$tran->tran_id)->update(['status'=>'approved',
                                                                                                        'time'=>$time,
                                                                                                        'date'=>$date]);

                                //get current step

                                //find how many steps has the same order as current step (which is nxt step of current transaction)
                                $thesamestepcount = 0;
                            $thesamesteps = DB::table('transaction')->where('document_doc_id','=',$tran->document_doc_id)
                                                        ->where('order','=',$tran->order)
                                                        ->get();
                            foreach ($thesamesteps as $thesamestep) {
                                $thesamesteporder = $thesamestep->order;
                                $thesamestepcount++;
                            }

                            $thesamestepnxtorder = $thesamesteporder + 1; //next order of current step

                            //max number of steps of workflow of document
                            $maxstep = DB::table('transaction')->where('document_doc_id','=',$tran->document_doc_id)->max('order');

                            if($thesamestepcount==1) //if only cc as nxt step of current transaction
                            {
                                //get current step
                                $csteps = DB::table('transaction')->where('document_doc_id','=',$tran->document_doc_id)
                                                                    ->where('order','=',$currenttranorder)
                                                                    ->get();

                                    $samecurrentstepcount = 0; //count how many steps in the current order

                                    foreach ($csteps as $cstep) {
                                             $samecurrentstepcount++;
                                         }

                                    if($samecurrentstepcount==1) //if only one step is in current order  
                                    {

                                        //what if the nxt order is beyond the no. of steps
                                         $nxttrans = DB::table('transaction')->where('document_doc_id','=',$tran->document_doc_id)
                                                        ->where('order','=',$thesamestepnxtorder)
                                                        ->get();

                                            //if thesamestepnxtorder<=maxstep, go to next next step from current order
                                             if($thesamestepnxtorder<=$maxstep){          
                                                foreach ($nxttrans as $nxttran) {
                                                        $nxt2[] = $nxttran->tran_id;
                                                }
                                                $nxt2[] = $tran->tran_id; //include trans id with cc too
                                            }
                                             else //else go to next order
                                                {
                                                    
                                                        $nxtcurrentorder = $currenttranorder + 1;
                                                        $currentnexts = DB::table('transaction as t')
                                                                            ->where('t.document_doc_id','=',$tran->document_doc_id)
                                                                            ->join('workflowsteps as ws','t.wd_id','ws.ws_id')
                                                                            ->where('t.order','=',$nxtcurrentorder)
                                                                            ->get();

                                                        foreach ($currentnexts as $currentnext) {
                                                            if($currentnext->action=="cc")
                                                            {
                                                                $nxt2[] = $currentnext->tran_id;
                                                            }
                                                            
                                                        }
                                                    
                                                }
                                                
                                    }
                                    else if($samecurrentstepcount>1) //if 2 or more steps in current order
                                    {
                                        $totalcsteps = 0;
                                        $totalapprovedcsteps = 0;
                                        foreach ($csteps as $cstep1) { //see if the number of approve == number of current steps
                                            $totalcsteps++;

                                            if($cstep1->status=="approved")
                                                $totalapprovedcsteps++;
                                        }

                                        if($totalcsteps==$totalapprovedcsteps)
                                        {
                                            // $cnxts = array();

                                            // foreach ($csteps as $cstep2) {
                                               
                                            //     $cnexts = $cstep2->next;
                                            //     if(strpos($csteps,',')!== false) //if there are more than one nexts
                                            //     {
                                            //         $cnxts = explode(',', $cnexts); //result already in array
                                            //     }
                                            //     else //if there's only one next, put it in array 
                                            //     {
                                            //         $next1 = json_decode(json_encode($cnexts),TRUE);
                                            //         $cnxts[] = $next1;
                                            //     }
                                            // }

                                            // $nxt2 = $cnxts;
                                             $nxttrans = DB::table('transaction')->where('document_doc_id','=',$tran->document_doc_id)
                                                        ->where('order','=',$thesamestepnxtorder)
                                                        ->get();

                                                if($thesamestepnxtorder<=$maxstep){ 
                                                    foreach ($nxttrans as $nxttran) {
                                                        $nxt2[] = $nxttran->tran_id;
                                                    }
                                                    $nxt2[] = $tran->tran_id;
                                                }
                                                else
                                                {
                                                    
                                                        $nxtcurrentorder = $currenttranorder + 1;
                                                        $currentnexts = DB::table('transaction as t')
                                                                            ->where('t.document_doc_id','=',$tran->document_doc_id)
                                                                            ->join('workflowsteps as ws','t.wd_id','ws.ws_id')
                                                                            ->where('t.order','=',$nxtcurrentorder)
                                                                            ->get();

                                                        foreach ($currentnexts as $currentnext) {
                                                            //if($currentnext->action=="cc"){
                                                                $nxt2[] = $currentnext->tran_id;
                                                            //}
                                                            
                                                        }
                                                    
                                                }

                                        }
                                          //return $nxt2;

                                    }

                             }
                             else if($thesamestepcount>1)
                             {
                                //get all steps with the same order as the step with cc
                                $sameordersteps = DB::table('transaction as t')
                                                    ->where('t.document_doc_id','=',$tran->document_doc_id)
                                                    ->join('workflowsteps as ws','t.wd_id','ws.ws_id')
                                                    ->where('t.order','=',$tran->order)
                                                    ->get();

                                    foreach ($sameordersteps as $sameorderstep) {
                                        if($sameorderstep->action=="cc"){
                                            $nxt2[] = $sameorderstep->tran_id;
                                        }
                                        
                                    }
                             }
                            // return $nxt2;
                            }
                            else{
                                //return "next is sign";
                                 $nxt2[] = $tran->tran_id;
                            }

                }

            }

            //  $poss= session()->get('upgid');
            // $docs = DB::table("document")->where('doc_id','=',$docid)->get();

             $allnxt = $this->countAllNext($docid,$nexts);
            $allapproved = $this->countAllApproved($docid,$nexts);
            $totalTrans = $this->getTotalTrans($docid);
            $currentNumApprove = $this->getTotalApprove($docid); 

            //   if($totalTrans == $currentNumApprove){
            //     return $this->archive($upgid,$docid);
            // }

           // return $allnxt." == ".$allapproved;
           //  return $nexts;

             if($allnxt==$allapproved)
                    return $this->insertInboxAfterApprove($docid,$nxt2,$upgid);
              else
                  return redirect()->route('docView',['upgid'=>$upgid,'id'=>$docid]);

                // return $upgid.", ".$docid;

    }

       
       

           


          
          
                        
                            //if next is cc
                            // if($tran->action=="cc"){
                            //     DB::table('transaction')->where('tran_id','=',$tran->tran_id)->update(['status'=>'approved',
                            //                                                                             'time'=>$time,
                            //                                                                             'date'=>$date]);

                            //     //find how many steps has the same order as current step
                            //     $thesamestepcount = 0;
                            // $thesamesteps = DB::table('transaction')->where('document_doc_id','=',$tran->document_doc_id)
                            //                             ->where('order','=',$tran->order)
                            //                             ->get();
                            // foreach ($thesamesteps as $thesamestep) {
                            //     $thesamesteporder = $thesamestep->order;
                            //     $thesamestepcount++;
                            // }

                            // $thesamestepnxtorder = $thesamesteporder + 1; //next order of current step

                            // if($thesamestepcount==1)
                            // {
                            //     $nxttrans = DB::table('transaction')->where('document_doc_id','=',$tran->document_doc_id)
                            //                             ->where('order','=',$thesamestepnxtorder)
                            //                             ->get();

                            //     foreach ($nxttrans as $nxttran) {
                            //         $nxt2[] = $nxttran->tran_id;
                            //     }
                            // }
                            // else
                            //     $nxt2[] = $tran->tran_id;

                            // }
                            // else
                                // $nxt2[] = $tran->tran_id;
                            
                    
                //}
                //}
                

    public function rejectdoc($upgid,$docid){
        $user = Auth::user();
        $rand = rand(100,1000);
        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');
        $time = date('h:i:sa');

        $trans = \DB::table('transaction')->where('document_doc_id','=',$docid)->get();
        foreach ($trans as $tran){
            $upgid = \DB::table('userpositiongroup as upg')
            ->where('upg.user_user_id','=',$user->user_id)
            ->get();
            foreach($upgid as $key){
                $u_id = $key->upg_id;
            }

        }
         \DB::table('transaction')->where(['document_doc_id'=>$tran->document_doc_id])->where('upg_id','=',$u_id)
            ->update(['status'=>'rejected','time'=>$time,'date'=>$date]);
            
            \DB::table('archive')->insert(['idarchive'=>$rand, 'docid'=>$docid]);
         // return redirect()->route("viewInbox",['groupid'=>Session::get('groupid')]);
         return redirect()->route('docView',['upgid'=>$upgid,'id'=>$docid]);  
    }

    public function archive($upgid,$docid)
    {
        $rand = rand(100,10000);
        \DB::table('archive')->insert(['idarchive'=>$rand, 'docid'=>$docid]);

         // return redirect()->route("viewInbox",['groupid'=>Session::get('groupid')]);
        //return redirect()->route('docView',['upgid'=>$upgid,'id'=>$docid]);
    }

    public function getTotalTrans($docid){

        $counting=\DB::table('transaction')->where('document_doc_id','=',$docid)->count();
        return $counting;
    }

    public function getTotalApprove($docid){
        $countapprove=\DB::table('transaction')->where('document_doc_id','=',$docid)->where('status','=','approved')->count();
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
        $date = date('m-d-Y');
        $time = date('h:i:sa');
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

    foreach ($documentname as $key) {
        $docid = $key->doc_id;
        //$datetime = \DB::table('inbox')->where('doc_id','=',$docid)->first();    
    }
    
        return view('user/sentDocs',['documentname'=>$documentname,'User'=>$user,'upgid'=>$upgid]);
                 
    }

    public function complete($groupid){

        $user = Auth::user();
        $userid = $user->user_id;
        $getupg = \Session::get('upgid');


        $view = \DB::table('document')
        ->where('document.userpositiongroup_upg_id','=',$getupg)
        ->join('archive','document.doc_id','=','archive.docid')
        ->get();

        // $view = \DB::table('archive')
        // ->join('document','archive.docid','=','document.doc_id')
        // ->where('document.userpositiongroup_upg_id','=',$getupg)
        // ->get();

        return view('user/completedocs',['completedoc'=>$view, 'User'=>$user]);

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
    ->join('document','transaction.document_doc_id','=','document.doc_id')
    ->join('userpositiongroup','transaction.upg_id','=','userpositiongroup.upg_id')
    ->join('user','userpositiongroup.user_user_id','=','user.user_id')
    ->select('transaction.status','user.lastname','user.firstname','transaction.time','transaction.date','document.template_template_id','transaction.order')
    ->get();

   //order statuss 
    $docInfo = \DB::table("document")->where("doc_id",'=',$id)->get();

    return view("user/fileStatus",["name"=>$name],["statuss"=>$statuss,'User'=>$user,"pdf"=>$id,'docinfos'=>$docInfo,'upgid'=>$upgid]);
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
                    ->join('group as g','upg.group_group_id','=','g.group_id')
                    ->join('rights as r','upg.rights_rights_id','=','r.rights_id')
                    ->get();
        return view('user/chooseGroup',['User'=>$name,'usergroups'=>$groups]);
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
               // ->distinct()
                ->where('upg.client_id','=',$clientid)
                ->orderBy('lastname','asc')
                ->paginate(7); //change
                // ->get();
        }
        else
        {
            $users = DB::table('user')->where('user.status','=','active')
                ->join('userpositiongroup as upg','user.user_id','=','upg.user_user_id')
               // ->distinct()
                ->where('upg.group_group_id','=',$admingroup)
                ->orderBy('lastname','asc')
                ->paginate(7); //change
                // ->get();
        }
    	
        
    	return view('admin/usermngmt',['users'=>$users,'User'=>$name,'upgid'=>$upgid]);
                
    }

    public function show($upgid,$id)
    {
        $name = Auth::user();
    	$userinfos = DB::table('user')->where('user_id', $id)->get();

        $usergroups = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$id)
                                                    ->join('position as p','upg.position_pos_id','p.pos_id')
                                                    ->join('group as g','upg.group_group_id','g.group_id')
                                                    ->join('rights as r','upg.rights_rights_id','r.rights_id')
                                                    ->get();

    	return view('admin/userprofpage',['userid' => $id,
    									 'userinfos' => $userinfos,
                                         'User'=>$name,
                                          'usergroups'=>$usergroups,
                                        'upgid'=>$upgid]);
       
    }

    public function showForEdit($upgid,$id)
    {
        $name = Auth::user();
        $userinfos = DB::table('user')->where('user_id', $id)->get();
        return view('admin/userprofedit',['userid' => $id,
                                         'userinfos' => $userinfos,
                                         'User'=>$name,
                                        'upgid'=>$upgid]);
    }

    public function update(Request $request,$upgid,$id)
    {
        $name = Auth::user();
         if($request->profpic){
            $path = $request->profpic->store('users/pictures');
            $image = $request->profpic->hashName();
            DB::table('user')->where('user_id',$id)->update(['profilepic'=>$image]);
        }

        if($request->sign){
            // $path = $request->sign->store('users/signatures');
            // $signature = $request->sign->hashName();
            $rand = rand(100000,999999);
            Storage::putFileAs("signature",$request['sign'],$rand.".png");
            $signpath = $rand.".png";
            DB::table('user')->where('user_id',$id)->update(['signature'=>$signpath]);
        }
        
        DB::table('user')->where('user_id',$id)->update(['firstname'=>$request['fname'],
                                                        'lastname'=>$request['lname'],
                                                        'email'=>$request['email'],
                                                        'gender'=>$request['gender'],
                                                        'address'=>$request['address']]);
                                                        // 'password'=>bcrypt($request['userpassword'])]);
                                                                   
        return $this->show($upgid,$id);
    }

    public function add(Request $request)
    {
        $name = Auth::user();
        $path = $request->image->store('users/pictures');
        $image = $request->image->hashName();
        DB::table('user')->insert(['user_id'=>$request['userid'],
                                    'firstname'=>$request['fname'],
                                    'lastname'=>$request['lname'],
                                     'email'=>$request['email'],
                                    'gender'=>$request['gender'],
                                    'address'=>$request['address'],
                                     'password'=>bcrypt($request['password']),
                                     'status'=>"Pending",
                                     'profilepic'=>$image,
                                     'status'=>'active']); 
        return redirect()->route('UserManage');
    }

    public function findUser($groupid,$string)
    {
        $users = DB::table('user')->where('group_group_id','=',$groupid)->where('firstname','LIKE','%'.$string.'%')->orWhere('lastname','LIKE','%'.$string.'%')->get();

        return response()->json($users);
    }

    public function delete($upgid,$id)
    {
        $name = Auth::user();
        // DB::table('user')->where('userId',$id)->delete();
        DB::table('user')->where('user_id',$id)->update(['status'=>'inactive']);
        return $this->index($upgid);
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
