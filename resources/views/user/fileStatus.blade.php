@extends('mastertemplate')
@section('menu')
<li>
              <a href="{{route('Template',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li>
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

<li class="active">
              <a href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  In progress
                  @if($numinprogress>0)
                     ({{$numinprogress}})
                    @endif 
                </p>
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

<div class="container">
  <div class="row justify-content-start ml-2">
    <a class="btn btn-primary" href="{{route('viewSent',['upgid'=>$upgid])}}">Back</a>
  </div>
  <div id="docsentinfo">
    @foreach($docinfos as $docinfo)
      Document Name: {{$docinfo->docname}}<br>
      Date Sent: {{$docinfo->sentDate}} <br>
      Time Sent: {{$docinfo->sentTime}}
    @endforeach
  </div>

<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Document Workflow</h3></div>
  <div class="panel-body">
  <div class="row justify-content-start">
      @for($i=1;$i<=count($statusarray);$i++)
        <div class="media">
          <div class="media-left">
            <div class="card">
              @for($j=0;$j<count($statusarray[$i]);$j++)
                <div class="card-content">
                  {{$statusarray[$i][$j]['lastname']}}, {{$statusarray[$i][$j]['firstname']}}
                  @if($statusarray[$i][$j]['seenstatus']=="read")
                    {{-- <br>Read at {{$statusarray[$i][$j]['datetime']}} --}}
                    <br><i class="material-icons" data-toggle="tooltip" title="Seen at {{$statusarray[$i][$j]['seendatetime']}}">
                          remove_red_eye
                        </i>
                  @endif

                  @if($statusarray[$i][$j]['approvestatus']=="pending")
                    <br>pending
                  @elseif($statusarray[$i][$j]['approvestatus']=="approved")
                    {{-- &nbsp;approved on {{$statusarray[$i][$j]['datetime']}} --}}
                    <i class="material-icons" style="color: green" data-toggle="tooltip" title="Approved on {{$statusarray[$i][$j]['datetime']}}">
                      check_circle
                    </i>
                  @elseif($statusarray[$i][$j]['approvestatus']=="rejected")
                    {{-- &nbsp;rejected on {{$statusarray[$i][$j]['datetime']}} --}}
                    <i class="material-icons" style="color: red" data-toggle="tooltip" title="Rejected on {{$statusarray[$i][$j]['datetime']}}">
                      cancel
                    </i>
                  @endif
                </div>
              @endfor
            </div>
          </div>
          @if($i != count($statusarray))
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

  <div class="row justify-content-center mt-4 mb-4">
<object data="{{ $pdf }}" type="application/pdf" width="750" height="350"></object>
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
              <p class="meta">{{$comment->comment_date}} <a> {{$comment->firstname}} {{$comment->lastname}}</b></a> says : <i class="pull-right"></i></p>
              <p>
      {{$comment->comment}}
    </p>
          </div>
          </li>
        </ul>
    

    @endforeach
  @endif
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
</div>
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