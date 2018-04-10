<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Session;
use App\Http\Controllers\User;
use \CloudConvert\Api;

class DocumentController extends Controller
{
   public function readFile($upgid,$tempid)
    {
        //Testing
        $sender = DB::table("userpositiongroup as upg")
                            ->where("upg_id",$upgid)
                            ->join("user","user.user_id","upg.user_user_id")
                            ->get();
        $name = Auth::user();
        $group = \Session::get('groupid');
        $numunread = getNumberOfUnread($upgid);
        $request = \DB::table("template")->where("template_id","=",$tempid)->get();
        foreach ($request as $requests)
            //get template name
            $tempname = $requests->templatename;
            $template = new \PhpOffice\PhpWord\TemplateProcessor('templates/'.$requests->templatename.'.docx');
        $variable = $template->getVariables();
        $var = getWorkflow2($upgid,$group,$tempid);
        $sortedvar = sortWorkflow($var,$tempid);
        $position = \DB::table('template as t')->where('t.template_id','=',$tempid)
                                                    ->join('workflow as w','t.workflow_w_id','w.w_id')
                                                    ->join('workflowsteps as ws','w.w_id','ws.workflow_w_id')
                                                    ->join('position as p','ws.position_pos_id','p.pos_id')
                                                    ->get();
        $numinprogress = getNumberofInProgress($upgid);
        $temp = sizeof($variable);
        //Get predefined signature block
        for ($i=0; $i <$temp; $i++) 
        { 
            if(strpos($variable[$i],'-')!=false)
            {
                unset($variable[$i]); 
            }
        }
        
        $variable = array_values($variable);
        //Trim variable and get positions
        foreach($position as $positions)
        {
            foreach($variable as $variables)
            {
                if($variables == $positions->posName)
                {
                    $signatureArray[] = $positions->posName;
                    $temp = array_search($positions->posName,$variable);
                    unset($variable[$temp]);
                    $signatureArray[] = $positions->posName."-Name";
                    $signatureArray[] = $positions->posName."-Position";
                    //$variable = array_values($variable);
                }
            }
        }
        if(isset($signatureArray))
        {
            return view("user/templatefillup",["variable"=>$variable,
                                           "var"=>$var,
                                           "sortedvar"=>$sortedvar,
                                           "id"=>$request->first(),
                                           "User"=>$name,
                                           "upgid"=>$upgid,
                                           "position"=>$signatureArray,
                                            "numUnread"=>$numunread,
                                            'numinprogress'=>$numinprogress,
                                            "templatename"=>$tempname,
                                            "sender"=>$sender]);
        }
        else
        {
             return view("user/templatefillup",["variable"=>$variable,
                                           "var"=>$var,
                                           "sortedvar"=>$sortedvar,
                                           "id"=>$request->first(),
                                           "User"=>$name,
                                           "upgid"=>$upgid,
                                            "numUnread"=>$numunread,
                                            'numinprogress'=>$numinprogress,
                                            "templatename"=>$tempname,
                                            "sender"=>$sender]);
        }

        // echo "<pre>";
        // var_dump($var); 
    }

	public function viewFile($id, $upgid) //Views file in PDF with corresponding values inserted, POST
    {

        $groupid = \Session::get('groupid');
        $workflow = getWorkflow2($upgid,$groupid,$id);
        $templateRequest = request()->all();
        $request = \DB::table("template")->where("template_id","=",$id)->get();
        foreach ($request as $requests)
        $template = new \PhpOffice\PhpWord\TemplateProcessor('templates/'.$requests->templatename.'.docx');
        $variable = $template->getVariables();

        foreach($variable as $variables)
        {
            foreach($workflow as $workflows)
            {
                $template->setValue($workflows['posName']."-Name",$workflows['lastname'].', '.$workflows['firstname']);
                $template->setValue($workflows['posName']."-Position",$workflows['groupName'].', '.$workflows['posName']);
            }
            
            if(!strpos($variables,'-'))
            {
            	$newVar = str_replace(" ","_",$variables);
	            $template->setValue($variables,$templateRequest[$newVar]);
	        }
        }
        $template->saveAs('temp/'.$requests->templatename.'.docx');

        //Save file as HTML
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord = \PhpOffice\PhpWord\IOFactory::load('temp/'.$requests->templatename.'.docx'); 
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'HTML');
        $htmlWriter->save('temp/'.$requests->templatename.'.html');
        $getContent = file_get_contents('temp/'.$requests->templatename.'.html');
        //Change name
        $replaceTitle = str_replace("PHPWord","DocTrack | Preview",$getContent);
        file_put_contents('temp/'.$requests->templatename.'.html', $replaceTitle);
        unlink('temp/'.$requests->templatename.'.docx');

