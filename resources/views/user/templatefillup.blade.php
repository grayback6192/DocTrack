@extends('mastertemplate')
@section('menu')
<li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
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

<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewSent',['groupid'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <span class="nav-link-text">
                  Sent</span>
              </a>
 </li>
 
@endsection

@section('main_content')

<div class="row" style="margin-left: 60px; margin-top: 20px;">
    
  <!-- Header -->
  {{-- <header class="w3-container" style="padding-top:22px">
    <div class="search"><input type="text"  name="search" placeholder="Search.."></div>
    <h5><b><i class="fa"></i> Create Document</b></h5>
  </header> --}}



<br><br><br>
@if(isset($template))
<table class="table">
<tr>
<th>Template Name</th>
<th style = "text-align:center" colspan = "2">Action</th>
@foreach($template as $templates)
<tr>
<td>{{ $templates->templatename }}</td>
<td style = "text-align:center"><a href = "/templateInput/{{ $templates->template_id }}">Use Template</a></td>
</tr>
@endforeach
{{-- <form method = "get" action = "createfile">
<input type = "submit" value = "Create File" name = "submit">
</form> --}}
@endif

{{-- Input Type --}}
@if(isset($variable))
<form method = "post">
<a class="row btn btn-primary" style="margin-top: 20px;float:right;margin-left: 300px;" href="javascript:openInstructions()">Show Instructions</a>
<input class="row" style="margin-top: 20px;" type="text" name="subject" placeholder="Subject"><br>

<div class="modal" id="instruct">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Instructions</h5>
      </div>
      <div class="modal-body">
        Instructions here...
      </div>
      <div class="modal-footer">
      <a class="btn btn-primary" href="javascript:closeInstructions()">Close</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
function openInstructions()
{
  var modal = document.getElementById('instruct');
  modal.style.display = "block";
}  

function closeInstructions()
{
  var modal = document.getElementById('instruct');
  modal.style.display = "none";
}
</script>

<div style="float:right;margin-left: 290px;"> 
<object data="../pdf/{{ $id->templatename }}.pdf" type="application/pdf" width="500" height="350" style="float: right;"></object><br>
</div>

{{ csrf_field() }}
@foreach($variable as $variables)
<input type = "text" name = "{{ $variables }}" placeholder = "{{ $variables }}"><br>
@endforeach
<br>

<input class="btn btn-primary" type = "submit" formaction = "{{route('postDoc',['id'=>$id->template_id])}}" value = "Send">
<input class="btn btn-primary" type = "submit" formaction = '/templateView/{{ $id->template_id }}' value = "View">

<br><br>
Workflow:<br><br>
 @for($i=0;$i<(count($var));$i++)
 <table border="2" style="display:inline-block;">
@if($i==(count($var)-1))
@for($j=0;$j<(count($var[$i]));$j++)
<tr>
<td>
{{$var[$i][$j]['lastname']}}, {{$var[$i][$j]['firstname']}}</td></tr>
@endfor 
</table>

@else

@for($j=0;$j<(count($var[$i]));$j++)
<tr>
<td>
{{$var[$i][$j]['lastname']}}, {{$var[$i][$j]['firstname']}}</td></tr>
@endfor 
</table>-->
@endif
@endfor
<br><br>

</form>
@endif
</form> 
     
</div>

@endsection