<?php

//Global methods to be used by other controllers

function getUserUPG($upgid)
{
    $userupg = DB::table('userpositiongroup')->where('upg_id','=',$upgid)->get();
    return $userupg;
}

function getAdminGroup($upgid)
{
    $adminupg = getUserUPG($upgid);
    foreach ($adminupg as $admin) {
        $admingroup = $admin->group_group_id;
    }

    return $admingroup;
}

function getClientId($userid)
{
	$clientgroup = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                                                        ->distinct()
                                                        ->get();
    return $clientgroup;
}

function getAdminClient($upgid)
{
    $adminclient = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$upgid)
                                                        ->get();

    foreach ($adminclient as $key) {
        $adminclientid = $key->client_id;
    }
    return $adminclientid;
}

function getUserGroup($upgid)
{
    $user = Auth::user();
    $usergroups = DB::table('userpositiongroup')->where('upg_id','=',$upgid)->get();
    foreach ($usergroups as $usergroup) {
        $ugroup = $usergroup->group_group_id;
    }

    return $ugroup;
}

function getWorkflow2($upgid,$groupid,$templateid)
{
    $workflowsteps = DB::table('template as t')->where('t.template_id','=',$templateid)
                                                ->join('workflow as w','t.workflow_w_id','w.w_id')
                                                ->join('workflowsteps as ws','w.w_id','ws.workflow_w_id')
                                                ->orderBy('ws.order')
                                                ->get();

    $storestep = array();
    $storestep2 = array();
    $storestep3 = array();

   foreach ($workflowsteps as $workflowstep) {
       $recipients = DB::table('workflowsteps as ws')->where('ws.ws_id','=',$workflowstep->ws_id)
                                                    ->join('wsreceiver as wsr','ws.ws_id','wsr.ws_id')
                                                    ->join('next as nxt','ws.ws_id','nxt.ws_id')
                                                    //->join('previous as prev','ws.ws_id','prev.ws_id')
                                                    ->get();
        foreach ($recipients as $recipient) {
            //echo "".$recipient->ws_id."=".$recipient->receiver."(".$recipient->order.")"."<br>";
            $recipientarray = json_decode(json_encode($recipient),TRUE);
            if($recipient->receiver=="All")
            {
                $usergroup = getUserGroup($upgid);
                $depposusers = DB::table('userpositiongroup as upg')->where('upg.position_pos_id','=',$recipient->position_pos_id)
                                                                ->where('upg.upg_status','=','active')
                                                                ->where('upg.group_group_id','=',$usergroup)
                                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                                ->get();
                 //get from org chart                                                
                $deporgchart = DB::table('orgchartnode as on')->where('on.pos_id','=',$recipient->position_pos_id)
                                                            ->where('on.group_id','=',$usergroup)
                                                            ->get();
                if(count($deporgchart)>0)
                 {
                    foreach ($deporgchart as $orgchartupg) {
                        $orgchartupgs = DB::table('userpositiongroup as upg')
                                        ->where('upg.upg_id','=',$orgchartupg->upg_id)
                                        ->join('user as u','upg.user_user_id','u.user_id')
                                        ->get();

                    }
                     foreach ($orgchartupgs as $orgchartupg) {
                        $deporgchartarray = json_decode(json_encode($orgchartupg), TRUE);
                        $merge = array_merge($recipientarray,$deporgchartarray);
                        $storestep[] = $merge;
                     }
                }   
                else if(count($deporgchart)==0) 
                {                                           
                    if(count($depposusers)>0)
                    {
                     foreach ($depposusers as $depposuser) {
                        $depposuserarray = json_decode(json_encode($depposuser),TRUE);
                        $merge = array_merge($recipientarray,$depposuserarray);
                        $storestep[] = $merge;
                    // storeToArray($storestep);
                        }
                    }
                else
                {
                    $allposusers = DB::table('userpositiongroup as upg')->where('upg.position_pos_id','=',$recipient->position_pos_id)
                                                                ->where('upg.upg_status','=','active')
                                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                                ->get();

                     foreach ($allposusers as $allposuser) {
                        $allposuserarray = json_decode(json_encode($allposuser),TRUE);
                        $merge = array_merge($recipientarray,$allposuserarray);
                        $storestep[] = $merge;
                    // storeToArray($storestep);
                    }
                }
            }
               
            }
            else
            {
                  $posusers = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$recipient->receiver)
                                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                                ->get();
                foreach ($posusers as $posuser) {
                    $posuserarray = json_decode(json_encode($posuser),TRUE);
                    $merge = array_merge($recipientarray,$posuserarray);
                    $storestep[] = $merge;
                    //storeToArray($storestep);

                }
            }
            
        }
       
   }
   return $storestep;
}

