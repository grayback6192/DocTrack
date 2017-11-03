<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Session;


class User extends Controller
{
    public function editFile($id)
    {
        $user = Auth::user();
        $request = \DB::table("template")->where("template_id","=",$id)->get();
        foreach ($request as $requests)
        $phpWord = \PhpOffice\PhpWord\IOFactory::load('templates/'.$requests->templatename.'.docx');
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'HTML');
        $htmlWriter->save('temp/'.$requests->templatename.'.html');
        $htmlLoader = file_get_contents('temp/'.$requests->templatename.'.html');

        $usergroup = DB::table('userpositiongroup')->get();
    foreach ($usergroup as $ug) {
        $group = $ug->group_group_id;
    }
    $upgid = \Session::get('upg');
        $client = DB::table('userpositiongroup')->where('upg_id','=',$upgid)->get();
        foreach ($client as $value) {
            $clientid = $value->client_id;
        }
    $workflow = DB::table('workflow')->where('client_id','=',Session::get('client'))->where('status','=','active')->get();
    $docwf = DB::table('template')->where('template.template_id','=',$id)
            ->join('workflow','template.workflow_w_id','=','workflow.w_id')
            ->select('template.workflow_w_id','workflow.workflowName')
            ->get();

    foreach ($docwf as $key) {
        $wid = $key->workflow_w_id;
    }
    $groups = DB::table('group')->get();

    $docgroup = DB::table('template')->where('template.template_id','=',$id)
                ->join('group','template.group_group_id','=','group.group_id')
                ->select('template.group_group_id')
                ->get();
    foreach ($docgroup as $key) {
        $gid = $key->group_group_id;
    }
     
