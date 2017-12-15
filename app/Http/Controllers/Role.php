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
    	$roles = DB::table('position')->where('status','=','active')->where('client_id','=',$clientId)->paginate(5);
        $deps = DB::table('group')->get();

    	return view('admin/roleView',['roles'=>$roles,'deps'=>$deps, 'User'=>$user,'upgid'=>$upgid]);
    }

    function addRole($upgid)
    {
        $user = Auth::user();
         $clients = $this->getClientId($user->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
    	 $roleInfo = request()->all();
         $rand = rand(1000,9999);
    	 DB::table('position')->insert(['pos_id'=>$rand,'posName'=>$roleInfo['newrole'],'status'=>'active','client_id'=>$clientId]);

    	 return $this->viewRoles($upgid);
    }

    function deleteRole($roleid)
    {
    	DB::table('position')->where('pos_id',$roleid)->update(['status'=>'inactive']);
        return $this->viewRoles();
    }

    function editRole($upgid,$roleid)
    {
        $info = request()->all();
        DB::table('position')->where('pos_id',$roleid)->update(['posName'=>$info['role']]);

        return redirect()->route('viewRolePage',['upgid'=>$upgid]);
    }
}
