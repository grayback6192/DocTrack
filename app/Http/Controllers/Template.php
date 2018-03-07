<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Storage;

// include "....//vendor/autoload.php";

class Template extends Controller
{

    function viewTemplateOwners($upgid) //new
    {
        $name = Auth::user();
        $clients = getClientId($name->user_id);
        $deps = array();
        $admingroup = getAdminGroup($upgid);
    
        foreach ($clients as $client) {
            $clientId = $client->client_id;
        }

        if($clientId==$admingroup)
           $listDep = DB::table('group')->where('client_id','=',$clientId)->where(['status'=>'active'])->get();
         else
           $listDep = DB::table('group')->where('group_id','=',$admingroup)->where(['status'=>'active'])->get();

           foreach ($listDep as $list) {
               $serviceCount = \DB::table('template')->where('group_group_id','=',$list->group_id)->where('status','=','active')->get();

               if(count($serviceCount)>0)
               {
                    $deps[] = $list;
               }
           }
        
            $admingroup = getAdminGroup($upgid);

             return view('admin/templatepage1',['departments'=>$deps,'User'=>$name,'upgid'=>$upgid,'admingroup'=>$admingroup]);
    }

    function viewTemplates($upgid,$groupid) //new
    {
        $name = Auth::user();

        $templates = DB::table("template")->where('status','=','active')->where('group_group_id','=',$groupid)->get();
        $admingroup = getAdminGroup($upgid);

        return view("admin/grouptemplates",["templates"=>$templates,"User"=>$name,'upgid'=>$upgid,'admingroup'=>$admingroup]);
    }

      function viewAllTemplates($upgid) //new
    {
        $name = Auth::user();
        $userclient = getClient($upgid);

        $templates = DB::table("template")->where('status','=','active')->where('client_id','=',$userclient)->get();
        $admingroup = getAdminGroup($upgid);

        return view("admin/grouptemplates",["templates"=>$templates,"User"=>$name,'upgid'=>$upgid]);
    }

    function viewTemplate()
    {
    	

$phpWord = new \PhpOffice\PhpWord\PhpWord();
$section= $phpWord->addsection();
$section->Addtext("dexter gwapo");

$dompdf = new Dompdf();
$dompdf->set_option('defaultFont', 'Courier');
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
$objWriter->save('sample.html');

// reference the Dompdf namespace

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$html = file_get_contents("sample.html");
$dompdf->loadHtml($html);
//ari ko mu butang sa docx to html.

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
// $dompdf->stream();
$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
exit(0);
    }

     function addTemplate(Request $request)
    {
    	$path = Storage::putFile('templates',$request->file('template'));

    	return $path;
    }

    function searchTemplate($upgid,$string)
    {
      $result="";
      $templates = DB::table('template')->where('templatename','LIKE','%'.$string.'%')->get();

      if($string=="")
      {
         $userclient = getClient($upgid);

        $templates = DB::table("template")->where('status','=','active')->where('client_id','=',$userclient)->get();
      }
    
      return response()->json($templates);
    }

}
