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
<div class="container">
    <div class="row justify-content-start ml-2">
      <a class="btn btn-primary" href="{{route('viewOwners',['upgid'=>$upgid])}}">Back</a>
    </div>
  <div class="row" style="margin-left: 60px; margin-top: 20px;">
    @if(isset($templates))
      @foreach($templates as $template)
        <div class="col-sm-4" style="margin-top: 15px;">
            <a href="{{route('openTemplate',['upgid'=>$upgid,'id'=>$template->template_id])}}"><div class="card" style="border: none;">
          <div style="text-align: center">
            <i class="material-icons" style="font-size: 60px;">insert_drive_file</i>
          </div>
          <div class="card-block">
            <h3 class="card-title" style="margin-top: 1rem; text-align: center">{{$template->templatename}}</h3>
          </div>
        </div></a>
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