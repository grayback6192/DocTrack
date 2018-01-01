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
   
    <a class="btn btn-primary" href="#" onclick="openAdd()">Add Step</a>
  
</div>
    <!--Sorted List-->
 <div class="row" style="margin-left: 60px; margin-top: 20px;"> 
  @if(count($steps2)>0)
  @for($a=0;$a<(count($steps2));$a++)
  <div class="media">
  <div class="card" style="width: 10rem;border:0">
    @for($b=0;$b<(count($steps2[$a]));$b++)
    <div class="card-block p-3">
        {{-- <th>Prev</th> --}}
        {{-- Position --}}
        {{-- <th>Next</th> --}}
        {{-- <th colspan="2"></th> --}}
    <div class="card" style="width: 10rem; border: 0.5px solid black">
      <div class="card-block p-3">
            <div class="row justify-content-center">    
                <h5>{{$steps2[$a][$b]['posName']}}</h5>
            </div>
            <div class="btn-toolbar justify-content-between mt-3">
                <a data-toggle="modal" href="javascript:openWsModal({{$steps2[$a][$b]['ws_id']}})" id="openWsModal">Edit</a>

                <a data-toggle="modal" href="javascript:openDeleteModal({{$steps2[$a][$b]['ws_id']}})" id="openDeleteModal">Remove</a>
            </div>
          </div>
          </div>
        {{--   @if($steps2[$a][$b]['next']!="")
      <script type="text/javascript">
        var div = document.getElementById('wf-arrow');
        div.style.display = "block";
      </script>
    @endif --}}
        </div>

  <div id="addModal" class="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span class="close">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <form method="post" action="{{route('postAddStep',['upgid'=>$upgid])}}">
    {{csrf_field()}}
    <input type="hidden" name="wid" value="{{$flow->w_id}}"><br>
    Position: <select id="pos" name="pos">
                <option value="none">--Choose position--</option>
                @foreach($positions as $pos)
                    <option value="{{$pos->pos_id}}">{{$pos->posName}}</option>
                @endforeach
                </select><br><br>
  <div style="display: block;">
    Previous: <br>   
                    <?php
                    $previous = array();
                    $previous[] = "";
                    
                        $ws = \DB::table('workflowsteps')->where('workflow_w_id','=',$flow->w_id)->where('next','=',"")->get();
                        if(count($ws)>0){
                        foreach ($ws as $key) {
                          $previous[] = $key->ws_id;
                        }
                       } 
                     
                     foreach ($steps as $s) {
                       if(in_array($s->ws_id, $previous)){
                        echo "<input type='checkbox' name='prev[]' value=".$s->ws_id." checked>".$s->posName."<br>";
                     }
                     else
                     {
                        echo "<input type='checkbox' name='prev[]' value=".$s->ws_id.">".$s->posName."<br>";
                     }
                   }
                    ?>
      </div><br>

      Action: <input type="radio" name="action" value="sign" checked="checked"> Sign
              <input type="radio" name="action" value="cc"> Carbon Copy<br>
            <div class="modal-footer">
                <input type="submit" name="addNewStep" value="Add"> <a class="btn btn-primary" href="javascript:closeAdd()">Cancel</a>
               {{-- <a class="btn btn-primary" href="javascript:openWsModal({{}})"></a> --}}
            </div>
    </form>
    </div>
  </div>
</div>
</div>

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

    <div id="editWsModal-{{$steps2[$a][$b]['ws_id']}}" class="modal">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Workflow</h5>
      </div>
      <div class="modal-body">
    <form method="post" action="{{route('UpdateWs',['upgid'=>$upgid,'wsid'=>$steps2[$a][$b]['ws_id'],'wfid'=>$steps2[$a][$b]['workflow_w_id']])}}">
    {{csrf_field()}}
    <input type="hidden" name="wsid" value="{{$steps2[$a][$b]['ws_id']}}"><br>
    <input type="hidden" name="wfid" value="{{$steps2[$a][$b]['workflow_w_id']}}">
    Position: {{$steps2[$a][$b]['posName']}}<br>
              Previous:<br>   
                    <?php
                    $previous = array();
                    $previous[] = "";
                     $prevs = \DB::table('workflowsteps')->where('ws_id','=',$steps2[$a][$b]['ws_id'])->get();

                     foreach ($prevs as $pre) {

                      $wfid = $pre->workflow_w_id;

                      if($pre->prev!=""){
                      if(strpos($pre->prev,',')!==false){
                        $previous = explode(',',$pre->prev);
                      }
                      else
                      {
                        $previous[] = $pre->prev;
                      }
                     }
                     else if($pre->prev==="" && $pre->next==="")
                     {
                        $ws = \DB::table('workflowsteps')->where('workflow_w_id','=',$wfid)->where('next','=',"")->where('ws_id','!=',$steps2[$a][$b]['ws_id'])->get();
                        if(count($ws)>0){
                        foreach ($ws as $key) {
                          $previous[] = $key->ws_id;
                        }
                       } 
                       else if(count($ws)==0)
                       {
                        $previous[] = "";
                       }
                     }
                   }
                     foreach ($steps as $s) {
                       if(in_array($s->ws_id, $previous)){
                        echo "<input type='checkbox' name='prev[]' value=".$s->ws_id." checked>".$s->posName."<br>";
                     }
                     else
                     {
                        echo "<input type='checkbox' name='prev[]' value=".$s->ws_id.">".$s->posName."<br>";
                     }
                   }
                     // echo "<pre>";
                     // var_dump($previous);
                    ?>
               
                <br>
                Action: @if($steps2[$a][$b]['action']=="sign")
                        <input type="radio" name="action" value="sign" checked="checked"> Sign
                        <input type="radio" name="action" value="cc"> Carbon Copy<br>
                        @elseif($steps2[$a][$b]['action']=="cc")
                         <input type="radio" name="action" value="sign"> Sign
                        <input type="radio" name="action" value="cc" checked="checked"> Carbon Copy<br>
                        @endif

            <input type="submit" name="addNewStep" value="Save">&nbsp;&nbsp;
            <input type="button" id="closeWsModal" value="Cancel" onclick="closeModal({{$steps2[$a][$b]['ws_id']}})">
    </form>
    </div>
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

    <script type="text/javascript">
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
    </script>
      
    @endfor
</div>
{{--end of card div--}} 
<div class="ml-4 media-body" id="wf-arrow" style="margin-top: 40px;">
  <i class="fa fa-arrow-right fa-fw"></i>
</div>
</div>
  @endfor
  @elseif(count($steps2)==0)
  <div id="addModal" class="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span class="close">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <form method="post" action="{{route('postAddStep',['upgid'=>$upgid])}}">
    {{csrf_field()}}
    <input type="hidden" name="wid" value="{{$flow->w_id}}"><br>
    Position: <select id="pos" name="pos">
                <option value="none">--Choose position--</option>
                @foreach($positions as $pos)
                    <option value="{{$pos->pos_id}}">{{$pos->posName}}</option>
                @endforeach
                </select><br><br>
                
      Action: <input type="radio" name="action" value="sign" checked="checked"> Sign
              <input type="radio" name="action" value="cc"> Carbon Copy<br>
            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" name="addNewStep" value="Add"> <a class="btn btn-primary" href="javascript:closeAdd()">Cancel</a>
               {{-- <a class="btn btn-primary" href="javascript:openWsModal({{}})"></a> --}}
            </div>
    </form>
    </div>
  </div>
</div>
</div>

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

  @endif

<br><br>
  {{-- <input type="button" id="addstep" value="Add Step"> --}}

     <!-- The Modal -->

  </div>

@endforeach
@endsection