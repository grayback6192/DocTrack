<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//for sending of doc from scratch
Route::get('/user/{upgid}/send/newdoc', function($upgid){
	$user = Auth::user();
	$clientid = \Session::get('client');
	$usergroup = DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)->get();
	foreach ($usergroup as $ug) {
		$group = $ug->client_id;
	}
	$workflow = DB::table('workflow')->where('client_id','=',$clientid)->where('status','=','active')->get();
	$groups = DB::table('group')->where('client_id','=',$clientid)->where('status','=','active')->get();
	$numinprogress = getNumberofInProgress($upgid);
	$numunread = getNumberOfUnread($upgid);

	return view('user/createDocs',['User'=>$user, 'workflow'=>$workflow, 'groups'=>$groups,'upgid'=>$upgid,"numUnread"=>$numunread,'numinprogress'=>$numinprogress]);
})->name('test');

Route::post("/test/{upgid}/create","DocumentController@sendScratchDoc");


Route::get('master',function(){
	return view('mastertemplate');
});
//End Login
Route::get("/","Auth\LoginController@showLoginForm")->name("Login");
Route::post("/login","Auth\LoginController@login")->name("Credentials");
Route::get("/register","Auth\RegisterController@showRegistrationForm")->name("RegisterClient");
Route::post('/register','Auth\RegisterController@register')->name('ClientRegister');
Route::get('/logout',"Auth\LoginController@logout")->name('Logout');
Route::get("/registeruser","Auth\RegisterUserController@showRegistrationForm")->name("RegisterUser");
Route::post("/registeruser","Auth\RegisterUserController@register")->name("UserRegister");
Route::get("/key","Auth\LoginController@getBusinessKey");
//User routes
Route::get('/home', function(){
	return view('user/userhome');
});
//Admin Routes
Route::get('/admin/{upgid}', function($upgid){
	$name = Auth::user();
	$userprof = $name->profilepic;
    return view('admin/admindash',["User"=>$name,'userprof'=>$userprof,"upgid"=>$upgid]);
})->name('AdminDash');
//User Management
Route::get('admin/{upgid}/usermanagement','User@index')->name('UserManage');
Route::get('admin/user/{status}', function($status){

 $clientid = \Session::get('client');
        if($status=='active' || $status=='inactive')
        {
            $users = \DB::table('user')->where('user.status','=',$status)
                    ->join('userpositiongroup as upg','user.user_id','=','upg.user_user_id')
                    ->where('client_id','=',$clientid)
                     ->select([DB::raw('DISTINCT(user.user_id)'),'user.lastname','user.firstname'])
                    ->orderBy('lastname','asc')
                    //->paginate(7); //change
                     ->get();
        }
        else if($status=='all')
        {
             $users = \DB::table('user')
                    ->join('userpositiongroup as upg','user.user_id','=','upg.user_user_id')
                    ->where('client_id','=',$clientid)
                     ->select([DB::raw('DISTINCT(user.user_id)'),'user.lastname','user.firstname'])
                    ->orderBy('lastname','asc')
                     //change
                     ->get();
        }

        return response()->json($users);

})->name('filterStatus');
Route::get('admin/{upgid}/usermanagement/userprofile/{id}','User@show')->name('UserProfile');
Route::post('admin/{upgid}/usermanagement/userprofile/{id}','User@update')->name('Update');
Route::get('admin/{upgid}/usermanagement/userprofile/{id}/edit', 'User@showForEdit')->name('EditProfile');
Route::get('admin/usermanagement/adduser', function(){
	return view('admin/addUser');
})->name('Reg');

Route::post('admin/usermanagement/delete','User@delete')->name('DeleteUser');

Route::post('admin/usermanagement/depID={depid}', function($depid){

	$results = DB::table('user')->where(['department_depId'=>$depid])->get();
	return Response::json($results);
});

Route::get('admin/user/group/{userid}','User@showUserGroups')->name('UserShowGroups');
Route::get('admin/user/account/{userid}','User@showUserAccount')->name('UserShowAccount');
//End User Management

//Department Management
Route::get('admin/{upgid}/department', 'Department@viewDep')->name('viewDep');

Route::get('admin/department/status/{status}', function($status){

$clientid = \Session::get('client');

	if($status=='inactive' || $status=='active')
		$list = DB::table('group')->where('client_id','=',$clientid)->where('status','=',$status)->get();
	else if($status=='all')
		$list = DB::table('group')->where('client_id','=',$clientid)->get();

	 return Response::json($list);
	//return Response::json($clientid);

})->name('PostTest');

