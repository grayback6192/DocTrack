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

<div class="row" id="tempresults">
@foreach($template as $templates)
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
@endforeach
</div>
@endif

{{-- Input Type --}}
@if(isset($variable))
<div class="container">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style = " background-color:orange; margin-left:62px; position:absolute" >Open Template</button>

<div class="row justify-content-between">
<div class="media">
<form method = "post">


<div class="media-left">
<div class="col-md-offset-1" style="padding-top: 60px;">
  <div class = "form-group">
    <label for="subject"><h4><b>Subject</b></h4></label>
    <input class="form-control" id = "subject" type="text" name="subject" value="{{$templatename}}" placeholder="Subject"><br>
  </div>
<table width = 1000>
  
  {{ csrf_field() }}
{{-- Variable Form --}}
  @foreach($variable as $variables)
    @if(str_contains($variables,'Body') || str_contains($variables,'body'))
     @if($loop->index%5 == 0)
      </tr>
      <tr>
    @endif
      <td>
      <div class = "form-group" style = "padding-right: 15px;width: 185px;">
        <label for="{{ $variables }}"><b>{{ $variables }}</b></label>
          <textarea id = "textarea" class="form-control" rows = 5 cols = 40 name = "{{$variables}}" style = "margin-top:0px"></textarea><br>
      </div>
    </td>
  @elseif(str_contains($variables,'Date') || str_contains($variables,"date"))
    @if($loop->index%5 == 0)
      </tr>
      <tr>
    @endif
    <td>
      <div class = "form-group" style = "padding-right: 15px;width: 185px;">
        <label for="{{ $variables }}"><b>{{ $variables }}</b></label>
          <input type = "text" class="form-control date"  placeholder = "{{$variables}}" name = "{{ $variables }}"><br>
      </div>
    </td>
  @else
    @if($loop->index%5 == 0)
  </tr>
      <tr>
    @endif
      <td>
        <div class = "form-group" style = "padding-right: 15px;width: 185px;">
        <label for="{{ $variables }}"><b>{{ $variables }}</b></label>
        <input type = "text" name = "{{ $variables }}" class="form-control" placeholder = "{{ $variables }}"><br>
        </div>
      </td>
    @endif
  @endforeach
</table>
<small class="form-text text-muted"><i>Values written in ${} will be replaced in the form. Please refer by opening the template button above.</i></small>
@if(isset($position))
@foreach($position as $positions)
<input type = "text" id = "positions" name = "{{ $positions }}" placeholder = "{{ $positions }}" value = "<?php echo '${'.$positions.'}' ?>" hidden><br>
@endforeach
@endif


{{-- Modal Content --}}
 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style = "padding-right: 74px;padding-left: 56px;">
          <object data="/pdf/{{ $id->templatename }}.pdf" type="application/pdf" width="500" height="350"></object><br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<input class="btn btn-primary" style = "background-color:green"type = "submit" formaction = "{{route('postDoc',['id'=>$id->template_id])}}" value = "Send">
<input class="btn btn-primary" type = "submit" formaction = '/templateView/{{ $id->template_id }}' value = "Preview Document">
</div>
</div>


  <div class="media-body">
  <div class="col-sm-7 col-md-offset-3"> 
  <div class="col-md-offset-10" style="margin-bottom: 10px;">
  </div>

</div>

 </div>
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
 <script type="text/javascript">
    $(document).ready(function () {
        $('#template-table').DataTable();
         $(".date").datepicker({ dateFormat: 'MM dd, yy' });
    });
    </script>  
@endsection

