@extends('mastertemplate')
@section('menu')
<li class="nav-item">
              <a class="nav-link" href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="{{route('showDep',['upgid'=>$upgid,'id'=>$admingroup])}}" data-placement="right" title="Inbox">
                <i class="material-icons">business</i>
               <p>Departments</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="{{route('viewRolePage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">event_seat</i>
                <p>Positions</p>
              </a>
 </li>

 <li class="nav-item active">
              <a class="nav-link" href="{{route('viewWorkflow',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">group</i>
               <p>Workflows</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="{{route('viewOwners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">description</i>
                <p>Templates</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="#" data-placement="right" title="Inbox">
                <i class="material-icons">archive</i>
                <p>Archive</p>
              </a>
 </li>
@endsection

@section('main_content')
<div class="row" style="margin-left: 60px; margin-top: 20px">
  <a class="btn btn-info" href="{{route('viewWorkflow',['upgid'=>$upgid])}}">Back</a>
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
    <a class="btn btn-info" href="#" onclick="openAdd()">Add Step</a>
  @endif
  
</div>
    <!--Sorted List-->
 <div class="row" style="margin-top: 20px;"> 
  {{-- <div class="media"> --}}
  @if(count($steps2)>0)
  @for($a=0;$a<(count($steps2));$a++)
  <div class="col-sm-3">
  <div class="card col-xs-10" style="border:1px solid black; margin: auto; margin-bottom: 15px;">
    @for($b=0;$b<(count($steps2[$a]));$b++)

        @if($b==0)
          <div class="btn-group btn-group-justified">
             <div class="btn-group">
               <a class="btn" href="javascript:openForPrevModal({{$steps2[$a][$b]['ws_id']}})" id="openForPrevModal" data-toggle="tooltip" data-placement="top" title="Add Previous Step">
                <i class="material-icons">arrow_back</i>
               </a>
             </div>
              <div class="btn-group">
               <a class="btn" href="javascript:openSameOrderModal({{$steps2[$a][$b]['ws_id']}})" id="openSameOrderModal" data-toggle="tooltip" data-placement="top" title="Add Same Step">
                   <i class="material-icons">add</i>
               </a>
             </div>
              <div class="btn-group">
               <a class="btn" href="javascript:openForNextModal({{$steps2[$a][$b]['ws_id']}})" id="openForNextModal" data-toggle="tooltip" data-placement="top" title="Add Next Step">
                  <i class="material-icons">arrow_forward</i>
               </a>
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
                  <h6>
                    <a href="javascript:openEditModal({{$steps2[$a][$b]['ws_id']}})" id="openEditModal">{{$steps2[$a][$b]['posName']}}</a>
                  </h6>
                </td>
                <td>
                  <a style="margin-left: 20px;" href="javascript:openDeleteModal({{$steps2[$a][$b]['ws_id']}})" id="openDeleteModal"><i class="material-icons">delete</i></a>
                </td>
              </tr>
              </tbody>
            </table>   
                
            </div>

          </div>
          </div>

  <?php $currentwsid = $steps2[$a][$b]['ws_id']; ?>


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
          var html2 = "<div class='col-md-12'><input type='checkbox' name='all' class='all' value='All' id='checkAllNext' checked>All</div>";
          $('#fornextusers-'+wsid).append(html2);
          for(var c=0; c<data.length; c++)
          {
            var html = "<div class='col-md-4'>";
            html+="<input type='checkbox' class='nextrec' name='wfsrecnext[]' value='"+data[c].upg_id+"' checked>";
            html+=" "+data[c].lastname+", "+data[c].firstname+" ("+data[c].groupName+")";
            html+="</div>";
            console.log(html);
            $('#fornextusers-'+wsid).append(html);
            setCheckRecipientNext();
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
          var html2 = "<div class='col-md-12'><input type='checkbox' name='all' value='All' id='checkAllPrev' checked>All</div>";
          $('#forprevusers-'+wsid).append(html2);
           for(var c=0; c<data.length; c++)
          {
            var html = "<div class='col-md-4'>";
            html+="<input type='checkbox' class='prevrec' name='wfsrecprev[]' value='"+data[c].upg_id+"' checked>";
            html+=" "+data[c].lastname+", "+data[c].firstname+" ("+data[c].groupName+")";
            html+="</div>";
            console.log(html);
            $('#forprevusers-'+wsid).append(html);
            setCheckRecipientPrev();
          }
        }
      });
    });

     $('#sameorderpos-'+wsid).change(function(){
      var posid = $(this).val();
      $.ajax({
        type: 'GET',
        url: 'http://localhost:8000/admin/posusers/'+posid,
        success: function(data){
          console.log(data);
          $('#sameorderusers-'+wsid).empty();
          var html2 = "<div class='col-md-12'><input type='checkbox' name='all' value='All' id='checkAllSame' checked>All</div>";
          $('#sameorderusers-'+wsid).append(html2);
           for(var c=0; c<data.length; c++)
          {
            var html = "<div class='col-md-4'>";
            html+="<input type='checkbox' class='samerec' name='wfsrecsame[]' value='"+data[c].upg_id+"' checked>";
            html+=" "+data[c].lastname+", "+data[c].firstname+" ("+data[c].groupName+")";
            html+="</div>";
            console.log(html);
            $('#sameorderusers-'+wsid).append(html);
            setCheckRecipientSame();
          }
        }
      });
    });

    //if all is checked, all are checked, if one is unchecked, uncheck all button
    //var fornextcheckboxes = $('#fornextusers input[type=checkbox]:not(:first)');

    function setCheckRecipientNext(){

      $('#checkAllNext').change(function(){
      //$("input[name='wfrsec']").prop('checked', this.checked);
        if($(this).is(':checked'))
        {
          $('.nextrec').prop('checked', true);
        }
        else
        {
          $('.nextrec').prop('checked', false);
        }
        //console.log('checked');
      });

      $('.nextrec').change(function(){
        $('#checkAllNext').prop('checked', false);

        var nxtcheck = $('.nextrec');
        if(nxtcheck.length==nxtcheck.filter(":checked").length)
        {
          $('#checkAllNext').prop('checked', true);
        }
      });

      // if($('.nextrec :checkbox:not(:checked)').length == 0)
      //   {
      //     $('#checkAllNext').prop('checked', true);
      //   }

    }

    function setCheckRecipientPrev(){

      $('#checkAllPrev').change(function(){
      //$("input[name='wfrsec']").prop('checked', this.checked);
        if($(this).is(':checked'))
        {
          $('.prevrec').prop('checked', true);
        }
        else
        {
          $('.prevrec').prop('checked', false);
        }
        //console.log('checked');
      });

      $('.prevrec').change(function(){
        $('#checkAllPrev').prop('checked', false);

        var prevcheck = $('.prevrec');
        if(prevcheck.length==prevcheck.filter(":checked").length)
        {
          $('#checkAllPrev').prop('checked', true);
        }
      });

    }

    function setCheckRecipientSame(){

      $('#checkAllSame').change(function(){
      //$("input[name='wfrsec']").prop('checked', this.checked);
        if($(this).is(':checked'))
        {
          $('.samerec').prop('checked', true);
        }
        else
        {
          $('.samerec').prop('checked', false);
        }
        //console.log('checked');
      });

      $('.samerec').change(function(){
        $('#checkAllSame').prop('checked', false);

        var samecheck = $('.samerec');
        if(samecheck.length==samecheck.filter(":checked").length)
        {
          $('#checkAllSame').prop('checked', true);
        }
      });

    }

    function setCheckRecipientFirst(){

      $('#checkAllFirst').change(function(){
      //$("input[name='wfrsec']").prop('checked', this.checked);
        if($(this).is(':checked'))
        {
          $('.firstrec').prop('checked', true);
        }
        else
        {
          $('.firstrec').prop('checked', false);
        }
        //console.log('checked');
      });

      $('.firstrec').change(function(){
        $('#checkAllFirst').prop('checked', false);

        var samecheck = $('.firstrec');
        if(samecheck.length==samecheck.filter(":checked").length)
        {
          $('#checkAllFirst').prop('checked', true);
        }
      });

    }
    

  });
