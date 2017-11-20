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
    <table class="table">
  <tr>
    <th>Document Name</th>
    <th></th>
  </tr>
  @foreach($documentname as $docs)
  <tr>
    <td>{{$docs->docname}}</td>
    <td><a href="/track/{{$docs->doc_id}}">View</a></td>
  </tr>
  @endforeach
</table>      
</div>

@endsection