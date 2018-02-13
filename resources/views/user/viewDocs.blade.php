@extends('mastertemplate')
@section('menu')
<li>
              <a href="{{route('serviceowners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li class="active">
              <a href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">mail</i>
                <p>
                  Inbox</p>
              </a>
 </li>

<li>
              <a href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Sent</p>
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
  <input type="button" class="btn btn-primary" id="back" value="Back" onclick="window.location='{{route('viewInbox',['upgid'=>$upgid])}}'">&nbsp;&nbsp;&nbsp;
  <input type="button" class="btn btn-primary" id="back" value="Download" onclick="window.location='/temp/{{$pdf}}.docx'">
</div>
@foreach($docInfos as $docInfo)
  Received File on {{$docInfo->date}} {{$docInfo->time}}
@endforeach
  <div class="row" style="margin-left: 60px; margin-top: 20px;">
<object data="{{ $pdf }}" type="application/pdf" width="750" height="350"></object>
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
  <input class="btn btn-primary" type = "submit" formaction = "{{route('approve',['upgid'=>$upgid,'id'=>$id])}}" value = "Approve">
{{-- <input type = "" formaction = "{{route('reject',['id'=>$pdf])}}" value = "Reject"> --}}
{{-- <a class="btn btn-primary" href="{{route('reject',['id'=>$pdf])}}">Reject</a> --}}
<input class="btn btn-primary" type = "submit" formaction = "{{route('reject',['upgid'=>$upgid,'id'=>$id])}}" value = "Reject">
@endif

</form>
</div>  
@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
@endsection