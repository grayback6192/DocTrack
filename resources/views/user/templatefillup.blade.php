@extends('mastertemplate')
@section('menu')
<li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
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

<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
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
<div class="container">
<div class="row justify-content-start ml-2 mb-2">
  <a class="btn btn-primary" href="{{route('serviceowners',['upgid'=>$upgid])}}">  Back</a>
  </div>
{{-- <div class="row justify-content-center mr-4 ml-2">
<table class="table">
<tr>
<th>Template Name</th>
<th style = "text-align:center" colspan = "2">Action</th>
</tr>
@foreach($template as $templates)
<tr>
<td>{{ $templates->templatename }}</td>
<td style = "text-align:center"><a href = "/templateInput/{{ $templates->template_id }}">Use Template</a></td>
</tr>
@endforeach

</table>
</div> --}}
<div class="row" style="margin-left: 60px; margin-top: 20px;">
      @foreach($template as $templates)
        <div class="col-sm-6" style="margin-top: 15px;">
            <a href="/user/{{$upgid}}/send/{{$gid}}/templateInput/{{ $templates->template_id }}"><div class="card" style="width: 15rem; border: none;">
            <i class="fa fa-5x fa-file-o"></i>
          <div class="card-block">
            <h3 class="card-title" style="margin-top: 1rem">{{$templates->templatename}}</h3>
          </div>
        </div></a>
        </div>
      @endforeach
</div>
@endif

{{-- Input Type --}}
@if(isset($variable))
<div class="container">
<div class="row justify-content-start ml-2">
    <a class="btn btn-primary" href="{{route('Template',['upgid'=>$upgid,'gid'=>$gid])}}">Back</a>
</div>
<div class="media">
<div class="row justify-content-center mr-4 ml-2">
<form method = "post">
  <div class="media-body mr-3">
<a class="row btn btn-primary mb-3" style="margin-top: 20px;float:right;margin-left: 300px;" href="javascript:openInstructions()">Show Instructions</a>
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
<object data="/pdf/{{ $id->templatename }}.pdf" type="application/pdf" width="500" height="350" style="float: right;"></object><br>
</div>
</div>

<input class="row" style="margin-top: 20px;" type="text" name="subject" placeholder="Subject"><br>

{{ csrf_field() }}
@foreach($variable as $variables)
<input type = "text" name = "{{ $variables }}" placeholder = "{{ $variables }}"><br>
@endforeach
<br>

<input class="btn btn-primary" type = "submit" formaction = "{{route('postDoc',['id'=>$id->template_id])}}" value = "Send">
<input class="btn btn-primary" type = "submit" formaction = '/templateView/{{ $id->template_id }}' value = "View">

{{-- '/templateView/{{ $id->template_id }}' --}}
{{--open new window to view document--}}
<script type="text/javascript" src="{{URL::asset('js/jquery-3.2.1.min.js')}}" ></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#viewDocument').submit(function(event){
        var url = "localhost:8000/templateView/";
        var windowName = "View Document";

        window.open(url, windowName, "height=100, width=100");

        event.preventDefault();
    });
  });
  
</script>
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