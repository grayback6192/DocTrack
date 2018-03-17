<?php

//Global methods to be used by other controllers

function getNumberOfUnread($upgid)
{
    $numUnreadInbox = 0;
    $unreadinboxes = DB::table('inbox')->where('upg_id','=',$upgid)
                                        ->get();
    foreach ($unreadinboxes as $unreadinbox) {
        $inboxlog = DB::table('log')->where('inbox_id','=',$unreadinbox->inbox_id)
                                    ->orderBy('datetime','desc')
                                    ->first();
        if($inboxlog!=NULL)
        {
             if($inboxlog->status=="unread")
                    $numUnreadInbox++;
        }                                    
       

    }

     return $numUnreadInbox;

}

function getNumberofInProgress($upgid)
{
    $inprogress = DB::table('document as d')->where('d.userpositiongroup_upg_id','=',$upgid)
                                            ->leftJoin('archive as a','d.doc_id','a.docid')
                                            ->whereNull('a.docid')
                                            ->count();
    return $inprogress;
}

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

function getClient($upgid)
{
    $client = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$upgid)
                                                        ->get();

    foreach ($client as $key) {
        $clientid = $key->client_id;
    }
    return $clientid;
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
                                                    ->get();
            // echo "<pre>";
            // var_dump($recipients);      
            //return $recipients;
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
                                                                ->join('position as p','upg.position_pos_id','p.pos_id')
                                                                ->join('group as g','upg.group_group_id','g.group_id')
                                                                ->get();
                 //get from org chart                                                
                $deporgchart = DB::table('orgchart as o')->where('o.group_id','=',$usergroup)
                                                        ->join('orgchartnode as on','o.orgchart_id','on.orgchart_id')
                                                        ->join('userpositiongroup as upg','on.upg_id','upg.upg_id')
                                                        ->join('position as p','upg.position_pos_id','p.pos_id')
                                                        ->where('p.pos_id','=',$recipient->position_pos_id)
                                                            ->get();
                 //   echo "<pre>";
                 // var_dump($deporgchart);                                          
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
    // echo "<pre>";
    //              var_dump($storestep);
   return $storestep;
}

function getWorkflowForCustom($upgid,$wfid)
{
    //get workflow where wfid = $wfid
      $storestep = array();
      $sendergroup = getUserGroup($upgid);
    $selectedworkflow = DB::table('workflow as w')->where('w_id','=',$wfid)
                        ->join('workflowsteps as ws','w.w_id','ws.workflow_w_id')
                        ->orderBy('ws.order')
                        ->get();

    foreach ($selectedworkflow as $selectedstep) {
        $recipients = DB::table('workflowsteps as ws')->where('ws.ws_id','=',$selectedstep->ws_id)
                                                    ->join('wsreceiver as wsr','ws.ws_id','wsr.ws_id')
                                                    //->join('next as nxt','ws.ws_id','nxt.ws_id')
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
                                                                 ->join('position as p','upg.position_pos_id','p.pos_id')
                                                                ->join('group as g','upg.group_group_id','g.group_id')
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

                }
            }
        } 
    }

    return $storestep;
       
}

function sortWorkflow($workflowarray,$tempid)
{
    $maxOrder = DB::table('template as t')->where('t.template_id','=',$tempid)
                                        ->join('workflowsteps as ws','t.workflow_w_id','ws.workflow_w_id')
                                        ->max('ws.order');

    $sortWf =array();

    for($i=0;$i<count($workflowarray);$i++)
    {
        $sortWf[$workflowarray[$i]['order']][] = $workflowarray[$i];
    }

    return $sortWf;
}

function sortTransaction($docid)
{
    $doctransactions = DB::table('transaction as t')->where('t.document_doc_id','=',$docid)
                                                ->join('userpositiongroup as upg','t.upg_id','upg.upg_id')
                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                //->leftJoin('log as l','t.tran_id','l.tran_id')
                                                ->orderBy('t.order')
                                                ->select('u.lastname','u.firstname','t.order','t.upg_id')
                                                ->get();

     $sortTransaction = array();
     foreach ($doctransactions as $doctransaction) 
     {
        $sortTransaction[$doctransaction->order][] = $doctransaction;                                          
    } 

    return $sortTransaction;                                          
}

function insertTransaction($docid,$array,$senderupgid)
{
        //insert to transaction table
         for ($i=0; $i < sizeof($array); $i++) { 
            $upgid = $array[$i]['upg_id'];
            $wdid = $array[$i]['ws_id'];
            $order = $array[$i]['order'];
            $nexts = DB::table('workflowsteps as ws')->where('ws.ws_id','=',$wdid)
                                                    ->join('next as nxt','ws.ws_id','nxt.ws_id')
                                                    ->get();
            foreach ($nexts as $next) {
                $next = $next->next_wsid;
            }

            DB::table('transaction')->insert(['document_doc_id'=>$docid,
                                                'upg_id'=>$upgid,
                                                'wd_id'=>$wdid,
                                                'order'=>$order,
                                                'next'=>$next]);
         }

         //send to first receiver
         $firstreceivers = DB::table('transaction')->where('document_doc_id','=',$docid)->where('order','=',1)->get();
         foreach ($firstreceivers as $firstreceiver) {
            insertToLog($firstreceiver->upg_id,$docid,$senderupgid,$firstreceiver->tran_id);
             insertInbox2($firstreceiver->upg_id,$docid,$senderupgid);
         }
       
      return redirect()->route('Template',['upgid'=>$senderupgid]);

}

function insertToLog($receiverupgid,$docid,$senderupgid,$tranid)
{
    // $randLogId = rand(1,9999);
      date_default_timezone_set('Asia/Manila');
        $datetime = date('M d, Y H:i:s a');
       // $time = date('h:i:sa');

    DB::table('log')->insert(['tran_id'=>$tranid,
                            'inbox_id'=>NULL,
                            'status'=>"pending",
                            'datetime'=>$datetime]);
}

function insertInbox2($receiverupgid,$docid,$senderupgid)
{
     $user = Auth::user();
         date_default_timezone_set('Asia/Manila');
        $datetime = date('M d, Y H:i:s a');
        //$time = date('h:i:sa');

        DB::table('inbox')->insert(['doc_id'=>$docid,
                                    'upg_id'=>$receiverupgid]);

       $newinbox = DB::table('inbox')->where('doc_id','=',$docid)
                                    ->where('upg_id','=',$receiverupgid)
                                    ->get();
        foreach ($newinbox as $inbox) {
            // $randLog = rand(1,99999);
            DB::table('log')->insert(['tran_id'=>NULL,
                                    'inbox_id'=>$inbox->inbox_id,
                                    'status'=>'unread',
                                    'datetime'=>$datetime]);
        }


        return redirect()->route('Template',['upgid'=>$senderupgid]);
}

?>