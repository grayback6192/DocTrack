<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;


class Department extends Controller
{
    function getClientId($userid){
        $clientgroup = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                        ->distinct()
                        ->get();
            return $clientgroup;
    }

    function showDep($upgid,$depid)
    {
        $name = Auth::user(); 
        $admingroup = getAdminGroup($upgid);
    	$depInfo = DB::table('group')->where(['group_id'=>$depid])->where('status','=','active')->get();
        $subgroups = DB::table('group')->where('group_group_id','=',$depid)->where('status','=','active')->get();
        $clientid = getAdminClient($upgid);

        //get org chart file only
        // $orgchart = new OrgChart;
        // $deporgchart = $orgchart->show($depid);

        //get org chart info
        //$orgchartInfos = DB::table('orgchart')->where('group_id','=',$depid)->get();

        //get pos_id where position name = masteradmin
        $masteradminpos = DB::table('position')->where('posName','=','masteradmin')->where('client_id','=',$clientid)->get();
        foreach ($masteradminpos as $masteradmin) {
            $masteradminposid = $masteradmin->pos_id;
        }

        //if department id has no client_id (mothergroup), masteradmin is automatically part of admin
        //get master admin of depid
        $adminid = DB::table('position')->where('posName','=','Admin')
                                        ->where('client_id','=',$clientid)
                                        ->get();
        if(count($adminid)>0)
        {
            foreach ($adminid as $key) {
            $adminposid = $key->pos_id;
            }
        }
        else
        {
            $adminid = rand(10,10000000);
            DB::table('position')->insert(['pos_id'=>$adminid,
                                            'posName'=>'Admin',
                                            'posDescription'=>'',
                                            'status'=>'active',
                                            'client_id'=>$clientid]);
            //retrieve new position
            $newadminid = DB::table('position')->where('posName','=','Admin')
                                                ->where('client_id','=',$clientid)
                                                ->get();
            foreach ($newadminid as $key) {
                $adminposid = $key->pos_id;
            }

        }
        
        

        //get group admins
        $admins = DB::table('userpositiongroup as upg')
                    ->where('upg.group_group_id','=',$depid)
                    ->where('upg.rights_rights_id','=',1)
                    //->where('upg.position_pos_id','!=',$position_id)
                    ->where('upg_status','=','active')
                    ->join('user as u','upg.user_user_id','u.user_id')
                    ->get();   

        //to be changed
         $members = DB::table('userpositiongroup as upg')
                    ->where('upg.client_id','=',$clientid)
                    ->where('upg.upg_status','=','active')
                     ->join('user as u','upg.user_user_id','u.user_id')
                    // ->join('position as p','upg.position_pos_id','p.pos_id')
                    ->select([DB::raw('DISTINCT(u.user_id)'),'u.user_id','u.lastname','u.firstname'])
                    ->get();   

        //members who already is an admin/masteradmin of the department
        $adminusers = DB::table('userpositiongroup')
                    // ->where('client_id','=',$clientid)
                    ->where('group_group_id','=',$depid)
                    // ->where('position_pos_id','=',$masteradminposid)
                    // ->orWhere('position_pos_id','=',$adminposid)
                     ->where('rights_rights_id','=',1)
                     ->where('upg_status','=','active')
                    ->get();

        $adminusersarray = array(); //used to store users that are admin of department
        foreach ($adminusers as $adminuser) {
            $adminusersarray[] = $adminuser->user_user_id;
        }

        // $depPositions = DB::table('deppos')->where('pos_group_id','=',$depid)->where('deppos_status','=','active')->get();
        $depPositions = DB::table('deppos as dp')->where('dp.pos_group_id','=',$depid)
                        ->where('dp.deppos_status','=','active')
                        ->join('position as p','dp.pos_id','p.pos_id')
                        ->get();

            $depPosition1 ='';
        foreach ($depPositions as $depPosition) {
                $depPosition1 = $depPosition->posName;
            }

        //to view all positions
        $allpositions = DB::table('position')->where('client_id','=',$clientid)
                                            ->where('status','=','active')
                                            ->orderBy('posName')
                                            ->get();

        //depPos with department
        $departmentPositions = DB::table('deppos as dp')
                                ->join('position as p','dp.pos_id','p.pos_id')
                                ->where('p.client_id','=',$clientid)
                                ->join('group as g','dp.pos_group_id','g.group_id')
                                ->orderBy('p.posName')
                                ->get();


        //depPos with departmentHead Defined 
        $positionHeadss = DB::table('deppos as dp')
                            ->join('position as p','dp.pos_id','p.pos_id')
                            ->where('dp.pos_group_id','=',$depid)
                            ->where('dp.deppos_status','=','active')
                            ->join('group as g','dp.pos_group_id','g.group_id')
                            // ->select('dp.motherPos')
                            // ->where('g.client_id','=',$clientid)
                            // ->orderBy('p.posName')
                            ->get();
                            // dd($positionHeadss);
        // foreach ($positionHeadss as $positionHeads) {
        //     $positionHead = $positionHeads->group_group_id;
        // }
        // $positionheadfirst = DB::table('deppos as dp')
        //                         ->where('dp.pos_group_id','=',$positionHead);
        $positionHeadGetGroups = '';
        $positionHeadGetGroups = DB::table('group as g')
                                ->where('g.group_id','=',$depid)
                                ->select('group_group_id')
                                ->get();
        foreach ($positionHeadGetGroups as $positionHeadGetGroup) {
            $positionheadgroup = $positionHeadGetGroup->group_group_id;
        }

            
        $positionHeadFirsts = '';
        $positionHeadFirsts = DB::table('deppos as dp')
                                ->join('position as p','dp.pos_id','p.pos_id')
                                // ->where('dp.pos_group_id','=',$depid)
                                ->where('dp.deppos_status','=','active')
                                ->where('dp.pos_group_id','=',$positionheadgroup)
                                ->select('dp.deppos_id')
                                ->get();
        $positionHeadFirst='';
        foreach ($positionHeadFirsts as $phf) {
            $positionHeadFirst = $phf->deppos_id;
        }
        // dd($positionHeadFirst);
        $lastnaka='';
        $lastnaka = DB::table('deppos as dp')
                                ->join('position as p','dp.pos_id','p.pos_id')
                                ->where('dp.deppos_id','=',$positionHeadFirst)
                                ->join('group as g','dp.pos_group_id','g.group_id')
                                ->orderBy('p.posName')
                                ->get();
        
        //PARA SA immideate head ang above department nga ang iyahang motherPos kay dli nila grouptitle
        // foreach ($lastnaka as $lastnakatest) {
        //     $lastnka = $lastnakatest->motherPos;
        //     $lastnkadepid = $lastnakatest->pos_group_id;
        // }


        // $getmothers= DB::table('deppos as dp')
        //                     ->where('dp.deppos_id','=',$lastnka)
        //                     ->where('dp.pos_group_id','!=',$lastnkadepid)
        //                     ->get();

        // $lastnkapost= DB::table('deppos as dp')
        //                         ->join('position as p','dp.pos_id','p.pos_id')
        //                         ->where('dp.motherPos','=',$lastnka)
        //                         ->where('dp.deppos_status','=','active')
        //                         ->join('group as g','dp.pos_group_id','g.group_id')
        //                         ->orderBy('p.posName')
        //                         ->get();

        $positionHeadFirsts1 = '';
        $positionHeadFirsts1 = DB::table('deppos as dp')
                                ->join('position as p','dp.pos_id','p.pos_id')
                                // ->where('dp.pos_group_id','=',$depid)
                                ->where('dp.deppos_status','=','active')
                                ->where('dp.pos_group_id','=',$positionheadgroup)
                                ->get();
        $positionHeadFirsts2 = DB::table('deppos as dp')
                                ->join('position as p','dp.pos_id','p.pos_id')
                                // ->where('dp.pos_group_id','=',$depid)
                                ->where('dp.deppos_status','=','active')
                                ->where('dp.pos_group_id','=',$positionheadgroup)
                                ->select('dp.deppos_id')
                                ->get();     

              $positionHeadFirst2='';
              $lastnka = '';                  
            foreach ($positionHeadFirsts1 as $key => $value) {
                $valDeppos = $value->deppos_id;
                $valMotherpos = $value->motherPos;
                foreach ($positionHeadFirsts2 as $phf2) {
                    $positionHeadFirst2 = $phf2->deppos_id;
                    if($positionHeadFirst2!=$valMotherpos){
                        $lastnka  = DB::table('deppos as dp')
                                ->join('position as p','dp.pos_id','p.pos_id')
                                ->where('dp.deppos_id','=',$valDeppos)
                                ->join('group as g','dp.pos_group_id','g.group_id')
                                ->orderBy('p.posName')
                                ->get();
                }
            }
        }


//for position head nga daghan position title sa upper department
$currentGetPosHeads =DB::table('userpositiongroup as upg')
                        ->where('upg.group_group_id','=',$depid)
                        ->join('deppos as dp','upg.position_pos_id','dp.deppos_id') 
                        ->get();
$currentGetPosHead='';
foreach ($currentGetPosHeads as $cgph) {
    $currentGetPosHead = $cgph->motherPos;
}
// $getDepposIdGroup = DB::table('deppos as dp')
//                         ->where('dp.deppos_id','=',$currentGetPosHead)
//                         ->join('userpositiongroup as upg','dp.deppos_id','upg.position_pos_id')
//                         // ->where('upg.user_user_id','!=','999999')
//                         ->join('position as p','dp.pos_id','p.pos_id')
//                         ->join('group as g','dp.pos_group_id','g.group_id')
//                         ->orderBy('p.posName')
//                         ->get();
$getDepposIdGroups = DB::table('deppos as dp')
                        ->where('dp.deppos_id','=',$currentGetPosHead)
                        ->join('userpositiongroup as upg','dp.deppos_id','upg.position_pos_id')
                        // ->where('upg.user_user_id','!=','999999')
                        ->join('position as p','dp.pos_id','p.pos_id')
                        ->join('group as g','dp.pos_group_id','g.group_id')
                        ->orderBy('p.posName')
                        ->get();
                        // dd(count($getDepposIdGroups));
if(count($getDepposIdGroups)==0){
    $kani2 = $getDepposIdGroups;
}
else{

            foreach ($getDepposIdGroups as $gdig) {
                $DepposIdGroup = $gdig->pos_group_id;
            }

            $kani =DB::table('deppos as dp')->where('pos_group_id','=',$DepposIdGroup)->min('posLevel');
            
            $kani2 = DB::table('deppos as dp')->where('pos_group_id','=',$DepposIdGroup)->where('posLevel','<=',$kani)
                        ->join('userpositiongroup as upg','dp.deppos_id','upg.position_pos_id')
                        // ->where('upg.user_user_id','!=','999999')
                        ->join('position as p','dp.pos_id','p.pos_id')
                        ->join('group as g','dp.pos_group_id','g.group_id')
                        ->orderBy('p.posName')
                        ->get();
            // dd($kani2);
    }


        //     $positionHeadFirst = '';
        // $positionHeadFirst = DB::table('deppos as dp')
        //                         ->join('position as p','dp.pos_id','p.pos_id')
        //                         // ->where('dp.pos_group_id','=',$depid)
        //                         ->where('dp.deppos_status','=','active')
        //                         ->where('dp.deppos_id','=',$positionHeadFirstMotherposition)
        //                         ->join('group as g','dp.pos_group_id','g.group_id')
        //                         ->where('g.client_id','=',$clientid)
        //                         ->orderBy('p.posName')
        //                         ->get();

//getHeadUndefine
        $getundefineheadmotherposs = DB::table('deppos as dp')
                                ->where('dp.pos_group_id','=',$depid)
                                ->select('motherPos')
                                ->get();
        $getundefineheadmotherpos='';
        foreach ($getundefineheadmotherposs as $guhmp) {
            $getundefineheadmotherpos = $guhmp->motherPos;
        }
        
        $checkundefinehead = DB::table('deppos as dp')
                                    ->where('dp.deppos_id','=',$getundefineheadmotherpos)
                                    ->where('dp.pos_id','=','12345')
                                    ->get();



        //array to store position infos
        $posArray = array();

         $depPos = DB::table('deppos as dp')->where('dp.pos_group_id','=',$depid)
                                            ->where('dp.deppos_status','=','active')
                                            ->join('position as p','dp.pos_id','p.pos_id')
                                            ->get();
            if(count($depPos)>0)
            {
                foreach ($depPos as $pos) {
                    $pos = json_decode(json_encode($pos),true);
                    $posArray[] = $pos;
                }
            }

            foreach ($allpositions as $allposition) {
 
                $sameposcount = 0;
                for ($i=0; $i < count($posArray); $i++) { 
                    if($posArray[$i]['pos_id'] == $allposition->pos_id)
                        $sameposcount++;
                }

                if($sameposcount == 0)
                {
                    $allposition = json_decode(json_encode($allposition),true);
                    $posArray[] = $allposition;
                }
            }

        //sort array alphabetically
       usort($posArray, array($this,"compareByName"));


        //assignments of department
        $depAssignments = DB::table('userpositiongroup as upg')->where('upg.group_group_id','=',$depid)
                                                        ->where('upg.upg_status','=','active')
                                                        // ->join('position as p','upg.position_pos_id','=','p.pos_id')
                                                        ->join('deppos as dp','upg.position_pos_id','dp.deppos_id')
                                                        ->join('position as p','dp.pos_id','p.pos_id')
                                                        ->join('rights as r','upg.rights_rights_id','=','r.rights_id')
                                                        ->join('user as u','upg.user_user_id','=','u.user_id')
                                                        ->get();
                                                        
        //get positions of department
        // $departmentPos = DB::table('position')->where('pos_group_id','=',$depid)
        //                                     ->where('status','=','active')
        //                                     ->get();
        //get people that belongs to the department
        $depUsers = DB::table('userpositiongroup as upg')->where('upg.group_group_id','=',$depid)
                                                        ->join('user as u','upg.user_user_id','u.user_id')
                                                        ->where('upg.upg_status','=','inactive')
                                                        ->distinct()
                                                        ->get();
                                                        // dd($depUsers);
 
 //assignment and position name must be filled
    $getDepposId= DB::table('deppos as dp')
                        ->where('dp.pos_group_id','=',$depid)
                        ->where('dp.deppos_status','=','active')
                        ->select('deppos_id')
                        ->get();
          
        $getdepid='';
        $assignmentAndposition  = '0';
         foreach($getDepposId as $gdi) {
        $getdepid = $gdi->deppos_id;

        $getDepposIdPosition = DB::table('deppos as dp')
                        ->where('dp.pos_group_id','=',$depid)
                        ->where('dp.deppos_status','=','active')
                        ->join('userpositiongroup as upg','dp.deppos_id','upg.position_pos_id')
                        ->where('upg.position_pos_id','=',$getdepid)
                        ->distinct()
                        ->get();

        if($getDepposIdPosition->isEmpty()){
            $assignmentAndposition = '1';
        }     

    }
//edit positions assignment
    $positionHeadGetDataDP = DB::table('deppos as dp')
                                ->where('dp.pos_group_id','=',$depid)
                                ->where('dp.deppos_status','=','active')
                                ->get();
    $positionHeadGetDataUPG = DB::table('userpositiongroup as upg')
                                ->where('upg.group_group_id','=',$depid)
                                ->select('upg.position_pos_id')
                                ->get();
    

// dd($departmentPositions);
        return view('admin/depProfile',['depid'=>$depid, 
                                        'depinfos'=>$depInfo, 
                                        'User'=>$name, 
                                        'subgroups'=>$subgroups, 
                                        'depid'=>$depid,
                                        'adminposid'=>$adminposid,
                                        'masteradminposid'=>$masteradminposid,
                                        'adminusersarray'=>$adminusersarray,
                                        'admins'=>$admins,
                                        'members'=>$members,
                                        'upgid'=>$upgid,
                                        'admingroup'=>$admingroup,
                                        'depAssignments'=>$depAssignments,
                                        'users'=>$depUsers,
                                        'positions'=>$allpositions,
                                        'posArray'=>$posArray,
                                        'depPositions'=>$depPositions,
                                        'posHeads'=>$departmentPositions,
                                        'posHeadFirstUndefine'=>$kani2,
                                        'posHeadFirst'=>$positionHeadss,
                                        'checkundefinehead'=>$checkundefinehead,
                                        'assignmentAndposition'=>$assignmentAndposition,
                                        'depPosition1'=>$depPosition1]);

      

        // echo "<pre>";
        // var_dump($depAssignments);
    }

