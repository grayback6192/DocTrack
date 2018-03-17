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

 <li class="active">
              <a href="{{route('viewRolePage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">event_seat</i>
                <p>Positions</p>
              </a>
 </li>

 <li>
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
<script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
	$(document).ready(function(){
		
		$('#dept').change(function(){
			var value = $(this).val();
			console.log(value);
			$.ajax({
				type: 'POST',
				url: 'http://localhost:8000/admin/roles/depID='+value,
				data: value,
				success: function(data){
					console.log(data);
					$('#rowTable tr:not(:first)').remove();
					for(var i=0; i<data.length;i++)
					{
						var html = "<tr id="+data[i].pos_id+">";
						html+= "<form method='post' action=http://localhost:8000/admin/roles/edit="+data[i].pos_id+">";
						html+= "<input type='hidden' name='_token' value='{{csrf_token()}}'>";
						html+= "<td><input readonly name='role' id="+data[i].pod_id+" value="+data[i].posName+"></td>";
						html+= "<td><a href='javascript:editMode("+data[i].pos_id+")' id="+data[i].pos_id+"><i class='material-icons w3-xlarge'>mode edit</i></a><input type='submit' id='"+data[i].pos_id+"-save' name='save' value='Save' style='display: none'></td>";
						html+= "<td><a href=http://localhost:8000/admin/roles/"+data[i].pos_id+"><i class='material-icons w3-xlarge'>delete</i></a></td>";
						html+= "</form></tr>";

						console.log(html);
						$('#rowTable').append(html);
					}

				}
			});
		});

	});
</script>

{{-- @if(count($errors)>0)
		<ul>
			@foreach($errors->all() as $error)
				<li class="alert alert-danger alert-dismissible">
					 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Position name already exists.
				</li>
			@endforeach
		</ul>
	@endif --}}
@if(session('RoleExists'))
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  {{session('RoleExists')}}
</div>
@endif

@if(session('activerole'))
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  {{session('activerole')}}
</div>
@endif

@if(session('removerole'))
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  {{session('removerole')}}
</div>
@endif

<div class="row" role="toolbar" aria-label="Toolbar with button groups">

<div class="col-lg-9" role="group" aria-label="First Group">
	<button type="button" class="btn btn-primary" onclick="showAddPosModal()">Add New Position</button>

	<div class="modal" id="addPosModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" onclick="closeAddPosModal()"><span>&times;</span></button>
        				<h4 class="modal-title">Add New Position</h4>
      				</div>
      				<form method="post" action="{{route('AddRole',['upgid'=>$upgid])}}">
      					<div class="modal-body">
      						{{csrf_field()}}
      						<label>Position Name</label>
      						<input type="text" class="form-control" data-toggle="tooltip" title="Add New Position"  name="newrole" id="newroleid" placeholder="Position Name"> 

      						<input type="checkbox" name="motherdep" id="motherdep" onclick="showMotherDep()"> Please check if this position has a certain hierarchy.
      						<div id="motherdeps" style="display: none;">
							    <div class="form-group">
							  	<label>Parent Position:</label> 
							    <select class="form-control" name="motherpos">
							  	<option value=""></option>
							  	@foreach($positionlist as $position)
							  	<option value="{{$position->pos_id}}">{{$position->posName}}</option>
							  	@endforeach	
							  	</select> 
							    </div> 
							 </div>
      					</div>
      					<div class="modal-footer">
      						<input type="submit" class="btn btn-primary" name="addNewPos" value="Add New Position">
      					</div>
      				 </form>
				</div>
			</div>
		</div>
		
	</div>
	

<script type="text/javascript">
	function showAddPosModal()
	{
		var addPosModal = document.getElementById('addPosModal');
		addPosModal.style.display = "block";
	}

	function showMotherDep()
	{
		var chooseMotherPos = document.getElementById('motherdeps');
		var checkbox = document.getElementById('motherdep');
		var checkedMotherPos = checkbox.checked;

		if(checkedMotherPos){
			chooseMotherPos.style.display = "block";
		}
		else
		{
			chooseMotherPos.style.display = "none";
		}
		
	}

	function closeAddPosModal()
	{
		var addPosModal = document.getElementById('addPosModal');
		addPosModal.style.display = "none";
	}
</script>

<div class="col-sm-3" role="group" aria-label="Second Group" style="margin-top: 27px;">
	<a class="btn btn-primary" href="{{route('viewAssignments',['upgid'=>$upgid])}}">Position Assignments</a>
</div> 
</div>