Route::get('admin/{upgid}/department/depID={id}','Department@showDep')->name('showDep');
Route::post('admin/{upgid}/department/depID={id}', 'Department@editDep')->name('saveDep');
Route::get('admin/{upgid}/department/depID={id}/edit', 'Department@showDepInfo')->name('editDep');
Route::post('admin/{upgid}/department/{depid}/edit','Department@editDepartment')->name('editDepartment');
Route::get('admin/{upgid}/department/{depid}/add',function($upgid,$depid){
	$name = Auth::user();
	 $clients = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$name->user_id)
                        ->distinct()
                        ->get();
          foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
	
	$motherGroups = DB::table('group')->where('status','=','active')->where('client_id','=',$clientId)->get();
	$admingroup = getAdminGroup($upgid);
	//get motherDepartment name
	$motherDepartment = DB::table('group')->where('group_id','=',$depid)->get();
	foreach ($motherDepartment as $motherDep) {
		$motherDepName = $motherDep->groupName;
	}

	return view('admin/addDep',['motherGroups'=>$motherGroups,'User'=>$name,'upgid'=>$upgid,'admingroup'=>$admingroup,'depid'=>$depid,'motherDepName'=>$motherDepName]);
})->name('regDep');
Route::post('admin/{upgid}/department/{depid}/add', 'Department@addDep')->name('addDep');
Route::get('admin/{upgid}/department/{depid}/{currentdepid}','Department@deleteDep')->name('deleteDep');
Route::get('admin/depactive/{depid}','Department@setToActive');
Route::get('admin/depinactive/{depid}','Department@setToInactive');
//End Department Management
//roles
Route::get('admin/{upgid}/roles', 'Role@viewRoles')->name('viewRolePage');
Route::post('admin/{upgid}/addroles', 'Role@addNewRole')->name('addnewrole');
Route::post('admin/{upgid}/roles', 'Role@addRole')->name('AddRole');
Route::post('admin/{upgid}/existing/{depid}', 'Role@addExistingPosToDepartment')->name('addExistingPos');
Route::get('admin/{upgid}/deppos/{depid}/{posid}','Role@removeDeppos')->name('DelDeppos');
Route::get('admin/{upgid}/depposdel/{depid}/{posid}','Role@removeDepposOrg')->name('DelDepposOrg');
Route::post('admin/{upgid}/existingUndefine/{depid}', 'Role@addExistingPosToDepartmentUndefine')->name('addExistingPosUndefine');
Route::get('admin/{upgid}/roles/{id}/remove', 'Role@deletePosition')->name('DelPos');
Route::get('admin/{upgid}/roles/{id}', 'Role@deleteRole')->name('DelRole');
Route::post('admin/{upgid}/roles/edit={id}', 'Role@editRole')->name('UpdateRole');
Route::get('admin/{upgid}/assignment', function($upgid){
	$user = Auth::user();
	$admingroup = getAdminGroup($upgid);
	$clients = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$user->user_id)
                        ->distinct()
                        ->get();
      foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
    $groupid = \Session::get('groupid');
    $clientid = \Session::get('client');

    if($clientId==$admingroup)
    {
		$groups = DB::table('group')->where('client_id','=',$clientId)->where('status','=','active')->orderBy('groupName')->get();
		$allupgs = DB::table('userpositiongroup as upg')->where('upg.client_id','=',$clientId)
					->where('upg.upg_status','=','active')
					->join('group as dep','upg.client_id','dep.group_id')
					->join('deppos as dp','upg.position_pos_id','dp.deppos_id')
					->join('position as p','dp.pos_id','=','p.pos_id')
					->join('rights as r','upg.rights_rights_id','=','r.rights_id')
					->join('user as u','upg.user_user_id','=','u.user_id')
					->get();
	}
	else
	{
		$groups = DB::table('group')->where('group_id','=',$admingroup)->where('status','=','active')->orderBy('groupName')->get();
		$allupgs = DB::table('userpositiongroup as upg')->where('upg.group_group_id','=',$admingroup)
					->where('upg.upg_status','=','active')
					->join('group as dep','upg.client_id','dep.group_id')
					->join('deppos as dp','upg.position_pos_id','=','dp.deppos_id')
					->join('position as p','dp.pos_id','=','p.pos_id')
					->join('rights as r','upg.rights_rights_id','=','r.rights_id')
					->join('user as u','upg.user_user_id','=','u.user_id')
					->get();
	}

	$positions = DB::table('position')->where('status','=','active')->where('client_id','=',$clientid)->orderBy('posName')->get();	
	
	$roles = DB::table('rights')->get();
	$admingroup = getAdminGroup($upgid);

	return view('admin/assignment',['User'=>$user, 'groups'=>$groups, 'positions'=>$positions,'allupgs'=>$allupgs,'roles'=>$roles,'upgid'=>$upgid,'admingroup'=>$admingroup]);

})->name('viewAssignments');

