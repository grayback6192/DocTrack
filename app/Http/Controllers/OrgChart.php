<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgChart extends Controller
{
    //
    public function store(Request $request){

        // echo "<script> html(."$request['id']".);</script>"
        $user = Auth::user();
        $group = $request['group_id'];
        $filename= rand(1,10000);
        $file= fopen($filename."orgchart.txt","w");
        $datasource=$request['id'];
        $fwuserrite= fwrite($file,$datasource);
        \DB::table('orgchart')->insert(['path'=>$filename.'orgchart.txt','group_id'=>$group]);

        return $request['id'];
        //return $file;
            }

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

    public function edit($groupid)
    {
        $user = Auth::user();
        $datasourceget = \DB::table('orgchart')->where('group_id','=',$groupid)->select('path')->get();
        foreach ($datasourceget as $datasource) {
            $dataEdit= $datasource->path;
        }
        $file=fopen($orgfile, "r");
        $files=fread($file, filesize($dataEdit));
        // return view('admin/edit',['files'=>$files,'User'=>$user]);

    }


}
