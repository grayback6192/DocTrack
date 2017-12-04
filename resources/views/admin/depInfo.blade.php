@extends('mastertemplate')
@section('menu')
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('UserManage')}}" data-placement="right" title="Inbox">
                <i class="fa fa-user fa-fw"></i>
                <span class="nav-link-text">
                  Users</span>
              </a>
 </li>

 <li class="nav-item  active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{'viewDep',['status'=>'active']}}" data-placement="right" title="Inbox">
                <i class="fa fa-building fa-fw"></i>
                <span class="nav-link-text">
                  Departments</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewRolePage')}}" data-placement="right" title="Inbox">
                <i class="fa fa-star fa-fw"></i>
                <span class="nav-link-text">
                  Positions</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewWorkflow')}}" data-placement="right" title="Inbox">
                <i class="fa fa-group fa-fw"></i>
                <span class="nav-link-text">
                  Workflows</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewOwners')}}" data-placement="right" title="Inbox">
                <i class="fa fa-file-o fa-fw"></i>
                <span class="nav-link-text">
                  Templates</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="#" data-placement="right" title="Inbox">
                <i class="fa fa-archive fa-fw"></i>
                <span class="nav-link-text">
                  Archive</span>
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