@extends('mastertemplate')
@section('menu')
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('serviceowners',['groupid'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Send File</span>
              </a>
 </li>

 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewInbox',['groupid'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Inbox</span>
              </a>
 </li>

<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewSent',['groupid'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Sent</span>
              </a>
 </li>
 
@endsection

@section('main_content')

<div class="row" style="margin-left: 60px; margin-top: 20px;">
    <table class="table">
<tr>
<th style="text-align: center">Document Name</th>
<th style="text-align: center">Sender</th>
<th style="text-align: center">Department</th>
<th style="text-align: center"></th>
</tr>
@foreach($inbox as $inboxes)
<tr>
<td style="text-align: center">{{ $inboxes->docname }}</td>
<td style="text-align: center">{{ $inboxes->lastname }}, {{$inboxes->firstname}}</td>
<td style="text-align: center">{{ $inboxes->groupName }}</td>
<td style="text-align: center"><a href="{{URL::route('docView',['id'=>$inboxes->doc_id])}}">View</a></td>
{{-- <td style = "text-align:center"><a href="/documentView/{{ $inboxes->$doc_id }}"</td> --}}
</tr> 
@endforeach
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

@endsection