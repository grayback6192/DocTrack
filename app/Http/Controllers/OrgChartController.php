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
        $depparent = (new Department)->getMotherGroup($upgid,$depid);
        if($depparent!=NULL)
        {
                $ancestornodes = DB::table('orgchart as o')->where('o.group_id','=',$depparent)
                                                        ->join('orgchartnode as on','o.orgchart_id','on.orgchart_id')
                                                        ->get();
                if((count($ancestornodes))>0){
                     foreach ($ancestornodes as $ancestornode) {
                    DB::table('orgchartnode')->insert(['orgchart_id'=>$orgchartid,
                                                    'upg_id'=>$ancestornode->upg_id]);
                        // echo "<pre>";
                        // var_dump($ancestornodes);
                }
               
                }
        }

       return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$depid]);
    }

    public function addOrgChartNode($userupgid,$depid,$newupgid)
    {
        //$orgchartnodeid = rand(10,1000);
        //find orgchart of depid
        $deporgchart = DB::table('orgchart')->where('group_id','=',$depid)->get();
        foreach ($deporgchart as $key) {
            $orgchartid = $key->orgchart_id;
        }

        //insert new assignment as new dep org chart node
        DB::table('orgchartnode')->insert([ 'orgchart_id'=>$orgchartid,
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
                         // $orgchartnoderand = rand(10,1000);
                        DB::table('orgchartnode')->insert(['orgchart_id'=>$childrennode->orgchart_id,
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

    function getgroupchildrenlevel($upgid,$groupid,$array,$level,$orgtxt){
         $gettexts=DB::table('orgchart')->where('orgchart.group_id','=',$orgtxt)->get();
        $childrengroup = DB::table('group')->where('group_group_id','=',$groupid)->get();

        if((count($childrengroup))>0){
            foreach ($childrengroup as $children) {
                $name= $children->groupName;
                $childId = $children->group_id;
                $array[] = array('link_id'=> $childId,'root_id'=>$childId,'label'=>$name,'depth'=>$level);
            }
            $level++;
            return $this->getgroupchildrenlevel($upgid,$childId,$array,$level,$orgtxt);
        }
        else
          $test= $this->listItems($array);

         foreach($gettexts as $gettext){
        $querrs = $gettext->path;
       }
       
        if(count($querrs)>0){
                $file= fopen($groupid.".txt","w");
                fwrite($file,$test);
                \DB::table('orgchart')->where('group_id','=',$groupid)->update(['path' => $groupid.".txt "]);
                
            }
  return view('admin/vieworgchart',['files'=>$test]);
           // return $array;
           
    }
   

    function vieworg($upgid,$groupid){       
        $orgtxt = $groupid;
        $gettexts=DB::table('orgchart')->where('orgchart.group_id','=',$groupid)->get();
        $getorgnodes=DB::table('orgchart')->where('orgchart.group_id','=',$groupid)->join('orgchartnode','orgchart.orgchart_id','=','orgchartnode.orgchart_id')->join('position','orgchartnode.pos_id','=','position.pos_id')->get();
        $departments= DB::table('group')->get();
        $depname=array();
        foreach ($departments as $department) {
          if($department->group_id==$groupid){
            $depname=$department->groupName;
          }

          // else
          //   return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$groupid]);
        }
        // $departname[]=array($depname->);
       
        $arrs=array();
        $level=0;
        $childrenarraylevel =array();
        $childrenarraylevel[] = array('link_id'=> $groupid,'root_id'=>$groupid,'label'=>$depname,'depth'=>$level);
        $level++;
        return $this->getgroupchildrenlevel($upgid,$groupid,$childrenarraylevel,$level,$orgtxt);

    // foreach ($departments as $department) {
    //     $i=0;
    //     if ($department->group_group_id == NULL){
    //                      $arrs[]=array(
    //                                     'link_id' => $department->group_id,
    //                                     'root_id' => $department->group_group_id,
    //                                     'label' => $department->groupName,
    //                                     'depth' => $i);
               
      
        
    //            }
    //         }        
        // foreach($getorgnodes as $orgdetail){
        //     $arrs[]=array(
        //                       'link_id' => $orgdetail->pos_id,
        //                       'root_id' => $orgdetail->motherPos,
        //                       'label' => $orgdetail->posName,
        //                       'depth' => $orgdetail->posLevel);
        // }
       $test = $this->listItems($arrs);
       foreach($gettexts as $gettext){
        $querrs = $gettext->path;
       }
       // return $test;
      
            if(count($querrs)>0){
                 $file= fopen($groupid.".txt","w");
                fwrite($file,$test);
                \DB::table('orgchart')->where('group_id','=',$groupid)->update(['path' => $groupid.".txt "]);
                
            }
           /* else(count($querrs)==null){
                
            }*/
        return view('admin/vieworgchart',['files'=>$test]);
        
    }

    public function listItems($items)
    {

        $html = '';
 
        $depth = 0; 
        foreach($items as $index => $item){ 
            $newDepth = intval($item['depth']);
            if ($newDepth > $depth) {
                while ($newDepth > $depth) {
                    $html .= '<ul><li>';
                    $depth++;
                 }
            } else if ($newDepth < $depth) { 
                while ($newDepth < $depth) {
                    $html .= '</li></ul>';
                    $depth--;
                } 
                $html .= '<li>';
            } else if ($newDepth === $depth) {
                if ($index === 0) {
                    $html .= '<ul><li>';
                } else {
                    $html .= '</li><li>'; 
                }
            }
 
            $html .= htmlentities($item['label']);
            $depth = $newDepth;
        }
        if (count($items) > 0) {
            while ($depth-- >= 0) {
                $html .= '</li></ul>';
            }
        }
       
        return $html;
        
    }
 

}
