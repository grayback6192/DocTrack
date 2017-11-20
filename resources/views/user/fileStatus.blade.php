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

<div class="row" style="margin-left: 60px; margin-top: 20px;">
  @foreach($statuss as $status1)
  <div class="col-sm-6" style="margin-top: 20px;">
    <table class="table table-sm" style="border: 0.5px solid black;">
    <tr>
      <th>Name</th>
      <th>Status</th>
      <th></th>
    </tr>
  {{--  @foreach($name as $names) --}}

<tr>
<td>{{$status1->lastname}} {{$status1->firstname}}</td>
{{-- @foreach($statuss as $status1) --}}
{{-- @endforeach --}}
<td>{{$status1->status}}
  <div class="card-block">
    @if(isset($status1->time) && isset($status1->date))
      on {{$status1->date}}  {{$status1->time}}
    @endif
  </div>
</td>
{{-- <td>{{$status1->date}} {{$status1->time}}</td> --}}
</tr>
{{-- @endforeach  --}}  
  </table>
  </div><div style="margin-top: 40px;">===></div>
@endforeach

</div>

@endsection