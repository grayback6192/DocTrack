<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Role extends Controller
{
    //
     function getClientId($userid){
        $clientgroup = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                        ->distinct()
                        ->get();
            return $clientgroup;
    }

    function viewRoles($upgid)
    {
        $user = Auth::user();
        $clients = $this->getClientId($user->user_id);
         foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
    	// $roles = DB::table('position as p')->where('p.status','=','active')
     //                                    ->where('p.client_id','=',$clientId)
     //                                    ->leftJoin('group as g','p.pos_group_id','g.group_id')
     //                                    ->orderBy('p.posName')
     //                                    ->paginate(10);
        $roles = DB::table('position as p')->where('p.status','=','active')
                                        ->where('p.client_id','=',$clientId)
                                        ->join('deppos as dp','p.pos_id','dp.pos_id')
                                        ->leftJoin('group as g','dp.pos_group_id','g.group_id')
                                        ->orderBy('p.posName')
                                        ->paginate(10);
        $deps = DB::table('group')->get();
        $admingroup = getAdminGroup($upgid);

        $positionlist = DB::table('position')->where('status','=','active')
                                        ->where('client_id','=',$clientId)
                                        ->orderBy('posName')
                                        ->get();

    	return view('admin/roleView',['roles'=>$roles,'deps'=>$deps, 'User'=>$user,'upgid'=>$upgid,'admingroup'=>$admingroup,'positionlist'=>$positionlist]);
    }

    function addNewRole($upgid, Request $request)
    {
        $user = Auth::user();
         $clients = $this->getClientId($user->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }

          //detect if position already exists in the school
         $positionsarray = array();
         $positions = DB::table('position')->where('client_id','=',$clientId)->get();
         foreach ($positions as $position) {
           $positionsarray[] = $position->posName;
        }

          if(in_array($request['newrole'],$positionsarray))
             return redirect()->route('viewRolePage',['upgid'=>$upgid])->with('RoleExists','Position already exists');
         else
         {
              $rand = rand(1000,9999);
         // DB::table('position')->insert(['pos_id'=>$rand,'posName'=>$roleInfo['newrole'],'status'=>'active','client_id'=>$clientId,'motherPos'=>$motherposition,'posLevel'=>$posLevel]);
            DB::table('position')->insert(['pos_id'=>$rand,'posName'=>$request['newrole'],'status'=>'active','client_id'=>$clientId]);

         return redirect()->route('viewRolePage',['upgid'=>$upgid]);

         }

    }

    function addRole($upgid, Request $request)
    {
        $user = Auth::user();
         $clients = $this->getClientId($user->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
    	 $roleInfo = request()->all();

         if($roleInfo['motherpos']=='')
         {
            $motherposition = NULL;
            $posLevel = 0;
         }
         else
         {
            $motherposition = $roleInfo['motherpos'];
            //get level of motherpos
            // $motherposlevel = DB::table('position')->where('pos_id','=',$roleInfo['motherpos'])->select('posLevel')->get();
            $motherposlevel = DB::table('deppos')->where('deppos_id','=',$roleInfo['motherpos'])->select('posLevel')->get();

            foreach ($motherposlevel as $mlevel) {
                $motherposlvl = $mlevel->posLevel;
            }
            $posLevel = $motherposlvl + 1;
         }


            $positionDep = $roleInfo['deppos'];
        

         //look if newly entered position already exists
         $positions = DB::table('position')->get();
         $positionslist = array();
         foreach ($positions as $position) {
             $positionslist[] = strtolower($position->posName);
         }

         //detect if position already exists in the school
         $positionsarray = array();
         $positions = DB::table('position')->where('client_id','=',$clientId)->get();
         foreach ($positions as $position) {
           $positionsarray[] = $position->posName;
        }

          if(in_array($roleInfo['newrole'],$positionsarray))
             return redirect()->route('viewRolePage',['upgid'=>$upgid])->with('RoleExists','Position already exists');
         else
         {
              $rand = rand(1000,9999);
         // DB::table('position')->insert(['pos_id'=>$rand,'posName'=>$roleInfo['newrole'],'status'=>'active','client_id'=>$clientId,'motherPos'=>$motherposition,'posLevel'=>$posLevel]);
            DB::table('position')->insert(['pos_id'=>$rand,'posName'=>$roleInfo['newrole'],'status'=>'active','client_id'=>$clientId]);

         return $this->addDeppos($upgid,$roleInfo['deppos'],$rand,$motherposition,$posLevel);

         }
        

       
    }

    function addDeppos($upgid,$depid,$posid,$motherposition,$poslevel)
    {
        $id = rand(10,9999);
        DB::table('deppos')->insert(['deppos_id'=>$id,
                                        'pos_id'=>$posid,
                                        'pos_group_id'=>$depid,
                                        'deppos_status'=>'active',
                                        'posLevel'=>$poslevel,
                                        'motherPos'=>$motherposition]);

        return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid]);
    }

    function addExistingPosToDepartment(Request $request,$upgid,$depid)
    {

        // for($i=0;$i<count($request['depPos']);$i++)
        // {
            $newDepPos = $request['depPos'];
            $depPos = $depid;
            $posIdRand = rand(1,9999);
            //get existing info of newDepPos
            // $checkedDepPos = array(); //store checked positions
            // $checkedDepPosName = array();

            // $posInfos = DB::table('position')->where('pos_id','=',$newDepPos)->get();
            // foreach ($posInfos as $posInfo) {
            //     $posName = $posInfo->posName;
            //     $posClient = $posInfo->client_id;
            //     $posLevel = $posInfo->posLevel;
            //     $posParent = $posInfo->motherPos;

            //     $checkedDepPos[] = $posInfo;
            //     //$checkedDepPosName[] = $posName;
            // }

            //get head position
            $motherpos = $request['headpos'];
            if($request['headpos']=="none")
            {
                $posLevel = 0;
                $motherposition = NULL;
            }
            else
            {
                $motherposition = $motherpos;
                $motherposlevel = DB::table('deppos')->where('deppos_id','=',$motherpos)->select('posLevel')->get();

                    foreach ($motherposlevel as $mlevel) {
                        $motherposlvl = $mlevel->posLevel;
                    }
                    $posLevel = $motherposlvl + 1;
            }

            //get positions of dep
            //$depPositions = DB::table('position')->where('pos_group_id','=',$depid)->get();
            // $depPositions = DB::table('deppos')->where('pos_group_id','=',$depid)->get();



            // if(count($depPositions)==0)
            // {
                 // DB::table('position')->insert(['pos_id'=>$posIdRand,
                 //                            'posName'=>$posName,
                 //                            'posDescription'=>NULL,
                 //                            'pos_group_id'=>$depPos,
                 //                            'status'=>'active',
                 //                            'client_id'=>$posClient,
                 //                            'posLevel'=>$posLevel,
                 //                            'motherPos'=>$posParent]);
                DB::table('deppos')->insert(['deppos_id'=>$posIdRand,
                                                'pos_id'=>$newDepPos,
                                                'pos_group_id'=>$depPos,
                                                'deppos_status'=>'active',
                                                'posLevel'=>$posLevel,
                                                'motherPos'=>$motherposition]);
            //}
            // else if(count($depPositions)>0)
            // {
            //     $existingDepPos = array(); //array to store department's position names

            //     foreach ($depPositions as $depPosition) {
            //         //store to array
            //         $existingDepPos[] = $depPosition->pos_id;
            //     }

            //     for ($j=0; $j < count($checkedDepPos); $j++) { 
            //         if(!in_array($checkedDepPos[$j]->pos_id,$existingDepPos))
            //         {
            //             // DB::table('position')->insert(['pos_id'=>$posIdRand,
            //             //                     'posName'=>$posName,
            //             //                     'posDescription'=>NULL,
            //             //                     'pos_group_id'=>$depPos,
            //             //                     'status'=>'active',
            //             //                     'client_id'=>$posClient,
            //             //                     'posLevel'=>$posLevel,
            //             //                     'motherPos'=>$posParent]);
            //              DB::table('deppos')->insert(['deppos_id'=>$posIdRand,
            //                                     'pos_id'=>$newDepPos,
            //                                     'pos_group_id'=>$depPos,
            //                                     'deppos_status'=>'active']);

            //         }
            //     }


            // }

           



        //}

        //return $this->setPosToInactive($upgid,$existingDepPos,$request['depPos'],$depid);
        return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid]);

    }

    function setPosToInactive($upgid,$existingPosArray,$checkedPosArray,$depid)
    {

        $checkedDepPos = array();

        for ($i=0; $i < count($checkedPosArray); $i++) { 
            $posInfos = DB::table('deppos')->where('pos_id','=',$checkedPosArray[$i])->get();
            foreach ($posInfos as $posInfo) {
                $checkedDepPos[] = $posInfo->pos_id;
            }
        }

        for ($j=0; $j < count($existingPosArray); $j++) { 
            if(!in_array($existingPosArray[$j],$checkedDepPos))
            {
                // echo "<pre>";
                // var_dump($existingPosArray[$j]);
                DB::table('deppos')->where('pos_id','=',$existingPosArray[$j])
                                            ->where('pos_group_id','=',$depid)
                                            ->update(['deppos_status'=>'inactive']);
            }
        }

        return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid]);
    }

    function removeDeppos($upgid,$depid,$posid)
    {
        DB::table('deppos')->where('pos_id','=',$posid)->where('pos_group_id','=',$depid)
                            ->update(['deppos_status'=>'inactive']);

        return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid]);
    }

    function deletePosition($upgid,$roleid) //for roleView.blade.php
    {
        $countactiverole = DB::table('deppos')->where('pos_id','=',$roleid)->where('deppos_status','=','active')->count();

        if($countactiverole>0)
            return redirect()->route('viewRolePage',['upgid'=>$upgid])->with('activerole','Position is still active in department/s!');
        else
        {
            DB::table('position')->where('pos_id',$roleid)->update(['status'=>'inactive']);

             return redirect()->route('viewRolePage',['upgid'=>$upgid])->with('removerole','Position removed.');
        }
    }

    function deleteRole($upgid,$roleid)
    {

        //get group_id of to be deleted pos_id
        // $posInfos = DB::table('position')->where('pos_id','=',$roleid)->get();
        // foreach ($posInfos as $posInfo) {
        //     $pos_group_id = $posInfo->pos_group_id;
        // }
        //detect if role is still used in any department/s
        // $countactiverole = DB::table('userpositiongroup')->where('position_pos_id','=',$roleid)->where('upg_status','=','active')->count();
        $countactiverole = DB::table('deppos')->where('pos_id','=',$roleid)->where('deppos_status','=','active')->count();

        if($countactiverole>0)
            return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$pos_group_id])->with('activerole','Position is still active in department/s!');
        else
        {
            DB::table('position')->where('pos_id',$roleid)->update(['status'=>'inactive']);

             return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$pos_group_id])->with('removerole','Position removed.');
        }
    }

    function editRole($upgid,$roleid,Request $request)
    {
         $info = request()->all();
       //  //validate if edited role already exists aside from its name
        //$samePosNameCount = 0;

        // $posnames = DB::table('position')->where('pos_id','=',$roleid)->get();
        // foreach ($posnames as $posname) {
        //     $posID = $posname->pos_id;
        //     $posName = $posname->posName;
        // }
         //get group_id of roleid
       //   $posInfos = DB::table('position')->where('pos_id','=',$roleid)->get();
       //  if(($posID!=$roleid) && ($posName==$info['role']))
       //      $samePosNameCount++;

       // if($samePosNameCount==0)
       // {
            DB::table('position')->where('pos_id','=',$roleid)->update(['posName'=>$info['role'],
                                                                 'posDescription'=>$info['roledesc']]);
        // }

        // if($samePosNameCount>0)
        // {
        //     return redirect()->route('viewRolePage',['upgid'=>$upgid])->with('takenposname','Position Name already exists.');
        // }
        // else
             return redirect()->route('viewRolePage',['upgid'=>$upgid]);
    }
}
