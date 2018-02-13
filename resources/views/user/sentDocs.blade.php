@extends('mastertemplate')

@section('menu')
<li>
              <a href="{{route('serviceowners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">mail</i>
                <p>
                  Inbox</p>
                 
              </a>
 </li>

<li class="active">
              <a href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Sent</p>
              </a>
 </li>
 
 
 
@endsection

@section('main_content')

<div class="content">


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
        {{$docs->sentDate}}
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

@section('js')
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
@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
@endsection