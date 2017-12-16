@extends('mastertemplate')
@section('menu')
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('UserManage')}}" data-placement="right" title="Inbox">
                <i class="fa fa-user fa-fw"></i>
                <span class="nav-link-text">
                  Users</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewDep',['status'=>'active'])}}" data-placement="right" title="Inbox">
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

 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
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

<div class="row" style="margin-left: 60px;">

<script src = "{{ URL::asset("js/tinymce/tinymce.min.js") }}"></script>
<script>
tinymce.init({
  selector: "#textarea",
  branding:false,
  height:350,
  width:750
});
</script>

@if(!isset($title))
<form method = "post" action = "{{route('uploadTemplate')}}" enctype="multipart/form-data">
{{csrf_field()}}
<table>
<tr>
  <td>Title:</td><td><input type = "text" placeholder = "Title" name = "title"> <input class="btn btn-primary" type = "submit" value = "Save" name = "submit">&nbsp;&nbsp;<a class="btn btn-primary" href="{{route('AdminTemplate')}}">Back</a></td><br>
  </tr>
  <tr>
    <td>Workflow:</td>
    <td><select name="wf">
    @foreach($workflow as $flow)
      <option value="{{$flow->w_id}}">{{$flow->workflowName}}</option>
    @endforeach
    </select>
  </td>

  </tr>
  <tr>
    <td>Group:</td>
    <td><select name="group">
    @foreach($groups as $group)
      <option value="{{$group->group_id}}">{{$group->groupName}}</option>
    @endforeach
    </select>
  </td>

  </tr>
</table>
  
<br>
<br>
  <input type="file" name="UploadFile">
  
</form> 
@else
{{ $content }}
<form method = "post" enctype="multipart/form-data">
{{csrf_field()}}
<table>
<tr>
  <td>Title:</td><td><input type = "text" value = "{{ $title }}" placeholder = "Title" name = "title"></td>
  </tr>
  <tr>
  <td>Subject:</td><td><input type = "text" placeholder = "Subject" name = "subject"></td>
  </tr>
</table>
  <input type="file" name="uploadFile">
  <br>
  <br>
  <input type = "submit" formaction = "/templateEdit/create" value = "Send" name = "submit">
</form> 
</div>
@endif


@endsection