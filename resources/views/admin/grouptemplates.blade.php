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

 {{-- <li>
              <a href="#" data-placement="right" title="Inbox">
                <i class="material-icons">archive</i>
                <p>Archive</p>
              </a>
 </li> --}}
@endsection

@section('main_content')
<div class="content">
    <div class="row justify-content-start">
      <a class="btn btn-primary" href="{{route('viewOwners',['upgid'=>$upgid])}}">Back</a>
    </div>
  <div class="row">
    @if(isset($templates))
      @foreach($templates as $template)
        <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <a href="{{route('openTemplate',['upgid'=>$upgid,'id'=>$template->template_id])}}">
          
            <div class="card-header" data-background-color="orange">
              <i class="material-icons">insert_drive_file</i>
          </div>

           <div class="card-content"> 
            <h3 class="card-title">{{$template->templatename}}</h3>
            </div>

      </a>
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