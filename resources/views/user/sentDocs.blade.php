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

<div class="container">

<div class="row justify-content-end mr-2 mb-2">
<form id="choosesentstatus" name="sentstatusdrop">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
  <select id="sentstatus" name="sentStatus" class="form-control">
    <option value="all">All</option>
    <option value="approved">Completed</option>
    <option value="pending">Ongoing</option>
    <option value="rejected">Rejected</option>
  </select>
</form>

<script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  $(document).ready(function(){
    $('#sentstatus').change(function(){
      var statusSent = $(this).val();
      console.log(statusSent);
      $.ajax({
        type: 'GET',
        url: "http://localhost:8000/sent/"+statusSent,
        success: function(data){
          console.log(data);
          $('#sent-table tr:not(:first)').remove();
                    for(var i=0;i<data.length;i++){
                    var html = "<tr>";
                    html+= "<td></td>";
                    html+="<td>"+data[i].docname+"</td>";
                    html+="<td><a href=http://localhost:8000/track/"+data[i].doc_id+">View</a></td>";
                    html+="</tr>";
                    console.log(html);
                    $('#sent-table').append(html);
          }
        }
      });
    });
  });
</script>
</div>

<div class="row" style="margin-left: 60px; margin-top: 20px;">
    <table class="table" id="sent-table">
  <tr>
    <th>Date</th>
    <th>Document Name</th>
    <th></th>
  </tr>
  @foreach($documentname as $docs)
  <tr>
    <td>
        <?php 
          list($month,$day,$year) = explode('-',$docs->sentDate);
          $monthword = date('M', mktime(0,0,0,$month,10));
          $newDate = $monthword." ".$day.", ".$year;

          echo $newDate;
        ?>     
    </td>
    <td>{{$docs->docname}}</td>
    <td><a href="/track/{{$docs->doc_id}}">View</a></td>
  </tr>
  @endforeach
</table>      
</div>
</div>

@endsection