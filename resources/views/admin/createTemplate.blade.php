@extends('mastertemplate')
@section('menu')
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="fa fa-user fa-fw"></i>
                <span class="nav-link-text">
                  Users</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('showDep',['upgid'=>$upgid,'id'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <i class="fa fa-building fa-fw"></i>
                <span class="nav-link-text">
                  Departments</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewRolePage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="fa fa-star fa-fw"></i>
                <span class="nav-link-text">
                  Positions</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewWorkflow',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="fa fa-group fa-fw"></i>
                <span class="nav-link-text">
                  Workflows</span>
              </a>
 </li>

 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewOwners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
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

    <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        $('#workflow').change(function(){
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
              html+=data[x].posName+"<br>";
           }
           $('#pos').empty();
           $('#pos').append(html);
          }
        });
      });

      });
    </script>

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

<div style="float:right;margin-left:800px;border: 1px solid black;" id="pos">
    Positions:
</div>
<form method = "post" action = "{{route('CreateTemplate')}}">
{{csrf_field()}}
<table>
<tr>
  <td>Title:</td><td><input type = "text" placeholder = "Title" name = "title"> <input class="btn btn-primary" type = "submit" value = "Save" name = "submit">&nbsp;&nbsp;<a class="btn btn-primary" href="{{route('AdminTemplate')}}">Back</a></td><br>
  </tr>

  <tr>
    <td>Workflow:</td>
    <td><select name="wf" id="workflow">
      <option value="none">--Select Workflow--</option>
    @foreach($workflow as $flow)
      <option value="{{$flow->w_id}}">{{$flow->workflowName}}</option>
    @endforeach
    </select>
  </td>

  </tr>
  <tr>
    <td>Service Owner:</td>
    <td><select name="group">
      <option value="none">--Select Service Owner--</option>
    @foreach($groups as $group)
      <option value="{{$group->group_id}}">{{$group->groupName}}</option>
    @endforeach
    </select>
  </td>

  </tr>
</table><br><br>  
  <textarea name = "text" id = "textarea"></textarea><br>
 
</form> 
@else
{{ $content }}
<form method = "post">
{{csrf_field()}}
<table>
<tr>
  <td>Title:</td><td><input type = "text" value = "{{ $title }}" placeholder = "Title" name = "title"></td>
  </tr>
  <tr>
  <td>Subject:</td><td><input type = "text" placeholder = "Subject" name = "subject"></td>
  </tr>
</table>
  <textarea name = "text" id = "textarea">{{ $content }}</textarea>
  <input type = "submit" formaction = "/templateEdit/create" value = "Send" name = "submit">
</form> 

</div>
@endif
 
@endsection