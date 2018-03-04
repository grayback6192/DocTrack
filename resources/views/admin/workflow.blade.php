@extends('mastertemplate')
@section('menu')
<li>
              <a href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li>
              <a href="{{route('showDep',['upgid'=>$upgid,'id'=>$admingroup])}}" data-placement="right" title="Inbox">
                <i class="material-icons">business</i>
               <p>Departments</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewRolePage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">event_seat</i>
                <p>Positions</p>
              </a>
 </li>

 <li class="active">
              <a href="{{route('viewWorkflow',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">group</i>
               <p>Workflows</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewOwners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">description</i>
                <p>Templates</p>
              </a>
 </li>

 <li>
              <a href="#" data-placement="right" title="Inbox">
                <i class="material-icons">archive</i>
                <p>Archive</p>
              </a>
 </li>
@endsection

@section('main_content')

<div class="content">
<div id="view" class="row">
<input type="button" class="btn btn-primary" id="addwf" value="Add Workflow">

 <!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add Workflow</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="close">
      <span class="close">&times;</span>
      </button>
    </div>
    <form method="post" action="{{route('postAddWf',['upgid'=>$upgid])}}">
    <div class="modal-body">
    {{csrf_field()}}
    <div class="form-group">
  <label for="example-text-input">Workflow Name</label>
  <div class="col-10">
      <input class="form-control" type="text" name="wfname">
  </div>
</div>
</div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" name="addNewAssign" value="Add New Workflow">
        </div>
    </form>
  </div>
  </div>
</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("addwf");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</div>

@if(session('activewf'))
  <div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  {{session('activewf')}}
</div>
@endif

@if(session('removewf'))
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  {{session('removewf')}}
</div>
@endif

<div class="row" style="margin-left: 60px;">
@if(isset($workflows))
@foreach($workflows as $workflow)
 <div class="col-sm-4" style="margin-top: 20px;">
    <a href="{{route('AddWf',['upgid'=>$upgid,'id'=>$workflow->w_id])}}">
      <div class="card col-sm-10" style="border: none;">
        <div class="card-header" data-background-color="orange"  style="text-align: center;">
          <i class="material-icons" style="font-size: 50px;">group</i>
        </div>
      <div class="card-block">
        <h3 class="title text-center" style="margin-top: 1rem">{{$workflow->workflowName}}</h3>
      </div>
    </div></a>
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
           <div class="btn-group mr-2" role="group" aria-label="First group">
              <input type="button" class="btn btn-primary" name="editWf" id="editWf-{{$workflow->w_id}}" value="Edit" onclick="openEditModal({{$workflow->w_id}})">
          </div>
          <div class="btn-group mr-2" role="group" aria-label="First group">
              {{-- <input type="button" class="btn btn-primary" name="delWf" value="Delete" onclick="window.location='{{route('DelWf',['upgid'=>$upgid,'id'=>$workflow->w_id])}}'"> --}}
              <input type="button" class="btn btn-primary" name="delWf" value="Delete" onclick="openDeleteModal({{$workflow->w_id}})">
          </div>
        </div>
        <!-- The Modal -->
<div id="myModal2-{{$workflow->w_id}}" class="modal">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Workflow</h5>
    </div>
    <div class="modal-body">
    <form method="post" action="{{route('EditWf',['upgid'=>$upgid,'wfid'=>$workflow->w_id])}}">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{$workflow->w_id}}"><br>
    Workflow Name: <input type="text" name="wfname" value="{{$workflow->workflowName}}"><br><br>

          <input type="submit" class="btn btn-primary" name="editWfName" value="Save">&nbsp;&nbsp;
          <input type="button" class="btn btn-primary" id="cancel-{{$workflow->w_id}}" value="Cancel" onclick="closeEditModal({{$workflow->w_id}})">
    </form>
  </div>
  </div>

</div>
<script type="text/javascript">

  function openEditModal(wfid){
    var modal2 = document.getElementById('myModal2-'+wfid);
        modal2.style.display = "block";
        //console.log(wfid);
  }
  function closeEditModal(wfid) {
    var modal2 = document.getElementById('myModal2-'+wfid);
    modal2.style.display = "none";
  }

  function openDeleteModal(wfid)
  {
    var delmodal = document.getElementById('deleteWorkflowModal-'+wfid);
    delmodal.style.display = "block";
  }

  function closeDeleteModal(wfid)
  {
    var delmodal = document.getElementById('deleteWorkflowModal-'+wfid);
    delmodal.style.display = "none";
  }

</script>
  </div>

  <div id="deleteWorkflowModal-{{$workflow->w_id}}" class="modal">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center">Do you want to delete this workflow?</h5>
        </div>
        <div class="modal-body">
          <div class="btn-toolbar">
            <div class="btn-group">
              <a href="{{route('DelWf',['upgid'=>$upgid,'id'=>$workflow->w_id])}}" class="btn btn-primary">YES</a>
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-danger" onclick="closeDeleteModal({{$workflow->w_id}})">NO</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
@endif

</div>
 
</div>
@endsection