    function editDepartment($upgid, $depid){
        $user = Auth::user();
        $depInfo = request()->all();
        


    }
     function compareByName($a, $b){
            return $a['posName'] > $b['posName'];
        }

    function showDepInfo($upgid,$depid)
    {
        $name = Auth::user(); 
        $dep = DB::table('group')->where('group_id',$depid)->get();
        $clients = getClientId($name->user_id);
         foreach ($clients as $client) {
            $clientId = $client->client_id;
        }

        $admingroup = getAdminGroup($upgid);

        foreach ($dep as $key) {
            $depMotherGroup = $key->group_group_id;
        }

        $motherGroups = DB::table('group')->where('status','=','active')->where('client_id','=',$clientId)
                                                                        ->orWhere('group_id','=',$clientId)
                                                                        ->orderBy('groupName','asc')
                                                                        ->get();
        
        return view('admin/depProfileEdit',['depId'=>$depid],
                                            ['depInfos'=>$dep, 'User'=>$name, 'motherGroups'=>$motherGroups,'upgid'=>$upgid,'admingroup'=>$admingroup,'depMotherGroup'=>$depMotherGroup,'clientID'=>$clientId]);
    }

    function editDep($upgid,$depid)
    {
        $user = Auth::user();
         $depInfo = request()->all();

        $depValidator = Validator::make($depInfo,[
            'depname' => 'required',
            'depKey' => 'required',
        ]);

        if($depValidator->fails())
        {
            return redirect()->route('editDep',['upgid'=>$upgid,'depid'=>$depid])->withErrors($depValidator);
        }

        if($depInfo['mothergroup']==''){
            $mothergroup = $this->getClientId($user->user_id);
        foreach ($mothergroup as $client) {
            $mg = $client->client_id;
        }
        }
        else if($depInfo['mothergroup']=="NULL")
            $mg = NULL;
        else
        {
            $mg = $depInfo['mothergroup'];
        }
        
       
        DB::table('group')->where('group_id',$depid)->update(['groupName'=>$depInfo['depname'],
                                                            'groupDescription'=>$depInfo['depDesc'],
                                                            'group_group_id'=>$mg,
                                                            'businessKey'=>$depInfo['depKey']]);

        // return $this->showDep($upgid,$depid)->with('edited','Department information has been edited.');
        return redirect()->route('showDep',['upgid'=>$upgid,'depid'=>$depid])->with('edited','Department information has been edited.');
    }

