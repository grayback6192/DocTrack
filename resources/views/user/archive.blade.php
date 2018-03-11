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

<li>
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

   <li class="active">
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
    <br>
      @for($i=1;$i<=count($docwf);$i++)
        <div class="media">
          <div class="media-left">
            <div class="card">
              @for($j=0;$j<count($docwf[$i]);$j++)
                <div class="card-content">
                  {{$docwf[$i][$j]->lastname}}, {{$docwf[$i][$j]->firstname}}<br>
                  <?php
foreach ($inboxstatus as $key) {
  if($key->upg_id==$docwf[$i][$j]->upg_id)
  {
    if($key->readtime!=NULL && $key->readdate!=NULL)
    {
      ?>
      {{--   <tr> --}}
          {{-- <td> --}}<i class="material-icons" style="color: black;" data-toggle="tooltip" data-placement="top" title="seen <?php echo "".$key->readdate." ".$key->readtime; ?>">visibility</i>{{-- </td> --}}

           {{--  <td> --}}
            @if($docwf[$i][$j]->status=="approved")
              <i class="material-icons" style="color: green" data-toggle="tooltip" data-placement="top" title="{{$docwf[$i][$j]->status}} on {{$docwf[$i][$j]->date}} {{$docwf[$i][$j]->time}}">check_circle</i>
            @elseif($docwf[$i][$j]->status=="rejected")
                <i class="material-icons" style="color: red" data-toggle="tooltip" data-placement="top" title="{{$docwf[$i][$j]->status}} on {{$docwf[$i][$j]->date}} {{$docwf[$i][$j]->time}}">clear</i>
            @endif
          {{-- </td> --}}
     {{--    </tr> --}}
      <?php
    }
  }
}
?>
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
</div>
</div>
</div>

@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
@endsection