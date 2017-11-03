@extends('mastertemplate')
@section('menu')
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('UserManage')}}" data-placement="right" title="Inbox">
                <i class="fa fa-user fa-fw"></i>
                <span class="nav-link-text">
                  Users</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewDep',['status'=>'active'])}}" data-placement="right" title="Inbox">
                <i class="fa fa-building fa-fw"></i>
                <span class="nav-link-text">
                  Departments</span>
              </a>
 </li>

 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewRolePage')}}" data-placement="right" title="Inbox">
                <i class="fa fa-star fa-fw"></i>
                <span class="nav-link-text">
                  Positions</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewWorkflow')}}" data-placement="right" title="Inbox">
                <i class="fa fa-group fa-fw"></i>
                <span class="nav-link-text">
                  Workflows</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('AdminTemplate')}}" data-placement="right" title="Inbox">
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

	{{-- <div class="selectDep" id="dep">
	<form id="list" name="depList">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
		<select name="dept" id="dept">
			@foreach($deps as $dep)
				<option value="{{$dep->group_id}}">{{$dep->groupName}}</option>
			@endforeach
		</select>
	</form>
	</div> --}}
<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups" style="margin-left: 60px;">
<div class="btn-group" role="group" aria-label="First Group">
	<form method="post" action="{{route('AddRole')}}">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<div class="form-group">
		<input type="text" name="newrole" placeholder="Role Name"> <input type="submit" class="btn btn-primary" name="addRole" value="Add Role">
	</div>
	</form> 
	
</div>

<div class="btn-group" role="group" aria-label="Second Group" style="margin-right: 60px;">
	<a class="btn btn-primary" href="{{route('viewAssignments')}}">Position Assignments</a>
</div> 
</div>

<div class="center-div" style="margin-top: 20px;">
	<table class="table" id="rowTable">
	<tr>
		<th>Position</th>
		<th colspan="2"></th>
	</tr>
	@foreach($roles as $role)
	<tr id="{{$role->pos_id}}">
		<form method="post" action="{{route('UpdateRole',['roleid'=>$role->pos_id])}}">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<td><input readonly style="border: none;" name="role" id="{{$role->pos_id}}-name" value="{{$role->posName}}"></td>

		<td>
			<a href="javascript:editMode({{$role->pos_id}})" id="{{$role->pos_id}}-edit">Edit</a>
			<input type="submit" class="btn btn-primary" id="{{$role->pos_id}}-save" name="save" value="Save" style="display: none">
		</td>

		<td>
			<a href="{{route('DelRole',['roleid'=>$role->pos_id])}}" id="{{$role->pos_id}}-delete">Remove</a>
			<input type="button" class="btn btn-primary" id="{{$role->pos_id}}-cancel" value="Cancel" style="display: none;" onclick="viewMode({{$role->pos_id}})">
		</td>

		</form>

		<script type="text/javascript">

  		function editMode(id)
  	{
  		document.getElementById(id+"-name").readOnly = false;
  		document.getElementById(id+"-name").removeAttribute("style");	
  		document.getElementById(id+"-edit").style.display = "none";
  		document.getElementById(id+"-save").style.display = "block";
  		document.getElementById(id+"-cancel").style.display = "block";
  		document.getElementById(id+"-delete").style.display = "none";
  	}

  	function viewMode(id)
  	{
  		document.getElementById(id+"-name").readOnly = true;
  		document.getElementById(id+"-name").setAttribute("style","border: none;");	
  		document.getElementById(id+"-edit").style.display = "block";
  		document.getElementById(id+"-save").style.display = "none";
  		document.getElementById(id+"-cancel").style.display = "none";
  		document.getElementById(id+"-delete").style.display = "block";
  	}

  		</script>
  	
	</tr>
	@endforeach
	</table>
	</div>

@endsection