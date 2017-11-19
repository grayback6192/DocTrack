<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Session;


class User extends Controller
{
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
   
    public function approvedoc($docid){
        date_default_timezone_set('Asia/Manila');
        $user = Auth::user();
        $date = date('m-d-Y');
        $time = date('h:i:sa');
        //get transactions of the document
        $trans = \DB::table("transaction")->where('document_doc_id','=',$docid)->get();
        foreach ($trans as $tran) {
                    $upgid = \DB::table('userpositiongroup as upg')
                    ->where('upg.user_user_id','=',$user->user_id)
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
       $signing= DB::table('userpositiongroup')->where('userpositiongroup.upg_id','=',$poss)
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
                $templateProcessor->setValue($name, "".$sign." ".Auth::user()->lastname.", ".Auth::user()->firstname);
           }
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
     public function getClientId($userid)
    {
        $clientgroup = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$userid)
                                                            ->distinct()
                                                            ->get();
        return $clientgroup;
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

    public function addFile(Request $request)
    {
         $name = Auth::user();
         $clients = $this->getClientId($name->user_id);
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
