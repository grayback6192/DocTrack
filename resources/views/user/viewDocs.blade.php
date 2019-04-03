@extends('mastertemplate')
@section('menu')
<li class="nav-item">
              <a class="nav-link" href="{{route('Template',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li class="nav-item active">
              <a class="nav-link" href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">mail</i>
                <p>
                  Inbox
                   @if($numUnread>0)
                     ({{$numUnread}})
                    @endif 
                </p>
              </a>
 </li>

<li class="nav-item">
              <a class="nav-link" href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  In progress</p>
              </a>
 </li>

   <li class="nav-item">
              <a class="nav-link" href="{{route('complete',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Archive</p>
              </a>
 </li>
@endsection

@section('main_content')
<div class="container">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title text-light">Document Workflow</h3>
  </div>
  <div class="panel-body">
  <div class="row justify-content-start" style="padding: 10px;">
    <br>
  @for($i=1;$i<=count($docwf);$i++)
    <div class="media">
      <div class="media-left">
        <div class="card">
          @for($j=0;$j<count($docwf[$i]);$j++)
            <div class="card-content text-light">
              {{$docwf[$i][$j]->lastname}}, {{$docwf[$i][$j]->firstname}}
            </div>
          @endfor
        </div>
      </div>
       @if($i < (count($docwf)))
            <div class="media-right">
              <div style="margin-top: 30px;">
                <i class="material-icons">forward</i>
              </div>
            </div>
            @endif
    </div>
  @endfor
</div>
  </div>
</div>

  <div class="card card-profile">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Document Preview</h4>

                </div>
  
  <div class="card-body" style="height: 650px;">
    <object data="{{ $pdf }}" type="application/pdf" width="750" height="500" style="padding-top: 40px;"></object>
  </div>
  
</div>

<div id="docsentinfo">
  @foreach($docInfos as $docInfo)
  <div class="row">
    <div class="col-6"><center>Received File on {{$receivedatetime}}</center></div>
    <form method="post" class="col-6">
{{csrf_field()}}
@if($docStatus!="pending")
  @if($docStatus=="approved")
  <div><center>Document Approved</center></div>
  @elseif($docStatus=="rejected")
  <div><center>Document Rejected</center></div>
  @endif
@else
<div class="col-6" style="float: right;">
<input class="btn btn-warning" type = "submit" formaction = "{{route('approve',['upgid'=>$upgid,'id'=>$id])}}" value = "Approve">
<input class="btn btn-warning" type = "submit" formaction = "{{route('reject',['upgid'=>$upgid,'id'=>$id])}}" value = "Reject">
</div>
@endif

</form>
  </div>
  @endforeach
</div>
<br><br>


 <div class="blog-comment">      
   @if($comments!=null)
    @foreach($comments as $comment)
{{--     <ul class="comments">
        <li class="clearfix">
    <div class="row">
    <div class="col-md-6">
    </div>
    </div> --}}

 {{--    <div class="post-comments">
              <p class="meta">{{$comment->comment_date}} <a> {{$comment->firstname}} {{$comment->lastname}}</a> says : <i class="pull-right"></i></p>
              <p>
      {{$comment->comment}}
    </p>
          </div> --}}
              <div class="media border p-3">
                <div class="comment-avatar col-md-1 col-sm-2 text-center pr-1">
                    <a href=""><img class="mx-auto rounded-circle img-fluid" src="/users/pictures/{{$commentprof}}" alt="avatar"></a>
                </div>
                <div class="comment-content col-md-11 col-sm-10">
                    <h6 class="small comment-meta"><a href="">{{$comment->firstname}} {{$comment->lastname}}</a> Posted on <i>{{$comment->comment_date}}</i></h6>
                    <div class="comment-body text-light">
                        <p>
                           {{$comment->comment}}
                            <br>
                        </p>
                    </div>
                </div>
              </div>
          {{-- </li> --}}
        {{-- </ul> --}}
    

    @endforeach
  @endif
</div>
<br>

<div class="border p-4">
  <form method="post"> 
 {{csrf_field()}}
 <div class="form-group">
  <label for="formGroupComment">Write a comment</label>
  <br>
<input type="text" class="form-control" name="comment" id="formGroupComment" placeholder="Comment here.">
</div>
</div>
<input class="btn btn-info" style="float: right; margin-top: 10px;" type="submit" value="comment" formaction="{{route('comment',['upgid'=>$upgid, 'docid'=>$id])}}">
</form>

<br><br>



<br>
<div class="card">
    <div class="card-header card-header-warning">
      <h4 class="card-title">Document Logs</h4>
      <p class="card-category">All of document logs.</p>
    </div>
    <div class="card-content table-responsive">
    <table class="table" id="logs-table-track">
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


<div class="row justify-content-end ml-2">
   <input type="button" class="btn btn-warning" id="back" value="Download" onclick="window.location='{{$pdf}}'">&nbsp;&nbsp;&nbsp;
   <input type="button" class="btn btn-warning" id="back" value="Back" onclick="window.location='{{route('viewInbox',['upgid'=>$upgid])}}'">
</div>

</div>
@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
   $(document).ready(function(){
      $('#logs-table-track').DataTable({
        "ordering": false
      });
   });
 </script>   
@endsection