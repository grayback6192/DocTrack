<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserPositionGroup extends Controller
{
    //
    public function findNull($userid)
    {   
        $users = DB::table('userpositiongroup')
                    ->where('user_user_id','=',$userid)
                    ->where('rights_rights_id','=',2)
                    ->whereNull('position_pos_id')
                    ->get();
        return $users;
    }

    public function addNewAssignment(Request $request,$upgid)
    {
        $clientid = \Session::get('client');
        $user = Auth::user();
    	$rand = rand(100,9999);
        $found = $this->findNull($request['userid']);



         if(count($found)==1){
             DB::table('userpositiongroup')->where('user_user_id','=',$request['userid'])
            ->update(['position_pos_id'=>$request['position'],
                        'upg_status'=>'active']);
        }
        else if(count($found)==0){
    	 DB::table('userpositiongroup')->insert(['upg_id'=>$rand,
    	 										'position_pos_id'=>$request['position'],
    	 										'rights_rights_id'=>$request['role'],
    											'user_user_id'=>$request['userid'],
    											'group_group_id'=>$request['group'],
                                                'client_id'=>$clientid,
                                                'upg_status'=>'active']);
    }
    
        if($request['role']==2)
    	   return redirect()->route('viewAssignments',['upgid'=>$upgid]);
        else
            return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$request['group']]);
        //return count($users);
    }

    public function removeAdmin($upgid, Request $request)
    {
        DB::table('userpositiongroup')->where('upg_id','=',$request['adminupgid'])->update(['upg_status'=>'inactive']);

        return redirect()->route('showDep',['upgid'=>$upgid, 'id'=>$request['admindep']])->with("adminremoved","Admin has been removed.");
    }

    public function enterGroup(Request $request)
    {
        $user = Auth::user();
        $rand = rand(100,9999);
        $found = $this->findNull($user->user_id);

        $studpos = DB::table('position')->where('posName','=','Student')->where('client_id','=',$request['clientid'])->get();

        if(count($studpos)==0)
        {
            $posrand = rand(1000,99999);
            DB::table('position')->insert(['pos_id'=>$posrand,
                                            'posName'=>'Student',
                                            'status'=>'active',
                                            'client_id'=>$request['clientid']]);

            $studentposid = $posrand;
        }
        else
        {
             foreach ($studpos as $key) {
                $studposid = $key->pos_id;
            }
        }

        if($request['position']=="Employee")
        {
            if(count($found)==1){
             DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)
            ->update(['group_group_id'=>$request['groupid']]);
        }else if(count($found)==0){
            DB::table('userpositiongroup')->insert(['upg_id'=>$rand,
                                                    'position_pos_id'=>NULL,
                                                    'rights_rights_id'=>2,
                                                    'user_user_id'=>$user->user_id,
                                                    'group_group_id'=>$request['groupid'],
                                                    'client_id'=>$request['clientid'],
                                                    'upg_status'=>'inactive']);
        }
        }
        else if($request['position']=="Student")
        {
            if(count($found)==1){
             DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)
            ->update(['group_group_id'=>$request['groupid'],'position_pos_id'=>$studposid]);
        }else if(count($found)==0){
            DB::table('userpositiongroup')->insert(['upg_id'=>$rand,
                                                    'position_pos_id'=>$studposid,
                                                    'rights_rights_id'=>2,
                                                    'user_user_id'=>$user->user_id,
                                                    'group_group_id'=>$request['groupid'],
                                                    'client_id'=>$request['clientid'],
                                                    'upg_status'=>'active']);
        }
        }

        return redirect()->route('gotogroup',['groupid'=>$request['groupid'],'rightid'=>2]);
    }

    public function removeAssignment(Request $request)
    {
        DB::table("userpositiongroup")->where("upg_id",$request['upgid'])->update(['upg_status'=>'inactive']);

        return redirect()->route('viewAssignments',['upgid'=>$request['loginupgid']])->with('upgremove','User Assignment successfully removed.');
    } //set it to inactive
}
