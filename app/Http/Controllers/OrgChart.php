<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgChart extends Controller
{
    //
    public function store(Request $request,$upgid){

        $user = Auth::user();
        $filename= rand(1,10000);
        $file= fopen($filename."orgchart.txt","w");
        $datasource=$request['id'];
        $fwuserrite= fwrite($file,$datasource);

        $group = $request['group_id'];
        $orgchartid = $request['orgchartid'];
        $orgchartnodesarray = $request['orgchartnodesArray'];


         \DB::table('orgchart')->insert(['orgchart_id'=>$orgchartid,'path'=>$filename.'orgchart.txt','group_id'=>$group]);
        //echo "".$request['orgchartid']."<br>".$request['group_id']."<br>".$filename;

                return $this->addOrgchartNodes($orgchartnodesarray, $orgchartid, $group);
            }


        public function addOrgchartNodes($orgchartnodesArray, $orgchartid, $groupid){
            foreach ($orgchartnodesArray as $nodesArray) {
               // echo "".$nodeid = $nodesArray['nodeid'];
               //  echo "<br>".$pos_id = $nodesArray['pos_id'];
               //  echo "<br>".$upg_id = $nodesArray['upg_id'];
               //  echo "<br>".$orgchartid;
               //  echo "<br>".$groupid;
                $nodeid = $nodesArray['nodeid'];
                $pos_id = $nodesArray['pos_id'];
                $upg_id = $nodesArray['upg_id'];
                 
               \DB::table('orgchartnodes')->insert(['orgchartnodes_id'=>$nodeid,
                                                     'orgchart_id'=>$orgchartid,
                                                    'pos_id'=>$pos_id,
                                                    'upg_id'=>$upg_id,
                                                    'group_id'=>$groupid]);
            }
        }

       public function show($groupid)
    {
        $user = Auth::user();
        $datasourceget= \DB::table('orgchart')->where('group_id','=',$groupid)->get();

        // $datasourceget= \DB::table('orgchart')->select('path')->get();
        if((count($datasourceget))>0){

        	foreach ($datasourceget as $datasource) {
            	$orgfile = $datasource->path;
        	}
        	$file=fopen($orgfile,"r");
        	$files=fread($file,filesize($orgfile));	
        }
        else
        	$files="none";
        
        // return response()->json($datasourceget);
        //return view('admin/read',['files'=>$files,'User'=>$user]);
        return $files;

    }

    public function edit($upgid,$groupid)
    {
         $user = Auth::user();
         $clientid = session()->get('client');
         $departments = \DB::table('group')->where('client_id','=',$clientid)->orWhere('group_id','=',$groupid)->get();
        $readchart= \DB::table('orgchart')->where('group_id','=',$groupid)->get();
          $lists=\DB::table('userpositiongroup')
        ->where('userpositiongroup.client_id','=',$clientid)
        ->join('position','userpositiongroup.position_pos_id','=','position.pos_id')
        ->join('user','userpositiongroup.user_user_id','=','user.user_id')
        ->join('group','userpositiongroup.group_group_id','=','group.group_id')
        ->get();

    foreach ($readchart as $chart) {
        $orgchartfile = $chart->path;
        $orgchart_id = $chart->orgchart_id;
    }

     $file=fopen($orgchartfile,"r");
        $files=fread($file,filesize($orgchartfile));

        $admingroup = getAdminGroup($upgid);
     return view('admin/editOrgChart',['User'=>$user,'readchart'=>$readchart,'files'=>$files,'groups'=>$departments,'upgid'=>$upgid,'groupid'=>$groupid,'admingroup'=>$admingroup,'lists'=>$lists,'orgchart_id'=>$orgchart_id]);

    }

    public function update(Request $request,$upgid)
    {
        $group = $request['group_id'];
        $filename= rand(1,10000);
        $file= fopen($filename."orgchart.txt","w");
        $datasource=$request['id'];
        $fwrite= fwrite($file,$datasource);
        $orgchartnodesarrays = $request['orgchartnodesArray'];
        $removeorgchartnodesarray = $request['removenodesarray'];
        $orgchartid = $request['orgchartid'];
        $count = count($removeorgchartnodesarray);

    \DB::table('orgchart')->where('group_id','=',$group)->update(['path'=>$filename.'orgchart.txt']);

     if (isset($removeorgchartnodesarray))
      {
            for ($i=0; $i < $count ; $i++) 
            {
                \DB::table('orgchartnodes')->where('orgchart_id','=',$orgchartid)
                                             ->where('upg_id','=',$removeorgchartnodesarray[$i])
                                             ->delete();

            }
        }
        return $this->addOrgchartNodes($orgchartnodesarrays, $orgchartid, $group);
        
        
    }

}
