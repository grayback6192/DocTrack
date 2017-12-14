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
  <script src = "{{ URL::asset("js/tinymce/tinymce.min.js") }}"></script>
<script>
tinymce.init({
  selector: "#textarea",
  plugins:"table",
  menubar:"table",
  branding:false,
  height:350,
  width:750
});
</script>

<div class="container">
<div class="row" style="margin-left: 60px;">
@if(!isset($title))
<form method = "post" action = "create">
{{csrf_field()}}
<table>
<tr>
  <td>Title:</td><td><input type = "text" placeholder = "Title" name = "title"></td><br>
  </tr>
  <tr>
  <td>Subject:</td><td><input type = "text" placeholder = "Subject" name = "subject"></td>
  </tr>
</table>
  <textarea name = "text" id = "textarea"></textarea>
  <input type = "submit" value = "Send" name = "submit">
</form> 
@else
{{-- {{ $content }} --}}
<form method = "post">
{{csrf_field()}}
<div class="row justify-content-end mr-2">
 <label class="switch">
    <input type="checkbox" name="userstatus" checked>
    <span class="slider round"></span>
  </label>
</div>
<table>
<tr>
  <td>Title:</td><td><input type = "text" value = "{{ $title }}" placeholder = "Title" name = "title"></td>
  </tr>
  <tr>
    <td>Workflow:</td>
    <td><select name="wf">
    @foreach($workflow as $flow)
      @if($flow->w_id==$wid)
        <option value="{{$flow->w_id}}" selected="selected">{{$flow->workflowName}}</option>
      @else
        <option value="{{$flow->w_id}}">{{$flow->workflowName}}</option>
      @endif
    @endforeach
    </select>
  </td>

  </tr>
  <tr>
    <td>Service Owner:</td>
    <td><select name="group">
    @foreach($groups as $group)
      @if($group->group_id==$gid)
        <option value="{{$group->group_id}}" selected="selected">{{$group->groupName}}</option>
      @else
        <option value="{{$group->group_id}}">{{$group->groupName}}</option>
      @endif
    @endforeach
    </select>
  </td>

  </tr>
  
</table>
  <textarea name = "text" id = "textarea">{{ $content }}</textarea>
  <input class="btn btn-primary" type = "submit" formaction = "/admin/templateEdit/create/{{$tempid}}" value = "Save" name = "submit">&nbsp;&nbsp;&nbsp;
  @foreach($tempInfos as $tempInfo)
  <a class="btn btn-primary" href="{{route('getGroupTemplates',['groupid'=>$tempInfo->group_group_id])}}">Back</a>
  @endforeach
</form> 
</div>
@endif
</div>

@endsection