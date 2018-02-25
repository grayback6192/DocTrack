<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\OrgChart;


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
    	$depInfo = DB::table('group')->where(['group_id'=>$depid])->get();
        $subgroups = DB::table('group')->where('group_group_id','=',$depid)->get();
        $clientid = getAdminClient($upgid);

        //get org chart file only
        $orgchart = new OrgChart;
        $deporgchart = $orgchart->show($depid);

        //get org chart info
        $orgchartInfos = DB::table('orgchart')->where('group_id','=',$depid)->get();

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
            $adminid = rand(10,10000);
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


        return view('admin/depProfile',['depid'=>$depid, 
                                        'depinfos'=>$depInfo, 
                                        'User'=>$name, 
                                        'subgroups'=>$subgroups, 
                                        'deporgchart'=>$deporgchart, 
                                        'orgchartInfos'=>$orgchartInfos,
                                        'depid'=>$depid,
                                        'adminposid'=>$adminposid,
                                        'masteradminposid'=>$masteradminposid,
                                        'adminusersarray'=>$adminusersarray,
                                        'admins'=>$admins,
                                        'members'=>$members,
                                        'upgid'=>$upgid,
                                        'admingroup'=>$admingroup]);
        // echo "<pre>";
        // var_dump($clientid);
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

        return $this->showDep($upgid,$depid)->with('edited','Department information has been edited.');
    }

    function addDep($upgid)
    {
         $user = Auth::user(); 
         $dep = request()->all();
    
        if($dep['mothergroup']==''){
            $mothergroup = $this->getClientId($user->user_id);
        foreach ($mothergroup as $client) {
            $mg = $client->client_id;
        }
        }
        else
        {
            $mg = $dep['mothergroup'];
        }

         $clients = $this->getClientId($user->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }

        $rand = rand(10000,99999);
        DB::table('group')->insert(['group_id'=>$rand,
                                    'groupName'=>$dep['depname'], 'groupDescription'=>$dep['depDesc'], 'status'=>'active',
                                    'group_group_id'=>$mg,
                                    'client_id'=>$clientId,
                                    'creator_user_id'=>$user->user_id,
                                    'businessKey'=>$dep['depKey']]);

        $admingroup = getAdminGroup($upgid);

        return redirect()->route('showDep',['upgid'=>$upgid,'depid'=>$rand]);
 
    }

    function deleteDep($upgid,$depid)
    {
        DB::table('group')->where('group_id',$depid)->update(['status'=>'inactive']);

        return $this->viewDep($upgid);
    }

     function viewGroups()
    {
         $name = Auth::user();
        $clients = $this->getClientId($name->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
           $listDep = DB::table('group')->where('client_id','=',$clientId)->where(['status'=>'active'])->get();

           return view('user/addGroup',['groups'=>$listDep,'User'=>$name]);
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
        
            return view('user/groups',['departments'=>$deps,'User'=>$name,'upgid'=>$upgid]);
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

}