    function addDep($upgid,$depid)
    {
         $user = Auth::user(); 
         $dep = request()->all();


        // if($dep['mothergroup']==''){
        //     $mothergroup = $this->getClientId($user->user_id);
        // foreach ($mothergroup as $client) {
        //     $mg = $client->client_id;
        // }
        // }
        // else
        // {
        //     $mg = $dep['mothergroup'];
        // }
         $mg = $dep['motherDep'];

         $clients = $this->getClientId($user->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }

        $rand = $this->groupIdRandomize();
        DB::table('group')->insert(['group_id'=>$rand,
                                    'groupName'=>$dep['depname'], 'groupDescription'=>$dep['depDesc'], 'status'=>'active',
                                    'group_group_id'=>$mg,
                                    'client_id'=>$clientId,
                                    'creator_user_id'=>$user->user_id,
                                    'businessKey'=>$dep['depKey']]);


        //vieworgchart when adding department

         $orgchartid = rand(10,10000);

        DB::table('orgchart')->insert(['orgchart_id'=>$orgchartid,
                                        'group_id'=>$rand]);


         $depparent = (new Department)->getMotherGroup($upgid,$rand);
        if($depparent!=NULL)
        {
                $ancestornodes = DB::table('orgchart as o')->where('o.group_id','=',$depparent)
                                                        ->join('orgchartnode as on','o.orgchart_id','on.orgchart_id')
                                                        ->get();
                if((count($ancestornodes))>0){
                     foreach ($ancestornodes as $ancestornode) {
                    DB::table('orgchartnode')->insert(['orgchart_id'=>$orgchartid,
                                                    'upg_id'=>$ancestornode->upg_id]);
                }
               
                }
        }



        // // TO BE DETERMINED
        $randUPG = rand(10,10000);
        $randPOSID = rand(10,1000);
        DB::table('userpositiongroup')->insert(['upg_id'=>$randUPG,
                                                'position_pos_id'=> $randPOSID,
                                                'rights_rights_id'=>'2',
                                                'user_user_id'=>'999999',
                                                'client_id'=>$clientId,
                                                'group_group_id'=>$rand,
                                                'upg_status'=>'active']);

        $motherposDets= DB::table('group')->where('group.group_id','=',$rand)
                                         ->join('deppos','group.group_group_id','deppos.pos_group_id')
                                         ->get();

            if($motherposDets->isEmpty()){

   DB::table('deppos')->insert(['deppos_id'=>$randPOSID,
                                        'pos_id'=>'12345',
                                        'pos_group_id'=>$rand,
                                        'deppos_status'=>'active',
                                        'posLevel'=>'2']);
        }
        else
        {
                        foreach ($motherposDets as $motherposDet) {
                   $motherpositiondepartment = $motherposDet->deppos_id;
                }
        // $nulltext = "null";

            DB::table('deppos')->insert(['deppos_id'=>$randPOSID,
                                        'pos_id'=>'12345',
                                        'pos_group_id'=>$rand,
                                        'deppos_status'=>'active',
                                        'posLevel'=>'2',
                                        'motherPos'=>$motherpositiondepartment]);
        }



        $admingroup = getAdminGroup($upgid);


          $orgchartcontroller = new OrgChartController();

              return $orgchartcontroller->addOrgChartNode($upgid,$rand,$randUPG);
     
        return redirect()->route('addneworgchart',['upgid'=>$upgid,'depid'=>$rand]);

        // return redirect()->route('showDep',['upgid'=>$upgid,'depid'=>$rand]);

 
    }
    function groupIdRandomize(){
        $rand=rand(10,100);
        $idExist= DB::table('group as g')
                            ->where('g.group_id','=',$rand)
                            ->get();

                            
        if(count($idExist)>0){
            
            $this->groupIdRandomize();
        }
        else
        {
            
            return $rand;
        }

    }

