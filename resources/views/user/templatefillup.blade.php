@extends('mastertemplate')
@section('menu')
<li class="active">
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

<li>
              <a href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Sent</p>
              </a>
 </li>
 
@endsection

@section('main_content')
<div class="container-fluid">
<div class="row">
    
  <!-- Header -->
  {{-- <header class="w3-container" style="padding-top:22px">
    <div class="search"><input type="text"  name="search" placeholder="Search.."></div>
    <h5><b><i class="fa"></i> Create Document</b></h5>
  </header> --}}


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
<div class="row">
      @foreach($template as $templates)
        <div class="col-lg-3 col-md-6 col-sm-6">
           <div class="card card-stats">
            <a href="/user/{{$upgid}}/send/{{$gid}}/templateInput/{{ $templates->template_id }}">
               <div class="card-header" data-background-color="orange">
                  <i class="material-icons">description</i>
                </div>
          <div class="card-content">
             <p class="category">Template</p>
            <h3 class="title">{{$templates->templatename}}</h3>
          </div>
          </a>
        </div>
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

<div class="row">
<form method = "post">
{{--   <div class="media-body mr-3"> --}}
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


{{-- </div> --}}
<div class="col-md-4">
<input class="row" style="margin-top: 20px;" type="text" name="subject" placeholder="Subject"><br>
{{ csrf_field() }}
{{-- Variable Form --}}
@foreach($variable as $variables)
  @if($variables == "Body" || $variables == "body")
    <textarea id = "textarea" rows = 5 cols = 40 name = "{{$variables}}" style = "margin-top:0px"></textarea><br>
  @elseif($variables == "Date" || $variables == "date")
    <input type = "date" name = "{{ $variables }}"><br>
  @else
    <input type = "text" name = "{{ $variables }}" placeholder = "{{ $variables }}"><br>
  @endif
@endforeach
@foreach($position as $positions)
  <input type = "text" id = "positions" name = "{{ $positions }}" placeholder = "{{ $positions }}" value = "<?php echo '${'.$positions.'}' ?>" hidden><br>
@endforeach

{{-- Unfixed --}}
 {{-- @foreach($position as $positions)
      @if($positions == $variables)
        <input type = "text" name = "{{ $variables }}" value = ${{{$variables}}}><br>
      @endif --}}

<input class="btn btn-primary" type = "submit" formaction = "{{route('postDoc',['id'=>$id->template_id])}}" value = "Send">
<input class="btn btn-primary" type = "submit" formaction = '/templateView/{{ $id->template_id }}' value = "View">
</div>

<div class="col-sm-3 col-md-offset-4"> 
<object data="/pdf/{{ $id->templatename }}.pdf" type="application/pdf" width="500" height="350" style="float: right;"></object><br>
</div>

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

</form> 
     
</div>
Workflow:<br><br>
<?php
// echo "<pre>";
// var_dump($var);
for ($i=0; $i < count($var); $i++) { 

 if($i==(count($var)-1))
     echo "".$var[$i]['lastname'];
   else
    echo "".$var[$i]['lastname']."--> ";

 
}
?>
<br><br>
</div>
@endif
</div>
@endsection

