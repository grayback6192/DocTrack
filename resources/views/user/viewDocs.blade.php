@extends('mastertemplate')
@section('menu')
<li>
              <a href="{{route('Template',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li class="active">
              <a href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">mail</i>
                <p>
                  Inbox
                   @if($numUnread>0)
                     ({{$numUnread}})
                    @endif 
                </p>
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
  <input type="button" class="btn btn-primary" id="back" value="Download" onclick="window.location='{{$pdf}}'">
</div>
@foreach($docInfos as $docInfo)
  Received File on {{$receivedatetime}}
@endforeach
  <div class="row" style="margin-left: 60px; margin-top: 20px;">
<object data="{{ $pdf }}" type="application/pdf" width="750" height="350"></object>
<br><br>
<form style="padding-left: 680px; margin-top: 20px;" method="post">
{{csrf_field()}}
@if($docStatus!="pending")
  @if($docStatus=="approved")
    Approved on {{$datetime}}
  @elseif($docStatus=="rejected")
    Rejected on {{$datetime}}
  @endif
@else
  <input class="btn btn-primary" type = "submit" formaction = "{{route('approve',['upgid'=>$upgid,'id'=>$id])}}" value = "Approve">
{{-- <input type = "" formaction = "{{route('reject',['id'=>$pdf])}}" value = "Reject"> --}}
{{-- <a class="btn btn-primary" href="{{route('reject',['id'=>$pdf])}}">Reject</a> --}}
<input class="btn btn-primary" type = "submit" formaction = "{{route('reject',['upgid'=>$upgid,'id'=>$id])}}" value = "Reject">
@endif

</form>
</div>  

 <div class="blog-comment">      
<br>
   @if($comments!=null)
    @foreach($comments as $comment)
    <ul class="comments">
        <li class="clearfix">
    <div class="row">
    <div class="col-md-6">
    </div>
    </div>

    <div class="post-comments">
              <p class="meta">{{$comment->comment_date}} <a> {{$comment->firstname}} {{$comment->lastname}}</b></a> says : <i class="pull-right"></a></i></p>
              <p>
      {{$comment->comment}}
    </p>
          </div>
          </li>
        </ul>
    

    @endforeach
  @endif

  <form method="post"> 
 {{csrf_field()}}
 <div class="col-md-12">
<textarea name="comment" placeholder="Comment" rows="5" cols="143" >
</textarea>
</div>
<input class="btn btn-primary" style="float: right;" type="submit" value="comment" formaction="{{route('comment',['upgid'=>$upgid, 'docid'=>$id])}}">
</form>
<br>
</div>

<br>

<div class="container">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Document Workflow</h3>
  </div>
  <div class="panel-body">
  <div class="row justify-content-start" style="padding: 10px;">
    <br>
  @for($i=1;$i<=count($docwf);$i++)
    <div class="media">
      <div class="media-left">
        <div class="card">
          @for($j=0;$j<count($docwf[$i]);$j++)
            <div class="card-content">
              {{$docwf[$i][$j]->lastname}}, {{$docwf[$i][$j]->firstname}}
            </div>
          @endfor
        </div>
      </div>
       @if($i < (count($docwf)))
            <div class="media-right">
              <div style="margin-top: 40px;">
                <i class="material-icons">forward</i>
              </div>
            </div>
            @endif
    </div>
  @endfor
</div>
  </div>
</div>
</div>
<br>
<div class="card">
    <div class="card-content table-responsive">
      Document Logs<br>
    <table class="table table-striped" id="logs-table-track">
      <thead>
        <th>Date and Time</th>
        <th>Status</th>
        <th>User Involved</th>
      </thead>
      <tbody>
        @if(count($logsArray) != 0)
        @for($i=0; $i<count($logsArray); $i++)
          <tr>
            <td>{{$logsArray[$i]['datetime']}}</td>
            <td>{{$logsArray[$i]['status']}}</td>
            <td>{{$logsArray[$i]['user']}}</td>
          </tr>
        @endfor
        @endif
      </tbody>
    </table>
    </div>
  </div>
@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
@endsection