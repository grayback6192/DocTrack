<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgChart extends Controller
{
    //
    public function store(Request $request,$upgid){

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

    foreach ($readchart as $chart) {
        $orgchartfile = $chart->path;
    }

     $file=fopen($orgchartfile,"r");
        $files=fread($file,filesize($orgchartfile));

    return view('admin/editOrgChart',['User'=>$user,'readchart'=>$readchart,'files'=>$files,'groups'=>$departments,'upgid'=>$upgid,'groupid'=>$groupid]);

    }

    public function update(Request $request,$upgid)
    {
        $group = $request['group_id'];
        $filename= rand(1,10000);
        $file= fopen($filename."orgchart.txt","w");
        $datasource=$request['id'];
        $fwrite= fwrite($file,$datasource);
       
        \DB::table('orgchart')->where('group_id','=',$group)->update(['path'=>$filename.'orgchart.txt']);
        
        return $request['id'];
    }


}
