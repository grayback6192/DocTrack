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
Route::get('/admin', function(){
	$name = Auth::user();
    return view('admin/admindash',["User"=>$name]);
});
//User Management

Route::get('admin/usermanagement','User@index')->name('UserManage');

Route::get('admin/user/{status}', function($status){

 $clientid = \Session::get('client');
        if($status=='active' || $status=='inactive')
        {
            $users = \DB::table('user')->where('user.status','=',$status)
                    ->join('userpositiongroup as upg','user.user_id','=','upg.user_user_id')
                    ->where('client_id','=',$clientid)
                    ->get();
        }
        else if($status=='all')
        {
             $users = \DB::table('user')
                    ->join('userpositiongroup as upg','user.user_id','=','upg.user_user_id')
                    ->where('client_id','=',$clientid)
                    ->get();
        }

        return Response::json($users);

})->name('filterStatus');

Route::get('admin/usermanagement/userprofile/{id}','User@show')->name('UserProfile');

Route::post('admin/usermanagement/userprofile/{id}','User@update')->name('Update');

Route::get('admin/usermanagement/userprofile/{id}/edit', 'User@showForEdit')->name('EditProfile');


Route::get('admin/usermanagement/adduser', function(){
	return view('admin/addUser');
})->name('Reg');

Route::post('admin/usermanagement/adduser','User@add')->name('Add');

Route::get('admin/usermanagement/{id}','User@delete')->name('Delete');
Route::post('admin/usermanagement/depID={depid}', function($depid){

	$results = DB::table('user')->where(['department_depId'=>$depid])->get();
	return Response::json($results);
});
//End User Management

//Department Management
Route::get('admin/department', 'Department@viewDep')->name('viewDep');

Route::get('admin/department/status/{status}', function($status){

$clientid = \Session::get('client');

	if($status=='inactive' || $status=='active')
		$list = DB::table('group')->where('client_id','=',$clientid)->where(['status'=>$status])->get();
	else if($status=='all')
		$list = DB::table('group')->where('client_id','=',$clientid)->get();

	return Response::json($list);

})->name('PostTest');

Route::get('admin/department/depID={id}','Department@showDep')->name('showDep');
Route::post('admin/department/depID={id}', 'Department@editDep')->name('saveDep');
Route::get('admin/department/depID={id}/edit', 'Department@showDepInfo')->name('editDep');
Route::get('admin/department/add',function(){
	$name = Auth::user();
	 $clients = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$name->user_id)
                        ->distinct()
                        ->get();
          foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
	
	$motherGroups = DB::table('group')->where('status','=','active')->where('client_id','=',$clientId)->get();
	return view('admin/addDep',['motherGroups'=>$motherGroups,'User'=>$name]);
})->name('regDep');
Route::post('admin/department/add', 'Department@addDep')->name('addDep');
Route::get('admin/department/{id}','Department@deleteDep')->name('deleteDep');
//End Department Management

//roles
Route::get('admin/roles', 'Role@viewRoles')->name('viewRolePage');
Route::post('admin/roles', 'Role@addRole')->name('AddRole');
Route::get('admin/roles/{id}', 'Role@deleteRole')->name('DelRole');
Route::post('admin/roles/edit={id}', 'Role@editRole')->name('UpdateRole');

Route::get('admin/assignment', function(){
	$user = Auth::user();
	$clients = DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$user->user_id)
                        ->distinct()
                        ->get();
      foreach ($clients as $client) {
            $clientId = $client->client_id;
        }
    $groupid = \Session::get('groupid');
    $clientid = \Session::get('client');
	$groups = DB::table('group')->where('client_id','=',$clientId)->where('status','=','active')->orderBy('groupName')->get();
	$positions = DB::table('position')->where('status','=','active')->where('client_id','=',$clientid)->orderBy('posName')->get();
	$users = DB::table('userpositiongroup as upg')
				 ->where('upg.client_id','=',$clientId)
				//->where('upg.group_group_id','=',$groupid)
				->join('user as u','upg.user_user_id','=','u.user_id')
				->orderBy('lastname')
				->get();
	$roles = DB::table('rights')->get();
	return view('admin/assignment',['User'=>$user, 'groups'=>$groups, 'positions'=>$positions, 'users'=>$users, 'roles'=>$roles]);
})->name('viewAssignments');

Route::get('admin/group/user/find/{groupid}/{string}/','User@findUser')->name('findUser');

