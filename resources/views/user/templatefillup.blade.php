@extends('mastertemplate')
@section('menu')
<li class="nav-item active">
  <a class="nav-link" href="{{route('Template',['upgid'=>$upgid])}}">
    <i class="material-icons">send</i>
    <p>Send File</p>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{route('viewInbox',['upgid'=>$upgid])}}">
   <i class="material-icons">mail</i>
   <p>
    Inbox
    @if($numUnread>0)
    ({{$numUnread}})
    @endif 
  </p>

</a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{route('viewSent',['upgid'=>$upgid])}}">
   <i class="material-icons">drafts</i>
   <p>
    In progress
    @if($numinprogress>0)
    ({{$numinprogress}})
    @endif 
  </p>
</a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{route('complete',['upgid'=>$upgid])}}">
    <i class="material-icons">drafts</i>
    <p>
    Archive</p>
  </a>
</li>

@endsection

@section('main_content')
<script type="text/javascript" src="{{URL::asset('js/jquery-3.2.1.min.js')}}" ></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
      <div id="results"></div>
      <div class="row">
        {{-- title for creating new document --}}
  <div class="card ">
   <div class="card-header card-header-warning">
    <h4 class="card-title ">Create New Document</h4>
    <p class="card-category">This section lets you create new document.</p>
  </div>

        <div class="col-lg-4 col-md-6 col-sm-12 ">                           
         <a href="{{route('test',['upgid'=>$upgid])}}">
          <div class="card card-stats bg-secondary">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">folder_open</i>
              </div>
              <h3 class="card-title text-white">Create Document</h3>
              <p class="card-category text-white"><small>Allows you to create a new document file</small></p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">warning</i>
                <a href="" class="warning-link">User</a>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
    </div>
{{--   </div> --}}


<div class="row">
<div class="card">
   <div class="card-header card-header-warning">
    <h3 class="card-title">Choose Document</h3>
    <p class="card-category">This section lets you choose document.</p>
  </div>
{{-- for searching the existing document file --}}
  <div class="">
   <form class="navbar-form navbar-right" role="search" style="color: gray;">
    <div class="form-group  is-empty">
      Search: <input type="text" name="tempsearch" id="tempsearch">
    </div>
  </form>
</div>


   

<div id="tempresults">
  @foreach($template as $templates)

        <div class="col-lg-4 col-md-6 col-sm-12 temp" id="{{$templates->template_id}}">                           
          <a href="/user/{{$upgid}}/send/templateInput/{{ $templates->template_id }}">
          <div class="card card-stats bg-secondary" >
            <div class="card-header card-header-warning card-header-icon" data-background-color="orange">
              <div class="card-icon">
                <i class="material-icons">description</i>
              </div>
              <h3 class="card-title text-white">{{$templates->templatename}}</h3>
              <p class="card-category text-white"><small>{{$templates->groupName}}</small></p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">warning</i>
                <a href="" class="warning-link">User</a>
              </div>
            </div>
          </div>
        </a>
      </div>
  @endforeach
</div>
</div>
</div>
@endif

