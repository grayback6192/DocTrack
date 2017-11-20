<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Session;



class TemplateController extends Controller
{
	public function deleteTemplate($tempid) //Deletes existing template, Get
    {
        DB::table('template')->where('template_id','=',$tempid)->update(["status"=>"inactive"]);
        return redirect()->route('AdminTemplate');
    }
    public function editFile($id) //Edit Template File, GET
    {
        $user = Auth::user();
        $request = \DB::table("template")->where("template_id","=",$id)->get();
        foreach ($request as $requests)
        $phpWord = \PhpOffice\PhpWord\IOFactory::load('templates/'.$requests->templatename.'.docx');
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'HTML');
        $htmlWriter->save('temp/'.$requests->templatename.'.html');
        $htmlLoader = file_get_contents('temp/'.$requests->templatename.'.html');
        $usergroup = DB::table('userpositiongroup')->get();
	    foreach ($usergroup as $ug)
	    {
	        $group = $ug->group_group_id;
	    }
	    $upgid = \Session::get('upg');
	    $client = DB::table('userpositiongroup')->where('upg_id','=',$upgid)->get();
        foreach ($client as $value) 
        {
            $clientid = $value->client_id;
        }
	    $workflow = DB::table('workflow')->where('client_id','=',Session::get('client'))->where('status','=','active')->get();
	    $docwf = DB::table('template')->where('template.template_id','=',$id)
							          ->join('workflow','template.workflow_w_id','=','workflow.w_id')
							          ->select('template.workflow_w_id','workflow.workflowName')
							          ->get();
	    foreach ($docwf as $key) 
	    {
	        $wid = $key->workflow_w_id;
	    }
	    $groups = DB::table('group')->get();
	    $docgroup = DB::table('template')->where('template.template_id','=',$id)
						                 ->join('group','template.group_group_id','=','group.group_id')
						                 ->select('template.group_group_id')
						                 ->get();
	    foreach ($docgroup as $key) 
	    {
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

    public function addEditedTemplate($tempid) //Template Creation, Post
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
    public function addTemplate(Request $request) //Adds template, Post
    {
        $name = Auth::user();
        $clients = getClientId($name->user_id);
        foreach ($clients as $client) 
        {
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
    public function uploadfile(Request $request)
    {
    	$name = Auth::user();
        $clients = getClientId($name->user_id);
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
}
