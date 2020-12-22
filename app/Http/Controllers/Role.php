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
      
      $user = Auth::user();
      $clients = $this->getClientId($user->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
      $dpGroupName = DB::table('deppos as dp')
                        ->where('dp.pos_group_id','=',$depid)
                        ->where('dp.pos_id','=',$request['depPos'])
                        ->join('position as p','dp.pos_id','p.pos_id')
                        ->get();
      if(count($dpGroupName)==0){      
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
// dd($request->all());
          // $posDescrip= DB::table('position')->where($request['depPos'],'=',$requ)
$posStud= DB::table('position')->where('pos_id','=',$request['depPos'])->pluck('posName');

foreach ($posStud as  $posStude) {
    $posStudent = $posStude;
}
if($posStudent == 'Student')
{
                  DB::table('deppos')->insert(['deppos_id'=>$posIdRand,
                                                'pos_id'=>$request['depPos'],
                                                'pos_group_id'=>$request['deppos'],
                                                'deppos_status'=>'active',
                                                'posLevel'=>$posLevel,
                                                'motherPos'=>$motherposition]);

              // $orgchartcontroller = new OrgChartController();

              // return $orgchartcontroller->addOrgChartNode($upgid,$depPos,$randUPG);
              return redirect()->route('showDep',['upgid'=>$userupgid,'id'=>$depid]);
              }


else{
//IF STUDENT DLI NALANG MAG ADD UG UNDEFINE UG INSERT PD SA DEPPOS NGA TABLE
//get position id sa student ($request['depPos'])
//find nga nag enroll ug student nga same ug group
// $enrolledstud= DB::table('userpositiongroup as upg')->where('group_group_id','=',$request['deppos']);
              // if nakita na{
                // DB::table('deppos')->insert(['deppos_id'=>$posIdRand,
//                                                 'pos_id'=>$request['depPos'],
//                                                 'pos_group_id'=>$request['deppos'],
//                                                 'deppos_status'=>'active',
//                                                 'posLevel'=>$posLevel,
//                                                 'motherPos'=>$motherposition]);

//               $orgchartcontroller = new OrgChartController();

//               return $orgchartcontroller->addOrgChartNode($upgid,$depPos,$randUPG);
              // }



// TO BE DETERMINED
        $randUPG = rand(10,10000);
        $randPOSID = rand(10,1000);
        DB::table('userpositiongroup')->insert(['upg_id'=>$randUPG,
                                                'position_pos_id'=> $posIdRand,
                                                'rights_rights_id'=>'2',
                                                'user_user_id'=>'999999',
                                                'client_id'=>$clientId,
                                                'group_group_id'=>$depPos,
                                                'upg_status'=>'active']);


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

              $orgchartcontroller = new OrgChartController();

              return $orgchartcontroller->addOrgChartNode($upgid,$depPos,$randUPG);
            }
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
        // return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid]);

    }
    else{
      return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid]);
    }
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
      //only for 1 group
      $orgchartParents = DB::table('deppos as dp')->where('pos_id','!=','12345')->where('pos_group_id','=',$depid)->where('pos_id','=',$posid)->get();
      foreach ($orgchartParents as $orgchartParent) {
        $ParentOrgchart = $orgchartParent->deppos_id;
      }
      // dd($orgchartParents);
      $findParents = DB::table('deppos as dp')->where('pos_id','!=','12345')->where('motherPos','=',$ParentOrgchart)->get();
      // dd(count($findParents);
      if(count($findParents)==0){
        // dd('madelete');
      //deleting data on table
        $getdepposIDs=DB::table('deppos')->where('pos_id','=',$posid)->where('pos_group_id','=',$depid)->get();
        foreach ($getdepposIDs as $gdID) {
          $getdepposID = $gdID->deppos_id;
        }
        $getUpgIdDelNodes = DB::table('userpositiongroup as upg')
                               ->where('upg.position_pos_id','=',$getdepposID)
                               ->join('orgchartnode as on','upg.upg_id','on.upg_id')
                               ->get();
        
        DB::table('deppos')->where('pos_id','=',$posid)->where('pos_group_id','=',$depid)
                            ->delete();
                            
        DB::table("userpositiongroup")->where("position_pos_id",'=',$getdepposID)->where('user_user_id','!=','999999')->update(['upg_status'=>'inactive']);
        DB::table("userpositiongroup")->where("position_pos_id",'=',$getdepposID)->where('user_user_id','=','999999')->delete();

        foreach ($getUpgIdDelNodes as $gUPGDN) {
            $getUpgIdDelNode = $gUPGDN->upg_id;
             DB::table('orgchartnode')->where('upg_id','=',$getUpgIdDelNode)->delete();
        }
        // $orgchartcontroller = new OrgChartController();

        // return $orgchartcontroller->removeOrgChartNode($upgid,$getUpgIdDelNode,$depid);
        return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid]);
      }
      else{
        //getting parent title
        // dd($findParents);
        foreach ($findParents as $findP) {
          $findParent = $findP->pos_id;
        }
        $findParentTitles = DB::table('position')->where('pos_id','=',$findParent)->select('posName')->get();

        foreach ($findParentTitles as $findPT) {
          $findParentTitle= $findPT->posName;
        }
        // dd($findParentTitle[0]);
        return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid])->with("delDepHaveChild","Delete '".$findParentTitle."' (Position Title) first before deleting this Position Title.");
      }
    }

    //     function removeDepposOrg(Request $upgid,$depid,$posid)
    // {
    //     DB::table('deppos')->where('pos_id','=',$posid)->where('pos_group_id','=',$depid)
    //                         ->update(['deppos_status'=>'inactive']);


    //     return redirect()->route('addExistingPos',['upgid'=>$upgid,'depid'=>$depid]);
    // }
        function addExistingPosToDepartmentUndefine(Request $request,$upgid,$depid)
    {


      //for editing undefine position assignment

              //for deleteing and inactive for undefine position assignment
                 // DB::table("userpositiongroup")->where("upg_id",$request['assupgidund'])->update(['upg_status'=>'inactive']);
                 // DB::table('orgchartnode')->where('upg_id','=',$request['assupgidund'])->delete();

                // DB::table('deppos')->where('pos_id','=','12345')->where('pos_group_id','=',$depid)
                            // ->update(['deppos_status'=>'inactive']);


                // foreach ($depposChanges as $depposChange) {
                //     $depposIdWillChange = $depposChange->motherPos;
                // }

                //ang bag'o nga depposID


        // for($i=0;$i<count($request['depPos']);$i++)
        // {
            $newDepPos = $request['depPos'];
            // dd($request['assupgidund']);
            $depPos = $depid;
            $posIdRand = $this->groupIdRandomizeId();
            // $posIdRand = rand(1,9999);
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
                // DB::table('deppos')->insert(['deppos_id'=>$posIdRand,
                //                                 'pos_id'=>$newDepPos,
                //                                 'pos_group_id'=>$depPos,
                //                                 'deppos_status'=>'active',
                //                                 'posLevel'=>$posLevel,
                //                                 'motherPos'=>$motherposition]);

                DB::table('deppos')->where('pos_id','=','12345')->where('pos_group_id','=',$depid)
                                   ->update(['pos_id'=>$newDepPos,
                                             'posLevel'=>$posLevel,
                                             'motherPos'=>$motherposition]);
                
                // DB::table('orgchartnode')->where('upg_id','=',$request['assupgidund'])->update(['upg_id'=>$newDepPos]);
               

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

              //for changing motherposition of undefine position assignment
                // $depposUndefine=DB::table('deppos')->where('pos_id','=','12345')->where('pos_group_id','=',$depid)->where('deppos_status','=','inactive')->get();
                // foreach ($depposUndefine as $depposUndefines) {
                //     $depposbago = $depposUndefines->deppos_id;
                // }


                //  DB::table('deppos')->where('motherPos','=',$depposbago)->update(['motherPos'=>$posIdRand]);

        //return $this->setPosToInactive($upgid,$existingDepPos,$request['depPos'],$depid);
        return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid]);

    }

        function groupIdRandomizeId(){
        $posIdRand=rand(1,99999);
        $idExist= DB::table('group as g')
                            ->where('g.group_id','=',$posIdRand)
                            // ->where('g.group_id','=',$rand)
                            ->get();

                            
        if(count($idExist)>0){
            
            $this->groupIdRandomize();
        }
        else
        {
            
            return $posIdRand;
        }

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
