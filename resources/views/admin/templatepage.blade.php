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
<br><br><br>
 @if(isset($template))
<table class="table">
<tr>
<th>Template Name</th>
<th>Workflow</th>
<th style = "text-align:center" colspan = "2">Action</th>
@foreach($template as $templates)
<tr>
<td>{{ $templates->templatename }}</td>
<td>{{$templates->workflowName}}</td>
<td style = "text-align:center"><a href = "/admin/template/edit={{ $templates->template_id }}">Edit</a></td>
<td style = "text-align:center"><a href = "/admin/template/delete={{ $templates->template_id }}">Remove</a></td>
</tr>
@endforeach
<form method = "get" action = "{{route('AddTemplate2')}}">
<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
<input class="btn btn-primary" type = "submit" value = "Create Template" name = "submit">&nbsp;&nbsp;&nbsp;
{{-- <a class="btn btn-primary" href="{{route('uploadTemplate')}}">Upload Template</a> --}}
</div>
</form> 
@endif

{{-- Input Type --}}
@if(isset($variable))
<form method = "post">
<object data="../pdf/{{ $id->templatename }}.pdf" type="application/pdf" width="500" height="350" style = "float:right"></object><br>
{{ csrf_field() }}
@foreach($variable as $variables)
<input type = "text" name = "{{ $variables }}" placeholder = "{{ $variables }}"><br>
@endforeach
<!-- UI na langg ug further testing XD -->
@for($i=0;$i<(count($var));$i++)
@for($j=0;$j<(count($i));$j++)
{{$var[$i][$j]['ws_id']}}
@endfor
@endfor
<br><br>
<input type = "submit" formaction = "{{route('postDoc',['id'=>$id->template_id])}}" value = "Send">
<input type = "submit" formaction = '/templateView/{{ $id->template_id }}' value = "View">

</form>
@endif
</form> 
</div> 
@endsection