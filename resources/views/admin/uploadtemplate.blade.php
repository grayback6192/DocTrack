@extends('mastertemplate')
@section('menu')
<li>
              <a href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li>
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

 <li class="active">
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