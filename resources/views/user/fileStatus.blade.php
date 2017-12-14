@extends('mastertemplate')
@section('menu')
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('serviceowners',['groupid'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Send File</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewInbox',['groupid'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Inbox</span>
              </a>
 </li>

<li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewSent',['groupid'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Sent</span>
              </a>
 </li>
 
@endsection

@section('main_content')

<div class="container">
  <div class="row justify-content-start ml-2">
    <a class="btn btn-primary" href="{{route('viewSent',['groupid',Session::get('groupid')])}}">Back</a>
  </div>
  @foreach($docinfos as $docinfo)
    File Sent on {{$docinfo->sentDate}} {{$docinfo->sentTime}}
  @endforeach
  <div class="row justify-content-center mt-4 mb-4">
<object data="../temp/{{ $pdf }}.pdf" type="application/pdf" width="750" height="350"></object>
</div>

<div class="row justify-content-center">
  @foreach($statuss as $status1)
  <div class="col-sm-6" style="margin-top: 20px;">
    <div class="media">
      <div class="card" style="border: 0;width: 10rem">
        <table class="table table-sm" style="border: 0.5px solid black;">
    <tr>
      <th>Name</th>
      <th>Status</th>
      <th></th>
    </tr>

<tr>
<td>{{$status1->lastname}} {{$status1->firstname}}</td>
<td>{{$status1->status}}
  <div class="card-block">
    @if(isset($status1->time) && isset($status1->date))
      on {{$status1->date}}  {{$status1->time}}
    @endif
  </div>
</td>

</tr>
 
  </table>
</div>
<div class="media-body mt-5 ml-3">
  <div class="row justify-content-center">
      <i class="fa fa-arrow-right fa-fw"></i>
  </div>
</div>
</div>
  </div>
@endforeach

</div>
</div>

@endsection