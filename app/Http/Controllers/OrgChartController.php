<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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
        var_dump(array($userupgid, $depid, $newupgid));
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

        // return redirect()->route('viewAssignments',['upgid'=>$userupgid]);
        return redirect()->route('showDep',['upgid'=>$userupgid,'id'=>$depid]);
    }

    function removeOrgChartNode($userupgid,$removeupgid,$depid)
    {
        DB::table('orgchartnode')->where('upg_id','=',$removeupgid)->delete();

        // return redirect()->route('viewAssignments',['upgid'=>$userupgid])->with('upgremove','User Assignment successfully removed.');
        return redirect()->route('showDep',['upgid'=>$userupgid,'id'=>$depid]);
    }

    function getgroupchildrenlevel($upgid,$groupid,$array,$level,$orgtxt){
         $gettexts=DB::table('orgchart')->where('orgchart.group_id','=',$orgtxt)->get();
        // $childrengroup = DB::table('group')->where('group_group_id','=',$groupid)->get();
         // $check = DB::table('group')->where('group.group_id','=',$groupid)->join('orgchart','group.group_id','=','orgchart.group_id')->join('orgchartnode','orgchart.orgchart_id','=','orgchartnode.orgchart_id')->join('userpositiongroup','orgchartnode.upg_id','=','userpositiongroup.upg_id')->join('group as g','userpositiongroup.group_group_id','=','g.group_id')->join('position','userpositiongroup.position_pos_id','=','position.pos_id')->join('user','userpositiongroup.user_user_id','=','user.user_id')->get();
        $childrengroup = DB::table('group')->where('group.group_group_id','=',$groupid)->join('orgchart','group.group_id','=','orgchart.group_id')->join('orgchartnode','orgchart.orgchart_id','=','orgchartnode.orgchart_id')->join('userpositiongroup','orgchartnode.upg_id','=','userpositiongroup.upg_id')->join('group as g','userpositiongroup.group_group_id','=','g.group_id')->join('position','userpositiongroup.position_pos_id','=','position.pos_id')->join('user','userpositiongroup.user_user_id','=','user.user_id')->get();
        $group= DB::table('group')->where('group.group_group_id','=',$groupid)->join('userpositiongroup','group.group_id','=','userpositiongroup.group_group_id')->join('position','userpositiongroup.position_pos_id','=','position.pos_id')->join('user','userpositiongroup.user_user_id','=','user.user_id')->get();
           // $getchild = DB::table('');
           // dd($group);  
        $depname=array();   
        $depth = array();
         $firstname=array();
         $lastname=array();
         $rootpos=array();
         $groupidd=array();
      // dd($group);
        if((count($group))>0){
            foreach ($group as $children){

                $depth=$children->posLevel;
                $groupidd=$children->upg_id;
                $depname=$children->groupName;
                $firstname= $children->firstname;
                $lastname=$children->lastname;
                $rootpos=$children->motherPos;
                $groupid = $children->group_id;
                $posid = $children->pos_id;
                //$userpg = $children->upg_id;
                // $name= $children->groupName;
                // $firstname = $children->firstname;
                //query for mother group of recent upg_id
                $motherGroup = DB::table('group')->where('group_id','=',$groupid)->get();
                foreach ($motherGroup as $mGroup) {
                    $motherGroupId = $mGroup->group_group_id;
                }

                $motherPos = DB::table('position')->where('pos_id','=',$posid)->get();
                foreach ($motherPos as $mPos) {
                    $motherPosId = $mPos->motherPos;
                }

                $motherUPG = DB::table('userpositiongroup')->where([['group_group_id','=',$groupid],['position_pos_id','=',$motherPosId]])
                                                            ->get();
                if(count($motherUPG) > 0)
                {
                    foreach ($motherUPG as $mUPG) {
                    $motherUPGId = $mUPG->upg_id;
                }
                }
                else
                {
                    $motherUPG = DB::table('userpositiongroup')->where([['group_group_id','=',$motherGroupId],['position_pos_id','=',$motherPosId]])
                                                            ->get();
                    foreach ($motherUPG as $mUPG) {
                        $motherUPGId = $mUPG->upg_id;
                    }
                }
                

                    // echo "".$groupidd."----->".$motherUPGId."(motherUPGId)"."<br>";
                // $lastname = $children->lastname;
                // $childId = $children->group_id;
               $array[] = array('link_id'=> $groupidd,'root_id'=>$motherUPGId,'label'=>$depname,'depth'=>$depth,'firstname'=>$firstname,'lastname'=>$lastname);
            // dd($array);
            }
            //$level++;
            
            // echo "<pre>";
            // var_dump($array);
            // dd($array);
            return $this->getgroupchildrenlevel($upgid,$groupid,$array,$level,$orgtxt);
        }
        else
        {
            // dd($array);
            $temp = array();
            $prev = null;
            
            for ($i=0; $i < count($array); $i++) { 
                // var_dump($i);
               foreach($array as $arrays){
               while($arrays['depth']==$prev){
                array_push($temp,$arrays);
                foreach($arrays as $arr){
                    // echo "<pre>";
                    // var_dump($arr);
                }
                $prev++;
               }
           }
            }
            // for ($i=0; $i < count($array); $i++) {
            //     foreach($array as $arrays)
            //     {  
            //         if($arrays['depth'] == $i)
            //         {
            //             if($arrays['depth']!== null)
            //             {
            //                 // if($arrays['root_id'] == $prev)  
            //                 // {
            //                     array_push($temp,$arrays);
            //                     $prev =  $arrays['link_id'];

            //                 // }

            //             }
            //         }
            //     }
            //     // dd($temp);
                    
            //         // array_push($temp,$array[$i]);
            // }
            // dd($temp);

            // $parentsort=array();
            // foreach ($temp as $parent) {

            // }
          $test= $this->listItems($temp);

         foreach($gettexts as $gettext){
        $querrs = $gettext->path;
       }
       
        if(count($querrs)>0){
                $file= fopen($groupid.".txt","w");
                fwrite($file,$test);
                \DB::table('orgchart')->where('group_id','=',$groupid)->update(['path' => $groupid.".txt "]);
                
            }
            // dd($array);
  return view('admin/vieworgchart',['files'=>$test]);
           // return $array;
           
    }
}
   

    function vieworg($upgid,$groupid){  
        $orgtxt = $groupid;
           $check = DB::table('group')->where('group.group_id','=',$groupid)->join('orgchart','group.group_id','=','orgchart.group_id')->join('orgchartnode','orgchart.orgchart_id','=','orgchartnode.orgchart_id')->join('userpositiongroup','orgchartnode.upg_id','=','userpositiongroup.upg_id')->join('group as g','userpositiongroup.group_group_id','=','g.group_id')->join('position','userpositiongroup.position_pos_id','=','position.pos_id')->join('user','userpositiongroup.user_user_id','=','user.user_id')->get();
           $group= DB::table('group')->where('group.group_id','=',$groupid)->get();
           // dd($check);
        $depname=array();
        $posname=array();
        $poslname=array();
        $checkgroupid=array();
        $groupidd=array();
        $depth = array();
        $rootpos=array();
        $groupidd=array();
           $childrenarraylevel =array();
        $level=0;
// foreach ($group as $checkgroup) {
//         $checkgroupid=$checkgroup->group_id;
// }
        foreach ($check as $department) {
          // if($checkgroupid==$groupid){
            $depth=$department->posLevel;
            $groupidd=$department->pos_id;
            $upgid = $department->upg_id;
            $depname=$department->groupName;
            $posname= $department->firstname;
            $poslname=$department->lastname;
            $rootpos=$department->motherPos;
        $childrenarraylevel[] = array('link_id'=> $upgid,'root_id'=>$rootpos,'label'=>$depname,'depth'=>$depth ,'firstname'=>$posname,'lastname'=>$poslname

    );
        // dd($childrenarraylevel);
        sort($childrenarraylevel);
        $level++;
          // }
          
// dd($childrenarraylevel);
          // echo "<pre>";
          // var_dump($childrenarraylevel);

            
          // else
          //   return redirect()->route('showDep',['upgid'=>$upgid,'id'=>$groupid]);
        }
        // $departname[]=array($depname->);
       
        $arrs=array();
      
         \DB::table('orgchart')->where('group_id','=',$groupid)->insert(['path' => $groupid.".txt ", 'group_id' => $groupid]);
         // dd($upgid,$groupid,$childrenarraylevel,$level,$orgtxt);
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
        $htmlfname ='';
        $htmllname ='';
        $depth = 0; 
        foreach($items as $index => $item){

            $htmlfname=htmlentities($item['firstname']);
            $htmllname=htmlentities($item['lastname']);
            $newDepth = intval($item['depth']);
            
            if ($newDepth > $depth) {
                while ($newDepth > $depth) {
                    $html .= '<ul><li title="'.$htmlfname.','.$htmllname.'">';
                    $depth++;
                    $htmlname='';
                    $htmllname='';
                 }
            } else if ($newDepth < $depth) { 
                while ($newDepth < $depth) {
                    $html .= '</li></ul>';
                    $depth--;
                } 
                $html .= '<li title="'.$htmlfname.','.$htmllname.'">';
                $htmlfname='';
                $htmllname='';
            } else if ($newDepth === $depth) {
                if ($index === 0) {
                    $html .= '<ul><li title="'.$htmlfname.','.$htmllname.'">';
                    $htmlfname='';
                    $htmllname='';
                } else {
                    $html .= '</li><li title="'.$htmlfname.','.$htmllname.'">'; 
                    $htmlfname='';
                    $htmllname='';
                }
            }
 
            $html .= htmlentities($item['label']);
            $htmlfname .=htmlentities($item['firstname']);
            $htmllname .=htmlentities($item['lastname']);
            $depth = $newDepth;
        }
        if (count($items) > 0) {
            while ($depth-- >= 0) {
                $html .= '</li></ul>';
            }
        }
       // dd($html);
        return $html;
        
    }





    //for view orgchart
    public function getGroupOrgChart($upgid,$groupid)
    {
        $orgchartnodesarray = array();

        //query orgchart nodes of groupid
        // $groupOrgChartNodes = DB::table('orgchart as o')->where('o.group_id','=',$groupid)
        //                                         ->join('orgchartnode as on','o.orgchart_id','on.orgchart_id')
        //                                         ->get();

        $groupOrgChartNodes = DB::table('group')->where('group_id','=',$groupid)->get();
        foreach ($groupOrgChartNodes as $groupOrgChartNode) {
            $orgchartnodesarray[] = $groupOrgChartNode->group_id;
        }

        // echo "<pre>";
        // var_dump($orgchartnodesarray);
        // dd($orgchartnodesarray);
        return $this->getChildrenOrgChart($upgid,$groupid,$orgchartnodesarray);
    }

    public function getChildrenOrgChart($upgid,$groupid,$array)
    {

        $tempchildrenarray = array();

        $childrenOrgChartNodes = DB::table('group')->where('group_group_id','=',$groupid)->where('status','=','active')->get();
        $childrencount = 1;
        $totalchildrencount = count($childrenOrgChartNodes);

       if(count($childrenOrgChartNodes)==0)
       {
        return $this->storeArrayToOrgChart($upgid,$groupid,$array);
       }
       else
       {
        foreach ($childrenOrgChartNodes as $childrenOrgChartNode) {
            $array[] = $childrenOrgChartNode->group_id;
            $tempchildrenarray[] = $childrenOrgChartNode->group_id;
        }
        // dd($tempchildrenarray);
        return $this->getChildrenUntilNull($upgid,$array,$tempchildrenarray,$groupid);
        // echo "<pre>";
        // var_dump($tempchildrenarray);
       }
    }

    public function getChildrenUntilNull($upgid,$mainarray,$temparray,$groupid)
    {

        $countNULL = 0;
        $countNotNULL = 0;
        $totalTempArray = count($temparray);


            $temparray2 = $temparray;
            $temparray = null;
        for($i=0;$i<count($temparray2);$i++)
        {  

            $mainarray[] = $temparray2[$i];
            $childrenOrgChartNodes = DB::table('group')->where('group_group_id','=',$temparray2[$i])->get();
                if(count($childrenOrgChartNodes)==0)
                {
                //     echo "<pre>";
                // var_dump($childrenOrgChartNodes);
                    $countNULL++;


                    //break;
                }
                else
                {
                    //$countNotNULL++;
                    foreach ($childrenOrgChartNodes as $childrenOrgChartNode) {
                        $mainarray[] = $childrenOrgChartNode->group_id;
                        $temparray[] = $childrenOrgChartNode->group_id;
                    }

                }
                
        }
        if($countNULL!=$totalTempArray)
            return $this->getChildrenUntilNull($upgid,$mainarray,$temparray,$groupid);
        else if($countNULL == $totalTempArray)
            return $this->storeArrayToOrgChart($upgid,$groupid,$mainarray);

        // echo "<pre>";
        // var_dump($temparray);
    }

    public function storeArrayToOrgChart($upgid,$groupid,$array)
    {
        $array = array_unique($array);
        $array = array_values($array);
        $upg_array = array(); //array pang sud sa mga upg_id
        $upgDep_array = array(); //array for upg_id have department
        $dep_array = array(); // array for department without upg_id
       for($i=0;$i<count($array);$i++)
       {
        if($array[$i] != NULL){
             $groupOrgChart = DB::table('orgchart as o')->where('o.group_id','=',$array[$i])
                                                ->join('orgchartnode as on','o.orgchart_id','on.orgchart_id')
                                                ->get();

            
            $groupDep = DB::table('orgchart as o')->where('o.group_id','=',$array[$i])
                                                  ->leftJoin('orgchartnode as on','o.orgchart_id','on.orgchart_id')
                                                  ->get();
           
            foreach ($groupOrgChart as $orgChart) {
                $upg_array[] = $orgChart->upg_id;
                $upgDep_array[] = $orgChart->group_id;
            }


        }
       

       }

       $upg_array = array_unique($upg_array);
       $upg_array = array_values($upg_array);
       // $upgDep_array = array_unique($upgDep_array)l

      return $this->getUPGInfo($upgid,$groupid,$upg_array);
    }

    public function getUPGInfo($upgid,$groupid,$upgarray)
    {


        $finalArray = array();
        $temp = array();
        $orgchartnamesarray = array();
        $first = true;
         // $test= $upgarray[1];
        // echo "<pre>";
        // var_dump($deparray);

        foreach($upgarray as $upgarrays)
        {
            // dd($upgarrays);
            $upgInfos = DB::table('userpositiongroup as upg')->where('upg_id','=',$upgarrays)
                                                        ->join('deppos as dp','upg.position_pos_id','dp.deppos_id')
                                                        ->join('position as p','dp.pos_id','p.pos_id')
                                                        ->where('p.posName','!=','Student')
                                                        ->join('group as g','upg.group_group_id','g.group_id')
                                                        ->where('g.status','=','active')
                                                        ->join('user as u','upg.user_user_id','u.user_id')
                                                        ->select('dp.motherPos','upg.group_group_id','dp.posLevel','u.firstname','u.lastname','g.groupName','p.posName','upg.upg_id','u.profilepic')
                                                        ->get();

            // echo "<pre>";
            // var_dump($upgarray);
            foreach($upgInfos as $upgInfo)
            {
                $motherPosition = $upgInfo->motherPos;
                $upgGroup = $upgInfo->group_group_id;
                $upgPositionLevel = $upgInfo->posLevel;
                $upgFname = $upgInfo->firstname;
                $upgLname = $upgInfo->lastname;
                $upgPosName = $upgInfo->posName;
                $upgGroupName = $upgInfo->groupName;
                $upgid = $upgInfo->upg_id;
                $profpic= $upgInfo->profilepic;
                $upgGroupId = $upgInfo->group_group_id;
            }

            // echo "<pre>";
            // var_dump($upgInfos);
            //  if($test){
            //  $temp = array(['Name'=>$upgFname.' '.$upgLname,'Position'=>$upgPosName,'group'=>$upgGroupName,'Mother'=>NULL]);
            //          array_push($finalArray,$temp);

            //          $test = 'test';    
            // }

            // if($first){
            //      $temp = array(['Name'=>$upgFname.' '.$upgLname,'Position'=>$upgPosName,'group'=>$upgGroupName,'Mother'=>NULL]);
            //          array_push($finalArray,$temp);

            //          $first = false;
            // }

           
            //get node parent
            // $upgParent = DB::table('position as pos')->where('pos.pos_id',$motherPosition)
            //                                          ->join('userpositiongroup as upg','position_pos_id','pos.pos_id')
            //                                          ->join('group as g','upg.group_group_id','g.group_id')
            //                                          ->where("g.group_id",$motherGroup)
            //                                          ->join('user as u','upg.user_user_id','u.user_id')
            //                                          ->get();

            if($motherPosition!=NULL)
            {
            $upgParent = DB::table('userpositiongroup as upg')->where('upg.group_group_id','=',$upgGroup)
                                                    ->where('upg.position_pos_id','=',$motherPosition)
                                                    ->join('user as u','upg.user_user_id','u.user_id')
                                                    ->get();
            //PARA DLI MA DISPLAY ANG PERSON NGA WALA SA GROUP ID
            $upgParent11 = DB::table('userpositiongroup as upg')->where('upg.group_group_id','=',$upgGroup)
                                                    ->where('upg.position_pos_id','=',$motherPosition)
                                                    ->where('upg.group_group_id','=',$groupid)
                                                    ->join('user as u','upg.user_user_id','u.user_id')
                                                    ->get();                 

            if(count($upgParent11) > 0)
            {
                $parentArray = array();
                $parentString = '';
                foreach ($upgParent as $parent) {
                     $parentUpgId = $parent->upg_id;
                    // $parentFname = $parent->firstname;
                    // $parentLname = $parent->lastname;
                    $parentArray[] = $parent->upg_id;
                    $parentObj = $parent->upg_id;
                    $parentString = $parentObj.','.$parentString;
                }
                 $temp = array(['Name'=>$upgFname.' '.$upgLname,'Position'=>$upgPosName,'group'=>$upgGroupName,'Mother'=>$parentString,'upgid'=>$upgid,'profilepic'=>$profpic,'upgGroup'=>$upgGroup]);
                     array_push($finalArray,$temp);


                $parentUpgInfos = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$parentUpgId)->get();
            }
            else if(count($upgParent)==0) //if wala sa group ang parent, go to mother group
            {

                //get mother group of upgGroup
                $groupInfos = DB::table('group')->where('group_id','=',$upgGroup)->get();
                foreach ($groupInfos as $groupInfo) {
                    $parentGroup = $groupInfo->group_group_id;
                }

                $upgParent2 = DB::table('userpositiongroup as upg')->where('upg.group_group_id','=',$parentGroup)
                                                    ->where('upg.position_pos_id','=',$motherPosition)
                                                    ->join('user as u','upg.user_user_id','u.user_id')
                                                    ->get();
                $parentArray = array();
                $parentString = '';
                foreach ($upgParent2 as $parent) {
                    // $parentUpgId = $parent->upg_id;
                    // $parentFname = $parent->firstname;
                    // $parentLname = $parent->lastname;
                    $parentArray[] = $parent->upg_id;
                    $parentObj = $parent->upg_id;
                    $parentString = $parentObj.','.$parentString;
                }



                  $temp = array(['Name'=>$upgFname.' '.$upgLname,'Position'=>$upgPosName,'group'=>$upgGroupName,'Mother'=>$parentString,'upgid'=>$upgid,'profilepic'=>$profpic,'upgGroup'=>$upgGroup]);
                     array_push($finalArray,$temp);

            }
        }
            else
            {

                $temp = array(['Name'=>$upgFname.' '.$upgLname,'Position'=>$upgPosName,'group'=>$upgGroupName,'Mother'=>NULL,'upgid'=>$upgid,'profilepic'=>$profpic,'upgGroup'=>$upgGroup]);
                     array_push($finalArray,$temp);
                 
            }


            // foreach($upgInfos as $upgInfo)
            // {
            //     if(isset($upgParent))
            //     {
            //         $temp = array(['Name'=>$upgInfo->firstname.', '.$upgInfo->lastname,'Position'=>$upgInfo->posName,'Mother'=>NULL]);
            //     }
            //     foreach($upgParent as $upgParents)
            //     {
            //         $temp = array(['Name'=>$upgInfo->firstname.', '.$upgInfo->lastname,'Position'=>$upgInfo->posName,'Mother'=>$upgParents->firstname.', '.$upgParents->lastname]);
            //     }
            //     array_push($finalArray,$temp);
            // }

        }  
        // dd($upgarray);

        // dd($finalArray);
        $userlogin = Auth::user();

        $output = array_map("unserialize", array_unique(array_map("serialize", $finalArray)));
        // $wow = array_unique($finalArray);
        // echo "<pre>";
        // var_dump($output);
         $personupgnames = DB::table('group as g')->where('g.group_id','=',$groupid)->select('g.groupName')->get();

         foreach ($personupgnames as $personupgname) {
             $PUpgName=$personupgname->groupName;
         }
         // dd($output);
            return view('admin/vieworgchart',['files'=>$output,'upgid'=>$upgid, 'user'=>$userlogin, 'personupgname'=>$PUpgName, 'depid'=>$groupid]);
        // return $finalArray;



  // return view('admin/vieworgchart',['files'=>$test]);
    }








    //for view department orgchart
    public function getGroupOrgChartDep($upgid,$groupid)
    {
        $orgchartnodesarray = array();
        //GET CURRENT DEPARTMENT
        //query orgchart nodes of groupid
        // $groupOrgChartNodes = DB::table('orgchart as o')->where('o.group_id','=',$groupid)
        //                                         ->join('orgchartnode as on','o.orgchart_id','on.orgchart_id')
        //                                         ->get();

        $groupOrgChartNodes = DB::table('group')->where('group_id','=',$groupid)->where('status','=','active')->get();
        foreach ($groupOrgChartNodes as $groupOrgChartNode) {
            $orgchartnodesarray[] = $groupOrgChartNode->group_id;
        }

        // echo "<pre>";
        // var_dump($orgchartnodesarray);
        return $this->getChildrenOrgChartDep($upgid,$groupid,$orgchartnodesarray);
    }

    public function getChildrenOrgChartDep($upgid,$groupid,$array)
    {

        $tempchildrenarray = array();

        $childrenOrgChartNodes = DB::table('group')->where('group_group_id','=',$groupid)->where('status','=','active')->get();
        //GIKUHA IYAHANG CHILDREN (children ra niya)
        // dd($childrenOrgChartNodes);
        $childrencount = 1;
        $totalchildrencount = count($childrenOrgChartNodes);
       if(count($childrenOrgChartNodes)==0)
       {
        return $this->storeArrayToOrgChartDep($upgid,$groupid,$array);
       }
       else
       {
        foreach ($childrenOrgChartNodes as $childrenOrgChartNode) {
            $array[] = $childrenOrgChartNode->group_id;
            //GIKUHA ANG IYAHANG CHILDRENID NGA GROUPID

            $tempchildrenarray[] = $childrenOrgChartNode->group_id;
            //GIKUHA ANG IYAHANG CHILDRENID NGA GROUPID
        }

        return $this->getChildrenUntilNullDep($upgid,$array,$tempchildrenarray,$groupid);
        // echo "<pre>";
        // var_dump($tempchildrenarray);

       }
    }

    public function getChildrenUntilNullDep($upgid,$mainarray,$temparray,$groupid)
    {
        // dd($temparray);
        $countNULL = 0;
        $countNotNULL = 0;
        $totalTempArray = count($temparray);
        //GIIHAP ANG IYAHANG CHILDREN SA TEMPARRAY
            $temparray2 = $temparray;
            // dd($temparray2);
            $temparray = null;
        for($i=0;$i<count($temparray2);$i++)
        {  
            
            $mainarray[] = $temparray2[$i];
            $childrenOrgChartNodes = DB::table('group')->where('group_group_id','=',$temparray2[$i])->where('status','=','active')->get();
            //GIKUHA IYAHA CHILDREN PARA ISULOD ANG CHILDRENORGCHARTNODES

                if(count($childrenOrgChartNodes)==0)
                {
                //     echo "<pre>";
                // var_dump($childrenOrgChartNodes);
                    $countNULL++;

                    //break;

                }
                else
                {
                    //$countNotNULL++;
                    foreach ($childrenOrgChartNodes as $childrenOrgChartNode) {
                        $mainarray[] = $childrenOrgChartNode->group_id;
                        //GISULOD ANG MGA CHILDREN
                        $temparray[] = $childrenOrgChartNode->group_id;
                        //GISULOD ANG MGA CHILDREN
                    }


                }

                
        }




        if($countNULL!=$totalTempArray){
            //MUBALIK IF WLA NAKUHA TANAN CHILDREN SA CHILDREN
            return $this->getChildrenUntilNullDep($upgid,$mainarray,$temparray,$groupid);

        }
        else if($countNULL == $totalTempArray)
            return $this->storeArrayToOrgChartDep($upgid,$groupid,$mainarray);

        // echo "<pre>";
        // var_dump($temparray);
    }

    public function storeArrayToOrgChartDep($upgid,$groupid,$array)
    {

        $array = array_unique($array);
        $array = array_values($array);
        $upg_array = array(); //array pang sud sa mga upg_id
        $tempDep = array();
        $finalArrayDep = array();
        $posArray = array();
        $posString = '';

        foreach ($array as $arrays) {

            $depInfos = DB::table('group as g')->where('group_id','=',$arrays)->where('status','=','active')
                                               ->select('g.group_id','g.groupName','g.group_group_id','g.client_id')
                                               ->get();
            $depPoss = DB::table('deppos as dp')->where('pos_group_id','=',$arrays)
                                               ->join('position as p','dp.pos_id','p.pos_id')
                                               ->where('p.posName','!=','Student')
                                               ->join('userpositiongroup as upg','dp.deppos_id','upg.position_pos_id')
                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                ->select('u.firstname','u.lastname','p.posName')
                                               ->get();
            $depUsers = DB::table('deppos as dp')->where('pos_group_id','=',$arrays)
                                                ->join('userpositiongroup as upg','dp.deppos_id','upg.position_pos_id')
                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                ->select('u.firstname','u.lastname')
                                                ->get();
           foreach ($depInfos as $depInfo) {
              $motherDep = $depInfo->group_group_id;
              $depName = $depInfo->groupName;
              $depId = $depInfo->group_id;
           }

           foreach ($depPoss as $depPos) {
               $depPosition = $depPos->posName;
               $depPosName = $depPos->lastname;
               $depPosAndName = $depPosName.'('.$depPosition.')';
               $posString = $depPosAndName.' '.$posString;
           }
           

            $tempDep = array(['groupid'=>$depId,'depName'=>$depName,'motherDep'=>$motherDep, 'depPos'=>$posString]);
                     array_push($finalArrayDep,$tempDep);
            $posString = '';
        }

        // dd($finalArrayDep);
        // echo "<pre>";
        // var_dump($tempDep);
        
        

      return $this->getMotherDep($upgid,$groupid,$finalArrayDep,$motherDep);

       // return view('admin/vieworgchartdep',['files'=>$output,'upgid'=>$upgid, 'user'=>$userlogin]);
    }

    public function getMotherDep($upgid,$groupid,$finalArrayDep,$motherDep){
        $GetUpres= DB::table('userpositiongroup as upg')
                       ->where('group_group_id','=',$groupid)
                       ->select('client_id')
                       ->get();
        foreach ($GetUpres as $gups) {
            $Upres = $gups->client_id;
        }
        // dd($groupid);
        $tempDep = array();
        $finalArrayDep1 = array();
        $finalArrayDep1 = $finalArrayDep;
        $DepMothers = DB::table('group as g')->where('group_id','=',$motherDep)->get();
        foreach ($DepMothers as $DepMother) {
            $mother = $DepMother->group_group_id;
            $ids = $DepMother->group_id;
            $gname = $DepMother->groupName;
        }
        // $tempDep = array(['groupid'=>$ids,'depName'=>$gname,'motherDep'=>$mother]);
        //              array_push($finalArrayDep1,$tempDep);

        if ($motherDep != $Upres) {
            $DepMothers1 = DB::table('group as g')->where('group_id','=',$motherDep)->get();
            $depPoss = DB::table('deppos as dp')->where('pos_group_id','=',$motherDep)
                                               ->join('position as p','dp.pos_id','p.pos_id')
                                               ->where('p.posName','!=','Student')
                                               ->join('userpositiongroup as upg','dp.deppos_id','upg.position_pos_id')
                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                ->select('u.firstname','u.lastname','p.posName')
                                               ->get();
  
            foreach ($DepMothers1 as $DepMother1) {
                $mother1 = $DepMother1->group_group_id;
                $ids1 = $DepMother1->group_id;
                $gname1 =$DepMother1->groupName;
            }
            $posString = '';
           foreach ($depPoss as $depPos) {
               $depPosition = $depPos->posName;
               $depPosName = $depPos->lastname;
               $depPosAndName = $depPosName.'('.$depPosition.')';
               $posString = $depPosAndName.' '.$posString;
           }
           
              $tempDep = array(['groupid'=>$ids1,'depName'=>$gname1,'motherDep'=>$mother1,'depPos'=>$posString]);
                         array_push($finalArrayDep1,$tempDep);
             $posString = '';
           return $this->getMotherDep($upgid,$groupid,$finalArrayDep1,$mother1);
        }
        else{
            // dd($finalArrayDep1);
            $userlogin = Auth::user();
            return view('admin/vieworgchartdep',['files'=>$finalArrayDep1,'upgid'=>$upgid, 'user'=>$userlogin, 'groupid'=>$groupid]);
        }
        
    }






    //FOR DELETE DEPARTMENT
    public function getGroupOrgChartDel($upgid,$groupid)
    {
        $orgchartnodesarray = array();

        //query orgchart nodes of groupid
        // $groupOrgChartNodes = DB::table('orgchart as o')->where('o.group_id','=',$groupid)
        //                                         ->join('orgchartnode as on','o.orgchart_id','on.orgchart_id')
        //                                         ->get();

        $groupOrgChartNodes = DB::table('group')->where('group_id','=',$groupid)->get();


        // echo "<pre>";
        // var_dump($orgchartnodesarray);
        // dd($orgchartnodesarray);
        return $this->getChildrenOrgChartDel($upgid,$groupid,$orgchartnodesarray);
    }

    public function getChildrenOrgChartDel($upgid,$groupid,$array)
    {

        $tempchildrenarray = array();

        $childrenOrgChartNodes = DB::table('group')->where('group_group_id','=',$groupid)->where('status','=','active')->get();
        
        $childrencount = 1;
        $totalchildrencount = count($childrenOrgChartNodes);

       if(count($childrenOrgChartNodes)==0)
       {
        return $this->storeArrayToOrgChartDel($upgid,$groupid,$array);
       }
       else
       {
        foreach ($childrenOrgChartNodes as $childrenOrgChartNode) {
            $array[] = $childrenOrgChartNode->group_id;
            $tempchildrenarray[] = $childrenOrgChartNode->group_id;
        }
        dd($tempchildrenarray);
        return $this->getChildrenUntilNullDel($upgid,$array,$tempchildrenarray,$groupid);
        // echo "<pre>";
        // var_dump($tempchildrenarray);
       }
    }

    public function getChildrenUntilNullDel($upgid,$mainarray,$temparray,$groupid)
    {

        $countNULL = 0;
        $countNotNULL = 0;
        $totalTempArray = count($temparray);


            $temparray2 = $temparray;
            $temparray = null;
        for($i=0;$i<count($temparray2);$i++)
        {  

            $mainarray[] = $temparray2[$i];
            $childrenOrgChartNodes = DB::table('group')->where('group_group_id','=',$temparray2[$i])->get();

                if(count($childrenOrgChartNodes)==0)
                {
                //     echo "<pre>";
                // var_dump($childrenOrgChartNodes);
                    $countNULL++;

                    //break;
                }
                else
                {
                    //$countNotNULL++;
                    foreach ($childrenOrgChartNodes as $childrenOrgChartNode) {
                        $mainarray[] = $childrenOrgChartNode->group_id;
                        $temparray[] = $childrenOrgChartNode->group_id;
                    }

                }
                
        }
        if($countNULL!=$totalTempArray)
            return $this->getChildrenUntilNullDel($upgid,$mainarray,$temparray,$groupid);
        else if($countNULL == $totalTempArray)
            return $this->storeArrayToOrgChartDel($upgid,$groupid,$mainarray);

        // echo "<pre>";
        // var_dump($temparray);
    }

    public function storeArrayToOrgChartDel($upgid,$groupid,$array)
    {
        $array = array_unique($array);
        $array = array_values($array);
        $upg_array = array(); //array pang sud sa mga upg_id
        $upgDep_array = array(); //array for upg_id have department
        $dep_array = array(); // array for department without upg_id
       for($i=0;$i<count($array);$i++)
       {
        if($array[$i] != NULL){
             $groupOrgChart = DB::table('orgchart as o')->where('o.group_id','=',$array[$i])
                                                ->join('orgchartnode as on','o.orgchart_id','on.orgchart_id')
                                                ->get();


            $groupDep = DB::table('orgchart as o')->where('o.group_id','=',$array[$i])
                                                  ->leftJoin('orgchartnode as on','o.orgchart_id','on.orgchart_id')
                                                  ->get();
           
            foreach ($groupOrgChart as $orgChart) {
                $upg_array[] = $orgChart->upg_id;
                $upgDep_array[] = $orgChart->group_id;
            }


        }
       

       }

       $upg_array = array_unique($upg_array);
       $upg_array = array_values($upg_array);
       // $upgDep_array = array_unique($upgDep_array)l


      return $this->getUPGInfoDel($upgid,$groupid,$upg_array);
    }

    public function getUPGInfoDel($upgid,$groupid,$upgarray)
    {
        $finalArray = array();
        $temp = array();
        $orgchartnamesarray = array();
        $first = true;
         // $test= $upgarray[1];
        // echo "<pre>";
        // var_dump($deparray);
        foreach($upgarray as $upgarrays)
        {
            $upgInfos = DB::table('userpositiongroup as upg')->where('upg_id','=',$upgarrays)
                                                        ->join('deppos as dp','upg.position_pos_id','dp.deppos_id')
                                                        ->join('position as p','dp.pos_id','p.pos_id')
                                                        ->where('p.posName','!=','Student')
                                                        ->join('group as g','upg.group_group_id','g.group_id')
                                                        ->join('user as u','upg.user_user_id','u.user_id')
                                                        ->select('dp.motherPos','upg.group_group_id','dp.posLevel','u.firstname','u.lastname','g.groupName','p.posName','upg.upg_id','u.profilepic')
                                                        ->get();

            // echo "<pre>";
            // var_dump($upgarray);
            foreach($upgInfos as $upgInfo)
            {
                $motherPosition = $upgInfo->motherPos;
                $upgGroup = $upgInfo->group_group_id;
                $upgPositionLevel = $upgInfo->posLevel;
                $upgFname = $upgInfo->firstname;
                $upgLname = $upgInfo->lastname;
                $upgPosName = $upgInfo->posName;
                $upgGroupName = $upgInfo->groupName;
                $upgid = $upgInfo->upg_id;
                $profpic= $upgInfo->profilepic;
                $upgGroupId = $upgInfo->group_group_id;
            }

            // echo "<pre>";
            // var_dump($upgInfos);
            //  if($test){
            //  $temp = array(['Name'=>$upgFname.' '.$upgLname,'Position'=>$upgPosName,'group'=>$upgGroupName,'Mother'=>NULL]);
            //          array_push($finalArray,$temp);

            //          $test = 'test';    
            // }

            // if($first){
            //      $temp = array(['Name'=>$upgFname.' '.$upgLname,'Position'=>$upgPosName,'group'=>$upgGroupName,'Mother'=>NULL]);
            //          array_push($finalArray,$temp);

            //          $first = false;
            // }

           
            //get node parent
            // $upgParent = DB::table('position as pos')->where('pos.pos_id',$motherPosition)
            //                                          ->join('userpositiongroup as upg','position_pos_id','pos.pos_id')
            //                                          ->join('group as g','upg.group_group_id','g.group_id')
            //                                          ->where("g.group_id",$motherGroup)
            //                                          ->join('user as u','upg.user_user_id','u.user_id')
            //                                          ->get();
            if($motherPosition!=NULL)
            {
            $upgParent = DB::table('userpositiongroup as upg')->where('upg.group_group_id','=',$upgGroup)
                                                    ->where('upg.position_pos_id','=',$motherPosition)
                                                    ->join('user as u','upg.user_user_id','u.user_id')
                                                    ->get();
                              

            if(count($upgParent) > 0)
            {
                $parentArray = array();
                $parentString = '';
                foreach ($upgParent as $parent) {
                     $parentUpgId = $parent->upg_id;
                    // $parentFname = $parent->firstname;
                    // $parentLname = $parent->lastname;
                    $parentArray[] = $parent->upg_id;
                    $parentObj = $parent->upg_id;
                    $parentString = $parentObj.','.$parentString;
                }
                 $temp = array(['Name'=>$upgFname.' '.$upgLname,'Position'=>$upgPosName,'group'=>$upgGroupName,'Mother'=>$parentString,'upgid'=>$upgid,'profilepic'=>$profpic,'upgGroup'=>$upgGroup]);
                     array_push($finalArray,$temp);

                $parentUpgInfos = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$parentUpgId)->get();
            }
            else if(count($upgParent)==0) //if wala sa group ang parent, go to mother group
            {

                //get mother group of upgGroup
                $groupInfos = DB::table('group')->where('group_id','=',$upgGroup)->get();
                foreach ($groupInfos as $groupInfo) {
                    $parentGroup = $groupInfo->group_group_id;
                }

                $upgParent2 = DB::table('userpositiongroup as upg')->where('upg.group_group_id','=',$parentGroup)
                                                    ->where('upg.position_pos_id','=',$motherPosition)
                                                    ->join('user as u','upg.user_user_id','u.user_id')
                                                    ->get();
                $parentArray = array();
                $parentString = '';
                foreach ($upgParent2 as $parent) {
                    // $parentUpgId = $parent->upg_id;
                    // $parentFname = $parent->firstname;
                    // $parentLname = $parent->lastname;
                    $parentArray[] = $parent->upg_id;
                    $parentObj = $parent->upg_id;
                    $parentString = $parentObj.','.$parentString;
                }



                  $temp = array(['Name'=>$upgFname.' '.$upgLname,'Position'=>$upgPosName,'group'=>$upgGroupName,'Mother'=>$parentString,'upgid'=>$upgid,'profilepic'=>$profpic,'upgGroup'=>$upgGroup]);
                     array_push($finalArray,$temp);
                 
            }
        }
            else
            {

                
                $temp = array(['Name'=>$upgFname.' '.$upgLname,'Position'=>$upgPosName,'group'=>$upgGroupName,'Mother'=>NULL,'upgid'=>$upgid,'profilepic'=>$profpic,'upgGroup'=>$upgGroup]);
                     array_push($finalArray,$temp);
                 
            }


            // foreach($upgInfos as $upgInfo)
            // {
            //     if(isset($upgParent))
            //     {
            //         $temp = array(['Name'=>$upgInfo->firstname.', '.$upgInfo->lastname,'Position'=>$upgInfo->posName,'Mother'=>NULL]);
            //     }
            //     foreach($upgParent as $upgParents)
            //     {
            //         $temp = array(['Name'=>$upgInfo->firstname.', '.$upgInfo->lastname,'Position'=>$upgInfo->posName,'Mother'=>$upgParents->firstname.', '.$upgParents->lastname]);
            //     }
            //     array_push($finalArray,$temp);
            // }

        }  
        // dd($upgarray);

        // dd($finalArray);
        $userlogin = Auth::user();

        $output = array_map("unserialize", array_unique(array_map("serialize", $finalArray)));
        // $wow = array_unique($finalArray);
        // echo "<pre>";
        // var_dump($output);
         $personupgnames = DB::table('group as g')->where('g.group_id','=',$groupid)->select('g.groupName')->get();

         foreach ($personupgnames as $personupgname) {
             $PUpgName=$personupgname->groupName;
         }
         // dd($output);
        // return view('admin/vieworgchart',['files'=>$output,'upgid'=>$upgid, 'user'=>$userlogin, 'personupgname'=>$PUpgName]);
        // return $finalArray;
         return redirect()->route('showDep',['upgid'=>$upgid,'depid'=>$currentdepid]);




  // return view('admin/vieworgchart',['files'=>$test]);
    }




 
}

