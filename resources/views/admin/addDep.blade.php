{{-- @if(Auth::check()) --}}
@extends('mastertemplate')
@section('menu')
<li>
              <a href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li class="active">
              <a href="{{route('showDep',['upgid'=>$upgid,'id'=>$admingroup])}}" data-placement="right" title="Inbox">
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


@endsection

@section('main_content')

<div class="row justify-content-center">
<div class="content" style="margin-top: 20px;">
<div class="card" style="width: 800px;">
<div class="card-header" data-background-color="orange">
  <h4>Add New Department</h4>
</div>
<div class="card-content">
<form action="{{route('addDep',['upgid'=>$upgid,'depid'=>$depid])}}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
 <div class="form-group">
      <label>The newly added department will be under: </label>
      <input type="hidden" name="motherDep" value="{{$depid}}">
      <input readonly name="motherDepName" value="{{$motherDepName}}" class="form-control">
    </div>
<div class="form-group">
  <label>Department Name</label>
  <input type="text" name="depname" class="form-control" />
</div>
  <div class="form-group">
  <label>Description</label>
  <textarea class="form-control" name="depDesc"></textarea>
</div>
  <div class="form-group">
  <label>Department Key</label>

  <div class="form-inline">
    <div class="form-group">
      <input type="password" id="key" name="depKey" class="form-control">
    </div>
    <div class="form-group">
      <a id="show" href="javascript:showKey()"><i class="material-icons">visibility</i></a> 
      <a id="hide" href="javascript:hideKey()" style="display: none;"><i class="material-icons">visibility_off</i></a> 
  </div>
</div>


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
  <div class="row justify-content-end">
  <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
     <div class="input-group">
    <input type="submit" name="save" value="Add" class="btn btn-primary">
  </div>
  <div class="btn-group" role="group" aria-label="First group">
    <a href="{{route('showDep',['upgid'=>$upgid,'id'=>$admingroup])}}" class="btn btn-danger">Cancel</a>
  </div>
</div> 
</div>
</form>
</div>
</div>
</div>
</div>

@endsection
{{-- @endif --}}