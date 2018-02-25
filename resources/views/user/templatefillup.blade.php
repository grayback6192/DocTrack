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
  <div class="card">
    <div class="card-header" data-background-color="orange">
    <h4 class="title">Send</h4>
    <p class="category">Send a file.</p>
   </div>
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
          <div class="col-lg-4 col-md-3 col-sm-3">
            <a href="/user/{{$upgid}}/send/{{$gid}}/templateInput/{{ $templates->template_id }}">
               <div class="card card-stats">
         <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">description</i>
                                </div>

       <div class="card-content">
                 <h3 class="title">{{$templates->templatename}}</h3>
                </div>
              </div>
          </a>
        </div>
      @endforeach
</div>

@endif

{{-- Input Type --}}
@if(isset($variable))
<div class="container">

<div class="row justify-content-between">
<div class="media">
<form method = "post">
{{--   <div class="media-body mr-3"> --}}

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
      <a class="btn btn-info" href="javascript:closeInstructions()">Close</a>
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

<div class="media-left">
<div class="col-md-offset-1" style="padding-top: 60px;">

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
@if(isset($position))
@foreach($position as $positions)
  <input type = "text" id = "positions" name = "{{ $positions }}" placeholder = "{{ $positions }}" value = "<?php echo '${'.$positions.'}' ?>" hidden><br>
@endforeach
@endif

{{-- Unfixed --}}
 {{-- @foreach($position as $positions)
      @if($positions == $variables)
        <input type = "text" name = "{{ $variables }}" value = ${{{$variables}}}><br>
      @endif --}}

<input class="btn btn-primary" type = "submit" formaction = "{{route('postDoc',['id'=>$id->template_id])}}" value = "Send">
<input class="btn btn-primary" type = "submit" formaction = '/templateView/{{ $id->template_id }}' value = "View">
</div>
</div>


  <div class="media-body">
  <div class="col-sm-7 col-md-offset-3"> 
  <div class="col-md-offset-10" style="margin-bottom: 10px;">
    <a class="row btn btn-info mb-3" href="javascript:openInstructions()">Show Instructions</a>
  </div>
<object data="/pdf/{{ $id->templatename }}.pdf" type="application/pdf" width="500" height="350"></object><br>
</div>

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
</div>

<br><br><br>

<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Document Workflow</h3></div>
  <div class="panel-body">
  <div class="row justify-content-start">
    @for($i=0; $i< count($var); $i++)
      <div class="media">
      <div class="media-left">
      <div class="card">
        <div class="card-content">
          {{$var[$i]['lastname']}}, {{$var[$i]['firstname']}}
        </div>
       {{--  @if((count($var[$i])) > 1)
        @for($j=0; $j < count($var[$i]); $j++)
          <div class="card-content">
            {{$var[$i][$j]['lastname']}}, {{$var[$i][$j]['firstname']}}
          </div>
        @endfor
        @endif --}}
      </div>
      </div>

      @if($i != (count($var)-1))
      <div class="media-right">
        <div style="margin-top: 40px;">
          <i class="material-icons">forward</i>
        </div>
      </div>
      @endif
      </div>
    @endfor
    </div>
  </div>
<?php
// echo "<pre>";
// var_dump($var);
// for ($i=0; $i < count($var); $i++) { 

//  if($i==(count($var)-1))
//      echo "".$var[$i]['lastname'];
//    else
//     echo "".$var[$i]['lastname']."--> ";

 
//}
?>
</div>
  <div class="row justify-content-start ml-2 mb-2" style="float: right; margin-right: 50px;">
    <a class="btn btn-info" href="{{route('serviceowners',['upgid'=>$upgid])}}">  Back</a>
    </div>
</div>
@endif
</div>
@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
@endsection

