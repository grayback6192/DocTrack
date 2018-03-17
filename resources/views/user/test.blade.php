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
                  {{--  <div class="notification"> --}}
                    {{--Number of pending inbox--}}
                  {{-- </div> --}}
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

   <li>
              <a href="{{route('complete',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Archive</p>
              </a>
 </li>
 
@endsection

@section('main_content')

<div class="content">
  <div class="row justify-content-end">
    <div class="form-group col-sm-2">

<form id="chooseinboxstatus" name="inboxstatusdrop">
{{--   <input type="hidden" name="_token" value="{{csrf_token()}}"> --}}

  
  <select id="inboxstatus" name="inboxStatus" class="form-control">
    <option value="all">All</option>
    <option value="read">Read</option>
    <option value="unread">Unread</option>
   {{--  <option value="approved">Approved</option>
    <option value="pending">Pending</option> --}}
  </select>
 

</form>
 </div>
  </div>


<div class="panel-body">
<table class="table" id="inbox-table">
  <thead>
<tr>
<th style="text-align: center">Date</th>
<th style="text-align: center">Document Name</th>
<th style="text-align: center">Sender</th>
<th style="text-align: center">Department</th>
<th style="text-align: center"></th>
</tr>
</thead>
<tbody>
@for($inbox = 0; $inbox<count($inboxArray); $inbox++)
  @if($inboxArray[$inbox]->status=="unread")
    <tr style="background-color: #e6e6e6">
    <td style="text-align: center; font-weight: bold">
       <?php 
        // $date = new DateTime($inboxArray[$inbox]->datetime, new DateTimeZone('Asia/Manila'));
        // $date2 = $date->format('M d');
      $timestamp = strtotime($inboxArray[$inbox]->datetime);  
      $date = date('M d',$timestamp);
        echo $date;
       ?>     
    </td>
    <td style="text-align: center; font-weight: bold">{{ $inboxArray[$inbox]->docname }}</td>
    <td style="text-align: center; font-weight: bold">{{ $inboxArray[$inbox]->lastname }}, {{$inboxArray[$inbox]->firstname}}</td>
    <td style="text-align: center; font-weight: bold">{{ $inboxArray[$inbox]->groupName }}</td>
    <td style="text-align: center"><a href="{{URL::route('docView',['upgid'=>$upgid,'id'=>$inboxArray[$inbox]->doc_id])}}">View</a></td>
    </tr> 
    @else
      <tr>

      <td style="text-align: center">
        <?php 
        $timestamp = strtotime($inboxArray[$inbox]->datetime);  
      $date = date('M d',$timestamp);
        echo $date;
       ?>     
      </td>
      <td style="text-align: center">{{ $inboxArray[$inbox]->docname }}</td>
      <td style="text-align: center">{{ $inboxArray[$inbox]->lastname }}, {{$inboxArray[$inbox]->firstname}}</td>
      <td style="text-align: center">{{ $inboxArray[$inbox]->groupName }}</td>
      <td style="text-align: center"><a href="{{URL::route('docView',['upgid'=>$upgid,'id'=>$inboxArray[$inbox]->doc_id])}}">View</a></td>
      </tr>
  @endif
@endfor
</tbody>
</table>



{{-- Input Type --}}
@if(isset($variable))
<form method = "post">
<object data="../pdf/{{ $id->docname }}.pdf" type="application/pdf" width="500" height="350" style = "float:right"></object><br>
{{ csrf_field() }}
@foreach($variable as $variables)
<input type = "text" name = "{{ $variables }}" placeholder = "{{ $variables }}"><br>
@endforeach
<input type = "submit" formaction = "/senddocs" value = "Send">
<input type = "submit" formaction = '/templateView/{{ $id->doc_id }}' value = "View">
</form>
@endif
{{-- </form> --}}      
</div>
</div>

@endsection

@section('js')

<script type="text/javascript" src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
        $(document).ready(function () {
            $('#inbox-table').DataTable({
             "ordering": false
            });
        });
    </script>
<script type="text/javascript">var upgid="<?php echo $upgid; ?>";</script>
<script type="text/javascript" src="{{URL::asset('js/doctrack.js')}}"></script>
@endsection