function getWorkflowForCustom($upgid,$wfid)
{
    //get workflow where wfid = $wfid
      $storestep = array();
    $selectedworkflow = DB::table('workflow as w')->where('w_id','=',$wfid)
                        ->join('workflowsteps as ws','w.w_id','ws.workflow_w_id')
                        ->orderBy('ws.order')
                        ->get();

    foreach ($selectedworkflow as $selectedstep) {
        $recipients = DB::table('workflowsteps as ws')->where('ws.ws_id','=',$selectedstep->ws_id)
                                                    ->join('wsreceiver as wsr','ws.ws_id','wsr.ws_id')
                                                    ->join('next as nxt','ws.ws_id','nxt.ws_id')
                                                    ->get();    

            foreach ($recipients as $recipient) {
                $recipientarray = json_decode(json_encode($recipient),TRUE);
                
                 if($recipient->receiver=="All")
             {
                $usergroup = getUserGroup($upgid);
                $depposusers = DB::table('userpositiongroup as upg')->where('upg.position_pos_id','=',$recipient->position_pos_id)
                                                                ->where('upg.upg_status','=','active')
                                                                ->where('upg.group_group_id','=',$usergroup)
                                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                                ->get();

                 //get from org chart                                                
                $deporgchart = DB::table('orgchartnode as on')->where('on.pos_id','=',$recipient->position_pos_id)
                                                            ->where('on.group_id','=',$usergroup)
                                                            ->get();

                                  
                if(count($deporgchart)>0)
                 {
                    foreach ($deporgchart as $orgchartupg) {
                        $orgchartupgs = DB::table('userpositiongroup as upg')
                                        ->where('upg.upg_id','=',$orgchartupg->upg_id)
                                        ->join('user as u','upg.user_user_id','u.user_id')
                                        ->get();

                    }
                     foreach ($orgchartupgs as $orgchartupg) {
                        $deporgchartarray = json_decode(json_encode($orgchartupg), TRUE);
                        $merge = array_merge($recipientarray,$deporgchartarray);
                        $storestep[] = $merge;
                     }
                }   
                else if(count($deporgchart)==0) 
                {                                           
                    if(count($depposusers)>0)
                    {
                     foreach ($depposusers as $depposuser) {
                        $depposuserarray = json_decode(json_encode($depposuser),TRUE);
                        $merge = array_merge($recipientarray,$depposuserarray);
                        $storestep[] = $merge;
                    // storeToArray($storestep);
                        }
                    }
                else
                {
                    $allposusers = DB::table('userpositiongroup as upg')->where('upg.position_pos_id','=',$recipient->position_pos_id)
                                                                ->where('upg.upg_status','=','active')
                                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                                ->get();

                     foreach ($allposusers as $allposuser) {
                        $allposuserarray = json_decode(json_encode($allposuser),TRUE);
                        $merge = array_merge($recipientarray,$allposuserarray);
                        $storestep[] = $merge;
                    // storeToArray($storestep);
                    }
                }
            }
               
             }
            else
            {
                  $posusers = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$recipient->receiver)
                                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                                ->get();
                foreach ($posusers as $posuser) {
                    $posuserarray = json_decode(json_encode($posuser),TRUE);
                    $merge = array_merge($recipientarray,$posuserarray);
                    $storestep[] = $merge;
                    //storeToArray($storestep);

                }
            }
        } 
    }

    return $storestep;
       
}

function storeToArray($array)
{
    $stepsstorage = array();
    return $stepsstorage;
}

function insertTransaction($docid,$array,$senderupgid)
    {
       

        //insert to transaction table
         for ($i=0; $i < sizeof($array); $i++) { 
            $upgid = $array[$i]['upg_id'];
            $wdid = $array[$i]['ws_id'];
            $order = $array[$i]['order'];
            $next = $array[$i]['next_wsid'];

            DB::table('transaction')->insert(['document_doc_id'=>$docid,
                                                'upg_id'=>$upgid,
                                                'wd_id'=>$wdid,
                                                'order'=>$order,
                                                'status'=>"pending",
                                                'next'=>$next]);
         }

         //send to first receiver
         $firstreceivers = DB::table('transaction')->where('document_doc_id','=',$docid)->where('order','=',1)->get();
         foreach ($firstreceivers as $firstreceiver) {
             return insertInbox2($firstreceiver->upg_id,$docid,$senderupgid);
            //echo "".$firstreceiver->upg_id;
         }
       // echo "<pre>";
       // var_dump(sizeof($array));
       
      

    }

function insertInbox2($receiverupgid,$docid,$senderupgid)
{
     $user = Auth::user();
         date_default_timezone_set('Asia/Manila');
        $date = date('M d, Y');
        $time = date('H:i:sa');

        DB::table('inbox')->insert(['doc_id'=>$docid,
                                    'upg_id'=>$receiverupgid,
                                    'istatus'=>"unread",
                                    'time'=>$time,
                                    'date'=>$date]);

        // return "sent to first receiver success";
        return redirect()->route('serviceowners',['upgid'=>$senderupgid]);
        //return "".$senderupgid;
}

function insertInbox($docid,$node,$upgid){
        
        //get owner of template for redirection
        $tempgroup = DB::table('document')->where('doc_id','=',$docid)
                    ->join('template','document.template_template_id','=','template.template_id')
                    ->get();
        foreach ($tempgroup as $key) {
            $gid = $key->group_group_id;
        }
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
         return redirect()->route("Template",['upgid'=>$upgid,'gid'=>$gid]);
    }
function sortNodes($tempid,$array,$order,$processcount,$sorted)
    {
        $current = array();
        $max = getMax($tempid);
       
        if($processcount<$max || $processcount==$max){
        for ($i=0; $i < count($array) ; $i++) { 
            for ($j=0; $j < count($array[$i]); $j++) { 
                if($array[$i][$j]['order']==$order)
                    $current[] = $array[$i][$j];
                else
                    break;
            }
        }
        return storeOrdered($tempid,$array,$current,$order,$processcount,$sorted);
    }
    else 
        return $sorted;
    } 
 function getMax($templateid)
    {
        $wf = DB::table('template')->where('template_id','=',$templateid)->get();
        foreach ($wf as $key) {
            $wfid = $key->workflow_w_id;
        }
        
        $numorders = DB::table('workflowsteps')->where('workflow_w_id','=',$wfid)->count();
        return $numorders;
    }
 function storeOrdered($tempid,$array,$node,$order,$processcount,$sorted)
    {
        $sorted[] = $node;
        $order++;
        $processcount++;
        return sortNodes($tempid,$array,$order,$processcount,$sorted);
    }

?>