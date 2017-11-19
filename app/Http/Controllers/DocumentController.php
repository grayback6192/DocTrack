<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Session;
use App\Http\Controllers\User;

class DocumentController extends Controller
{
   public function readFile($tempid)
    {
        $name = Auth::user();
        $group = \Session::get('groupid');
        $request = \DB::table("template")->where("template_id","=",$tempid)->get();
        foreach ($request as $requests)
        $template = new \PhpOffice\PhpWord\TemplateProcessor('templates/'.$requests->templatename.'.docx');
        $variable = $template->getVariables();
        $var = getWorkflow($group,$tempid);
        return view("user/templatefillup",["variable"=>$variable,
                                            "var"=>$var,
                                           "id"=>$request->first(),
                                           "User"=>$name]);
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
    public function insertFileVariables($id) //Inserts Document Variables, POST
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
        $var = getWorkflow($groupid,$id); //Problem
        return insertTransaction($rand,$var);
    }

     public function viewdocs(Request $request,$id){
        $upgid = $request->session()->get('upgid');
        $user = Auth::user();
        $userid = $user->user_id;
        $upg_user = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$upgid)->where('upg.user_user_id','=',$userid)->get();
        foreach ($upg_user as $key){
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
}