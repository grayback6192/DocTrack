<?php

namespace App\Http\Controllers;
use App\Http\Controllers\OrgChartController;

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

        // foreach ($found as $key) {
        //     $newassignupgid = $key->upg_id;
        // }



         if(count($found)==1){
              foreach ($found as $key) {
            $newassignupgid = $key->upg_id;
        }
             DB::table('userpositiongroup')->where('user_user_id','=',$request['userid'])
                                        ->where('group_group_id','=',$request['group'])
                                            ->update(['position_pos_id'=>$request['position'],
                                                        'upg_status'=>'active']);
        }
        else if(count($found)==0){
            $newassignupgid = $rand;
    	 DB::table('userpositiongroup')->insert(['upg_id'=>$rand,
    	 										'position_pos_id'=>$request['position'],
    	 										'rights_rights_id'=>$request['role'],
    											'user_user_id'=>$request['userid'],
    											'group_group_id'=>$request['group'],
                                                'client_id'=>$clientid,
                                                'upg_status'=>'active']);
    }

        $orgchartcontroller = new OrgChartController();

    
        if($request['role']==2)
              return $orgchartcontroller->addOrgChartNode($upgid,$request['group'],$newassignupgid);
        else
            return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$request['group']]);
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

        //check if entered key is correct
        $depinfos = DB::table('group')->where('group_id','=',$request['groupid'])->get();

        foreach ($depinfos as $depinfo) {
            $depKey = $depinfo->businessKey;
            $motherGroup = $depinfo->group_group_id;
        }

        if($request['groupkey']!=$depKey)
        {
            return redirect()->route('addGroup',['userid'=>$user->user_id,'depid'=>$motherGroup])->with('wrongkey','Incorrect Department Key');
        }

        $studentpos = DB::table('position')->where('posName','=','Student')->where('client_id','=',$request['clientid'])->get();
        
        $studpos = DB::table('deppos as dp')->where('dp.pos_group_id','=',$request['groupid'])
                                            ->join('position as p','dp.pos_id','p.pos_id')
                                            ->where('p.posName','=','Student')
                                            ->get();


        if(count($studentpos)==0)
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
                $studposid = $key->deppos_id;
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
         return redirect()->route('addGroup',['userid'=>$user->user_id,'depid'=>$motherGroup])->with('correctkey','Successfully entered group. Go to admin for position assignment.');
        }
        else if($request['position']=="Student")
        {
            if(count($found)==1){
             DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)
            ->update(['group_group_id'=>$request['groupid'],'position_pos_id'=>$studposid, 'upg_status'=>'active']);
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

    public function removeAssignment(Request $request, $depid)
    {

        DB::table("userpositiongroup")->where("upg_id",$request['upgid'])->update(['upg_status'=>'inactive']);

        $orgchartcontroller = new OrgChartController();

        return $orgchartcontroller->removeOrgChartNode($request['loginupgid'],$request['upgid'],$depid);
        
    } //set it to inactive


    public function editAssignment(Request $request,$upgid){
        // DB::table("userpositiongroup")->where("upg_id",$request['upgid'])->update(['user_user_id'=> $request['userid']]);


        DB::table('userpositiongroup')->where('user_user_id','=',$request['userid'])
                                      ->where('upg_id','=',$request['upgid'])
                                      ->where('group_group_id','=',$request['group'])
                                      ->update(['position_pos_id'=>$request['position'],
                                                'upg_status'=>'active',
                                                'user_user_id'=> $request['userid']]);

        $orgchartcontroller = new OrgChartController();

    
    return $orgchartcontroller->addOrgChartNode($upgid,$request['group'],$request['upgid']);

        // return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$request['group']]);
    }
}
