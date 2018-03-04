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
                  In progress</p>
              </a>
 </li>

   <li>
              <a href="{{route('complete',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Archive</p>
              </a>
 </li>
@endsection

@section('main_content')
<div class="row" style="margin-left: 60px; margin-top: 20px;">
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

<br>
   @if($comments!=null)
    @foreach($comments as $comment)
    <div class="row">
      <div class="col-md-6">
        <br>
        <label for="comment">Comment by:</label><b>
    {{$comment->lastname}},{{$comment->firstname}}</b>
</div>
</div>
    <div class="row">
    <div class="col-md-12">
      <textarea readonly="true" rows="3" cols="60">{{$comment->comment}}</textarea>
    </div>
      </div>

    @endforeach
  @endif
</div>

<form method="post"> 
 {{csrf_field()}}
<textarea name="comment" placeholder="Comment" rows="5" cols="180" >
</textarea>
<input class="btn btn-primary" style="float: right; margin-right: 20px;" type="submit" value="comment" formaction="{{route('comment',['upgid'=>$upgid, 'docid'=>$id])}}">
</form>
<br>

<div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Document Workflow</h3>
  </div>
  <div class="panel-body">
  <div class="row">
    @foreach($docworkflows as $docworkflow)
      <div class="media">
      <div class="media-left">
      <div class="card">
        <div class="card-content">
          {{$docworkflow->lastname}}, {{$docworkflow->firstname}}
        </div>
      </div>
      </div>

      @if($docworkflow->order != (count($docworkflows)))
      <div class="media-right">
        <div style="margin-top: 40px;">
          <i class="material-icons">forward</i>
        </div>
      </div>
      @endif
      </div>
    @endforeach
  </div>
  </div>
</div>
</div>
@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
@endsection