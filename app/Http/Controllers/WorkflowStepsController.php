<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WorkflowStepsController extends Controller
{
    //
    public function addStep(Request $request,$upgid)
    {
        $prevVals = array();

        $rand = rand(1000,99999);

        if(!(isset($request['prev'])))
        {
            $previous = "";
            $orderprev = 1;

        }
        else
        {
            $prev = $request['prev'];
            foreach ($prev as $key) {
                $prevorder = DB::table('workflowsteps')->where('ws_id','=',$key)->get();
                foreach ($prevorder as $value) {
                    $orderprev = $value->order;
                }
                $prevVals[] = $key;

                DB::table('workflowsteps')->where('ws_id','=',$key)->update(['next'=>$rand]);
            }
             $previous = implode(',', $prevVals);
            $orderprev++;

        }
        DB::table('workflowsteps')->insert(['ws_id'=>$rand,
                                            'workflow_w_id'=>$request['wid'],
                                            'position_pos_id'=>$request['pos'],
                                            'order'=>$orderprev,
                                            'action'=>$request['action'],
                                            'prev'=>$previous,
                                            'next'=>""]);


            //update whole workflow
         $wfsteps = DB::table('workflowsteps')->where('workflow_w_id','=',$request['wid'])->get();
        foreach ($wfsteps as $wfstep) {
            $this->updateWF($wfstep->ws_id); //update whole workflow
        }

        return redirect()->route('AddWf',['id'=>$request['wid'],'upgid'=>$upgid]);
    }

    //edit
    public function editStep(Request $request,$upgid,$wsid)
    {


        $prevVals = array();

        //for prev update
        if(!(isset($request['prev'])))
        {
            DB::table('workflowsteps')->where('ws_id','=',$wsid)
            ->update(['prev'=>"",'order'=>1]);
        }
        else{
            $prev = $request['prev'];
           foreach ($prev as $key) {
               $prevVals[] = $key;

            $prevNode = \DB::table('workflowsteps')->where('ws_id','=',$key)->get();
            foreach ($prevNode as $prev) { //get order of previous node
                $prevOrder = $prev->order;
            }
           }
           $prevOrder++;

           \DB::table('workflowsteps')->where('ws_id','=',$wsid)->update(['order'=>$prevOrder]);
            }

        $currNode = \DB::table('workflowsteps')->where('ws_id','=',$wsid)->get();
        foreach ($currNode as $curr) {
            $currNodeOrder = $curr->order;
            $currNodePrev = $curr->prev;
            $currNodeNext = $curr->next;
            $wfid = $curr->workflow_w_id;
        }
 

        $currFlow = \DB::table('workflowsteps')->where('workflow_w_id','=',$wfid)->orderBy('order')->get();
        foreach ($currFlow as $flow) {
            $prevValue = $this->setPrev($flow->ws_id,$wfid);
            $nextValue = $this->setNext($flow->ws_id,$wfid);

            \DB::table('workflowsteps')->where('ws_id','=',$flow->ws_id)->update(['prev'=>$prevValue,'next'=>$nextValue]);
       }

       //to edit step action
       DB::table('workflowsteps')->where('ws_id','=',$wsid)->update(['action'=>$request['action']]);

        $wfsteps = DB::table('workflowsteps')->where('workflow_w_id','=',$wfid)->get();
        foreach ($wfsteps as $wfstep) {
            $this->updateWF($wfstep->ws_id); //update whole workflow
        }
       
         return redirect()->route('AddWf',['upgid'=>$upgid, 'id'=>$request['wfid']]);
    }

    public function setPrev($wsid,$wfid) //transfer
    {
        $prev = array();
        $currNode = \DB::table('workflowsteps')->where('ws_id','=',$wsid)->get();
        foreach ($currNode as $curr) {
            $currCount = $curr->order;
        }
        $currCount--;

        $prevNode = DB::table('workflowsteps')->where('workflow_w_id','=',$wfid)->where('order','=',$currCount)->get();
        if(count($prevNode)==1){
            foreach ($prevNode as $key) {
                $p = $key->ws_id;
            }
        }
        else if(count($prevNode)>1){
            foreach ($prevNode as $key) {
                $prev[] = $key->ws_id;
            }

            $p = implode(',',$prev);
        }
        else if(count($prevNode)==0)
        {
            $p = "";
        }

        // foreach ($prevNode as $key) {
        //     $prev[] = $key->ws_id;
        // }

         return $p;
        // echo "<pre>";
        // var_dump($currCount);
    }

    public function setNext($wsid,$wfid){
        $nxt = array();
        $currNode = \DB::table('workflowsteps')->where('ws_id','=',$wsid)->get();
        foreach ($currNode as $curr) {
            $currCount = $curr->order;
        }
        $currCount++;
        $nextNode = DB::table('workflowsteps')->where('workflow_w_id','=',$wfid)->where('order','=',$currCount)->get();
        if(count($nextNode)==1)
        {   
            foreach ($nextNode as $next) {
                $n = $next->ws_id;
            }
        }
        else if(count($nextNode)>1)
        {
            foreach ($nextNode as $next) {
                $nxt[] = $next->ws_id;
            }
            $n = implode(',', $nxt);
        }
        else if(count($nextNode)==0)
        {
            $n = "";
        }
        // echo "<pre>";
        // var_dump($nextNode);
        return $n;  
    }

    // public function forNext($wsid,$wfid)
    // {
    //     $nexts = array();
    //     $results = DB::table('workflowsteps')->where('prev','=',$wsid)->get();
    //     if(count($results)==0){
    //          $wsorder = DB::table('workflowsteps')->where('ws_id','=',$wsid)->get();
    //         foreach ($wsorder as $key) {
    //             $nxtorder = $key->order + 1;
    //             $nxtorders = DB::table('workflowsteps')->where('order','=',$nxtorder)->where('workflow_w_id','=',$wfid)->get();
    //             if(count($nxtorders)==0)
    //                 $next = "";
    //             else
    //             {
    //                 foreach ($nxtorders as $nxtorder) {
    //                     $nxt = $nxtorder->ws_id;
    //                      $nexts[] = $nxt;
    //                 }
                   
    //             }
    //         }
    //     }
    //     else
    //     {
    //         foreach ($results as $result) {
    //             $nexts[] = $result->ws_id;

    //         }
            
    //     }
    //     $next = implode(',', $nexts);
    //     return $next;
    // }

    //  public function forPrev($wsid)
    // {
    //     $prevs = array();
    //     $results = DB::table('workflowsteps')->where('next','=',$wsid)->get();
    //     if(count($results)==0)
    //         $prev = "";
    //     else
    //     {
    //         foreach ($results as $result) {
    //             $prevs[] = $result->ws_id;

    //         }
    //         $prev = implode(',', $prevs);
    //     }
    //     return $prev;
    // }
    public function openSteps($upgid,$wfid)
    {
       $prevarr = array();
        $prevarr2 = array();
        $user = Auth::user();
     //$upgid = \Session::get('upg');
        $client = DB::table('userpositiongroup')->where('upg_id','=',$upgid)->get();
        // foreach ($client as $value) {
        //     $clientid = $value->client_id;
        // }
        $clientid = \Session::get('client');
        $workflow = DB::table('workflow')->where('w_id','=',$wfid)->get();
        $positions = DB::table('position')->where('status','=','active')->where('client_id','=',$clientid)->get();
        foreach ($workflow as $flow) {
        $wid = $flow->w_id;
    }
    $steps = DB::table('workflowsteps as ws')->where('ws.workflow_w_id','=',$wid)
             ->join('position as p','ws.position_pos_id','=','p.pos_id')
             ->get();
             foreach ($steps as $step) {
                 $prevstep = $step->prev;
                 //$prevarr2[] = $step->ws_id;

                  // $prevarr = array();
            if(strpos($prevstep,',')!==false)
             {
                $prevarr = explode(',',$prevstep);
                //array_push($prevarr2, array($step->ws_id,$prevarr));
             }
             else
             {
                
                $prevarr[] = $prevstep;
              
             }
             array_push($prevarr2, array($step->ws_id,$prevarr));
             //$prevarr2[] = $prevarr;
             }
            
        $steps2 = $this->sortStep($wfid);
        
          return view("admin/addWf",['User'=>$user, 'positions'=>$positions, 'workflow'=>$workflow, 'steps'=>$steps, 'steps2'=>$steps2, 'prevarr'=>$prevarr,'prevarr2'=>$prevarr2,'upgid'=>$upgid]);
        
        // echo "<pre>";
        // var_dump($prevarr2);

    }

    public function sortStep($wfid)
    {
        $sort = array();
        $current = array();
        $steps = DB::table('workflowsteps as ws')->where('ws.workflow_w_id','=',$wfid)
                ->join('position as p','ws.position_pos_id','=','p.pos_id')
                ->get();
        foreach ($steps as $step) {
            if($step->order==1)
                $current[] = json_decode(json_encode($step),TRUE);
        }
            return $this->storeSteps($current,1,$wfid,$sort);
        //return $current;
        
    }

    public function storeSteps($step,$count,$wfid,$array)
    {
        
        $total = $this->getMax($wfid);

        if($count<$total || $count==$total){
        
        $array[] = $step;
        $count++;
         return $this->sortOtherSteps($count,$wfid,$array);
    }
    
        return $array;
    }

    public function sortOtherSteps($count,$wfid,$array)
    {
         $current = array();
        $steps = DB::table('workflowsteps as ws')->where('ws.workflow_w_id','=',$wfid)
                ->join('position as p','ws.position_pos_id','=','p.pos_id')
                ->get();
        foreach ($steps as $step) {
            if($step->order==$count)
                $current[] = json_decode(json_encode($step),TRUE);
        }
            return $this->storeSteps($current,$count,$wfid,$array);
        //return $count;
    }

    public function getMax($wfid)
    {
        $total = DB::table('workflowsteps')->where('workflow_w_id','=',$wfid)->max('order');
        return $total;
    }

//remove
    public function removeStep($upgid,$wsid)
    {
        $wfid = DB::table('workflowsteps')->where('ws_id','=',$wsid)->get();
        foreach ($wfid as $wf) {
            $wid = $wf->workflow_w_id;
            //$wfid = $wf->workflow_w_id;
            //$w_order = $wf->order;
        }
        DB::table('workflowsteps')->where('ws_id','=',$wsid)->delete();

        //update whole workflow
       //  $currFlow = \DB::table('workflowsteps')->where('workflow_w_id','=',$wfid)->orderBy('order')->get();
       //  foreach ($currFlow as $flow) {
       //      $prevValue = $this->setPrev($flow->ws_id,$wfid);
       //      $nextValue = $this->setNext($flow->ws_id,$wfid);
       //      \DB::table('workflowsteps')->where('ws_id','=',$flow->ws_id)->update(['prev'=>$prevValue,'next'=>$nextValue]);
       // }

        $wfsteps = DB::table('workflowsteps')->where('workflow_w_id','=',$wid)->get();
        foreach ($wfsteps as $wfstep) {
            $this->updateWF($wfstep->ws_id); //update whole workflow
        }

        return redirect()->route('AddWf',['upgid'=>$upgid,'wfid'=>$wid]);
        //return $wfsteps;
    }

    public function updateWF($wsid)
    {
        //get info of wsid
        $wsidinfos = DB::table('workflowsteps')->where('ws_id','=',$wsid)->get();

        //loop wsid
         foreach ($wsidinfos as $wsidinfo) {
            $wsid_order = $wsidinfo->order;
            // $wsid_prev = $wsidinfo->prev;
            // $wsid_next = $wsidinfo->next;
            $wsid_wf  = $wsidinfo->workflow_w_id;
         }

        //update order of wsid
        $neworder = $this->updateWSIDOrder($wsid,$wsid_wf,$wsid_order);

        //update DB for order
        DB::table('workflowsteps')->where('ws_id','=',$wsid)->update(['order'=>$neworder]);

        //update next and prev
        //query updated db
        $wsidinfos2 = DB::table('workflowsteps')->where('ws_id','=',$wsid)->get();

        foreach ($wsidinfos2 as $wsidinfo2) {
            $wsid_order2 = $wsidinfo2->order;
            $wsid_prev2 = $wsidinfo2->prev;
            // $wsid_next2 = $wsidinfo2->next;
            $wsid_wf2  = $wsidinfo2->workflow_w_id;
        
        }
       
        $newprev = $this->updateWSIDPrev($wsid,$wsid_wf2,$wsid_order2);
        DB::table('workflowsteps')->where('ws_id','=',$wsid)->update(['prev'=>$newprev]);

        $this->updateWSIDNext($wsid,$wsid_wf2,$wsid_order2);
 
    }

    public function updateWSIDOrder($wsid,$workflowid,$wsidorder)
    {
        //get max order that is lesser than wsidorder
        $maxprevorder = DB::table('workflowsteps')->where('order','<',$wsidorder)
                                                  ->where('workflow_w_id','=',$workflowid)
                                                  ->max('order');

        if($maxprevorder==1 && $wsidorder==1)
            $wsidneworder = 1;
        else
        {
            $wsidneworder = $maxprevorder + 1;
        }

        return $wsidneworder;
    }

    public function updateWSIDPrev($wsid,$workflowid,$wsidorder)
    {
        $newprev = array(); //to store wsid updated prevs
        $prevorder = $wsidorder - 1;

        $allsteps = DB::table('workflowsteps')->where('workflow_w_id','=',$workflowid)->where('order','=',$prevorder)->get();

        foreach ($allsteps as $allstep) {
            $previousstep = $allstep->ws_id;
            $newprev[] =  $previousstep;
        }

            $newprevstring = implode(',', $newprev);

            return $newprevstring;
    }

    public function updateWSIDNext($wsid,$workflowid,$wsidorder)
    {
        //update next of previous order to $wsid

        $newnext = array();

        $allsteps = DB::table('workflowsteps')->where('workflow_w_id','=',$workflowid)->where('order','=',$wsidorder)->get();

        foreach ($allsteps as $allstep) {
            $nextstep = $allstep->ws_id;
            $newnext[] =  $nextstep;
        }

            $newnextstring = implode(',', $newnext);

         $prevorder = $wsidorder - 1;

         //get previous order
         $allsteps = DB::table('workflowsteps')->where('workflow_w_id','=',$workflowid)->where('order','=',$prevorder)->get();

         //update next of previous order
         foreach ($allsteps as $allstep) {
             DB::table('workflowsteps')->where('ws_id','=',$allstep->ws_id)->update(['next'=>$newnextstring]);
         }

         //check if current wsid is the last step
         $nextorder = $wsidorder + 1;
         $allsteps = DB::table('workflowsteps')->where('workflow_w_id','=',$workflowid)->where('order','=',$nextorder)->get();
         if(count($allsteps)==0)
         {
            DB::table('workflowsteps')->where('ws_id','=',$wsid)->update(['next'=>" "]);
         }

        //return $newnextstring;
    }


    
  
}


    