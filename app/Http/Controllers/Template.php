<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Storage;

// include "....//vendor/autoload.php";

class Template extends Controller
{
    //
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

}
