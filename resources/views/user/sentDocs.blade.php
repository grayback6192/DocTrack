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
            $('#sent-table').DataTable();
        });
    </script>
@section('menu')
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('serviceowners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Send File</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Inbox</span>
              </a>
 </li>

<li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Sent</span>
              </a>
 </li>
 
 
@endsection

@section('main_content')

<div class="container">


<div class="panel-body">
    <table class="table" id="sent-table">
      <thead>
  <tr>
    <th>Date</th>
    <th>Document Name</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
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
    <td><a href="/user/{{$upgid}}/track/{{$docs->doc_id}}">View</a></td>
  </tr>
  @endforeach
  </tbody>
</table>      
</div>
</div>

@endsection