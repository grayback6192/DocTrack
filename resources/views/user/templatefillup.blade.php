@extends('mastertemplate')
@section('menu')
<li class="active">
              <a href="{{route('Template',['upgid'=>$upgid])}}">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewInbox',['upgid'=>$upgid])}}">
                 <i class="material-icons">mail</i>
                <p>
                  Inbox
                   @if($numUnread>0)
                     ({{$numUnread}})
                    @endif 
                </p>
                   
              </a>
 </li>

<li>
              <a href="{{route('viewSent',['upgid'=>$upgid])}}">
                 <i class="material-icons">drafts</i>
                <p>
                  In progress
                   @if($numinprogress>0)
                     ({{$numinprogress}})
                    @endif 
                </p>
              </a>
 </li>

   <li>
              <a href="{{route('complete',['upgid'=>$upgid])}}">
                <i class="material-icons">drafts</i>
                <p>
                  Archive</p>
              </a>
 </li>
 
@endsection

@section('main_content')
<div class="container-fluid">
<div class="row">
    
  <script type="text/javascript" src="{{URL::asset('js/jquery-3.2.1.min.js')}}" ></script>
  <script type="text/javascript">
    $(document).ready(function(){
      var rows = $('.temp');

      $('#tempsearch').on('keyup',function(){
        var value = $(this).val();
        if(value!=""){
           $.ajax({
          type: 'GET',
          url: 'http://localhost:8000/user/'+<?php echo $upgid; ?>+'/searchtemplate/'+value,
          success: function(data){
            console.log(data);

            //var templates = $.parseJSON(data);

           // for(var i=0;i<data.length;i++)
           //   {
           //  //   // $('#results').append(data[i]);
           //  //    if($('.temp').attr('id')==data[i].templatename)
           //  //    {
           //  //     $('#'+data[i].templatename).show();
           //  //    }  
           //  //    else{
           //  //     $('.temp').hide();
           //  //   }
           //  //    console.log(data[i].templatename);
           //         $('#tempresults div').each(function(){
           //    if(($(this).attr('id')) == data[i].templatename)
           //      $(this).show();
           //    else
           //      $(this).hide();
           //    console.log($(this));
           //  });

           //   }
           $('.temp').hide();
           $.each(data,function(index, template){
              $('#'+template.template_id).show();
           });
         
            
          }
        });
        }
        else
        {
          $('.temp').show();
        }
      });
    });
  </script>


@if(isset($template))
<div class="container">
  <div class="card">
    <div class="card-header" data-background-color="orange">
    <h4 class="title">Choose template.</h4>
    <p class="category">Choose type of document.</p>
   </div>
  </div>  
<div id="results"></div>
<div class="row">
<div class="col-lg-4 col-md-6 col-sm-12">                            
                              <a href="{{route('test',['upgid'=>$upgid])}}">
                               <div class="card card-stats" style="border: none">
                                  <div class="card-header" data-background-color="blue">
                                   <i class="material-icons">folder_open</i>
                               </div>
                                  <div class="card-content">
                                    <h3 class="title">Create Document</h3>
                                </div>
                              </div>
                                </a>
                            </div>
</div>

<div class="row col-md-offset-9">
 <form class="navbar-form navbar-right" role="search" style="color: gray;">
                            <div class="form-group  is-empty">
                              Search: <input type="text" name="tempsearch" id="tempsearch">
                            </div>
                        </form>
</div>
{{-- <table id="template-table" class="table">
  <thead>
    <th>Templates</th>
  </thead>
<tbody> --}}

<div class="row" id="tempresults">
        {{--   <tr class="row"> --}}
      @foreach($template as $templates)

    {{--     <td > --}}
          <div class="col-lg-4 col-md-3 col-sm-3 temp" id="{{$templates->template_id}}">
            <a href="/user/{{$upgid}}/send/templateInput/{{ $templates->template_id }}">
               <div class="card card-stats">
         <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">description</i>
                                </div>

       <div class="card-content">
                 <h3 class="title">{{$templates->templatename}}</h3>
                 <p class="category">({{$templates->groupName}})</p>
                </div>
              </div>
          </a>
        </div>
   {{--      </td> --}}
       
      @endforeach
    {{--  </tr> --}}
</div>
{{-- </tbody>
</table> --}}

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

<input class="row" style="margin-top: 20px;" type="text" name="subject" value="{{$templatename}}" placeholder="Subject"><br>
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

    @for($i=1;$i<=count($sortedvar);$i++)

        <div class="media">
          <div class="media-left">
            <div class="card">
        @for($j=0;$j<count($sortedvar[$i]);$j++)
       
              <div class="card-content">
                 {{$sortedvar[$i][$j]['lastname']}}, {{$sortedvar[$i][$j]['firstname']}}
                 {{-- {{$sortedvar[$i][$j]['groupName']}} --}}

              </div>
        @endfor
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
</div>
  <div class="row justify-content-start ml-2 mb-2" style="float: right; margin-right: 50px;">
    <a class="btn btn-info" href="{{route('Template',['upgid'=>$upgid])}}">  Back</a>
    </div>
</div>
@endif
</div>
@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
 <script type="text/javascript">
        $(document).ready(function () {
            $('#template-table').DataTable();
        });
    </script>  
@endsection