</script>





<div id="openEditModal-{{$steps2[$a][$b]['ws_id']}}" class="modal" style="top:-40px;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Modal</h4>
      </div>
      <form class="form-horizontal" method="post" action="{{route('editStepAction',['upgid'=>$upgid])}}">
        <div class="modal-body">
          {{csrf_field()}}
          <input type="hidden" name="editwsid" value="{{$steps2[$a][$b]['ws_id']}}">
          <input type="hidden" name="editwfid" value="{{$steps2[$a][$b]['workflow_w_id']}}">
          <div class="form-group">
            <label class="col-sm-2 control-label">{{$steps2[$a][$b]['posName']}}</label>
          </div>
          <div class="form-group">
            <div class="justify-content-between">
              <label class="col-sm-2 control-label">Recipients</label>
              <a href="javascript:openRecList({{$steps2[$a][$b]['ws_id']}})">Edit</a>
            </div>
             <div class="row col-sm-12" id="editStep-{{$steps2[$a][$b]['ws_id']}}">
               <?php

                $stepinfos = DB::table('wsreceiver as wsr')->where('wsr.ws_id','=',$steps2[$a][$b]['ws_id'])->get();
              foreach ($stepinfos as $stepinfo) {
                $receiver = $stepinfo->receiver;
              }

                $recipientlist = DB::table('wsreceiver as wsr')->where('wsr.ws_id','=',$steps2[$a][$b]['ws_id'])
                                                                ->join('userpositiongroup as upg','wsr.receiver','upg.upg_id')
                                                                // ->where('upg.upg_status','=','active')
                                                                ->join('user as u','upg.user_user_id','u.user_id')
                                                                ->join('group as g','upg.group_group_id','g.group_id')
                                                                ->get();
                  if($receiver=="All")
                  {
                      $allposusers = DB::table('userpositiongroup as upg')->where('upg.position_pos_id','=',$steps2[$a][$b]['pos_id'])
                                                                          ->where('upg.upg_status','=','active')
                                                                          ->join('user as u','upg.user_user_id','u.user_id')
                                                                          ->join('group as g','upg.group_group_id','g.group_id')
                                                                          ->get();
                        foreach ($allposusers as $allposuser) {
                           echo "<div class='col-md-4'><div class='col-md-12'>".$allposuser->lastname.", ".$allposuser->firstname."(".$allposuser->groupName.")"."</div></div>";
                        }
                  }
                  else
                  {
                    foreach ($recipientlist as $recipient) {
                    echo "<div class='col-md-4'><div class='col-md-12'>".$recipient->lastname.", ".$recipient->firstname."(".$recipient->groupName.")"."</div></div>";
                  }
                }
               ?>
            </div>
          </div>

          <div class="form-group">
            Action: @if($steps2[$a][$b]['action']=="sign")
                       <input type="radio" name="action" value="sign" checked="checked"> Sign
                        <input type="radio" name="action" value="cc"> Carbon Copy<br> 
                    @else
                      <input type="radio" name="action" value="sign"> Sign
                        <input type="radio" name="action" value="cc" checked="checked"> Carbon Copy<br>
                    @endif
          </div>
        </div>
        <div class="modal-footer">
           <input class="btn btn-info" type="submit" name="addNext" value="Submit"> <a class="btn btn-info" href="javascript:closeEditModal({{$steps2[$a][$b]['ws_id']}})">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="openRecList-{{$steps2[$a][$b]['ws_id']}}" class="modal" style="top:-40px;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="justify-content-between">
          <h4 class="modal-title">Recipients</h4>
          <input type="text" name="searchuser" id="searchuser-{{$steps2[$a][$b]['ws_id']}}"><a href="#">Search</a>
        </div>
      </div>
      <form method="post" action="{{route('editStepRecs',['upgid'=>$upgid])}}">
      <div class="modal-body">
        {{csrf_field()}}
        <input type="hidden" name="editstepwsid" value="{{$steps2[$a][$b]['ws_id']}}">
        <input type="hidden" name="editstepwfid" value="{{$steps2[$a][$b]['workflow_w_id']}}">
        <div class="form-group">
          <div id="viewRecList-{{$steps2[$a][$b]['ws_id']}}">
            <?php
              //all check button (temporary code)
              $stepinfos = DB::table('wsreceiver as wsr')->where('wsr.ws_id','=',$steps2[$a][$b]['ws_id'])->get();
              foreach ($stepinfos as $stepinfo) {
                $receiver = $stepinfo->receiver;
              }
             // echo "<input type='checkbox' name='wfrsec' value='All' id='checkAll' checked>All<br>";
              //get recipients where ws_id = $steps2[$a][$b]['ws_id']
              $recipients = DB::table('wsreceiver as wsr')->where('wsr.ws_id','=',$steps2[$a][$b]['ws_id'])
                                                          ->join('userpositiongroup as upg','wsr.receiver','upg.upg_id')
                                                          ->join('user as u','upg.user_user_id','u.user_id')
                                                          ->join('group as g','upg.group_group_id','g.group_id')
                                                          ->orderBy('g.groupName')
                                                          ->get();
                //turn object (recipients) into array
                $arr_recipients = array();
                foreach ($recipients as $recipient) {
                  $arr_recipients[] = $recipient->upg_id;
                  //$rec = $recipient->receiver;
                }

              $posusers = DB::table('userpositiongroup as upg')->where('upg.position_pos_id','=',$steps2[$a][$b]['pos_id'])
                                                              ->where('upg.upg_status','=','active')
                                                               ->join('user as u','upg.user_user_id','u.user_id')
                                                              ->join('group as g','upg.group_group_id','g.group_id')
                                                              ->get();
              if($receiver=="All")                                                
                echo "<input type='checkbox' name='all' value='All' checked>All<br>";
              else
                echo "<input type='checkbox' name='all' value='All'>All<br>";

              foreach ($posusers as $posuser) {
                if($receiver=="All")
                {
                  echo "<input type='checkbox' name='wfsrec[]' value=".$posuser->upg_id." checked> ".$posuser->lastname.", ".$posuser->firstname."(".$posuser->groupName.")"."<br>";
                }
                else{
                  if(in_array($posuser->upg_id,$arr_recipients))
                  {
                    echo "<input type='checkbox' name='wfsrec[]' value=".$posuser->upg_id." checked> ".$posuser->lastname.", ".$posuser->firstname."(".$posuser->groupName.")"."<br>";
                  }
                  else
                  {
                    echo "<input type='checkbox' name='wfsrec[]' value=".$posuser->upg_id."> ".$posuser->lastname.", ".$posuser->firstname."(".$posuser->groupName.")"."<br>";
                  }
              }
              }
            ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <input class="btn btn-info" type="submit" name="addNext" value="Save"> <a class="btn btn-info" href="javascript:closeRecList({{$steps2[$a][$b]['ws_id']}})">Cancel</a>
      </div>
      </form>
    </div>
  </div>