<div class="col-md-12">
<div class="card">
<div class="card-content table-responsive">
	<table class="table" id="rowTable">
	<thead>
	<tr>
		<th>Position</th>
		<th>Description</th>
		<th colspan="2"></th>
	</tr>
	</thead>
	@foreach($roles as $role)
	@if($role->posName!="masteradmin" && $role->posName!="Admin")
	<tbody>
	<tr id="{{$role->pos_id}}-row">
		<form method="post" action="{{route('UpdateRole',['upgid'=>$upgid,'roleid'=>$role->pos_id])}}">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<td>
			<div id="{{$role->pos_id}}-namefield">
				<input readonly style="border: none" name="role" id="{{$role->pos_id}}-name" value="{{$role->posName}}">
			</div>
		</td>
		<td>
			<div id="{{$role->pos_id}}-descfield">	
				<input readonly style="border: none; display: block;" name="roledesc" id="{{$role->pos_id}}-desc" value="{{$role->posDescription}}">
			</div>
		</td>
		<td>
				<a href="javascript:editMode({{$role->pos_id}})" id="{{$role->pos_id}}-edit"><i class="material-icons">mode_edit</i></a>
				<input type="submit" class="btn btn-primary" id="{{$role->pos_id}}-save" name="save" value="Save" style="display: none">
		</td>

		<td>
				<a href="javascript:showRemoveModal({{$role->pos_id}})" id="{{$role->pos_id}}-delete"><i class="material-icons">delete</i></a>
				<input type="button" class="btn btn-primary" id="{{$role->pos_id}}-cancel" value="Cancel" style="display: none;" onclick="viewMode({{$role->pos_id}})">
		</td>
		</form>

		{{--Remove Modal--}}
		<div class="modal bs-example-modal-sm" id="{{$role->pos_id}}-remove">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						{{-- <button type="button" class="close" onclick="closeRemoveModal({{$role->pos_id}})"><span aria-hidden="true">&times;</span></button> --}}
						<h4 class="modal-title">Remove Position?</h4>
					</div>
					<div class="modal-body">
						<div class="btn-toolbar">
							<div class="btn-group">
								<a href="{{route('DelRole',['upgid'=>$upgid,'roleid'=>$role->pos_id])}}" class="btn btn-primary">YES</a>
							</div>
							<div class="btn-group">
								<a href="javascript:closeRemoveModal({{$role->pos_id}})" class="btn btn-danger">NO</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">

		function showRemoveModal(posid)
		{
			document.getElementById(posid+"-remove").style.display = "block";
		}

		function closeRemoveModal(posid)
		{
			document.getElementById(posid+"-remove").style.display = "none";
		}

  		function editMode(id)
  	{
  		document.getElementById(id+"-namefield").className = "form-group";
  		document.getElementById(id+"-descfield").className = "form-group";

  		document.getElementById(id+"-name").readOnly = false;
  		document.getElementById(id+"-name").removeAttribute("style");
  		document.getElementById(id+"-name").className="form-control col-sm-5";

  		// document.getElementById(id+"-desc").style.display = "none"; 
  		 document.getElementById(id+"-desc").readOnly = false;
  		// document.getElementById(id+"-descedit").style.display = "block";
  		// document.getElementById(id+"-desc").removeAttribute("style");
  		document.getElementById(id+"-desc").className="form-control";

  		document.getElementById(id+"-edit").style.display = "none";
  		document.getElementById(id+"-save").style.display = "block";
  		document.getElementById(id+"-cancel").style.display = "block";
  		document.getElementById(id+"-delete").style.display = "none";
  	}

  	function viewMode(id)
  	{
  		document.getElementById(id+"-namefield").classList.remove("form-group");
  		document.getElementById(id+"-descfield").classList.remove("form-group");

  		document.getElementById(id+"-name").readOnly = true;
  		document.getElementById(id+"-name").setAttribute("style","border: none;");
  		document.getElementById(id+"-name").classList.remove("form-control");
  		document.getElementById(id+"-name").classList.remove("col-sm-5");

  		document.getElementById(id+"-desc").readOnly = true;
  		// document.getElementById(id+"-desc").style.display = "block";
  		// document.getElementById(id+"-descedit").style.display = "none";
  		// document.getElementById(id+"-desc").setAttribute("style","border: none;");
  		document.getElementById(id+"-desc").classList.remove("form-control");

  		document.getElementById(id+"-edit").style.display = "block";
  		document.getElementById(id+"-save").style.display = "none";
  		document.getElementById(id+"-cancel").style.display = "none";
  		document.getElementById(id+"-delete").style.display = "block";
  	}

  		</script>
  	
	</tr>
	</tbody>
	@endif
	@endforeach

	</table>
	<div class="justify-content-center">
		{{$roles->links()}}
	</div>
	</div>
	</div>
	</div>

@endsection
@section('js')
{{-- <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script> --}}
{{-- <script type="text/javascript">
        $(document).ready(function () {
            $('#rowTable').DataTable();
        });
    </script> --}}
@endsection