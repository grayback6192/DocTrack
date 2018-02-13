@extends('mastertemplate')
@section('menu')
<li>
              <a href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li>
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
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
      $(document).ready(function(){

        $('#workflow-edit').change(function(){
        var value = $(this).val();
        console.log(value);
        $.ajax({
          type : 'GET',
          url: 'http://localhost:8000/admin/template/workflow/'+value,
          data: value,
          success: function(data){

           console.log(data);
           var html = "Positions: <br>";
           for(var x=0;x<data.length;x++){
              html+=data[x].posName+"("+data[x].action+")<br>";
           }
           $('#posedit').empty();
           $('#posedit').append(html);
          }
        });
      });

      });
    </script>    
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

<div>
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
<div class="media">
<div class="media-left">
<form method = "post">
{{csrf_field()}}
{{-- <div class="row justify-content-end mr-2">
 <label class="switch">
    <input type="checkbox" name="userstatus" checked>
    <span class="slider round"></span>
  </label>
</div> --}}
<div class="form-group">
  Title:<input type = "text" value = "{{ $title }}" placeholder = "Title" name = "title" class="form-control">
</div>

<div class="form-group">
Workflow:
    <select name="wf" class="form-control" id="workflow-edit">
    @foreach($workflow as $flow)
      @if($flow->w_id==$wid)
        <option value="{{$flow->w_id}}" selected="selected">{{$flow->workflowName}}</option>
      @else
        <option value="{{$flow->w_id}}">{{$flow->workflowName}}</option>
      @endif
    @endforeach
    </select>
</div>

<div class="form-group"> 
    Service Owner:
    <select name="group" class="form-control">
    @foreach($groups as $group)
      @if($group->group_id==$gid)
        <option value="{{$group->group_id}}" selected="selected">{{$group->groupName}}</option>
      @else
        <option value="{{$group->group_id}}">{{$group->groupName}}</option>
      @endif
    @endforeach
    </select>
 </div> 

  <textarea name = "text" id = "textarea">{{ $content }}</textarea>
  <div class="col-md-5 col-md-offset-10">
  <div class="btn-toolbar">
  {{-- <div class="btn-group"> --}}
  <input class="btn btn-primary" type = "submit" formaction = "/admin/{{$upgid}}/templateEdit/create/{{$tempid}}" value = "Save" name = "submit">
  {{-- </div> --}}
  {{-- <div class="btn-group"> --}}
  @foreach($tempInfos as $tempInfo)
  <a class="btn btn-danger" href="{{route('getGroupTemplates',['upgid'=>$upgid,'groupid'=>$tempInfo->group_group_id])}}">Cancel</a>
  @endforeach
 {{--  </div> --}}
  </div>
  </div>
</form> 
</div>
<div class="media-right">
  <div style="padding-left: 150px;">
      <button class="btn btn-danger" onclick="openRemoveTemplateModal({{$tempid}})"><i class="material-icons">delete</i></button>

      <div class="modal" id="deltemplate-{{$tempid}}">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4>Remove Template?</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="{{route('removeTemplate',['upgid'=>$upgid,'id'=>$tempid])}}">
                {{csrf_field()}}
              <input type="hidden" name="tempid" value="{{$tempid}}">
              <input type="hidden" name="tempupgid" value="{{$upgid}}">
              <div class="btn-toolbar">
                <div class="btn-group">
                  <button type="submit" class="btn btn-primary">YES</a>
                </div>
                <div class="btn-group">
                  <button class="btn btn-danger" onclick="closeRemoveTemplateModal({{$tempid}})">NO</button>
                </div>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div id="posedit">
    Workflow Positions:<br><br>
      @foreach($workflowpositions as $workflowposition)
        {{$workflowposition->posName}}<br>
      @endforeach
</div>
</div>
</div>
</div>
@endif
</div>

<script type="text/javascript">
  function openRemoveTemplateModal(tempid)
  {
    var modal = document.getElementById('deltemplate-'+tempid);
    modal.style.display = "block";
  }

   function closeRemoveTemplateModal(tempid)
  {
    var modal = document.getElementById('deltemplate-'+tempid);
    modal.style.display = "none";
  }
</script>

@endsection