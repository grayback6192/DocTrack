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
                <p>
                  Inbox
                   @if($numUnread>0)
                     ({{$numUnread}})
                    @endif 
                </p>
                 
              </a>
 </li>

<li class="nav-item active">
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

   <li class="nav-item">
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
                  <h4 class="card-title ">Inbox</h4>
                  <p class="card-category"> Here is your inbox that is in progress</p>
                </div>

<div class="card-body">
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
  @if(!in_array($docs->doc_id,$getarchivearray))
  <tr>
    <td>

        {{$docs->sentDate}}
    </td>
    <td>{{$docs->docname}}</td>
    <td><a href="/user/{{$upgid}}/track/{{$docs->doc_id}}">View</a></td>
  </tr>
  @endif
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

{{-- @section('js')
<script
  src="https://code.jquery.com/jquery-1.11.2.min.js"
  integrity="sha256-Ls0pXSlb7AYs7evhd+VLnWsZ/AqEHcXBeMZUycz/CcA="
  crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sent-table').DataTable();
        });
    </script>
@endsection --}}

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script> 
 <script type="text/javascript">
        $(document).ready(function () {
            $('#sent-table').DataTable({
             "ordering": false
            });
        });
    </script> 
@endsection