    function deleteDep($upgid,$depid,$currentdepid)
    {
        $subgroups = DB::table('group')->where('group_group_id','=',$depid)->where('status','=','active')->get();
        $upgidOrg = DB::table('userpositiongroup')->where('group_group_id','=',$depid)->join('orgchartnode','userpositiongroup.upg_id','orgchartnode.upg_id')->get();
        $orgupgid='';
        foreach ($upgidOrg as $upgidOrgs) {
                   $orgupgid = $upgidOrgs->orgchartnode_id;
                }
        // dd($subgroups)
        if($subgroups->isEmpty()){
// return redirect()->back()->with('alert','hello');
            // dd($orgupgid);

            DB::table('deppos')->where('pos_group_id','=',$depid)->delete();

            if($orgupgid!='')
                DB::table('orgchartnode')->where('orgchartnode_id','=',$orgupgid)->delete();
        
            DB::table('userpositiongroup')->where('group_group_id','=',$depid)->update(['upg_status'=> 'inactive', 'position_pos_id' => NULL,'group_group_id'=> NULL]);
            DB::table('group')->where('group_id','=',$depid)->delete();


            return redirect()->route('showDep',['upgid'=>$upgid,'depid'=>$currentdepid])->with('alert','successfully deleted the department');
        }
        else{
            // dd($subgroups);
        // DB::table('group')->where('group_id',$depid)->update(['status'=>'inactive']);
        // return $OrgChartController->getGroupOrgChartDel($upgid,$currentdepid);

        return redirect()->route('showDep',['upgid'=>$upgid,'depid'=>$currentdepid])->with('info','Delete subgroup/s first before deleting this department.');
        // return $this->showDep($upgid,$depid);
    }
    }

