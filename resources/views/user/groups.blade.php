@extends('mastertemplate')
@section('menu')
<li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('serviceowners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Send File</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Inbox</span>
              </a>
 </li>

<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Sent</span>
              </a>
 </li>
 
@endsection

@section('main_content')

<div class="row" style="margin-left: 60px; margin-top: 20px;">
    @if(isset($departments))
@foreach($departments as $department)
 <div class="col-sm-6" style="margin-top: 15px;">
    <a href="{{route('Template',['upgid'=>$upgid,'gid'=>$department->group_id])}}"><div class="card" style="width: 15rem; border: none;">
       <i class="fa fa-5x fa-building"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">{{$department->groupName}}</h3>
      </div>
    </div></a>
  </div>
@endforeach
@endif 
</div>

@endsection