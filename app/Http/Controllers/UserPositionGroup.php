<?php

namespace App\Http\Controllers;
use App\Http\Controllers\OrgChartController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use Carbon\Carbon;

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
        // $date = Carbon::now()->timestamp;
        $clientid = \Session::get('client');
        $user = Auth::user();
    	$rand = rand(100,9999);
        $found = $this->findNull($request['userid']);
        $orgchartParent = DB::table('deppos as dp')->where('pos_id','!=','12345')->where('motherPos','=',$request['position'])->get();
        $foundDeleted = DB::table('userpositiongroup')
                            ->where('user_user_id','=',$request['userid'])
                            ->where('rights_rights_id','=',2)
                            ->whereNotNull('position_pos_id')
                            ->get();
//finding undefine name and changing it
        $findUnd= DB::table('userpositiongroup as upg')
                        ->where('user_user_id','=','999999')
                        ->where('group_group_id','=',$request['group'])
                        ->join('deppos as dp','upg.position_pos_id','dp.deppos_id')
                        ->where('dp.deppos_id','=',$request['position'])
                        ->get();

        if(count($orgchartParent)>1){
            // dd('greater 1 parent');
         return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$request['group']])->with("alertupg","Cannot add two or more parent.");
    }
        // foreach ($found as $key) {
        //     $newassignupgid = $key->upg_id;
        // }

else{
    // dd('not greater 1 parent');
        if(count($findUnd)==1){
            DB::table('userpositiongroup as upg')->where('user_user_id','=','999999')
                                          ->where('group_group_id','=',$request['group'])
                                          ->join('deppos as dp','upg.position_pos_id','dp.deppos_id')
                                          ->where('dp.deppos_id','=',$request['position'])
                                          ->update(['user_user_id'=>$request['userid']]);

            DB::table('userpositiongroup')->where('user_user_id','=',$request['userid'])
                                          ->where('group_group_id','=',$request['group'])
                                          ->where('position_pos_id','=',NULL)
                                          ->update(['user_user_id'=>'999999']);
 return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$request['group']]);
        }
        else{

         if(count($found)==1){
              foreach ($found as $key) {
            $newassignupgid = $key->upg_id;
        }
        // dd('nagupdate sa dli deleted');
             DB::table('userpositiongroup')->where('user_user_id','=',$request['userid'])
                                        ->where('group_group_id','=',$request['group'])
                                            ->update(['position_pos_id'=>$request['position'],
                                                        'upg_status'=>'active']);
        }
        else if(count($found)==0){
            
            if(count($foundDeleted)==1){
                foreach ($foundDeleted as $key) {
                            $newassignupgid = $key->upg_id;
                }
                // dd($newassignupgid);
                DB::table('userpositiongroup')->where('user_user_id','=',$request['userid'])
                                        ->where('group_group_id','=',$request['group'])
                                            ->update(['position_pos_id'=>$request['position'],
                                                        'upg_status'=>'active']);
            }
            else{
                $newassignupgid = $rand;
                // dd('naghimo bag.o');
    	 DB::table('userpositiongroup')->insert(['upg_id'=>$rand,
    	 										'position_pos_id'=>$request['position'],
    	 										'rights_rights_id'=>$request['role'],
    											'user_user_id'=>$request['userid'],
    											'group_group_id'=>$request['group'],
                                                'client_id'=>$clientid,
                                                'upg_status'=>'active']);
    }
}


        $orgchartcontroller = new OrgChartController();

    
        if($request['role']==2)
              return $orgchartcontroller->addOrgChartNode($upgid,$request['group'],$newassignupgid);
        else
            return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$request['group']]);
    }
}
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
                                            ->where('p.posName','=','Undefine')
                                            ->get();

// dd($request['groupid']);
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
                // dd($request['groupid']);
             DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)
            ->update(['group_group_id'=>$request['groupid']]);
        }else if(count($found)==0){
            // dd($request['groupid']);
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
        $getPos_pos_id= DB::table('userpositiongroup')->where('upg_id','=',$request['upgid'])->select('position_pos_id')->get();
        $getPosId='';
        foreach ($getPos_pos_id as $getPosPosId) {
            $getPosId = $getPosPosId->position_pos_id;
        }
        $orgchartParents = DB::table('deppos as dp')->where('pos_id','!=','12345')->where('motherPos','=',$getPosId)->get();
        $ParentOrgchart='';
      foreach ($orgchartParents as $orgchartParent) {
        $ParentOrgchart = $orgchartParent->deppos_id;
      }

      if($ParentOrgchart==''){
        // dd($request['posiddel']);

//change active to inactive
        DB::table('userpositiongroup as upg')->where('upg_id','=',$request['upgid'])
                                          ->where('group_group_id','=',$request['group'])
                                          ->join('deppos as dp','upg.position_pos_id','dp.deppos_id')
                                          ->where('dp.deppos_id','=',$request['posiddel'])
                                          ->update(['user_user_id'=>'999999']);
//change inactive to active
        $changefirsts=DB::table('userpositiongroup')->where('user_user_id','=','999999')
                                          ->where('group_group_id','=',$request['group'])
                                          ->where('position_pos_id','=',NULL)
                                          ->select()
                                          ->get();
                                          
        foreach ($changefirsts as $changefirst) {
            $changeFirstUpgId = $changefirst->upg_id;
            
        }
        DB::table('userpositiongroup')->where('upg_id','=',$changeFirstUpgId)
                                      ->update(['user_user_id'=>$request['userposdel']]);

        // DB::table("userpositiongroup")->where("upg_id",$request['upgid'])->update(['upg_status'=>'inactive']);

        // $orgchartcontroller = new OrgChartController();

        // return $orgchartcontroller->removeOrgChartNode($request['loginupgid'],$request['upgid'],$depid);

        return redirect()->route('showDep',['upgid'=>$request['upgid'],'id'=>$depid]);
      }
      else{
        dd('naay subdepartment');
        return redirect()->route('showDep',['upgid'=>$request['upgid'],'id'=>$depid]);
      }
        
    } //set it to inactive
    public function editAssignmentUPG(Request $request, $depid){
        DB::table('userpositiongroup as upg')
            ->where('upg.group_group_id','=',$depid)
            ->where('upg.upg_id','=',$request['upgid'])
            ->update(['upg.user_user_id'=>$request['positionedit']]);

        DB::table('userpositiongroup as upg')
            ->where('upg.group_group_id','=',$depid)
            ->where('upg.user_user_id','=',$request['positionedit'])
            ->where('upg.upg_status','=','inactive')
            ->update(['upg.user_user_id'=>$request['userUpgId']]);

        return redirect()->route('showDep',['upgid'=>$request['upgid'],'id'=>$depid]);                   

    }

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
