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
   public function readFile($upgid,$gid,$tempid)
    {
        $name = Auth::user();
        $group = \Session::get('groupid');
        $request = \DB::table("template")->where("template_id","=",$tempid)->get();
        foreach ($request as $requests)
            $template = new \PhpOffice\PhpWord\TemplateProcessor('templates/'.$requests->templatename.'.docx');
        $variable = $template->getVariables();
        $var = getWorkflow2($upgid,$group,$tempid);
        $position = \DB::table('template as t')->where('t.template_id','=',$tempid)
                                                    ->join('workflow as w','t.workflow_w_id','w.w_id')
                                                    ->join('workflowsteps as ws','w.w_id','ws.workflow_w_id')
                                                    ->join('position as p','ws.position_pos_id','p.pos_id')
                                                    ->get();
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
                }
            }
        } 

        return view("user/templatefillup",["variable"=>$variable,
                                           "var"=>$var,
                                           "id"=>$request->first(),
                                           "User"=>$name,
                                           "upgid"=>$upgid,
                                           "gid"=>$gid,
                                           "position"=>$signatureArray]);

    }

	public function viewFile($id) //Views file in PDF with corresponding values inserted, POST
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
    public function insertFileVariables($id) //Inserts Document Variables, POST, sends document to first receiver and enters all doc transactions
    {
        $user = Auth::user();
        $group = \Session::get('groupid');
        $upgs = DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)
                ->whereNotNull('group_group_id')
                ->get();   
        date_default_timezone_set('Asia/Manila');
        $date = date('M d, Y');
        $time = date('H:i:sa');

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
         $var = getWorkflow2($upgId,$groupid,$id); //Problem
        return insertTransaction($rand,$var,$upgId);
    }

     public function viewdocs(Request $request,$upgid,$id){    

        $user = Auth::user();
        $authSignature = $user->signature;
        $userid = $user->user_id;
        $upg_user = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$upgid)
                                                        ->where('upg.user_user_id','=',$userid)
                                                        ->get();

        //update seen info of document
        date_default_timezone_set('Asia/Manila');
        $readdate = date('M d, Y');
        $readtime = date('h:i:sa');

        $inboxInfos = DB::table('inbox')->where('upg_id','=',$upgid)->where('doc_id','=',$id)->get();
        foreach ($inboxInfos as $inboxinfo) {
            $ireadtime = $inboxinfo->readtime;
            $ireaddate = $inboxinfo->readdate;
        }

        if($ireadtime==NULL && $ireaddate==NULL)
        {
            DB::table('inbox')->where('doc_id','=',$id)
                            ->where('upg_id','=',$upgid)
                            ->update(['readtime'=>$readtime,
                                        'readdate'=>$readdate]); 
        }
       

        // $signature = DB::table('transaction as t')
        //                                      ->where('t.document_doc_id','=',$id)
        //                                      ->where("t.status","=","approved")
        //                                      ->join("userpositiongroup as upg",'t.upg_id',"=",'upg.upg_id')
        //                                      ->join('position as p','upg.position_pos_id',"=",'p.pos_id')
        //                                      ->join("user as u","upg.user_user_id","=","u.user_id")
        //                                      ->get(); //Added
        // $position = DB::table("position")->get();

        // $upg= session()->get('upgid');


        // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('file/'.$id.'.docx');
        // $variable = $templateProcessor->getVariables();

        // foreach($signature as $signatures)
        // {
        //     foreach($variable as $variables)
        //     {
        //         if($variables == $signatures->posName)
        //         {
        //             $templateProcessor->setImg($variables, [
        //                                                  "src"=>"signature/".$signatures->signature,
        //                                                 //"src"=>"{{url('./signature/'.$signatures->signature)}}",
        //                                                   "swh"=>"150"
        //                                                  ]);
        //         }
        //     }
        // }
        // $templateProcessor->saveAs('temp/'.$id.'.docx');

        foreach ($upg_user as $key){
            $recid = $key->upg_id;
        }

        $templateRequest = request()->all();
        $request = \DB::table("document")->where("doc_id","=",$id)->get();
        foreach($request as $requests)
        $name = $requests->docname;
        // Save file as HTML
        // $phpWord = new \PhpOffice\PhpWord\PhpWord();
        // $phpWord = \PhpOffice\PhpWord\IOFactory::load('file/'.$id.'.docx'); 
        // $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'HTML');
        // $htmlWriter->save('temp/'.$id.'.html');

        //View using DOMPDF
        // $dompdf = new Dompdf();
        // $dompdf->set_option("chroot","temp/");
        // $dompdf->load_html_file('temp/'.$id.'.html');
        // $dompdf->render();
        // $output = $dompdf->output();
        // file_put_contents("temp/".$id.".pdf", $output);

        // see if document has been approved
        $approved = DB::table('transaction')->where('upg_id','=',$upgid)->where('document_doc_id','=',$id)
                    ->get();
        foreach ($approved as $key) {
            $status = $key->status;
            $date = $key->date;
            $time = $key->time;
        }

        \DB::table('inbox')->where('doc_id','=',$id)->where('upg_id','=',$recid)->update(['istatus'=>'read']);
        $docInfo = \DB::table('inbox')->where('doc_id','=',$id)->where('upg_id','=',$recid)->get();

        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/temp/'.$id.'.pdf'))      
        $pdf = "/temp/".$id.".pdf";   
     else
        $pdf = "/pdf/".$id.".pdf";

       return view("user/viewDocs",["pdf"=>$pdf, 'User'=>$user, 'status'=>$status, 'time'=>$time, 'date'=>$date, 'docInfos'=>$docInfo,'upgid'=>$upgid,'id'=>$id]);
        //return $id;
        
    }
}