Route::get('admin/group/user/find/{groupid}/{string}/','User@findUser')->name('findUser');
Route::get('admin/group/{groupid}', function($groupid){ //for assignment
	
	$users = DB::table('userpositiongroup as upg')->where('upg.group_group_id','=',$groupid)
			->join('user','upg.user_user_id','=','user.user_id')
			->select('user.lastname','user.firstname','user.user_id')
			->distinct()
			->get();

	$positions = DB::table('position as p')->join('deppos as dp','p.pos_id','dp.pos_id')
										->where('dp.pos_group_id','=',$groupid)
										->get();
	return Response::json(['users'=>$users,'positions'=>$positions]);
});
Route::post('admin/{upgid}/assignment/add', 'UserPositionGroup@addNewAssignment')->name('newAssign'); //add new admin
Route::post('admin/{upgid}/assignment/delete', 'UserPositionGroup@removeAdmin')->name('removeAdmin'); //remove admin
Route::post('admin/{upgid}/department/edit','UserPositionGroup@editAssignment')->name('editAssign'); //edit assignment
Route::get('admin/assignment/{upgid}/{depid}', function($upgid,$depid){

	$results = DB::table('group as g')->where('g.group_id','=',$depid)
				->join('userpositiongroup as upg','g.group_id','=','upg.group_group_id')
				//->where('upg.upg_status','=','active')
				->join('deppos as dp','upg.position_pos_id','dp.deppos_id')
				->join('position as p','dp.pos_id','=','p.pos_id')
				->join('rights as r','upg.rights_rights_id','=','r.rights_id')
				->join('user as u','upg.user_user_id','=','u.user_id')
				->get();
	return Response::json($results);
});
Route::post('admin/assignment/delete/{depid}','UserPositionGroup@removeAssignment')->name('removeUPG');
Route::post('admin/assignment/edit/{depid}','UserPositionGroup@editAssignmentUPG')->name('editUPG');
//end role
Route::post('admin/template', 'Template@addTemplate')->name('SubmitTemplate');
Route::get('admin/{upgid}/template1', 'Template@viewTemplateOwners')->name('viewOwners'); //testUI
Route::get('admin/{upgid}/template/{groupid}', 'Template@viewTemplates')->name('getGroupTemplates'); //new


Route::get('admin/{upgid}/addtemplate', function($upgid){
	$user = Auth::user();
	$clientid = \Session::get('client');
	$usergroup = DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)->get();
	foreach ($usergroup as $ug) {
		$group = $ug->client_id;
	}
	$workflow = DB::table('workflow')->where('client_id','=',$clientid)->where('status','=','active')->get();
	$groups = DB::table('group')->where('client_id','=',$clientid)->where('status','=','active')->get();
	return view('admin/addTemplate',['User'=>$user, 'workflow'=>$workflow, 'groups'=>$groups,'upgid'=>$upgid]);
})->name('AddTemplate');
Route::get('admin/template/workflow/{wid}',function($wid)
{
	$results = \DB::table('workflowsteps as ws')
				->where('ws.workflow_w_id','=',$wid)
				->join('position as p','ws.position_pos_id','=','p.pos_id')
				->orderBy('ws.order')
				->get();
	//sort results for display
	$sortResults = array();
	foreach ($results as $result) 
	{
		$sortResults[$result->order][] = $result;
	}
	//return response()->json($sortResults);
	return $sortResults;
	//return response()->json($results);
});
Route::post("admin/{upgid}/template/create","TemplateController@addTemplate")->name('CreateTemplate');
Route::get("admin/{upgid}/template/edit/{id}","TemplateController@editFile")->name('openTemplate');
Route::post("admin/{upgid}/template/delete/{id}","TemplateController@deleteTemplate")->name('removeTemplate');
Route::post("admin/templateInsert/{id}","DocumentController@insertFileVariables")->name("postDoc");
Route::post("admin/{upgid}/templateEdit/create/{tempid}","TemplateController@addEditedTemplate");
//end template management