</div>

<div id="addNext-{{$steps2[$a][$b]['ws_id']}}" class="modal" style="top:-40px;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Add Next</h4>
      </div>
      <form class="form-horizontal" method="post" action="{{route('addNextStep',['upgid'=>$upgid])}}">
      <div class="modal-body">
        {{csrf_field()}}
        <input type="hidden" name="fornextwsid" id="fornextwsidtext" value="{{$steps2[$a][$b]['ws_id']}}"> <input type="hidden" name="fornextorder" value="{{$steps2[$a][$b]['order']}}"> <input type="hidden" name="fornextwfid" value="{{$steps2[$a][$b]['workflow_w_id']}}">
        <div class="form-group">
          <label class="col-sm-2 control-label">Position</label>
          <div class="col-sm-10">
            <select id="fornextpos-{{$steps2[$a][$b]['ws_id']}}" name="fornextpos" class="form-control">
                <option value="none">--Choose position--</option>
                @if(isset($positions))
                @foreach($positions as $pos)
                @if($pos->posName!="Admin" && $pos->posName!="masteradmin" && $pos->posName!="Student")
                    <option value="{{$pos->pos_id}}">{{$pos->posName}}</option>
                @endif
                @endforeach
                @endif
                {{--  @for($a=0;$a<count($posarray);$a++)
                  <option value="{{$posarray[$a]['pos_id']}}">{{$posarray[$a]['posName']}}</option>
                @endfor --}}
                </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Recipients</label>
            <div class="row col-sm-12 userlistdiv" id="fornextusers-{{$steps2[$a][$b]['ws_id']}}">
         
            </div>

        </div>
         Action: <input type="radio" name="action" value="sign" checked="checked"> Sign
              <input type="radio" name="action" value="cc"> Carbon Copy<br>
      
      </div>
      <div class="modal-footer">
        <input class="btn btn-info" type="submit" name="addNext" value="Submit"> <a class="btn btn-info" href="javascript:closeForNext({{$steps2[$a][$b]['ws_id']}})">Cancel</a>
      </div>
      </form>
    </div>
  </div>
