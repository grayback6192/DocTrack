<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Department;

class OrgChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        // echo "<script> html(."$request['id']".);</script>"
        $user = Auth::user();
        $group = $request['group_id'];
        $filename= rand(1,10000);
        $file= fopen($filename."orgchart.txt","w");
        $datasource=$request['id'];
        $fwuserrite= fwrite($file,$datasource);
        \DB::table('orgchart')->insert(['path'=>$filename.'orgchart.txt','group_id'=>$group,'User'=>$user]);

        return $request['id'];
            }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($groupid)
    {
        $user = Auth::user();
        $datasourceget= \DB::table('orgchart')->where('group_id','=',$groupid)->select('path')->get();
        // $datasourceget= \DB::table('orgchart')->select('path')->get();
        foreach ($datasourceget as $datasource) {
            $orgfile = $datasource->path;
        }
        $file=fopen($orgfile,"r");
        $files=fread($file,filesize($orgfile));
        // return response()->json($datasourceget);
        return view('admin/read',['files'=>$files,'User'=>$user]);
        //var_dump($files);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($groupid)
    {
        $user = Auth::user();
        $datasourceget = \DB::table('orgchart')->where('group_id','=',$groupid)->select('path')->get();
        foreach ($datasourceget as $datasource) {
            $dataEdit= $datasource->path;
        }
        $file=fopen($orgfile, "r");
        $files=fread($file, filesize($dataEdit));
        return view('admin/edit',['files'=>$files,'User'=>$user]);

    }

    public function addOrgChart($upgid,$depid)
    {
        $orgchartid = rand(10,1000);

        DB::table('orgchart')->insert(['orgchart_id'=>$orgchartid,
                                        'group_id'=>$depid]);

        return $this->addAncestorNodes($upgid,$depid,$orgchartid);
    }

    public function addAncestorNodes($upgid,$depid,$orgchartid)
    {
        $depparents = (new Department)->getAncestors($upgid,$depid);
        if((count($depparents)) > 0)
        {
            for ($i=0; $i < count($depparents); $i++) { 
                $ancestornodes = DB::table('orgchart as o')->where('o.group_id','=',$depparents[$i])
                                                        ->join('orgchartnode as on','o.orgchart_id','on.orgchart_id')
                                                        ->get();
                if((count($ancestornodes))>0){
                     foreach ($ancestornodes as $ancestornode) {
                    $orgchartnoderand = rand(10,1000);
                    DB::table('orgchartnode')->insert(['orgchartnode_id'=>$orgchartnoderand,
                                                    'orgchart_id'=>$orgchartid,
                                                    'upg_id'=>$ancestornode->upg_id]);
                        // echo "<pre>";
                        // var_dump($ancestornodes);
                }
               
                }
            }
        }

       return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid]);
    }

    public function addOrgChartNode($userupgid,$depid,$newupgid)
    {
        $orgchartnodeid = rand(10,1000);
        //find orgchart of depid
        $deporgchart = DB::table('orgchart')->where('group_id','=',$depid)->get();
        foreach ($deporgchart as $key) {
            $orgchartid = $key->orgchart_id;
        }

        //insert new assignment as new dep org chart node
        DB::table('orgchartnode')->insert(['orgchartnode_id'=>$orgchartnodeid,
                                            'orgchart_id'=>$orgchartid,
                                            'upg_id'=>$newupgid]);
        
        $depchildren = (new Department)->getDescendants($userupgid,$depid);
        if((count($depchildren)) > 0)
        {
            for($i=0;$i<count($depchildren);$i++)
            {
                $childrennodes = DB::table('orgchart as o')->where('o.group_id','=',$depchildren[$i])
                                                        ->get();

                if((count($childrennodes)) > 0)
                {
                    foreach ($childrennodes as $childrennode) {
                         $orgchartnoderand = rand(10,1000);
                        DB::table('orgchartnode')->insert(['orgchartnode_id'=>$orgchartnoderand,
                                                    'orgchart_id'=>$childrennode->orgchart_id,
                                                    'upg_id'=>$newupgid]);
                    }
                }
            }
        }

        return redirect()->route('viewAssignments',['upgid'=>$userupgid]);
    }

    function removeOrgChartNode($userupgid,$removeupgid)
    {
        DB::table('orgchartnode')->where('upg_id','=',$removeupgid)->delete();

        return redirect()->route('viewAssignments',['upgid'=>$userupgid])->with('upgremove','User Assignment successfully removed.');
    }
}