//workflow management
Route::get('admin/{upgid}/workflow',function($upgid){
	$clientid = \Session::get('client');
	$user = Auth::user();
	$workflows = DB::table('workflow')->where('client_id','=',$clientid)->where('status','=','active')->get();
	$admingroup = getAdminGroup($upgid);

	return view('admin/workflow',['User'=>$user, 'workflows'=>$workflows,'upgid'=>$upgid,'admingroup'=>$admingroup]);
})->name('viewWorkflow');


Route::get('admin/{upgid}/workflow/add/{wfid}','WorkflowStepsController@openSteps')->name('AddWf');
Route::post('admin/{upgid}/workflow/addworkflow','WorkflowController@addWF')->name('postAddWf');
Route::get('admin/{upgid}/workflow/delete/{wfid}','WorkflowController@deleteWf')->name('DelWf');
Route::post('admin/{upgid}/workflow/edit/{wfid}','WorkflowController@editWf')->name('EditWf');
Route::get('admin/viewPath','WorkflowStepsController@getWorkflow');

//workflowstep mnmgt
Route::get('admin/posusers/{posid}','WorkflowStepsController@getPosUsers');
Route::post('admin/{upgid}/workflow/addnext','WorkflowStepsController@addNextStep')->name('addNextStep');
Route::post('admin/{upgid}/workflow/addprev','WorkflowStepsController@addPrevStep')->name('addPrevStep');
Route::post('admin/{upgid}/workflow/addsameorder','WorkflowStepsController@addSameOrderStep')->name('addSameOrderStep');
Route::post('admin/{upgid}/workflow/addstep','WorkflowStepsController@addFirstStep')->name('postAddStep');
Route::post('admin/{upgid}/workflow/editsteprec','WorkflowStepsController@editStepRecipients')->name('editStepRecs');
Route::post('admin/{upgid}/workflow/editstepaction','WorkflowStepsController@editStepAction')->name('editStepAction');
Route::post('admin/{upgid}/workflow/deletestep','WorkflowStepsController@removeStep')->name('RemoveWs');
//End Admin

//User
Route::get('/user/{upgid}/profile','User@showUserProfile')->name('viewUserProfile');
Route::get('/user/{upgid}/profile/edit','User@editUserProfile')->name('userprofedit');
Route::get('/groups/{userid}','User@chooseGroups')->name('chooseGroups');
Route::get('/groups/{userid}/choose/{depid}','Department@viewGroups')->name('addGroup');
Route::get('/{groupid}/{rightid}','User@goToGroup')->name('gotogroup');
Route::get('/viewTemplate','Template@viewTemplate')->name('viewTemplate');
Route::post('/entergroup','UserPositionGroup@enterGroup')->name('enterGroup');
Route::get('/createDoc',"user@readFile");
// Route::get('/user/{upgid}/send','Department@viewServiceOwners')->name('serviceowners');
Route::get('/user/{upgid}/send',function($upgid)//needed fixing
{
	$name = Auth::user();
	//$upgid = \Session::get('upg');
        $client = DB::table('userpositiongroup')->where('upg_id','=',$upgid)->get();
        foreach ($client as $value) {
            $clientid = $value->client_id;
        }

        //get student position id
        $studentpos = DB::table('position')->where('posName','=','Student')
        								->where('client_id','=',$clientid)
        								->get();
        foreach ($studentpos as $key) {
        	$studentposid = $key->pos_id;
        }


        //get if upgid is a student or employee
        $upgrole = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$upgid)
        												->join('deppos as dp','upg.position_pos_id','dp.deppos_id')
        												->get();
        // $upgrolestudent = DB::table('userpositiongroup as upg')->where('upg.upg_id','=',$upgid)
        // 												->join('deppos as dp','upg.position_pos_id','dp.pos_id')
        // 												->get();
        // 												$roleupgstud='';
        // foreach ($upgrolestudent as $rolestud) {
        // 	$roleupgstud = $rolestud->pos_id;
        // }								
        foreach ($upgrole as $role) {
        	$roleupg = $role->pos_id;
        }

        if($roleupg==$studentposid)
        {
        	echo "Student here";
        	$template = DB::table("template as t")->where('t.status','=','active')
									->where('t.client_id','=',$clientid)
									->whereIn('filterView',['Student','All'])
									->join('group as g','t.group_group_id','g.group_id')
									->get();
        }
        else if($roleupg!=$studentposid)
        {
        	
        	echo "Employee here";
        	$template = DB::table("template as t")->where('t.status','=','active')
									->where('t.client_id','=',$clientid)
									->whereIn('filterView',['Employee','All'])
									->join('group as g','t.group_group_id','g.group_id')
									->get();
        }
		

	$numunread = getNumberOfUnread($upgid);
	$numinprogress = getNumberofInProgress($upgid);

	return view("user/templatefillup",["template"=>$template,"User"=>$name,'upgid'=>$upgid,'numUnread'=>$numunread,'numinprogress'=>$numinprogress]);
	
})->name("Template");