</div>

<div id="addPrev-{{$steps2[$a][$b]['ws_id']}}" class="modal" style="top:-40px;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Previous</h4>
      </div>
      <form class="form-horizontal" method="post" action="{{route('addPrevStep',['upgid'=>$upgid])}}">
      <div class="modal-body">
         {{csrf_field()}}
        <input type="hidden" name="forprevwsid" value="{{$steps2[$a][$b]['ws_id']}}"> <input type="hidden" name="forprevorder" value="{{$steps2[$a][$b]['order']}}"> <input type="hidden" name="forprevwfid" value="{{$steps2[$a][$b]['workflow_w_id']}}">

          <div class="form-group">
            <label class="col-sm-2 control-label">Position</label>
            <div class="col-sm-10">
              <select id="forprevpos-{{$steps2[$a][$b]['ws_id']}}" name="forprevpos" class="form-control">
                 <option value="none">--Choose position--</option>
                 @if(isset($positions))
                @foreach($positions as $pos)
                 @if($pos->posName!="Admin" && $pos->posName!="masteradmin" && $pos->posName!="Student")
                    <option value="{{$pos->pos_id}}">{{$pos->posName}}</option>
                @endif
                @endforeach
                @endif
                 {{-- @for($a=0;$a<count($posarray);$a++)
                  <option value="{{$posarray[$a]['pos_id']}}">{{$posarray[$a]['posName']}}</option>
                @endfor --}}
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Recipients</label>
            <div class="row col-sm-12 userlistdiv" id="forprevusers-{{$steps2[$a][$b]['ws_id']}}">
              
            </div>
          </div>

            Action: <input type="radio" name="action" value="sign" checked="checked"> Sign
              <input type="radio" name="action" value="cc"> Carbon Copy<br>

      </div>
        <div class="modal-footer">
        <input class="btn btn-info" type="submit" name="addPrev" value="Submit"> <a class="btn btn-info" href="javascript:closeForPrev({{$steps2[$a][$b]['ws_id']}})" id="cancelForPrev">Cancel</a>
      </div>
    </form>
    </div>
  </div>
