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

<div class="container">
  <div class="row justify-content-start ml-2">
    <a class="btn btn-primary" href="{{route('viewSent',['upgid'=>$upgid])}}">Back</a>
  </div>
  @foreach($docinfos as $docinfo)
    File Sent on {{$docinfo->sentDate}} {{$docinfo->sentTime}}
  @endforeach
  <div class="row justify-content-center mt-4 mb-4">
<object data="/temp/{{ $pdf }}.pdf" type="application/pdf" width="750" height="350"></object>
</div>

<div class="row justify-content-center">
  @foreach($statuss as $status1)
  <div class="col-sm-6" style="margin-top: 20px;">
    <div class="btn-toolbar">
      <div class="btn-group">
      <div class="card" style="border: 0;">
        <table class="table table-sm" >
    <tr>
      <th>Name</th>
      <th>Status</th>
      <th></th>
    </tr>

<tr>
<td>{{$status1->lastname}} {{$status1->firstname}}</td>
<td>{{$status1->status}}
  <div class="card-block">
    @if(isset($status1->time) && isset($status1->date))
      on {{$status1->date}}  {{$status1->time}}
    @endif
  </div>
</td>

</tr>
 
  </table>
</div>
</div>
<div class="btn-group" style="margin-top: 70px; margin-left: 10px;">
  <div class="row justify-content-center">
      <i class="material-icons">forward</i>
  </div>
</div>
</div>
  </div>
@endforeach

</div>
</div>

@endsection