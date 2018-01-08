@extends('mastertemplate')
@section('menu')
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="fa fa-user fa-fw"></i>
                <span class="nav-link-text">
                  Users</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('showDep',['upgid'=>$upgid,'id'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <i class="fa fa-building fa-fw"></i>
                <span class="nav-link-text">
                  Departments</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewRolePage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="fa fa-star fa-fw"></i>
                <span class="nav-link-text">
                  Positions</span>
              </a>
 </li>

 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewWorkflow',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="fa fa-group fa-fw"></i>
                <span class="nav-link-text">
                  Workflows</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewOwners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="fa fa-file-o fa-fw"></i>
                <span class="nav-link-text">
                  Templates</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="#" data-placement="right" title="Inbox">
                <i class="fa fa-archive fa-fw"></i>
                <span class="nav-link-text">
                  Archive</span>
              </a>
 </li>

@endsection

@section('main_content')
<div class="row" style="margin-left: 60px; margin-top: 20px">
  <a class="btn btn-primary" href="{{route('viewWorkflow',['upgid'=>$upgid])}}">Back</a>
</div>
<div class="row" style="margin-left: 60px; margin-top: 20px;">
    @foreach($workflow as $flow)
    Workflow Name: {{$flow->workflowName}}
    {{-- <input type="text" name="wid" value="{{$flow->w_id}}"> --}}
</div>
<hr>
{{--begin card div--}}
<div class="row" style="margin-left: 60px; margin-top: 20px;">
    Workflow Details:&nbsp;&nbsp;&nbsp;
    {{-- <input type="button" id="addstep" value="Add Step" onclick="openAdd()"> --}}
  
  @if(count($steps)==0) 
    <a class="btn btn-primary" href="#" onclick="openAdd()">Add Step</a>
  @endif
  
</div>
    <!--Sorted List-->
 <div class="row" style="margin-left: 60px; margin-top: 20px;"> 
  @if(count($steps2)>0)
  @for($a=0;$a<(count($steps2));$a++)
  <div class="media">
  <div class="card" style="border:1px solid black; margin: auto;">
           {{-- <div class="btn-group btn-group-justified">
             <div class="btn-group">
               <a class="btn" href="#">Prev</a>
             </div>
              <div class="btn-group">
               <a class="btn" href="#">Add</a>
             </div>
              <div class="btn-group">
               <a class="btn" href="#">Next</a>
             </div>
          </div> --}}
    @for($b=0;$b<(count($steps2[$a]));$b++)

        @if($b==0)
          <div class="btn-group btn-group-justified">
             <div class="btn-group">
               <a class="btn" data-toggle="modal" href="javascript:openForPrevModal({{$steps2[$a][$b]['ws_id']}})" id="openForPrevModal">Prev</a>
             </div>
              <div class="btn-group">
               <a class="btn" href="#">Add</a>
             </div>
              <div class="btn-group">
               <a class="btn" data-toggle="modal" href="javascript:openForNextModal({{$steps2[$a][$b]['ws_id']}})" id="openForNextModal">Next</a>
             </div>
          </div>
        @endif
    <div class="card border-0">
      <div class="card-block px-2">
            <div class="row justify-content-center"> 
            <table class="table-sm">
            <tbody>
              <tr>
                <td>
                  <h6>{{$steps2[$a][$b]['posName']}}</h6>
                </td>
                <td>
                  <a data-toggle="modal" href="javascript:openDeleteModal({{$steps2[$a][$b]['ws_id']}})" id="openDeleteModal">Remove</a>
                </td>
              </tr>
              </tbody>
            </table>   
                
            </div>

          </div>
          </div>

     <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>
<script type="text/javascript">
  $(document).ready(function(){

    var wsid = <?php echo $steps2[$a][$b]['ws_id']; ?>;

    $('#fornextpos-'+wsid).change(function(){
      var posid = $(this).val();
      $.ajax({
        type: 'GET',
        url: 'http://localhost:8000/admin/posusers/'+posid,
        success: function(data){
          console.log(data);
          $('#fornextusers-'+wsid).empty();
          var html2 = "<div class='col-md-12'><input type='checkbox' name='wfrsec' value='All' id='checkAll' checked>All</div>";
          $('#fornextusers-'+wsid).append(html2);
          for(var c=0; c<data.length; c++)
          {
            var html = "<div class='col-md-4'>";
            html+="<input type='checkbox' name='wfsrec[]' value='"+data[c].upg_id+"' checked>";
            html+=" "+data[c].lastname+", "+data[c].firstname+" ("+data[c].groupName+")";
            html+="</div>";
            console.log(html);
            $('#fornextusers-'+wsid).append(html);
          }
        }
      });
    });

    $('#forprevpos-'+wsid).change(function(){
      var posid = $(this).val();
      $.ajax({
        type: 'GET',
        url: 'http://localhost:8000/admin/posusers/'+posid,
        success: function(data){
          console.log(data);
          $('#forprevusers-'+wsid).empty();
          var html2 = "<div class='col-md-12'><input type='checkbox' name='wfrsec' value='All' id='checkAll' checked>All</div>";
          $('#forprevusers-'+wsid).append(html2);
           for(var c=0; c<data.length; c++)
          {
            var html = "<div class='col-md-4'>";
            html+="<input type='checkbox' name='wfsrec[]' value='"+data[c].upg_id+"' checked>";
            html+=" "+data[c].lastname+", "+data[c].firstname+" ("+data[c].groupName+")";
            html+="</div>";
            console.log(html);
            $('#forprevusers-'+wsid).append(html);
          }
        }
      });
    });

    //if all is checked, all are checked, if one is unchecked, uncheck all button
    var fornextcheckboxes = $('#fornextusers input[type=checkbox]:not(:first)');
    
    // fornextcheckboxes.change(function()
    // {
    //   var allIsChecked = fornextcheckboxes.filter(:enabled:not(:checked)).size() === 0;
    //   all[0].checked = allIsChecked;      
    // });

    // var all = $('#checkAll').change(function(){
    //   fornextcheckboxes.filter(':enabled').attr("checked",this.checked);
    // });

    $('#checkAll').click(function(){
      $("input[name^='wfrsec']").prop('checked', this.checked);
    });
  });
</script>

<div id="addNext-{{$steps2[$a][$b]['ws_id']}}" class="modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Add Next</h4>
      </div>
      <form class="form-horizontal" method="post" action="{{route('addNextStep',['upgid'=>$upgid])}}">
      <div class="modal-body">
        {{csrf_field()}}
        <input type="text" name="fornextwsid" value="{{$steps2[$a][$b]['ws_id']}}"> <input type="text" name="fornextorder" value="{{$steps2[$a][$b]['order']}}"> <input type="text" name="fornextwfid" value="{{$steps2[$a][$b]['workflow_w_id']}}">
        <div class="form-group">
          <label class="col-sm-2 control-label">Position</label>
          <div class="col-sm-10">
            <select id="fornextpos-{{$steps2[$a][$b]['ws_id']}}" name="fornextpos" class="form-control">
                <option value="none">--Choose position--</option>
                @foreach($positions as $pos)
                    <option value="{{$pos->pos_id}}">{{$pos->posName}}</option>
                @endforeach
                </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Recipients</label>
            <div class="row col-sm-12" id="fornextusers-{{$steps2[$a][$b]['ws_id']}}">
         
            </div>

        </div>
         Action: <input type="radio" name="action" value="sign" checked="checked"> Sign
              <input type="radio" name="action" value="cc"> Carbon Copy<br>
      
      </div>
      <div class="modal-footer">
        <input class="btn btn-primary" type="submit" name="addNext" value="Submit"> <a class="btn btn-primary" href="javascript:closeForNext({{$steps2[$a][$b]['ws_id']}})">Cancel</a>
      </div>
      </form>
    </div>
  </div>
</div>

<div id="addPrev-{{$steps2[$a][$b]['ws_id']}}" class="modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Previous</h4>
      </div>
      <form class="form-horizontal" method="post" action="{{route('addPrevStep',['upgid'=>$upgid])}}">
      <div class="modal-body">
         {{csrf_field()}}
        <input type="text" name="forprevwsid" value="{{$steps2[$a][$b]['ws_id']}}"> <input type="text" name="forprevorder" value="{{$steps2[$a][$b]['order']}}"> <input type="text" name="forprevwfid" value="{{$steps2[$a][$b]['workflow_w_id']}}">

          <div class="form-group">
            <label class="col-sm-2 control-label">Position</label>
            <div class="col-sm-10">
              <select id="forprevpos-{{$steps2[$a][$b]['ws_id']}}" name="forprevpos" class="form-control">
                 <option value="none">--Choose position--</option>
                @foreach($positions as $pos)
                    <option value="{{$pos->pos_id}}">{{$pos->posName}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Recipients</label>
            <div class="row col-sm-12" id="forprevusers-{{$steps2[$a][$b]['ws_id']}}">
              
            </div>
          </div>

            Action: <input type="radio" name="action" value="sign" checked="checked"> Sign
              <input type="radio" name="action" value="cc"> Carbon Copy<br>

      </div>
        <div class="modal-footer">
        <input class="btn btn-primary" type="submit" name="addNext" value="Submit"> <a class="btn btn-primary" href="javascript:closeForPrev({{$steps2[$a][$b]['ws_id']}})">Cancel</a>
      </div>
    </form>
    </div>
  </div>
</div>

    <script type="text/javascript">


function openWsModal(wsid)
{
  
    var modal2 = document.getElementById('editWsModal-'+wsid);
    modal2.style.display = "block";
}

function closeModal(wsid) {
    var modal2 = document.getElementById('editWsModal-'+wsid);
    modal2.style.display = "none";
}

function openForNextModal(wsid)
{
  var nextmodal = document.getElementById('addNext-'+wsid);
  nextmodal.style.display = "block";
}

function closeForNext(wsid)
{
   var nextmodal = document.getElementById('addNext-'+wsid);
  nextmodal.style.display = "none";
}

function openForPrevModal(wsid)
{
  var prevmodal = document.getElementById('addPrev-'+wsid);
  prevmodal.style.display = "block";
}

function closeForPrev(wsid)
{
   var prevmodal = document.getElementById('addPrev-'+wsid);
  prevmodal.style.display = "none";
}

</script>

 <!--Delete Modal-->
 <div id="deleteModal-{{$steps2[$a][$b]['ws_id']}}" class="modal">
  <div class="modal-dialog" role="document" style="width: 200px;">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title">Remove Step?</p>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('RemoveWs',['upgid'=>$upgid,'wsid'=>$steps2[$a][$b]['ws_id']])}}">
            {{csrf_field()}}
          
            <input type="hidden" name="wsid" value="{{$steps2[$a][$b]['ws_id']}}">
            <div class="btn-toolbar justify-content-between">
            <input class="btn btn-primary" type="submit" name="deleteWs" value="YES">
            <input class="btn btn-primary" type="button" id="no" onclick = "closeDeleteModal({{$steps2[$a][$b]['ws_id']}})" value="NO">
            </div>
        </form>
      </div>
     </div>   
    </div>
    </div>

  {{--   <script type="text/javascript">
        function openDeleteModal(wsid)
        {
            var modal3 = document.getElementById('deleteModal-'+wsid);
            modal3.style.display = "block";
        }

        function closeDeleteModal(wsid)
        {
            var modal3 = document.getElementById('deleteModal-'+wsid);
            modal3.style.display = "none";
        }
    </script> --}}
      
    @endfor
</div>
{{--end of card div--}} 
<div class="ml-4 media-body" id="wf-arrow" style="margin: auto;">
  <i class="fa fa-arrow-right fa-fw"></i>
</div>
</div>
  @endfor

  @endif
{{--   @elseif(count($steps2)==0) --}}
  <div id="addModal" class="modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span class="close">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <form class="form-horizontal" method="post" action="{{route('postAddStep',['upgid'=>$upgid])}}">
    {{csrf_field()}}
    <input type="hidden" name="wid" value="{{$flow->w_id}}"><br>
     <div class="form-group">
          <label class="col-sm-2 control-label">Position</label>
      <div class="col-sm-10">
        <select id="pos" name="pos" class="form-control">
                <option value="none">--Choose position--</option>
                @foreach($positions as $pos)
                    <option value="{{$pos->pos_id}}">{{$pos->posName}}</option>
                @endforeach
                </select><br><br>
      </div>
     <div class="form-group">
          <label class="col-sm-2 control-label">Recipients</label>
            <div class="row col-sm-12" id="posusers">
            </div>
        </div>
                
      Action: <input type="radio" name="action" value="sign" checked="checked"> Sign
              <input type="radio" name="action" value="cc"> Carbon Copy<br>
            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" name="addNewStep" value="Add"> <a class="btn btn-primary" href="javascript:closeAdd()">Cancel</a>
            </div>
    </form>
    </div>
  </div>
</div>
</div>

     <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>
<script type="text/javascript">
      $('#pos').change(function(){
      var posid = $(this).val();
      console.log(posid);
      $.ajax({
        type: 'GET',
        url: 'http://localhost:8000/admin/posusers/'+posid,
        success: function(data){
          console.log(data);
          $('#posusers').empty();
          var html2 = "<div class='col-md-12'><input type='checkbox' name='all' value='All' id='checkAll' checked>All</div>";
          $('#posusers').append(html2);
          for(var c=0; c<data.length; c++)
          {
            var html = "<div class='col-md-4'>";
            html+="<input type='checkbox' name='wfsrec[]' value='"+data[c].upg_id+"' checked>";
            html+=" "+data[c].lastname+", "+data[c].firstname+" ("+data[c].groupName+")";
            html+="</div>";
            console.log(html);
            $('#posusers').append(html);
          }
        }
      });
    });

</script>

<script type="text/javascript">
  function openAdd(){
    var modal5 = document.getElementById('addModal');
    modal5.style.display = "block";
  }

  function closeAdd()
  {
    var modal6 = document.getElementById('addModal');
    modal6.style.display = "none";
  }
</script>




<br><br>
  {{-- <input type="button" id="addstep" value="Add Step"> --}}

     <!-- The Modal -->



  </div>

@endforeach
@endsection