</div>

<div id="addSameOrder-{{$steps2[$a][$b]['ws_id']}}" class="modal" style="top:-40px;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Same Order</h4>
      </div>
       <form class="form-horizontal" method="post" action="{{route('addSameOrderStep',['upgid'=>$upgid])}}">
      <div class="modal-body">
         {{csrf_field()}}
        <input type="hidden" name="sameorderwsid" value="{{$steps2[$a][$b]['ws_id']}}"> <input type="hidden" name="sameorderorder" value="{{$steps2[$a][$b]['order']}}"> <input type="hidden" name="sameorderwfid" value="{{$steps2[$a][$b]['workflow_w_id']}}">

          <div class="form-group">
            <label class="col-sm-2 control-label">Position</label>
            <div class="col-sm-10">
              <select id="sameorderpos-{{$steps2[$a][$b]['ws_id']}}" name="sameorderpos" class="form-control">
                 <option value="none">--Choose position--</option>
                 @if(isset($positions))
                @foreach($positions as $pos)
                 @if($pos->posName!="Admin" && $pos->posName!="masteradmin" && $pos->posName!="Student")
                    <option value="{{$pos->pos_id}}">{{$pos->posName}}</option>
                  @endif
                @endforeach
                @endif
               {{--   @for($a=0;$a<count($posarray);$a++)
                  <option value="{{$posarray[$a]['pos_id']}}">{{$posarray[$a]['posName']}}</option>
                @endfor --}}
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Recipients</label>
            <div class="row col-sm-12 userlistdiv" id="sameorderusers-{{$steps2[$a][$b]['ws_id']}}">
              
            </div>
          </div>

            Action: <input type="radio" name="action" value="sign" checked="checked"> Sign
              <input type="radio" name="action" value="cc"> Carbon Copy<br>

      </div>
        <div class="modal-footer">
        <input class="btn btn-info" type="submit" name="addSameOrder" value="Submit"> <a class="btn btn-info" href="javascript:closeSameOrderModal({{$steps2[$a][$b]['ws_id']}})">Cancel</a>
      </div>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  function openEditModal(wsid)
  { 
    var modal2 = document.getElementById('openEditModal-'+wsid);
      modal2.style.display = "block";
  }

  function closeEditModal(wsid) {
    var modal2 = document.getElementById('openEditModal-'+wsid);
    modal2.style.display = "none";
  }

