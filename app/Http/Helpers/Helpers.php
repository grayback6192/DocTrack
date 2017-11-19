<?php

//Global methods to be used by other controllers


function getClientId($userid)
{
	$clientgroup = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                                                        ->distinct()
                                                        ->get();
    return $clientgroup;
}

function getWorkflow($groupid,$templateid)
{
    $workflow = DB::table('template')->where('template_id','=',$templateid)
                ->join('workflow','template.workflow_w_id','=','workflow.w_id')
                ->join('workflowsteps','workflow.w_id','=','workflowsteps.workflow_w_id')
                ->get();
    $flowlist = array();
    $arr = array();
    foreach ($workflow as $flow)
    {
        $res = DB::table('userpositiongroup as upg')
                        ->where('upg.position_pos_id','=',$flow->position_pos_id)
                        ->join('user as u','upg.user_user_id','=','u.user_id')
                        ->get();
        if((count($res))>1)
        {
            $res2 = DB::table('userpositiongroup as upg')
                             ->where('upg.group_group_id','=',$groupid)
                             ->where('upg.position_pos_id','=',$flow->position_pos_id)
                             ->join('user as u','upg.user_user_id','=','u.user_id')
                             ->get();
                            if(count($res2)>0)
                            {
                                $flowlist[] = $res2;
                            }
                            else
                            {
                                $res5 = DB::table('userpositiongroup as upg')
                                                  ->where('upg.position_pos_id','=',$flow->position_pos_id)
                                                  ->join('user as u','upg.user_user_id','=','u.user_id')
                                                  ->get();
                                $flowlist[] = $res5;
                                }
                      }
                      else
                      {
                        $flowlist[] = $res;
                      }
                }
                for($x=0;$x<(count($flowlist));$x++)
                {
                    for($y=0;$y<(count($flowlist[$x]));$y++)
                    {
                        $query6 = DB::table('template')
                                    ->where('template.template_id','=',$templateid)
                                    ->join('workflow','template.workflow_w_id','=','workflow.w_id')
                                    ->join('workflowsteps','workflow.w_id','=','workflowsteps.workflow_w_id')
                                    ->join('position','workflowsteps.position_pos_id','=','position.pos_id')
                                    ->where('position.pos_id','=',$flowlist[$x][$y]->position_pos_id)
                                    ->join('userpositiongroup as upg','position.pos_id','=','upg.position_pos_id')
                                    ->where('upg.upg_id','=',$flowlist[$x][$y]->upg_id)
                                    ->join('user','upg.user_user_id','=','user.user_id')
                                    ->get();
                            if($query6->count())
                            {
                                $arr1 = json_decode(json_encode($query6),TRUE);
                                $arr[] = $arr1;
                            }
                    }
                }
                $order = 1;
                $processcount = 1;
                $ordered = array();
                $sort = sortNodes($templateid,$arr,1,1,$ordered);
       return $sort;
}
function insertTransaction($docid,$array)
    {
        for($i=0;$i<(count($array));$i++){
        for($j=0;$j<(count($array[$i]));$j++){
            $upgid = $array[$i][$j]["upg_id"];
            $wdid = $array[$i][$j]["ws_id"];
            $order = $array[$i][$j]["order"];
            $next = $array[$i][$j]["next"];

            DB::table('transaction')->insert(["document_doc_id"=>$docid,
                                            "upg_id"=>$upgid,
                                            "wd_id"=>$wdid,
                                             "order"=>$order,
                                             "status"=>"pending",
                                             "next"=>$next]);
       }
       }
       $val = array();
       $firstNode = DB::table('transaction as t')->where('t.document_doc_id','=',$docid)
                ->join('workflowsteps as ws','t.wd_id','=','ws.ws_id')
                ->where('ws.prev','=','')
                ->get();
        foreach ($firstNode as $key) {
            $vals = $key->tran_id;
            $vals1 = json_decode(json_encode($vals),TRUE);
            $val[] = $vals1;
        }
        return insertInbox($docid,$val);
    }
function insertInbox($docid,$node){
        
        //get owner of template for redirection
        $tempgroup = DB::table('document')->where('doc_id','=',$docid)
                    ->join('template','document.template_template_id','=','template.template_id')
                    ->get();
        foreach ($tempgroup as $key) {
            $gid = $key->group_group_id;
        }
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
            DB::table('inbox')->insert(["status"=>"unread",
                                        "user_id"=>$sends->user_id,
                                        "doc_id"=>$sends->document_doc_id,
                                        "time"=>$time,
                                        "date"=>$date]);
            $send = json_decode(json_encode($send),TRUE);
            $rec[] = $send;
          } 
         }
         return redirect()->route("Template",['gid'=>$gid]);
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