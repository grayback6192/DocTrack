<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class orgchartupload extends Controller
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