function openRecList(wsid)
{
  var recmodal = document.getElementById('openRecList-'+wsid);
  recmodal.style.display = "block";
}

function closeRecList(wsid)
{
  var recmodal = document.getElementById('openRecList-'+wsid);
  recmodal.style.display = "none";
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

function openSameOrderModal(wsid)
{
  var samelvlmodal = document.getElementById('addSameOrder-'+wsid);
  samelvlmodal.style.display = "block";
}

function closeSameOrderModal(wsid)
{
  var samelvlmodal = document.getElementById('addSameOrder-'+wsid);
  samelvlmodal.style.display = "none";
}

function openDeleteModal(wsid)
{
  var deleteStepModal = document.getElementById('deleteModal-'+wsid);
  deleteStepModal.style.display = "block";
}

function closeDeleteModal(wsid)
{
  var deleteStepModal = document.getElementById('deleteModal-'+wsid);
  deleteStepModal.style.display = "none";
}

</script>

 <!--Delete Modal-->
 <div id="deleteModal-{{$steps2[$a][$b]['ws_id']}}" class="modal">
  <div class="modal-dialog" role="document" style="width: 200px;">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title">Remove Step?</p>
      </div>
       <form method="post" action="{{route('RemoveWs',['upgid'=>$upgid])}}">
      <div class="modal-body">
            <input type="hidden" name="removewsid" value="{{$steps2[$a][$b]['ws_id']}}">
            <input type="hidden" name="removewfid" value="{{$steps2[$a][$b]['workflow_w_id']}}">
            <input type="hidden" name="removeorder" value="{{$steps2[$a][$b]['order']}}">
            {{csrf_field()}}
          
            <input type="hidden" name="wsid" value="{{$steps2[$a][$b]['ws_id']}}">
            <div class="btn-toolbar justify-content-between">
            <input class="btn btn-info" type="submit" name="deleteWs" value="YES">
            <input class="btn btn-info" type="button" id="no" onclick = "closeDeleteModal({{$steps2[$a][$b]['ws_id']}})" value="NO">
            </div>
      
      </div>
    </form>
     </div>   
    </div>
    </div>

    <?php $currstep = $steps2[$a][$b]['order']; ?>
    
    @endfor

</div>
  </div>
    @if($currstep!=count($steps2))
<div>
  <i class="material-icons" style="font-size: 30px; margin-top:60px;">forward</i>
</div>
@endif
{{--end of card div--}} 
{{-- @if($steps2[$a] != (count($steps2)-1))
<div>
  <i class="material-icons" style="font-size: 30px; margin: auto;">forward</i>
</div>
@endif --}}

  @endfor

  @endif
{{-- </div> --}}
</div>
{{--   @elseif(count($steps2)==0) --}}
  <div id="addModal" class="modal" style="top:-40px;">
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
                @if(isset($positions))
                @foreach($positions as $pos)
                @if($pos->posName!='Admin' && $pos->posName!='masteradmin' && $pos->posName!='Student')
                    <option value="{{$pos->pos_id}}">{{$pos->posName}}</option>
                @endif
                @endforeach
                @endif
                </select><br><br>
      </div>
     <div class="form-group">
          <label class="col-sm-2 control-label">Recipients</label>
            <div class="row col-sm-12 userlistdiv" id="posusers">
            </div>
        </div>
                
      Action: <input type="radio" name="action" value="sign" checked="checked"> Sign
              <input type="radio" name="action" value="cc"> Carbon Copy<br>
            <div class="modal-footer">
                <input class="btn btn-info" type="submit" name="addNewStep" value="Add"> <a class="btn btn-info" href="javascript:closeAdd()">Cancel</a>
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
          var html2 = "<div class='col-md-12'><input type='checkbox' name='all' value='All' id='checkAllFirst' checked>All</div>";
          $('#posusers').append(html2);
          for(var c=0; c<data.length; c++)
          {
            var html = "<div class='col-md-4'>";
            html+="<input type='checkbox' class='firstrec' name='wfsrec[]' value='"+data[c].upg_id+"' checked>";
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

@endforeach
@endsection

@section('js')
{{--  <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  --}} 
<script type="text/javascript" src="{{URL::asset('js/doctrack.js')}}"></script>
@endsection