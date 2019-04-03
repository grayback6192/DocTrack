@extends('mastertemplate')



@section('menu')
 <li class="nav-item">
              <a class="nav-link" href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="{{route('showDep',['upgid'=>$upgid,'id'=>$admingroup])}}" data-placement="right" title="Inbox">
                <i class="material-icons">business</i>
               <p>Departments</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="{{route('viewRolePage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">event_seat</i>
                <p>Positions</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="{{route('viewWorkflow',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">group</i>
               <p>Workflows</p>
              </a>
 </li>

 <li class="nav-item active">
              <a class="nav-link" href="{{route('viewOwners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">description</i>
                <p>Templates</p>
              </a>
 </li>

@endsection

@section('main_content')
<div class="content">
    <div class="row justify-content-start">
      <a class="btn btn-primary" href="{{route('viewOwners',['upgid'=>$upgid])}}">Back</a>
    </div>
  <div class="row">
    @if(isset($templates))
      @foreach($templates as $template)
 <div class="col-md-4">
      <div class="card card-profile">
        <div class="card-body">
          <i class="material-icons" style="font-size: 50px;">insert_drive_file</i>
           <h6 class="card-category">Template</h6>
            <h4 class="card-title">{{$template->templatename}}</h4>
            <a href="{{route('openTemplate',['upgid'=>$upgid,'id'=>$template->template_id])}}" class="btn btn-primary btn-round">Open</a>
        </div> 
    </div>
  </div>
      @endforeach
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
  </div>
</div>
@endsection