        //View using DOMPDF
        $dompdf = new Dompdf();
        $dompdf->set_option("chroot","temp/");
        $dompdf->load_html_file('temp/'.$requests->templatename.'.html');
        $dompdf->render();
        $dompdf->stream("temp/".$requests->templatename.".pdf",array("Attachment"=>0));
        return redirect()->route("Template");
    }
    public function insertFileVariables($id) //Inserts Document Variables, POST, sends document to first receiver and enters all doc transactions
    {
        $user = Auth::user();
        $group = \Session::get('groupid');
        $upgs = DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)
                ->whereNotNull('group_group_id')
                ->get();   
        date_default_timezone_set('Asia/Manila');
        $date = date('M d, Y');
        $time = date('h:i:s a');

        foreach ($upgs as $upg) 
        {
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
            // $newVar = str_replace(" ","_",$variables);
            if(!strpos($variables,"-"))
            {
            	$newVar = str_replace(" ","_",$variables);
	            $template->setValue($variables,$templateRequest[$newVar]);
	        }
        }
        $rand = rand(1,99999);
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
          // Save file as HTML
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord = \PhpOffice\PhpWord\IOFactory::load('file/'.$rand.'.docx'); 
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'HTML');
        $htmlWriter->save('temp/'.$id.'.html');
        foreach ($docs as $doc) 
        {
            $html = file_get_contents('temp/'.$id.'.html');
            $dompdf= new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents("pdf/".$doc->doc_id.".pdf", $output);

        }
         $var = getWorkflow2($upgId,$groupid,$id);
        return insertTransaction($rand,$var,$upgId);
    }

    public function sendScratchDoc(Request $request,$upgid) //send doc from scratch
    {
        $name = Auth::user();
        $rand = rand(1,1000);
        $user = request()->all();
        $title = str_replace(" ", "_", $user['title']);
        $path = "file/".$rand.".docx";
        $workflow = $request['wf'];

        DB::table("document")->insert(["doc_id"=>$rand,
                                       "docname"=>$title,
                                       "doc_path"=>$path,
                                       "template_template_id"=>NULL,
                                       "userpositiongroup_upg_id"=>$upgid,
                                        "sentDate" => NULL,
                                        "sentTime" => NULL]);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $user['text']);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('file/'.$rand.'.docx');
        $objWriterHTML = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriterHTML->save('temp/'.$rand.'.html');

        //PDF RENDERER
        $dompdf= new Dompdf();
        $dompdf->loadHtml($user['text']);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("pdf/".$rand.".pdf", $output);

        $docworkflow = getWorkflowForCustom($upgid,$workflow);
        return insertTransaction($rand,$docworkflow,$upgid);

    }

    public function viewNotification($upgid,$docid)
    {

        DB::table('notification')->where('doc_id','=',$docid)
                                ->where('to_upg_id','=',$upgid)
                                ->update(['not_status'=>'read']);

        return redirect()->route('docView',['upgid'=>$upgid,'id'=>$docid]);
    }

     public function viewdocs(Request $request,$upgid,$id)
     {    
        $user = Auth::user();
        $authSignature = $user->signature;
        $userid = $user->user_id;
        $upg_user = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$upgid)
                                                        ->where('upg.user_user_id','=',$userid)
                                                        ->get();

        //update seen info of document
        date_default_timezone_set('Asia/Manila');
        $readdatetime = date('M d, Y H:i:s a');

        $inboxInfos = DB::table('inbox')->where('upg_id','=',$upgid)
                                        ->where('doc_id','=',$id)
                                        ->get();
        foreach ($inboxInfos as $inboxinfo) {
            // $ireadtime = $inboxinfo->readtime;
            // $ireaddate = $inboxinfo->readdate;
            $inboxLog = DB::table('log')->where('inbox_id','=',$inboxinfo->inbox_id)
                                        ->orderBy('datetime','desc')
                                        ->first();
                //$readdatetime = $inboxLog->datetime;
                $inboxid = $inboxinfo->inbox_id;
                $inboxStatus = $inboxLog->status;
        }

        // $randLog = rand(1,99999);
        if($inboxStatus == "unread"){
            DB::table('log')->insert(['tran_id'=>NULL,
                                    'inbox_id'=>$inboxid,
                                    'status'=>'read',
                                    'datetime'=>$readdatetime]);
        }
        

        foreach ($upg_user as $key){
            $recid = $key->upg_id;
        }

        $templateRequest = request()->all();
        $request = \DB::table("document")->where("doc_id","=",$id)->get();
        foreach($request as $requests)
        $name = $requests->docname;

        //get transaction id of current step
        $doctransactions = DB::table('transaction')->where('upg_id','=',$upgid)->where('document_doc_id','=',$id)->get();
        foreach ($doctransactions as $doctransaction) {
            $doctran_id = $doctransaction->tran_id;
        }

        //go to log for document's current status
        $currentstepstatus = DB::table('log')->where('tran_id','=',$doctran_id)->get();
        foreach ($currentstepstatus as $key) {
            $status = $key->status;
            $datetime = $key->datetime;
        }


        //for viewing workflow of document
         $docworkflows=\DB::table("transaction")
            ->where('transaction.document_doc_id','=',$id)
            ->join('document','transaction.document_doc_id','=','document.doc_id')
            ->join('log','transaction.tran_id','log.tran_id')
            ->join('userpositiongroup','transaction.upg_id','=','userpositiongroup.upg_id')
            ->join('user','userpositiongroup.user_user_id','=','user.user_id')
            ->select('log.status','user.lastname','user.firstname','log.datetime','document.template_template_id','transaction.order','userpositiongroup.upg_id')
            ->orderBy('transaction.order')
            ->get();

            \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
            \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

          $signature = DB::table('transaction as t')
                     ->where('t.document_doc_id','=',$id)
                     // ->where("t.status","=","approved")
                     // ->join("log","t.tran_id","log.tran_id")
                     // ->where("log.status","approved")
                     ->join("userpositiongroup as upg",'t.upg_id',"=",'upg.upg_id')
                     ->join('deppos as dp','upg.position_pos_id','dp.deppos_id')
                     ->join('position as p','dp.pos_id',"=",'p.pos_id')
                     ->join("user as u","upg.user_user_id","=","u.user_id")
                     ->join("group as gr", "upg.group_group_id","gr.group_id")
                     ->get(); //Added
                //get tran_id approve
            $approve = DB::table("transaction as t")
                                ->where("t.document_doc_id",$id)
                                ->join("log","t.tran_id","log.tran_id")
                                ->where("log.status","approved")
                                ->get();


        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('file/'.$id.'.docx');
        $variable = $templateProcessor->getVariables();

       
       foreach($signature as $signatures)
        {
            foreach($variable as $variables)
            {
                if($variables == $signatures->posName."-Name")
                {
                    if($signatures->signature == NULL)
                    {
                        foreach($approve as $approves)
                        {
                            if($approves->tran_id == $signatures->tran_id)
                            {
                                $string = explode("-",$variables);
                                $templateProcessor->setValue($string[0]."-Name","(SGD), ".$signatures->lastname.", ".$signatures->firstname);
                                $templateProcessor->setValue($string[0]."-Position",$signatures->groupName.", ".$signatures->posName);
                            }
                              
                        }
                    }
                    else
                    {
                        //Image Resize
                        $img = Image::make($signatures->signature);
                        $img->resize(100, 100);
                        $img->save($signatures->signature);
                        $templateProcessor->setImg($variables, ["src"=>$signatures->signature]);
                        $templateProcessor->setValue($variables."-Name",$signatures->lastname.", ".$signatures->firstname);
                        $templateProcessor->setValue($variables."-Position",$signatures->posName);
                    }
                    $string = explode("-",$variables);
                    $templateProcessor->setValue($string[0]."-Name",$signatures->lastname.", ".$signatures->firstname);
                    $templateProcessor->setValue($string[0]."-Position",$signatures->groupName.", ".$signatures->posName);  
                }
            }
        }

         $templateProcessor->saveAs('temp/'.$id.'.docx');



        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord = \PhpOffice\PhpWord\IOFactory::load('temp/'.$id.'.docx'); 
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'HTML');
        $htmlWriter->save('temp/'.$id.'.html');
        $getContent = file_get_contents('temp/'.$id.'.html');
        //Change name
        $replaceTitle = str_replace("PHPWord","DocTrack | Preview",$getContent);
        file_put_contents('temp/'.$id.'.html', $replaceTitle);

        //View using DOMPDF
        $dompdf= new Dompdf();
        $dompdf->set_option("chroot","temp/");
        $dompdf->load_html_file('temp/'.$id.'.html');
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("temp/".$id.".pdf", $output);

        //Working HTML TO PDF
        /*
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord = \PhpOffice\PhpWord\IOFactory::load('temp/'.$id.'.docx');
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
        $htmlWriter->save('temp/'.$id.'.pdf');
        */

        $docInfo = \DB::table('inbox')->where('doc_id','=',$id)->where('upg_id','=',$recid)->get();
        $docStatus = DB::table('transaction')->where('document_doc_id','=',$id)->where('upg_id','=',$recid)->get();
        //get receivedatetime
        foreach ($docStatus as $status) {
            $docInfoLog = DB::table('log')->where('tran_id','=',$status->tran_id)
                                        ->where('status','=','pending')
                                        ->orderBy('datetime','desc')
                                        ->first();
            
            $receivedatetime = $docInfoLog->datetime;
        }

        //get current doc status
         foreach ($docStatus as $status) {
            $docInfoLog = DB::table('log')->where('tran_id','=',$status->tran_id)
                                        ->orderBy('datetime','desc')
                                        ->first();
            
            $docStatus = $docInfoLog->status;
        }

        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/temp/'.$id.'.pdf'))      
            $pdf = "/temp/".$id.".pdf";   
        else
            $pdf = "/pdf/".$id.".pdf";

    $comments = \DB::table('comment as c')->where('c.comment_doc_id','=',$id)
                                     ->join('userpositiongroup as upg','c.comment_upg_id','=','upg.upg_id')
                                     ->join('user','upg.user_user_id','=','user.user_id') 
                                     ->get();

    $numunread = getNumberOfUnread($upgid);
    $docwf = sortTransaction($id);

    //view log
    $statuss=\DB::table("transaction")
     ->where('transaction.document_doc_id','=',$id)
    ->join('userpositiongroup','transaction.upg_id','=','userpositiongroup.upg_id')
    ->join('user','userpositiongroup.user_user_id','=','user.user_id')
    ->orderBy('transaction.order')
    ->get();

    $inboxstatus = DB::table('inbox')->where('doc_id','=',$id)
                   ->get();

    $statusarray = array();
    foreach ($statuss as $currentstatus) {
      //for approval status
      $tranApprovalStatus = DB::table('transaction as t')->where('t.tran_id','=',$currentstatus->tran_id)
                                                        ->join('log as l','t.tran_id','=','l.tran_id')
                                                        ->orderBy('l.datetime','desc')
                                                        ->first();
          if($tranApprovalStatus!=NULL)
       {
        $datetime = $tranApprovalStatus->datetime;
        if($tranApprovalStatus->status=="approved")
          $latestStatus = "approved";
        else if($tranApprovalStatus->status=="rejected")
          $latestStatus = "rejected";
        else if($tranApprovalStatus->status=="pending"){
          $latestStatus = "pending";
          $datetime = "";
        }
       } 
        else{
          $latestStatus="";
          $datetime="";
        }
          
          //for seen status
          $tranSeenStatus = DB::table('inbox as i')->where('i.doc_id','=',$id)
                                                  ->where('i.upg_id','=',$currentstatus->upg_id)
                                                  ->join('log as l','i.inbox_id','l.inbox_id')
                                                  ->orderBy('l.datetime','desc')
                                                  ->first();
            if($tranSeenStatus!=NULL)
            {
               if($tranSeenStatus->status=="unread")
               {
                  $latestSeen = "unread";
                  $seendatetime = "";
               }
              else if($tranSeenStatus->status=="read"){
                $latestSeen = "read";
                $seendatetime = $tranSeenStatus->datetime;
              }
            }
            else{
              $latestSeen = "";
              $seendatetime = "";
            }
                


            $statusarray[$currentstatus->order][] = array('lastname'=>$currentstatus->lastname,
                                    'firstname'=>$currentstatus->firstname,
                                    'approvestatus'=>$latestStatus,
                                    'seenstatus'=>$latestSeen,
                                    'datetime'=>$datetime,
                                    'seendatetime'=>$seendatetime);

    }

    // echo "<pre>";
    // var_dump($statusarray);

   //order status 
    $docInfo = \DB::table("document")->where("doc_id",'=',$id)->get();

     // if(file_exists($_SERVER['DOCUMENT_ROOT'].'/temp/'.$id.'.pdf'))      
     //    $pdf = "/temp/".$id.".pdf";   
     // else
     //    $pdf = "/pdf/".$id.".pdf";

    //get maximum order of  document in a transaction
    $last_order = DB::table('transaction')->where('document_doc_id','=',$id)->max('order');

    $numunread = getNumberOfUnread($upgid);
    $numinprogress = getNumberofInProgress($upgid);

    $docwf = sortTransaction($id);

    $comments = \DB::table('comment as c')->where('c.comment_doc_id','=',$id)
                                     ->join('userpositiongroup as upg','c.comment_upg_id','=','upg.upg_id')
                                     ->join('user','upg.user_user_id','=','user.user_id') 
                                     ->get();

    //view document logs

    $approveLogsArray = array();
    $readLogsArray = array();
    $readApproveArray = array();

    $approveLogs = DB::table('log as l')->join('transaction as t','l.tran_id','t.tran_id')
                                    ->where('t.document_doc_id','=',$id)
                                    ->join('userpositiongroup as upg','t.upg_id','upg.upg_id')
                                    ->join('user as u','upg.user_user_id','u.user_id')
                                    ->select('l.status','u.lastname','u.firstname','l.datetime','l.log_id')
                                    ->orderBy('l.datetime')
                                    ->get();
      foreach ($approveLogs as $approve) {
        $userInvolved = $approve->firstname." ".$approve->lastname;
        $approveLogsArray[] = array('log_id'=>$approve->log_id,'datetime'=>$approve->datetime,'status'=>$approve->status,'user'=>$userInvolved);
      }

    $readLogs = DB::table('log as l')->join('inbox as i','l.inbox_id','i.inbox_id')
                                    ->where('i.doc_id','=',$id)
                                    ->join('userpositiongroup as upg','i.upg_id','upg.upg_id')
                                    ->join('user as u','upg.user_user_id','u.user_id')
                                    ->select('l.status','u.lastname','u.firstname','l.datetime','l.log_id')
                                    ->orderBy('l.datetime')
                                    ->get();
      foreach ($readLogs as $read) {
        $userInvolved = $read->firstname." ".$read->lastname;
        $readLogsArray[] = array('log_id'=>$read->log_id,'datetime'=>$read->datetime,'status'=>$read->status,'user'=>$userInvolved); 
      }

      //sort merged array
      function cmp($a,$b)
      {
        $ad = strtotime($a['datetime']);
        $bd = strtotime($b['datetime']);
        return ($ad-$bd);
      }

      $readApproveArray = array_merge($readLogsArray,$approveLogsArray);

    usort($readApproveArray,function($item1, $item2){
      return $item2['log_id'] - $item1['log_id'];
    });
       return view("user/viewDocs",["pdf"=>$pdf, 'User'=>$user, 'status'=>$status, 'datetime'=>$datetime, 'docInfos'=>$docInfo,'receivedatetime'=>$receivedatetime,'docStatus'=>$docStatus,'upgid'=>$upgid,'id'=>$id,'docworkflows'=>$docworkflows, 'comments'=>$comments,'numUnread'=>$numunread,'docwf'=>$docwf,'logsArray'=>$readApproveArray]);
        
    }

     public function comment(Request $request,$upgid,$docid){
        $user = Auth::user();
        date_default_timezone_set('Asia/Manila');
        $date = date('M d, Y');
        $time = date('H:i:sa');
        $comment_id = rand(1,10000);
        $comment_text = $request['comment'];

        \DB::table('comment')->insert(["comment_id"=>$comment_id,
                                        "comment"=>$comment_text,
                                        "comment_doc_id"=>$docid,
                                        "comment_upg_id"=>$upgid,
                                        "comment_date"=>$date,
                                        "comment_time"=>$time
                                                  ]);

        return redirect()->route('docView',['upgid'=>$upgid,'id'=>$docid]);
    }
}