Route::get('admin/group/{groupid}', function($groupid){ //for assignment 
	$users = DB::table('userpositiongroup as upg')->where('upg.group_group_id','=',$groupid)
			->join('user','upg.user_user_id','=','user.user_id')
			->select('user.lastname','user.firstname','user.user_id')
			->distinct()
			//->groupBy('user.user_id')
			->get();
	return Response::json($users);
});
Route::post('admin/assignment/add', 'UserPositionGroup@addNewAssignment')->name('newAssign');

Route::get('admin/assignment/{depid}', function($depid){

	$results = DB::table('group as g')->where('g.group_id','=',$depid)
				->join('userpositiongroup as upg','g.group_id','=','upg.group_group_id')
				->join('position as p','upg.position_pos_id','=','p.pos_id')
				->join('rights as r','upg.rights_rights_id','=','r.rights_id')
				->join('user as u','upg.user_user_id','=','u.user_id')
				->get();
	return Response::json($results);
});

Route::get('admin/assignment/delete/{upgid}','UserPositionGroup@removeAssignment');
//end role

//template management
// Route::get('admin/template/add', function(){
// 	return view('admin/addTemplate');
// })->name('AddTemplate');

Route::post('admin/template', 'Template@addTemplate')->name('SubmitTemplate');

Route::get('admin/template',function()
{
	$user= Auth::user();
	$clientid = \Session::get('client');
	$template = DB::table("template as t")
				->where('t.client_id','=',$clientid)
				->where('t.status','=','active')
				->join('workflow as w','t.workflow_w_id','=','w.w_id')
				->get();
	return view("admin/templatepage",["template"=>$template, 'User'=>$user]);
})->name("AdminTemplate");

Route::get('admin/template/add', function(){
	$user = Auth::user();
	$clientid = \Session::get('client');
	$usergroup = DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)->get();
	foreach ($usergroup as $ug) {
		$group = $ug->client_id;
	}
	$workflow = DB::table('workflow')->where('client_id','=',$clientid)->where('status','=','active')->get();
	// $groups = DB::table('group')->where('group_group_id','=',$group)->where('client_id','=',$clientid)->where('status','=','active')->get();
	$groups = DB::table('group')->where('client_id','=',$clientid)->where('status','=','active')->get();
	return view('admin/createTemplate',['User'=>$user, 'workflow'=>$workflow, 'groups'=>$groups]);
})->name('AddTemplate2');

Route::get('admin/template/workflow/{wid}',function($wid){
	$results = \DB::table('workflowsteps as ws')->where('ws.workflow_w_id','=',$wid)
				->join('position as p','ws.position_pos_id','=','p.pos_id')
				->orderBy('ws.order')
				->get();

	return response()->json($results);
});

Route::post("admin/template/create","TemplateController@addTemplate")->name('CreateTemplate');

Route::get('admin/template/upload',function(){
	$user =Auth::user();
	$usergroup =DB::table('userpositiongroup')->where('user_user_id','=',$user->user_id)->get();
	foreach ($usergroup as $ug) {
		$group = $ug->client_id;
	}
	$workflow = DB::table('workflow')->where('client_id','=',$group)->get();
	$groups = DB::table('group')->where('group_group_id','=',$group)->get();
	return view('admin/uploadtemplate',['User'=>$user, 'workflow'=>$workflow, 'groups'=>$groups]);
})->name('UploadTemplate');

Route::post('admin/template/upload','TemplateController@uploadfile')->name('uploadTemplate');

Route::get("admin/template/edit={id}","TemplateController@editFile");

Route::get("admin/template/delete={id}","TemplateController@deleteTemplate");

Route::post("admin/templateInsert/{id}","DocumentController@insertFileVariables")->name("postDoc");

Route::post("admin/templateEdit/create/{tempid}","TemplateController@addEditedTemplate");
//end template management

//workflow management
Route::get('admin/workflow',function(){
	$clientid = \Session::get('client');
	$user = Auth::user();
	$workflows = DB::table('workflow')->where('client_id','=',$clientid)->where('status','=','active')->get();
	return view('admin/workflow',['User'=>$user, 'workflows'=>$workflows]);
})->name('viewWorkflow');