        return view("admin/editTemplate",["title"=>$requests->templatename,
                                        "content"=>$htmlLoader,
                                        "User"=>$user,
                                        "workflow"=>$workflow,
                                        "groups"=>$groups,
                                        "wid"=>$wid,
                                        "gid"=>$gid,
                                        "tempid"=>$id]);
    }
    public function editToAddFile($tempid)
    {
        $user = request()->all();
        $title = str_replace(" ", "_", $user['title']);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $user['text']);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('templates/'.$title.'.docx');
        //PDF RENDERER
        $dompdf= new Dompdf();
        $dompdf->loadHtml($user['text']);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("pdf/".$title.".pdf", $output);
        //Delete Files
        unlink('temp/'.$title.'.html');

        \DB::table('template')->where('template_id','=',$tempid)->update(['templatename'=>$title,
                                                                            'group_group_id'=>$user['group'],
                                                                            'workflow_w_id'=>$user['wf']]);
        return redirect()->route("AdminTemplate");
    }
    public function viewFile($id)
    {
        $templateRequest = request()->all();
        $request = \DB::table("template")->where("template_id","=",$id)->get();
        foreach ($request as $requests)
        $template = new \PhpOffice\PhpWord\TemplateProcessor('templates/'.$requests->templatename.'.docx');
        $variable = $template->getVariables();
        foreach($variable as $variables)
        {
            $newVar = str_replace(" ","_",$variables);
            $template->setValue($variables,$templateRequest[$newVar]);
        }
        $template->saveAs('temp/'.$requests->templatename.'.docx');

        //Save file as HTML
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord = \PhpOffice\PhpWord\IOFactory::load('temp/'.$requests->templatename.'.docx'); 
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'HTML');
        $htmlWriter->save('temp/'.$requests->templatename.'.html');
        unlink('temp/'.$requests->templatename.'.docx');

        //View using DOMPDF
        $dompdf = new Dompdf();
        $dompdf->set_option("chroot","temp/");
        $dompdf->load_html_file('temp/'.$requests->templatename.'.html');
        $dompdf->render();
        $dompdf->stream("temp/".$requests->templatename.".pdf",array("Attachment"=>0));
        return redirect()->route("Template");

    }

    public function uploadfile(Request $request){
         $name = Auth::user();
         $clients = $this->getClientId($name->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
        $rand = rand(1,1000);
        $user = request()->all();
        $title = str_replace(" ", "_", $user['title']);
        $path = "templates/".$title.".docx";
        $path = $request->UploadFile->storeAs('templates',$title.'.docx');
        DB::table("template")->insert(["template_id"=>$rand,
                                       "templatename"=>$title,
                                       "template_path"=>$path,
                                       "group_group_id"=>$request['group'],
                                       "workflow_w_id"=>$request['wf'],
                                       "client_id"=>$clientId,
                                       "status"=>"active"]);

        return "Upload Success";
    }


    public function insertFile($id)
    {
        
        $user = Auth::user();
        $group = \Session::get('groupid');
        $upgs = DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)
                ->whereNotNull('group_group_id')
                ->get();   

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');
        $time = date('h:i:sa');

        foreach ($upgs as $upg) {
            $upgId = $upg->upg_id;
            $groupid = $upg->group_group_id;
        }

        $templateRequest = request()->all();
        $request = \DB::table("template")->where("template_id","=",$id)->get();
        foreach ($request as $requests)
        {
        $template = new \PhpOffice\PhpWord\TemplateProcessor('templates/'.$requests->templatename.'.docx');
        $title = $templateRequest['subject'];
        }
        $variable = $template->getVariables();
        foreach($variable as $variables)
        {
            $newVar = str_replace(" ","_",$variables);
            $template->setValue($variables,$templateRequest[$newVar]);
        }
        $rand = rand(10000,99999);
        $path = 'file/'.$rand.'.docx';
        DB::table("document")->insert(["doc_id"=>$rand,
                                       "docname"=>$title,
                                       "doc_path"=>$path,
                                       "template_template_id"=>$id,
                                       "userpositiongroup_upg_id"=>$upgId,
                                        "sentDate"=>$date,
                                        "sentTime"=>$time]);
        $template->saveAs('file/'.$rand.'.docx');
        
        $docs = DB::table("document")->where('doc_id','=',$rand)->get();
        foreach ($docs as $doc) {
            //convert doc to pdf
         $dompdf= new Dompdf();
        $dompdf->loadHtml($doc->doc_id);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("pdf/".$doc->doc_id.".pdf", $output);
        }
        

         $var = $this->getWorkflow($groupid,$id);
          return $this->insertTransaction($rand,$var);
        // echo "<pre>";
        // var_dump($groupid);
    }

    public function insertTransaction($docid,$array)
    {
       
        for($i=0;$i<(count($array));$i++){
        for($j=0;$j<(count($array[$i]));$j++){
            $upgid = $array[$i][$j]["upg_id"];
            $wdid = $array[$i][$j]["ws_id"];
            $order = $array[$i][$j]["order"];
            $next = $array[$i][$j]["next"];

            DB::table('transaction')->insert(["document_doc_id"=>$docid,
                                            "upg_id"=>$upgid,
                                            "wd_id"=>$wdid,
                                             "order"=>$order,
                                             "status"=>"pending",
                                             "next"=>$next]);
        }
       }
       $val = array();
       $firstNode = DB::table('transaction as t')->where('t.document_doc_id','=',$docid)
                ->join('workflowsteps as ws','t.wd_id','=','ws.ws_id')
                ->where('ws.prev','=','')
                ->get();
        foreach ($firstNode as $key) {
            $vals = $key->tran_id;
            $vals1 = json_decode(json_encode($vals),TRUE);
            $val[] = $vals1;
        }
        return $this->insertInbox($docid,$val);
    }

    public function insertInbox($docid,$node){
        
        //get owner of template for redirection
        $tempgroup = DB::table('document')->where('doc_id','=',$docid)
                    ->join('template','document.template_template_id','=','template.template_id')
                    ->get();
        foreach ($tempgroup as $key) {
            $gid = $key->group_group_id;
        }
        $user = Auth::user();
         date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');
        $time = date('h:i:sa');
        $rec = array();
        //START HERE
         for ($z=0;$z<count($node);$z++) {
            $send = DB::table('transaction')->where([['document_doc_id','=',$docid],['tran_id','=',$node[$z]]])
                    ->join('userpositiongroup as upg','transaction.upg_id','=','upg.upg_id')
                    ->join('user','upg.user_user_id','=','user.user_id')
                    ->get();

        foreach($send as $sends){
            DB::table('inbox')->insert(["status"=>"unread",
                                        "user_id"=>$sends->user_id,
                                        "doc_id"=>$sends->document_doc_id,
                                        "time"=>$time,
                                        "date"=>$date]);
            $send = json_decode(json_encode($send),TRUE);
            $rec[] = $send;
                    

          }
         
            
         }
        
         return redirect()->route("Template",['gid'=>$gid]);
        

    }

    public function readFile($tempid)
    {
        $name = Auth::user();
        $group = \Session::get('groupid');
        echo $tempid;
        $request = \DB::table("template")->where("template_id","=",$tempid)->get();
        foreach ($request as $requests)
        $template = new \PhpOffice\PhpWord\TemplateProcessor('templates/'.$requests->templatename.'.docx');
        $variable = $template->getVariables();
        $var = $this->getWorkflow($group,$tempid);
        return view("user/templatefillup",["variable"=>$variable,
                                            "var"=>$var,
                                           "id"=>$request->first(),
                                           "User"=>$name]);
    }

    public function getWorkflow($groupid,$templateid)
    {
         
        $workflow = DB::table('template')->where('template_id','=',$templateid)
                    ->join('workflow','template.workflow_w_id','=','workflow.w_id')
                    ->join('workflowsteps','workflow.w_id','=','workflowsteps.workflow_w_id')
                    // ->select('template.templatename','workflow.workflowName','workflowsteps.position_pos_id','workflowsteps.order')
                    ->get();

                    $flowlist = array();
                    $arr = array();
                    foreach ($workflow as $flow) {
                        $res = DB::table('userpositiongroup as upg')
                                ->where('upg.position_pos_id','=',$flow->position_pos_id)
                                ->join('user as u','upg.user_user_id','=','u.user_id')
                                ->get();

                          if((count($res))>1)
                          {
                                    $res2 = DB::table('userpositiongroup as upg')
                                    ->where('upg.group_group_id','=',$groupid)
                                    ->where('upg.position_pos_id','=',$flow->position_pos_id)
                                    ->join('user as u','upg.user_user_id','=','u.user_id')
                                    ->get();
                               // $res3 = json_decode(json_encode($res2),TRUE);
                                if(count($res2)>0)
                                    $flowlist[] = $res2;
                                else{
                                        $res5 = DB::table('userpositiongroup as upg')
                                        ->where('upg.position_pos_id','=',$flow->position_pos_id)
                                        ->join('user as u','upg.user_user_id','=','u.user_id')
                                        ->get();
                                        $flowlist[] = $res5;
                                    }
                          }
                          else
                          {
                           // $res4 = json_decode(json_encode($res),TRUE);
                            $flowlist[] = $res;
                          }

                        
                    }
                    for($x=0;$x<(count($flowlist));$x++)
                    {
                        for($y=0;$y<(count($flowlist[$x]));$y++){
                        $query6 = DB::table('template')
                                    ->where('template.template_id','=',$templateid)
                                    ->join('workflow','template.workflow_w_id','=','workflow.w_id')
                                    ->join('workflowsteps','workflow.w_id','=','workflowsteps.workflow_w_id')
                                    ->join('position','workflowsteps.position_pos_id','=','position.pos_id')
                                    ->where('position.pos_id','=',$flowlist[$x][$y]->position_pos_id)
                                    ->join('userpositiongroup as upg','position.pos_id','=','upg.position_pos_id')
                                    ->where('upg.upg_id','=',$flowlist[$x][$y]->upg_id)
                                    ->join('user','upg.user_user_id','=','user.user_id')
                                    ->get();
                                    if($query6->count())
                                    {
                                        $arr1 = json_decode(json_encode($query6),TRUE);
                                        $arr[] = $arr1;
                                    }
                                }
                    }

                     $order = 1;
                    $processcount = 1;
                    $ordered = array();
                    $sort = $this->sortNodes($templateid,$arr,1,1,$ordered);

          
          // echo "<pre>";
          // var_dump($sort);
         
           return $sort;
    }

    public function sortNodes($tempid,$array,$order,$processcount,$sorted)
    {
        $current = array();
        $max = $this->getMax($tempid);
       
        if($processcount<$max || $processcount==$max){
        for ($i=0; $i < count($array) ; $i++) { 
            for ($j=0; $j < count($array[$i]); $j++) { 
                if($array[$i][$j]['order']==$order)
                    $current[] = $array[$i][$j];
                else
                    break;
            }
        }
        return $this->storeOrdered($tempid,$array,$current,$order,$processcount,$sorted);
    }
    else 
        return $sorted;
    } 

    public function getMax($templateid)
    {
        $wf = DB::table('template')->where('template_id','=',$templateid)->get();
        foreach ($wf as $key) {
            $wfid = $key->workflow_w_id;
        }
        
        $numorders = DB::table('workflowsteps')->where('workflow_w_id','=',$wfid)->count();
        return $numorders;
    }

    public function storeOrdered($tempid,$array,$node,$order,$processcount,$sorted)
    {
        //$sortarray = array();
        $sorted[] = $node;
        $order++;
        $processcount++;

        return $this->sortNodes($tempid,$array,$order,$processcount,$sorted);
        // else
        //     return $sortarray;
        //return $processcount;
    }


    public function viewInbox($groupid)
    {
        $user = Auth::user();
        $inbox = \DB::table('inbox')->where('inbox.user_id','=',$user->user_id)
                    ->join('document','inbox.doc_id','=','document.doc_id')
                    ->join('userpositiongroup as upg','document.userpositiongroup_upg_id','=','upg_id')
                    ->join('user as u','upg.user_user_id','=','u.user_id')
                    ->join('group as g', 'upg.group_group_id','=','g.group_id')
                    ->orderBy('inbox.date','desc')
                    ->orderBy('inbox.time','desc')
                    ->get();

         return view("user/test",['inbox'=>$inbox,'User'=>$user]);
                   // return $groupid;
    }
    public function viewdocs(Request $request,$id){

        $upgid = $request->session()->get('upgid');
        $user = Auth::user();
        $userid = $user->user_id;
        $upg_user = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$upgid)->where('upg.user_user_id','=',$userid)->get();
        foreach ($upg_user as $key) {
            $recid = $key->user_user_id;
        }

        $templateRequest = request()->all();
        $request = \DB::table("document")->where("doc_id","=",$id)->get();
        foreach($request as $requests)
        $name = $requests->docname;
        //Save file as HTML
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord = \PhpOffice\PhpWord\IOFactory::load('file/'.$id.'.docx'); 
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'HTML');
        $htmlWriter->save('temp/'.$id.'.html');

        //View using DOMPDF
        $dompdf = new Dompdf();
        $dompdf->set_option("chroot","temp/");
        $dompdf->load_html_file('temp/'.$id.'.html');
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("temp/".$id.".pdf", $output);

        // see if document has been approved
        $approved = DB::table('transaction')->where('upg_id','=',$upgid)->where('document_doc_id','=',$id)
                    ->get();
        foreach ($approved as $key) {
            $status = $key->status;
            $date = $key->date;
            $time = $key->time;
        }

        \DB::table('inbox')->where('doc_id','=',$id)->where('user_id','=',$recid)->update(['status'=>'read']);

        return view("user/viewDocs",["pdf"=>$id, 'User'=>$user, 'status'=>$status, 'time'=>$time, 'date'=>$date]);
        
    }

    public function approvedoc($docid){
   
         $user = Auth::user();

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');
        $time = date('h:i:sa');
        //get transactions of the document
        $trans = \DB::table("transaction")->where('document_doc_id','=',$docid)->get();
        foreach ($trans as $tran) {
            
            
                    $upgid = \DB::table('userpositiongroup as upg')
                    ->where('upg.user_user_id','=',$user->user_id)
                    //->where('upg.upg_id','=',$tran->upg_id)
                    ->get();
                    foreach ($upgid as $key) {
                        $u_id = $key->upg_id;
                    }
                    //update transaction status to approve of the signed in approver
            \DB::table('transaction')->where(['document_doc_id'=>$tran->document_doc_id])->where('upg_id','=',$u_id)
                ->update(['status'=>'approved',
                            'time'=>$time,
                            'date'=>$date]);
            }
            //get transactions of document where upg_id = upg_id of signed in approver to determine its next step
            $nxt = array();
                $next = DB::table('transaction')->where(['document_doc_id'=>$tran->document_doc_id])->where('upg_id','=',$u_id)
                    ->get();
                foreach ($next as $key) {
                    $nexts = $key->next;
                    if(strpos($next,',')!== false) //if there are more than one nexts
                    {
                        $nxt = explode(',', $nexts); //result already in array

                    }
                    else //if there's only one next, put it in array 
                    {
                    $next1 = json_decode(json_encode($nexts),TRUE);
                    $nxt[] = $next1;
                }

            }   
            

           $nxt2 = array();
            //get tran_id of the next/s
            for($x=0;$x<count($nxt);$x++){
                    $trans = DB::table('transaction')->where(['document_doc_id'=>$tran->document_doc_id])->where('wd_id','=',$nxt[$x])
                        ->get();

                        foreach ($trans as $tran) {
                    $nxt2[] = $tran->tran_id;
                }
                }

                //for online signature
                //..codes
                 $poss= session()->get('upgid');
$docs = DB::table("document")->where('doc_id','=',$docid)->get();

        foreach ($docs as $doc) {
           $low = new\PhpOffice\PhpWord\PhpWord();
           $section =   $low->addSection();
           $section->addText('${Chairman}');

                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('file/'.$doc->doc_id.'.docx');
           }
           $signing= DB::table('userpositiongroup')
             ->where('userpositiongroup.upg_id','=',$poss)
             ->join('position','userpositiongroup.position_pos_id','=','position.pos_id')
                ->get();
            
foreach($signing as $signs){
    $name=$signs->posName;
}
$variable=$templateProcessor->getVariables();

$user = DB::table('user')->where('user_id','=',Auth::user()->user_id)->get();
foreach ($user as $value) {
    $sign = $value->signature;
    $compname = $value->lastname.", ".$value->firstname;
}

$signblock = $sign."<br>".$compname;

foreach($variable as $variables)
        {
            if($variables == $name){
                 // $templateProcessor->setValue($name,'Approved By:'.Auth::user()->lastname);
               // $templateProcessor->setValue($name, $sign);
                $templateProcessor->setValue($name, "".$sign." ".Auth::user()->lastname.", ".Auth::user()->firstname);
           }
           // else
           //  $templateProcessor->setValue($variables,$user);
}
//mao ni ang file ang output
$templateProcessor->saveAs('file/'.$docid.'.docx');
               


                

           $allnxt = $this->countAllNext($docid,$nexts);
            $allapproved = $this->countAllApproved($docid,$nexts);
            $totalTrans = $this->getTotalTrans($docid);
            $currentNumApprove = $this->getTotalApprove($docid); 

            if($totalTrans == $currentNumApprove){
                return $this->archive($docid);
            }

//return $allnxt." == ".$allapproved;
            //return $nexts;
             if($allnxt==$allapproved)
                   return $this->insertInboxAfterApprove($docid,$nxt2);

              else
                return redirect()->route('docView',['id'=>$docid]);
                
             

    }

    public function rejectdoc($docid){
        $user = Auth::user();
        $rand = rand(100,1000);
        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');
        $time = date('h:i:sa');

        $trans = \DB::table('transaction')->where('document_doc_id','=',$docid)->get();
        foreach ($trans as $tran){
            $upgid = \DB::table('userpositiongroup as upg')
            ->where('upg.user_user_id','=',$user->user_id)
            ->get();
            foreach($upgid as $key){
                $u_id = $key->upg_id;
            }

        }
         \DB::table('transaction')->where(['document_doc_id'=>$tran->document_doc_id])->where('upg_id','=',$u_id)
            ->update(['status'=>'rejected','time'=>$time,'date'=>$date]);
            
            \DB::table('archive')->insert(['idarchive'=>$rand, 'docid'=>$docid]);
         // return redirect()->route("viewInbox",['groupid'=>Session::get('groupid')]);
         return redirect()->route('docView',['id'=>$docid]);  
    }

    public function archive($docid)
    {
        $rand = rand(100,10000);
        \DB::table('archive')->insert(['idarchive'=>$rand, 'docid'=>$docid]);

         // return redirect()->route("viewInbox",['groupid'=>Session::get('groupid')]);
        return redirect()->route('docView',['id'=>$docid]);
    }

    public function getTotalTrans($docid){

        $counting=\DB::table('transaction')->where('document_doc_id','=',$docid)->count();
        return $counting;
    }

    public function getTotalApprove($docid){
        $countapprove=\DB::table('transaction')->where('document_doc_id','=',$docid)->where('status','=','approved')->count();
        return $countapprove;
    }

    public function insertInboxAfterApprove($docid,$node)
    {
        $user = Auth::user();
         date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');
        $time = date('h:i:sa');
        $rec = array();
        //START HERE
         for ($z=0;$z<count($node);$z++) {
            $send = DB::table('transaction')->where([['document_doc_id','=',$docid],['tran_id','=',$node[$z]]])
                    ->join('userpositiongroup as upg','transaction.upg_id','=','upg.upg_id')
                    ->join('user','upg.user_user_id','=','user.user_id')
                    ->get();

        foreach($send as $sends){
            DB::table('inbox')->insert(["status"=>"unread",
                                        "user_id"=>$sends->user_id,
                                        "doc_id"=>$sends->document_doc_id,
                                        "time"=>$time,
                                        "date"=>$date]);
            $send = json_decode(json_encode($send),TRUE);
            $rec[] = $send;
                    

          }
         
            
         }
        
         //return redirect()->route("viewInbox",['groupid'=>Session::get('groupid')]);
         return redirect()->route('docView',['id'=>$docid]);
    }


    //count all next with the given docu id with the same nexts
    public function countAllNext($docid,$next)//parameter is document id, and $nxt array
    {
        $nxtcount = 0;
        // for($a=0;$a<count($next);$a++){
        $result = DB::table('transaction')->where('document_doc_id','=',$docid)->where('next','=',$next)->get();
        foreach ($result as $res) {
            $nxtcount++;
        }
    // }
        echo "".$docid.", ".$next;
        return $nxtcount;
    }
    //count all approved with the same nexts and docu id
    public function countAllApproved($docid,$next) //parameter is docu id, and $nxt array
    {
        $appCount = 0;
        // for($b=0;$b<count($next);$b++){
         $result = DB::table('transaction')->where('document_doc_id','=',$docid)->where('next','=',$next)->get();
         foreach ($result as $res) {
             if($res->status=='approved')
                $appCount++;
         }
         return $appCount;
    }

    public function sent($groupid)
    {
            $user = Auth::user();
    $userid = $user->user_id;


    $view = \DB::table('userpositiongroup')->where('user_user_id','=',$userid)
    ->get();
    foreach($view as $views){
        $upgID= $views->upg_id;


    }
    $view1 =\DB::table('transaction')->where('upg_id','=',$upgID)->get();

    $documentname =\DB::table('document')
    ->where('document.userpositiongroup_upg_id','=',$upgID)
    ->orderBy('document.sentDate','desc')
    ->orderBy('document.sentTime','desc')
    ->get();

    foreach ($documentname as $key) {
        $docid = $key->doc_id;
        //$datetime = \DB::table('inbox')->where('doc_id','=',$docid)->first();    
    }
    
    
       
        
        return view('user/sentDocs',['documentname'=>$documentname,'User'=>$user]);
                 
    }

    public function complete($groupid){

        $user = Auth::user();
        $userid = $user->user_id;
        $getupg = \Session::get('upgid');


        $view = \DB::table('document')
        ->where('document.userpositiongroup_upg_id','=',$getupg)
        ->join('archive','document.doc_id','=','archive.docid')
        ->get();

        // $view = \DB::table('archive')
        // ->join('document','archive.docid','=','document.doc_id')
        // ->where('document.userpositiongroup_upg_id','=',$getupg)
        // ->get();

        return view('user/completedocs',['completedoc'=>$view, 'User'=>$user]);

    }

    public function track($id){
        //$test = \DB::table("transaction")->get();
        $arr = array();
        $user = Auth::user();
        $name= \DB::table("transaction")
    ->where('document_doc_id','=',$id)
    ->join('userpositiongroup','transaction.upg_id','=','userpositiongroup.upg_id')
    ->join('user','userpositiongroup.user_user_id','=','user.user_id')
    ->get();


     $statuss=\DB::table("transaction")
     ->where('transaction.document_doc_id','=',$id)
     //->where('transaction.document_doc_id','=',16784)
    ->join('document','transaction.document_doc_id','=','document.doc_id')
    ->join('userpositiongroup','transaction.upg_id','=','userpositiongroup.upg_id')
    ->join('user','userpositiongroup.user_user_id','=','user.user_id')
    ->select('transaction.status','user.lastname','user.firstname','transaction.time','transaction.date','document.template_template_id','transaction.order')
    ->get();

   //order statuss 

    return view("user/fileStatus",["name"=>$name],["statuss"=>$statuss,'User'=>$user]);
}


    function getClientId($userid){
        $clientgroup = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                        ->distinct()
                        ->get();
            return $clientgroup;
    }

    public function addFile(Request $request)
    {
         $name = Auth::user();
         $clients = $this->getClientId($name->user_id);
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
        $rand = rand(1,1000);
        $user = request()->all();
        $title = str_replace(" ", "_", $user['title']);
        $path = "templates/".$title.".docx";
        DB::table("template")->insert(["template_id"=>$rand,
                                       "templatename"=>$title,
                                       "template_path"=>$path,
                                       "group_group_id"=>$request['group'],
                                       "workflow_w_id"=>$request['wf'],
                                       "client_id"=>$clientId,
                                       "status"=>"active"]);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $user['text']);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('templates/'.$title.'.docx');

        //PDF RENDERER
        $dompdf= new Dompdf();
        $dompdf->loadHtml($user['text']);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("pdf/".$title.".pdf", $output);
        return redirect()->route("AdminTemplate");
    }

    public function deleteFile($tempid)
    {
        //set status to inactive
        DB::table('template')->where('template_id','=',$tempid)->update(["status"=>"inactive"]);
        return redirect()->route('AdminTemplate');
    }

    public function chooseGroups($userid)
    {
        $name = Auth::user();
        $groups = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                    ->join('group as g','upg.group_group_id','=','g.group_id')
                    ->get();
        return view('user/chooseGroup',['User'=>$name,'usergroups'=>$groups]);
    }
    
    public function index()
    {
        $clientid = \Session::get('client');
        $name = Auth::user();
    	$users = DB::table('user')->where('user.status','=','active')
                ->join('userpositiongroup as upg','user.user_id','=','upg.user_user_id')
                ->where('upg.client_id','=',$clientid)
                ->orderBy('lastname','asc')
                ->get();
        
    	return view('admin/usermngmt',['users'=>$users,'User'=>$name]);
    }

    public function show($id)
    {
        $name = Auth::user();
    	$user = DB::table('user')->where('user_id', $id)->get();
    	return view('admin/userprofile',['userid' => $id],
    									 ['user' => $user],
                                         ['User'=>$name->firstname]);
       
    }

    public function showForEdit($id)
    {
        $name = Auth::user();
        $user = DB::table('user')->where('user_id', $id)->get();
        return view('admin/editprofile',['userid' => $id],
                                         ['user' => $user],
                                         ['User'=>$name->firstname]);
    }

    public function update(Request $request,$id)
    {
        $name = Auth::user();
        if($request->image){
            $path = $request->image->store('users/pictures');
            $image = $request->image->hashName();
            DB::table('user')->where('user_id',$id)->update(['profilepic'=>$image]);
        }
        
        DB::table('user')->where('user_id',$id)->update(['firstname'=>$request['fname'],
                                                        'lastname'=>$request['lname'],
                                                        'email'=>$request['email'],
                                                        'gender'=>$request['gender'],
                                                        'address'=>$request['address'],
                                                        'password'=>bcrypt($request['password_confirmation']),
                                                        'signature'=>$request['sign']]);
                                                                   
        return $this->show($id);
    }

    public function add(Request $request)
    {
        $name = Auth::user();
        $path = $request->image->store('users/pictures');
        $image = $request->image->hashName();
        DB::table('user')->insert(['user_id'=>$request['userid'],
                                    'firstname'=>$request['fname'],
                                    'lastname'=>$request['lname'],
                                     'email'=>$request['email'],
                                    'gender'=>$request['gender'],
                                    'address'=>$request['address'],
                                     'password'=>bcrypt($request['password']),
                                     'status'=>"Pending",
                                     'profilepic'=>$image,
                                     'status'=>'active']); 
        return redirect()->route('UserManage');
    }

    public function findUser($groupid,$string)
    {
        $users = DB::table('user')->where('group_group_id','=',$groupid)->where('firstname','LIKE','%'.$string.'%')->orWhere('lastname','LIKE','%'.$string.'%')->get();

        return response()->json($users);
    }

    public function delete($id)
    {
        $name = Auth::user();
        // DB::table('user')->where('userId',$id)->delete();
        DB::table('user')->where('user_id',$id)->update(['status'=>'inactive']);
        return $this->index();
    }

    public function goToGroup($groupid)
    {
        $user = Auth::user();
        $userUpg = DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)->where('group_group_id','=',$groupid)
                    ->get();

        foreach ($userUpg as $usersUpg) {
            $upgID = $usersUpg->upg_id;
        }
        \Session::put('groupid',$groupid);
        \Session::put('upgid',$upgID);

        $gid = \Session::get('groupid');

        return redirect()->route('viewInbox',['groupid'=>$gid]);
    }
}
