@extends('mastertemplate')
@section('menu')

<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('serviceowners',['groupid'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Send File</span>
              </a>
 </li>

 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewInbox',['groupid'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Inbox</span>
              </a>
 </li>

<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewSent',['groupid'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Sent</span>
              </a>
 </li>
@endsection

@section('main_content')
<div class="row" style="margin-left: 60px; margin-top: 20px;">
    <div class="alert alert-success alert-dismissable">
  <strong>Download</strong> the file to view the signature.
</div>
</div>
<div class="row" style="margin-left: 60px; margin-top: 20px;">
  <input type="button" style = "margin-right:20px" class="btn btn-primary" id="back" value="Back" onclick="window.location='{{route('viewInbox',['groupid'=>Session::get('groupid')])}}'">  
  <input type="button" class="btn btn-primary" id="back" value="Download" onclick="window.location='/temp/{{$pdf}}.docx'">
</div>
  <div class="row" style="margin-left: 60px; margin-top: 20px;">
<object data="../temp/{{ $pdf }}.pdf" type="application/pdf" width="750" height="350"></object>
<br><br>
<form style="padding-left: 680px; margin-top: 20px;" method="post">
{{csrf_field()}}
@if($status!="pending")
  @if($status=="approved")
    Approved on {{$date}} {{$time}}
  @elseif($status=="rejected")
    Rejected on {{$date}} {{$time}}
  @endif
@else
  <input class="btn btn-primary" type = "submit" formaction = "{{route('approve',['id'=>$pdf])}}" value = "Approve">
{{-- <input type = "" formaction = "{{route('reject',['id'=>$pdf])}}" value = "Reject"> --}}
{{-- <a class="btn btn-primary" href="{{route('reject',['id'=>$pdf])}}">Reject</a> --}}
<input class="btn btn-primary" type = "submit" formaction = "{{route('reject',['id'=>$pdf])}}" value = "Reject">
@endif

</form>
</div>  
@endsection