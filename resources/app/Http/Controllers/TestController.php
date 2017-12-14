<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function getUPG()
    {
    	$upgid = \Session::get('upg');
        $user = Auth::user();
        $userid = $user->user_id;
        $upg_user = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$upgid)->where('upg.user_user_id','=',$userid)->get();
       foreach ($upg_user as $key) {
            $recid = $key->user_user_id;
        }
         echo "<pre>";
         var_dump($recid);
    }

    public function inbox()
    {
        $val = array();
        $docid = 201412;
        $firstNode = DB::table('transaction as t')->where('t.document_doc_id','=',$docid)
                ->join('workflowsteps as ws','t.wd_id','=','ws.ws_id')
                ->where('ws.prev','=','')
                ->get();
        foreach ($firstNode as $key) {
            $vals = $key->tran_id;
            $vals1 = json_decode(json_encode($vals),TRUE);
            $val[] = $vals1;
        }

               return $this->inbox2($docid,$val);

    }

    public function inbox2($docid,$node)
    {
        $a = array();
        for ($z=0;$z<count($node);$z++) {
            $send = DB::table('transaction')->where('document_doc_id','=',$docid)->where('tran_id','=',$node[$z])
                    ->join('userpositiongroup as upg','transaction.upg_id','=','upg.upg_id')
                    ->join('user','upg.user_user_id','=','user.user_id')

                    ->get();

                        echo "<pre>";
                        var_dump($send);
                    
    }

    
    
}

public function getWorkflow()
    {
        $groupid = 68776;
        $templateid = 162;
         
        $workflow = DB::table('template')->where('template_id','=',$templateid)
                    ->join('workflow','template.workflow_w_id','=','workflow.w_id')
                    ->join('workflowsteps','workflow.w_id','=','workflowsteps.workflow_w_id')
                    // ->select('template.templatename','workflow.workflowName','workflowsteps.position_pos_id','workflowsteps.order')
                    ->get();

                    $flowlist = array();
                    $arr = array();
                    foreach ($workflow as $flow) {
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
                               // $res3 = json_decode(json_encode($res2),TRUE);
                                if(count($res2)>0)
                                    $flowlist[] = $res2;
                                else{
                                        $res5 = DB::table('userpositiongroup as upg')
                                        ->where('upg.position_pos_id','=',$flow->position_pos_id)
                                        ->join('user as u','upg.user_user_id','=','u.user_id')
                                        ->get();
                                        $flowlist[] = $res5;
                                    }
                          }
                          else
                          {
                           // $res4 = json_decode(json_encode($res),TRUE);
                            $flowlist[] = $res;
                          }

                        
                    }
                    for($x=0;$x<(count($flowlist));$x++)
                    {
                        for($y=0;$y<(count($flowlist[$x]));$y++){
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
                    $sort = $this->sortNodes($templateid,$arr,1,1,$ordered);

          
          echo "<pre>";
          var_dump($sort);
         
          // return $sort;
    }

    public function sortNodes($tempid,$array,$order,$processcount,$sorted)
    {
        $current = array();
        $max = $this->getMax($tempid);
       
        if($processcount<$max || $processcount==$max){
        for ($i=0; $i < count($array) ; $i++) { 
            for ($j=0; $j < count($array[$i]); $j++) { 
                if($array[$i][$j]['order']==$order)
                    $current[] = $array[$i][$j];
                else
                    break;
            }
        }
        return $this->storeOrdered($tempid,$array,$current,$order,$processcount,$sorted);
    }
    else 
        return $sorted;
    } 

    public function getMax($templateid)
    {
        $wf = DB::table('template')->where('template_id','=',$templateid)->get();
        foreach ($wf as $key) {
            $wfid = $key->workflow_w_id;
        }
        
        $numorders = DB::table('workflowsteps')->where('workflow_w_id','=',$wfid)->count();
        return $numorders;
    }

    public function storeOrdered($tempid,$array,$node,$order,$processcount,$sorted)
    {
        //$sortarray = array();
        $sorted[] = $node;
        $order++;
        $processcount++;

        return $this->sortNodes($tempid,$array,$order,$processcount,$sorted);
        // else
        //     return $sortarray;
        //return $processcount;
    }

    public function setPrev()
    {
        $wfid = 52019;
        $wsid = 2030;
         $currNode = \DB::table('workflowsteps')->where('ws_id','=',$wsid)->get();
        foreach ($currNode as $curr) {
            $currCount = $curr->count;
        }

        return $currCount;
    }
}