Route::get('user/{upgid}/searchtemplate/{string}',"Template@searchTemplate");
Route::get('/user/{upgid}/send/templateInput/{docid}/',"DocumentController@readfile");

Route::get("createfile",function()
{
	return view("user/createFile");
})->name("CreateFile");

Route::get("/viewWorkflow","user@loadWorkflow");

Route::post("templateEdit/create","TemplateController@addEditedTemplate");

Route::post("/templateInsert/{id}","DocumentController@insertFileVariables")->name("postDoc");

Route::post("/templateView/{id}/{upgid}","DocumentController@viewFile")->name('viewfile');

Route::get("/templateEdit/{id}","TemplateController@editFile");

Route::get('/number','User@countAllApproved');

Route::get('user/{upgid}/notification/{id}','DocumentController@viewNotification')->name('viewNotification');

Route::get("user/{upgid}/inbox/documentView/{id}","DocumentController@viewdocs")->name('docView');

  Route::get("/user/{upgid}/inbox","user@viewInbox")->name('viewInbox');

Route::post("user/{upgid}/approve/{id}","user@approvedoc2")->name('approve');

Route::post("user/{upgid}/reject/{id}","user@rejectdoc")->name('reject');

Route::get('user/{upgid}/sent','user@sent')->name('viewSent');

Route::get('user/{upgid}/track/{id}','user@track')->name('tracking');

Route::get('user/{upgid}/complete','user@complete')->name('complete');
Route::get('user/{upgid}/complete/{id}','user@completeview');

//Route::get('test/{sentStatus}','InboxController@filterInbox')->name('filterInbox');

Route::get('/sent/{upgid}/{status}','InboxController@filterSent');

Route::get('/user/{upgid}/inbox/{status}','InboxController@filterInbox');

Route::post('/user/{upgid}/comment/{id}','DocumentController@comment')->name("comment");

//Org Chart

Route::get('/admin/{upgid}/vieworgchart/{groupid}','OrgChartController@getGroupOrgChart')->name('vieworgchart');
Route::get('/admin/{upgid}/vieworgchartdep/{groupid}','OrgChartController@getGroupOrgChartDep')->name('vieworgchartdep');

// Route::get('/admin/{upgid}/addOrgChart/{groupid}', function ($upgid,$groupid) {
// 	$user = Auth::user();
// 	$clientid = Session::get('client');
// 	$departments = \DB::table('group')->where('client_id','=',$clientid)->orWhere('group_id','=',$groupid)->where('status','=','active')->get();
// 	 $lists=\DB::table('userpositiongroup')
//         ->where('userpositiongroup.client_id','=',$clientid)
//         ->join('position','userpositiongroup.position_pos_id','=','position.pos_id')
//         ->join('user','userpositiongroup.user_user_id','=','user.user_id')
//         ->join('group','userpositiongroup.group_group_id','=','group.group_id')
//         ->get();
//         $orgchartid = rand(1, 10000);
// 	//$department = \DB::table('group')->get();
//     return view('admin/welcome',['groups'=>$departments,'User'=>$user,'groupid'=>$groupid,'upgid'=>$upgid,'lists'=>$lists,'orgchartid'=>$orgchartid]);
// })->name('AddOrgChart');

Route::get('/admin/{upgid}/addorg','OrgChart@store');

 Route::get("admin/readOrgChart/{groupid}","OrgChart@show");
 Route::get('admin/{upgid}/editOrgChart/{groupid}','OrgChart@edit')->name('editOrgChart');
 Route::get('/admin/{upgid}/updateOrgChart','OrgChart@update');
//Route::get('/admin/{upgid}/vieworgchart/{groupid}','OrgchartController@vieworg')->name('vieworgchart');
 //new
 Route::get('/admin/{upgid}/addOrgChart/{depid}','OrgChartController@addOrgChart')->name('addneworgchart');

//End User

 //temp routes
 Route::get('client',function(){
 	return view('registerclient2');
 });
 Route::get('user',function(){
 	return view('registeruser2');
 });
 Route::get('random','TestController@rand');

 Route::get('/user/{upgid}/gethierarchy/{depid}','Department@getAncestors');
 Route::get('/user/{upgid}/getchildren/{depid}','Department@getDescendants');
 Route::get('/user/{upgid}/getchildrenlevel/{depid}','Department@getDepartmentChildrenLevel');

