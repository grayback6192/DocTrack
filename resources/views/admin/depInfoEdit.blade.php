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

@foreach($depInfos as $info)
<div class="center-div" style="margin-top: 20px;">
<form action="{{route('saveDep',['depid'=>$info->group_id])}}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group row">
	<label class="col-sm-4 col-form-label">Department Name</label>
    <input type="text" name="depname" value="{{$info->groupName}}" class="form-control">
</div>

<div class="form-group row">
	<label class="col-sm-4 col-form-label">Description</label>
	{{-- <input type="text" name="depname" value="{{$info->groupName}}" class="form-control"> --}}
  <textarea class="form-control" name="depDesc"><?php echo $info->groupDescription; ?></textarea>
</div>
<hr>
  <fieldset>
    <input type="checkbox" name="sub" id="sub" onclick="showSub()"> Please check if it's a Sub-Department
    {{-- (please leave it blank if not sub-department)<br> --}}
    <div id="fillsub" style="display: none;">
    Parent Department: <select class="form-control" name="mothergroup">
    <option value=""></option>
    @foreach($motherGroups as $motherGroup)
    <option value="{{$motherGroup->group_id}}">{{$motherGroup->groupName}}</option>
    @endforeach 
    </select> 
    </div> 
  </fieldset>
  <hr>

<div class="form-group row">
	<label class="col-sm-4 col-form-label">Department Key</label><a id="show" class="col-sm-4 col-form-label" href="javascript:showKey()">Show</a> 
  <a id="hide" class="col-sm-4 col-form-label" href="javascript:hideKey()" style="display: none;">Hide</a> 
	<input type="password" name="depKey" id="key" class="form-control" placeholder="Password" value="{{$info->businessKey}}">


<script type="text/javascript">
function showKey()
{
  var showbtn = document.getElementById('show');
  var hidebtn = document.getElementById('hide');
  var pass = document.getElementById('key');

  showbtn.style.display = "none";
  hidebtn.style.display = "block";
  pass.type="text";

}  

function hideKey()
{
  var showbtn = document.getElementById('show');
  var hidebtn = document.getElementById('hide');
  var pass = document.getElementById('key');

  showbtn.style.display = "block";
  hidebtn.style.display = "none";
  pass.type="password";
}

function showSub()
{
  var subdepfill = document.getElementById('fillsub');
  if(document.getElementById('sub').checked == true)
  {
    subdepfill.style.display = "block";
  }
  else if(document.getElementById('sub').checked == false)
  {
    subdepfill.style.display = "none";
  }
}
</script>

</div>

<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
	<div class="btn-group" role="group" aria-label="First group">
		<a href="{{route('showDep',['id'=>$info->group_id])}}" class="btn btn-primary">Cancel</a>
	</div>

	<div class="input-group">
		<input type="submit" name="edit" value="Save" class="btn btn-primary">
	</div>
</div>
</form>
</div>
@endforeach
@endsection