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
    	$roles = DB::table('position')->where('status','=','active')
                                        ->where('client_id','=',$clientId)
                                        ->orderBy('posName')
                                        ->paginate(5);
        $deps = DB::table('group')->get();
        $admingroup = getAdminGroup($upgid);

    	return view('admin/roleView',['roles'=>$roles,'deps'=>$deps, 'User'=>$user,'upgid'=>$upgid,'admingroup'=>$admingroup]);
    }

    function addRole($upgid, Request $request)
    {
        $user = Auth::user();
         $clients = $this->getClientId($user->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
    	 $roleInfo = request()->all();

         //look if newly entered position already exists
         $positions = DB::table('position')->get();
         $positionslist = array();
         foreach ($positions as $position) {
             $positionslist[] = strtolower($position->posName);
         }

         $this->validate($request,[
                            'newrole'=>'required|unique:position,posName',
                                    ]);

         $rand = rand(1000,9999);
    	 DB::table('position')->insert(['pos_id'=>$rand,'posName'=>$roleInfo['newrole'],'status'=>'active','client_id'=>$clientId]);

    	 return $this->viewRoles($upgid);
    }

    function deleteRole($upgid,$roleid)
    {
        //detect if role is still used in active user assignments
        $countactiverole = DB::table('userpositiongroup')->where('position_pos_id','=',$roleid)->where('upg_status','=','active')->count();

        if($countactiverole>0)
            return redirect()->route('viewRolePage',['upgid'=>$upgid])->with('activerole','Position is still being used by active assignments!');
        else
        {
            DB::table('position')->where('pos_id',$roleid)->update(['status'=>'inactive']);
             return redirect()->route('viewRolePage',['upgid'=>$upgid])->with('removerole','Position removed.');
        }
    }

    function editRole($upgid,$roleid,Request $request)
    {
         $info = request()->all();
        //validate if edited role already exists aside from its name
        $samePosNameCount = 0;

        $posnames = DB::table('position')->where('posName','=',$info['role'])->get();
        foreach ($posnames as $posname) {
            $posID = $posname->pos_id;
            $posName = $posname->posName;
        }

        if(($posID!=$roleid) && ($posName==$info['role']))
            $samePosNameCount++;

       if($samePosNameCount==0)
       {
            DB::table('position')->where('pos_id','=',$roleid)->update(['posName'=>$info['role'],
                                                                'posDescription'=>$info['roledesc']]);
        }

        if($samePosNameCount>0)
        {
            return redirect()->route('viewRolePage',['upgid'=>$upgid])->with('takenposname','Position Name already exists.');
        }
        else
             return redirect()->route('viewRolePage',['upgid'=>$upgid]);
    }
}
