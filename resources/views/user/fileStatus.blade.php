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
                  In progress</p>
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
  <div class="row justify-content-center mt-4 mb-4">
<object data="{{ $pdf }}" type="application/pdf" width="750" height="350"></object>
</div>

<div class="row justify-content-center">
  @foreach($statuss as $status1)
  {{-- <div class="col-sm-6" style="margin-top: 20px;"> --}}
    <div class="media">
      <div class="media-left">
      <div class="card" style="border: 0;">
        <table class="table table-sm" >
   {{--  <tr>
      <th>Name</th>
      <th>Status</th>
      <th></th>
    </tr> --}}

<tr>
<td>{{$status1->lastname}}, {{$status1->firstname}}</td>
</tr>

{{-- @if()
<tr>
<td>
  fdgfh
</td>    
</tr>
@endif --}}
<?php
foreach ($inboxstatus as $key) {
  if($key->upg_id==$status1->upg_id)
  {
    if($key->readtime!=NULL && $key->readdate!=NULL)
    {
      ?>
        <tr>
          <td>seen <?php echo "".$key->readdate." ".$key->readtime; ?></td>
        </tr>
      <?php
    }
  }
}
?>

<tr>
<td>{{$status1->status}}
  <div class="card-block">
    @if(isset($status1->time) && isset($status1->date))
      on {{$status1->date}} {{$status1->time}}
    @endif
  </div>
</td>

</tr>
 
  </table>
</div>
</div>
@if($status1->order!=$lastOrder)
<div class="media-right">
  <div style="margin-top: 70px;">
      <i class="material-icons">forward</i>
  </div>
</div>
@endif
</div>
  {{-- </div> --}}
@endforeach

</div>
</div>

@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
@endsection