@extends('mastertemplate')
<script
  src="https://code.jquery.com/jquery-1.11.2.min.js"
  integrity="sha256-Ls0pXSlb7AYs7evhd+VLnWsZ/AqEHcXBeMZUycz/CcA="
  crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css"
        href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" />
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#inbox-table').DataTable();
        });
    </script>
@section('menu')
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('serviceowners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Send File</span>
              </a>
 </li>

 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <div class="row justify-content-between ml-1 mr-2">
                <span class="nav-link-text">
                  Inbox</span>
                  <span class="nav-link-text">
                    @if($numUnread>0)
                      {{$numUnread}}
                    @endif {{--Number of pending inbox--}}
                  </span>
                  </div>
              </a>
 </li>

<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Sent</span>
              </a>
 </li>
 
@endsection

@section('main_content')

<div class="container">
<div class="row justify-content-end mr-2 mb-2">
<form id="chooseinboxstatus" name="inboxstatusdrop">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
  <select id="inboxstatus" name="inboxStatus" class="form-control">
    <option value="all">All</option>
    <option value="read">Read</option>
    <option value="unread">Unread</option>
   {{--  <option value="approved">Approved</option>
    <option value="pending">Pending</option> --}}
  </select>
</form>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

  $(document).ready(function(){
  $('#inboxstatus').change(function(){
    var statusInbox = $(this).val();
    console.log(statusInbox);
    $.ajax({
      type: 'GET',
      url: 'http://localhost:8000/inbox/'+statusInbox,
      success: function(data){
        console.log(data);

        $('#inbox-table tr:not(:first)').remove();
                    for(var i=0;i<data.length;i++){
                    var html = "<tr>";
                    html+= "<td style='text-align: center'>"+data[i].date+"</td>";
                    html+="<td style='text-align: center'>"+data[i].docname+"</td>";
                    html+="<td style='text-align: center'>"+data[i].lastname+", "+data[i].firstname  +"</td>";
                    html+="<td style='text-align: center'>"+data[i].groupName+"</td>";
                    html+="<td style='text-align: center'><a href=http://localhost:8000/documentView/"+data[i].doc_id+">View</a></td>";
                    html+="</tr>";
                    console.log(html);
                    $('#inbox-table').append(html);
          }
      }
    });
  });
  });
</script>

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
@foreach($inbox as $inboxes)
@if($inboxes->istatus=="unread")
<tr style="background-color: #e6e6e6">
<td style="text-align: center; font-weight: bold">
   <?php 
          list($month,$day,$year) = explode('-',$inboxes->date);
          $monthword = date('M', mktime(0,0,0,$month,10));
          $newDate = $monthword." ".$day.", ".$year;

          echo $newDate;
        ?>     
</td>
<td style="text-align: center; font-weight: bold">{{ $inboxes->docname }}</td>
<td style="text-align: center; font-weight: bold">{{ $inboxes->lastname }}, {{$inboxes->firstname}}</td>
<td style="text-align: center; font-weight: bold">{{ $inboxes->groupName }}</td>
<td style="text-align: center"><a href="{{URL::route('docView',['upgid'=>$upgid,'id'=>$inboxes->doc_id])}}">View</a></td>
{{-- <td style = "text-align:center"><a href="/documentView/{{ $inboxes->$doc_id }}"</td> --}}
</tr> 
@else
<tr>
<td style="text-align: center">
   <?php 
          list($month,$day,$year) = explode('-',$inboxes->date);
          $monthword = date('M', mktime(0,0,0,$month,10));
          $newDate = $monthword." ".$day.", ".$year;

          echo $newDate;
        ?>    
</td>
<td style="text-align: center">{{ $inboxes->docname }}</td>
<td style="text-align: center">{{ $inboxes->lastname }}, {{$inboxes->firstname}}</td>
<td style="text-align: center">{{ $inboxes->groupName }}</td>
<td style="text-align: center"><a href="{{URL::route('docView',['upgid'=>$upgid,'id'=>$inboxes->doc_id])}}">View</a></td>
{{-- <td style = "text-align:center"><a href="/documentView/{{ $inboxes->$doc_id }}"</td> --}}
</tr>
@endif

@endforeach
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