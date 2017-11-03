<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class Department extends Controller
{
    function getClientId($userid){
        $clientgroup = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                        ->distinct()
                        ->get();
            return $clientgroup;
    }
  
    function viewDep()
    {
        $name = Auth::user();
        $clients = $this->getClientId($name->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
    	   $listDep = DB::table('group')->where('client_id','=',$clientId)->where(['status'=>'active'])->get();
            //$listDep = DB::table('group')->where('group_group_id','=',$clientId)->where(['status'=>'active'])->get();
        
            return view('admin/depPage',['departments'=>$listDep,'User'=>$name]);
        }

    function showDep($depid)
    {
        $name = Auth::user(); 
    	$depInfo = DB::table('group')->where(['group_id'=>$depid])->get();
        $subgroups = DB::table('group')->where('group_group_id','=',$depid)->get();
        return view('admin/depInfo',['depid'=>$depid, 'dep'=>$depInfo, 'User'=>$name, 'subgroups'=>$subgroups]);
    }

    function showDepInfo($depid)
    {
        $name = Auth::user(); 
        $dep = DB::table('group')->where('group_id',$depid)->get();
        $clients = $this->getClientId($name->user_id);
         foreach ($clients as $client) {
            $clientId = $client->client_id;
        }

        $motherGroups = DB::table('group')->where('status','=','active')->where('client_id','=',$clientId)->get();
        return view('admin/depInfoEdit',['depId'=>$depid],
                                            ['depInfos'=>$dep, 'User'=>$name, 'motherGroups'=>$motherGroups]);
    }

    function editDep($depid)
    {
         $depInfo = request()->all();

        if($depInfo['mothergroup']==''){
            $mothergroup = $this->getClientId($user->user_id);
        foreach ($mothergroup as $client) {
            $mg = $client->client_id;
        }
        }
        else
        {
            $mg = $depInfo['mothergroup'];
        }

       
        DB::table('group')->where('group_id',$depid)->update(['groupName'=>$depInfo['depname'],
                                                            'groupDescription'=>$depInfo['depDesc'],
                                                            'group_group_id'=>$mg,
                                                            'businessKey'=>$depInfo['depKey']]);

        return $this->showDep($depid);
    }

    function addDep()
    {
         $user = Auth::user(); 
         $dep = request()->all();
          $path = public_path().'/storage/docs/'.$dep['depname'];
        File::makeDirectory($path,$mode=0777,true,true);
        $path2 = $path.'/pdf';
        $path3 = $path.'/temp';
        $path4 = $path.'/template';

        File::makeDirectory($path2,$mode=0777,true,true);
        File::makeDirectory($path3,$mode=0777,true,true);
        File::makeDirectory($path4,$mode=0777,true,true);

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
                                    'user_user_id'=>$user->user_id,
                                    'businessKey'=>$dep['depKey']]);


         return redirect()->route('viewDep');
        //return $path;   
    }

    function deleteDep($depid)
    {
        DB::table('group')->where('group_id',$depid)->update(['status'=>'inactive']);

        return $this->viewDep();
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

    function viewServiceOwners($groupid)
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
        
            return view('user/groups',['departments'=>$deps,'User'=>$name]);
           // echo "<pre>";
           // var_dump($deps);
        }

}