{{-- Input Type --}}
@if(isset($variable))
<div class="container">
  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal" style = "margin-left:62px; position:absolute">Open Template</button><br><br>

  <div class="row">
    <div class="media">
      <form method = "post">
        <div>
          <div>
            <div class = "form-group" style = "margin-left:79px">
              <label for="subject"><h4><b>Subject</b></h4></label>
              <div class = "form-group">
                <input class="form-control" id = "subject" type="text" name="subject" value="{{$templatename}}" placeholder="Subject"><br>
              </div>
              {{csrf_field()}}
              <div class = "input-container">
                @foreach($variable as $variables)
                @php $count = $loop->index; @endphp
                @if($count%5 == 0)
              </ul>
              <ul>
                @endif
                @if(str_contains($variables,'Body') || str_contains($variables,'body'))
                <li>
                  <div class = "form-group" style = "padding-right: 15px;width: 200px;">
                    <label for="{{ $variables }}"><b>{{ $variables }}</b></label>
                    <textarea id = "textarea" class="form-control" rows = 5 cols = 40 name = "{{ str_replace(" ","_",$variables) }}" style = "margin-top:0px"></textarea></div>
                  </div>
                </li>
                @elseif(str_contains($variables,'Date') || str_contains($variables,"date"))
                <li>
                  <div class = "form-group" style = "padding-right: 15px;width: 200px;">
                   <label for="{{ $variables }}"><b>{{ $variables }}</b></label>
                   <input type = "text" class="form-control date"  placeholder = "{{$variables}}" name = "{{ str_replace(" ","_",$variables) }}">
                 </div>
               </li>
               @elseif(str_contains($variables,'Sender') || str_contains($variables,'sender'))
               @foreach($sender as $senders)
               <div hidden>
                <input type = "text" name = "{{ $variables }}" class="form-control" placeholder = "{{ $variables }}" value = '(SGD), {{$senders->lastname}}, {{$senders->firstname}}' hidden >
              </div>
              @endforeach
              @else
              <li>
                <div class = "form-group" style = "padding-right: 15px;width: 200px;">
                  <label for="{{ $variables }}"><b>{{ $variables }}</b></label>
                  <input type = "text" name = "{{ str_replace(" ","_",$variables) }}" class="form-control" placeholder = "{{ $variables }}">
                </div>
              </li>
              @endif
              @endforeach
            </ul>
          </div>
          <small class="form-text text-muted"><i>Values written in ${} will be replaced in the form. Please refer by opening the template button above.</i></small>
          @if(isset($position))
          @foreach($position as $positions)
          <input type = "text" id = "positions" name = "{{ $positions }}" placeholder = "{{ $positions }}" value = "<?php echo '${'.$positions.'}' ?>" hidden><br>
          @endforeach
          @endif
          <br><input class="btn btn-info" type ="submit" formaction = "{{route('postDoc',['id'=>$id->template_id])}}" value = "Send">
          <input class="btn btn-warning" type = "submit" formaction = '/templateView/{{ $id->template_id }}/{{$upgid}}' value = "Preview Document">
        </div>
      </div>
    </div>
  </div>
</div>
</form>
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

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog" role = "document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <object data="/pdf/{{ $id->templatename }}.pdf" type="application/pdf" width="480" height="350"></object><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading text-light">
    <h3>Document Workflow</h3>
  </div>
  <div class="panel-body">
    <div class="row justify-content-start">

      @for($i=1;$i<=count($sortedvar);$i++)

      <div class="media">
        <div class="media-left">
          <div class="card bg-secondary">
            @for($j=0;$j<count($sortedvar[$i]);$j++)

            <div class="card-content text-white">
             {{$sortedvar[$i][$j]['lastname']}}, {{$sortedvar[$i][$j]['firstname']}}

           </div>
           @endfor
         </div>
       </div>
       @if($i != (count($var)))
       <div class="media-right">
        <div style="margin-top: 30px;">
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
  <a class="btn btn-info" href="{{route('Template',['upgid'=>$upgid])}}">Back</a>
</div>

</div>

<br><br><br>

 {{-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" role = "document">
    
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
  </div> --}}

{{-- <div class="panel panel-default">
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
</div> --}}
  {{-- <div class="row justify-content-start ml-2 mb-2" style="float: right; margin-right: 50px;">
    <a class="btn btn-info" href="{{route('Template',['upgid'=>$upgid])}}">Back</a>
  </div> --}}
</div>
@endif
</div>

<style type="text/css">
.form-group ul 
{
  display:inline-block;
  list-style-type:none;
}
</style>

@endsection

@section('js')
<script type="text/javascript">
  $(document).ready(function () {
    $('#template-table').DataTable();
    $(".date").datepicker({ dateFormat: 'MM dd, yy' });
  });
</script>  
@endsection