// Route::get('admin/workflow/add/{id}',function($wfid){
// 	$user = Auth::user();
// 	$workflow = DB::table('workflow')->where('w_id','=',$wfid)->get();
// 	$positions = DB::table('position')->where('status','=','active')->get();
// 	foreach ($workflow as $flow) {
// 		$wid = $flow->w_id;
// 	}
// 	$steps = DB::table('workflowsteps as ws')->where('ws.workflow_w_id','=',$wid)
// 				->join('position as p','ws.position_pos_id','=','p.pos_id')
// 				->get();

// 	return view("admin/addWf",['User'=>$user->firstname, 'positions'=>$positions, 'workflow'=>$workflow, 'steps'=>$steps]);
// })->name('AddWf');

Route::get('admin/workflow/add/{wfid}','WorkflowStepsController@openSteps')->name('AddWf');
Route::post('admin/workflow/addworkflow','WorkflowController@addWF')->name('postAddWf');
Route::get('admin/workflow/delete/{wfid}','WorkflowController@deleteWf')->name('DelWf');
Route::get('admin/workflow/edit/{wfid}','WorkflowController@setPrev')->name('EditWf');
Route::get('admin/viewPath','WorkflowStepsController@getWorkflow');

//workflowstep mnmgt
Route::post('admin/workflow/addstep','WorkflowStepsController@addStep')->name('postAddStep');
Route::post('admin/workflow/editstep/{wsid}','WorkflowStepsController@editStep')->name('UpdateWs');
Route::post('admin/workflow/deletestep/{wsid}','WorkflowStepsController@removeStep')->name('RemoveWs');
//End Admin

//User
Route::get('/groups/{userid}','User@chooseGroups')->name('chooseGroups');
Route::get('/groups/{userid}/choose','Department@viewGroups')->name('addGroup');
Route::get('/{groupid}','User@goToGroup')->name('gotogroup');
Route::get('/viewTemplate','Template@viewTemplate')->name('viewTemplate');
Route::post('/entergroup','UserPositionGroup@enterGroup')->name('enterGroup');
Route::get('/createDoc',"user@readFile");
Route::get('{groupid}/send','Department@viewServiceOwners')->name('serviceowners');
Route::get('/{gid}/template',function($gid)//needed fixing
{
	$name = Auth::user();
	$upgid = \Session::get('upg');
        $client = DB::table('userpositiongroup')->where('upg_id','=',$upgid)->get();
        foreach ($client as $value) {
            $clientid = $value->client_id;
        }
	$template = DB::table("template")->where('status','=','active')->where('group_group_id','=',$gid)->get();
	return view("user/templatefillup",["template"=>$template,"User"=>$name]);
})->name("Template");

Route::get('/templateInput/{docid}',"DocumentController@readfile");

Route::get('/groups/{userid}/{groupid}',function($userid,$groupid){
// Route::get('/groups/{$groupid}/home',function($userid,$groupid){
	$name = Auth::user();
	$role = \DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$name->user_id)->where('upg.group_group_id','=',$groupid)
                    ->join('rights as r','upg.rights_rights_id','=','r.rights_id')
                    ->select("r.rightsName","upg.position_pos_id","upg.group_group_id","upg.upg_id")
                    ->get();
        foreach ($role as $roles) {
           $title = $roles->rightsName;
           $group = $roles->group_group_id;
           $upgid = $roles->upg_id;
        }
        \Session::put('group',$group); //$_SESSION['group'] = $group;
        \Session::put('upg',$upgid);
	return view('user/userhome',['User'=>$name, 'Group'=>$group]);
})->name('userhome');

Route::get("createfile",function()
{
	return view("user/createFile");
})->name("CreateFile");

Route::get("/viewWorkflow","user@loadWorkflow");

Route::post("templateEdit/create","TemplateController@addEditedTemplate");

Route::post("/templateInsert/{id}","DocumentController@insertFileVariables")->name("postDoc");

Route::post("/templateView/{id}","DocumentController@viewFile");

Route::get("/templateEdit/{id}","TemplateController@editFile");

Route::get('/number','User@countAllApproved');

Route::get("/documentView/{id}","DocumentController@viewdocs")->name('docView');

Route::get("{groupid}/inbox","user@viewInbox")->name('viewInbox');

Route::post("/approve/{id}","user@approvedoc")->name('approve');

Route::post("/reject/{id}","user@rejectdoc")->name('reject');

Route::get('{groupid}/sent','user@sent')->name('viewSent');

Route::get('track/{id}','user@track')->name('tracking');

Route::get('{gourpid}/complete','user@complete')->name('complete');

//End User