     function viewGroups($userid,$depid)
    {
         $name = Auth::user();
        $clients = $this->getClientId($name->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
           $listDep = DB::table('group')->where('group_group_id','=',$depid)->where(['status'=>'active'])->get();

           //get parent group of depid for back
           $depParentId = DB::table('group')->where('group_id','=',$depid)->get();
           foreach ($depParentId as $parentId) {
               $depParent = $parentId->group_group_id;
           }

           return view('user/addGroup',['groups'=>$listDep,'User'=>$name,'depid'=>$depid,'clientId'=>$clientId,'parentDep'=>$depParent]);
    }

    function viewServiceOwners($upgid) //for user side
    {
        $name = Auth::user();
        $clients = $this->getClientId($name->user_id);
        $deps = array();
    
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
           $listDep = DB::table('group')->where('client_id','=',$clientId)->where(['status'=>'active'])->get();

           foreach ($listDep as $list) {
               $serviceCount = \DB::table('template')->where('group_group_id','=',$list->group_id)->where('status','=','active')->get();

               if(count($serviceCount)>0)
               {
                    $deps[] = $list;
               }
           }

           $numunread = getNumberOfUnread($upgid);
        
            return view('user/groups',['departments'=>$deps,'User'=>$name,'upgid'=>$upgid,'numUnread'=>$numunread]);
           // echo "<pre>";
           // var_dump($deps);
        }

        function setToActive($depid)
        {
            DB::table('group')->where('group_id','=',$depid)->update(['status'=>'active']);

            return response()->json('successfully updated to active');
        }

        function setToInactive($depid)
        {
            DB::table('group')->where('group_id','=',$depid)->update(['status'=>'inactive']);

            return response()->json('successfully updated to inactive');
        }

        function getAncestors($upgid,$depid)
        {
            $parentarray = array();

            return $this->getGroupFamily($upgid,$depid,$parentarray);
        }

        function getGroupFamily($upgid,$depid,$array)
        {
            //get ancestors of group
            
            $parentgroup = DB::table('group')->where('group_id','=',$depid)->get();
            foreach ($parentgroup as $key) {
                $parentid = $key->group_group_id;
            }

            if($parentid==NULL)
            {
                return $array;
            }
            else{
                $array[] = $parentid;
                return $this->getGroupFamily($upgid,$parentid,$array);
            }
        }

        function getDescendants($upgid,$depid)
        {
            $childrenarray = array();

            return $this->getGroupChildren($upgid,$depid,$childrenarray);
        }

        function getGroupChildren($upgid,$depid,$array)
        {
            //get descendants of group
            $temparray = array();
            $childrengroup = DB::table('group')->where('group_group_id','=',$depid)->get();

            if((count($childrengroup)) > 0)
            {
                  foreach ($childrengroup as $children) 
                  {
                    $childId = $children->group_id;
                    $array[] = $childId;
                    $temparray[] = $childId;
                }
                    return $this->getAllChildren($upgid,$childId,$array,$temparray); 
             }
             else
                return $array;
          
        }

        function getAllChildren($upgid,$depid,$array,$temparray)
        {
            //$temparray = array();
            $countNullChildren = 0;

            for ($i=0; $i < count($temparray); $i++) { 
                $childrengroup = DB::table('group')->where('group_group_id','=',$temparray[$i])->get();

                if((count($childrengroup))==0)
                    $countNullChildren++;
                else if((count($childrengroup))>0)
                {
                    foreach ($childrengroup as $children) {
                        $childId = $children->group_id;
                        $array[] = $childId;
                        $temparray[] = $childId;
                    }
                }
            }

            $array = array_unique($array);

            $countTempElements = count($temparray);

            if($countNullChildren == $countTempElements)
            {
                return $array;
            }
            else{
                $temparray = array();
                return $this->getAllChildren($upgid,$depid,$array,$temparray);  
            }

             

        }

        function getDepartmentChildrenLevel($upgid,$depid)
        {
            $level = 0;
            $childrenarraylevel = array();

            $childrenarraylevel[] = array('depid'=>$depid, 'level'=>$level);
            $level++;
            return $this->getGroupChildrenLevel($upgid,$depid,$childrenarraylevel,$level);
        }

         function getGroupChildrenLevel($upgid,$depid,$array,$level)
        {
            //get descendants of group

            $childrengroup = DB::table('group')->where('group_group_id','=',$depid)->get();

            if((count($childrengroup)) > 0)
            {
                  foreach ($childrengroup as $children) 
                  {
                    $childId = $children->group_id;
                    $array[] = array('depid'=>$childId,'level'=>$level);
                    }
                    $level++;
                return $this->getGroupChildrenLevel($upgid,$childId,$array,$level);
            }
            else
                return $array;
          
        }

        function getMotherGroup($upgid,$depid)
        {
            $motherDep = DB::table('group')->where('group_id','=',$depid)->get();
            foreach ($motherDep as $md) {
                $parentDep = $md->group_group_id;
            }

            return $parentDep;
        }
}
