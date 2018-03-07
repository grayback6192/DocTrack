@extends('mastertemplate')
@section('menu')
<li>
              <a href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li class="active">
              <a href="{{route('showDep',['upgid'=>$upgid,'id'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <i class="material-icons">business</i>
               <p>Departments</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewRolePage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">event_seat</i>
                <p>Positions</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewWorkflow',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">group</i>
               <p>Workflows</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewOwners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">description</i>
                <p>Templates</p>
              </a>
 </li>

 <li>
              <a href="#" data-placement="right" title="Inbox">
                <i class="material-icons">archive</i>
                <p>Archive</p>
              </a>
 </li>

@endsection

@section('main_content')

@foreach($dep as $info)
<div class="center-div" style="border: 0.5px solid black; margin-top: 20px;">
<form>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">Department Name</label>
	<div class="col-sm-10">
		<p class="form-control-static"> {{$info->groupName}}</p>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-4 col-form-label">Description</label>
	<div class="col-sm-10">
		<p class="form-control-static"> {{$info->groupDescription}}</p>
	</div>
</div>

<div class="form-group row">
  <label class="col-sm-4 col-form-label">Parent Department</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php $parent = \DB::table('group')->where('group_id','=',$info->group_group_id)->get();
                                      foreach ($parent as $key) {
                                         $parentName = $key->groupName;
                                       }
                                       echo $parentName.""; ?></p>
  </div>
</div>

<div class="form-group row">
	<label class="col-sm-4 col-form-label">Department Key</label>
	<div class="col-sm-10">
		<p class="form-control-static"> {{$info->businessKey}}</p>
	</div>
</div>

<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
	<div class="btn-group" role="group" aria-label="First group">
		<a href="{{route('viewDep',['status'=>'active'])}}" class="btn btn-primary">Back</a>
	</div>

	<div class="input-group">
		<a href="{{route('editDep',['id'=>$info->group_id])}}" class="btn btn-primary" style="margin-right: 10px;">Edit</a>
		<a href="{{route('deleteDep',['id'=>$info->group_id])}}" class="btn btn-primary">Delete</a>
	</div>
</div>
</form>
</div>
<hr>
<div class="row" style="margin-left: 60px; margin-top: 10px;">
  SUBGROUPS: <br>
  @if(isset($subgroups))
@foreach($subgroups as $subgroup)
 <div class="col-sm-6" style="margin-top: 15px;">
    <a href="{{route('showDep',['depid'=>$subgroup->group_id])}}"><div class="card" style="width: 15rem; border: none;">
       <i class="fa fa-5x fa-building"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">{{$subgroup->groupName}}</h3>
      </div>
    </div></a>
  </div>
@endforeach
@endif
</div>
@endforeach
@endsection