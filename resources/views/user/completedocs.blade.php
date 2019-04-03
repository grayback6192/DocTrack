@extends('mastertemplate')
@section('menu')
<li class="nav-item">
              <a class="nav-link" href="{{route('Template',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">mail</i>
                <p>Inbox
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
                  In progress
                   @if($numinprogress>0)
                     ({{$numinprogress}})
                    @endif 
                </p>
              </a>
 </li>

 <li class="nav-item active">
              <a class="nav-link" href="{{route('complete',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Archive</p>
              </a>
 </li>
@endsection

@section('main_content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
<div class="card-header card-header-warning">
                  <h4 class="card-title ">Archive</h4>
                  <p class="card-category"> Here is your archive</p>
                </div>
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
<th style="text-align: center"></th>
</tr>
</thead>
<tbody>

@foreach($completedoc as $docs)


<tr>

<td style="text-align: center">{{ $docs->sentDate }}</td>
<td style="text-align: center">{{ $docs->docname }}</td>
{{-- <td style="text-align: center">{{ $docs->lastname }}, {{$docs->firstname}}</td>
<td style="text-align: center">{{ $docs->groupName }}</td> --}}
<td style="text-align: center"><a href="/user/{{$upgid}}/complete/{{$docs->doc_id}}">View</a></td>

</tr>



  
  @endforeach
</tbody>
</table>      
</div>
</div>
</div>
</div>
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