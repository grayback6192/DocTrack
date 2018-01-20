@extends('mastertemplate')
@section('menu')
<li>
              <a href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li>
              <a href="{{route('showDep',['upgid'=>$upgid,'id'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
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

<script type="text/javascript" src="{{URL::asset('js/jquery-3.2.1.min.js')}}" ></script>
<script type="text/javascript">
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});  
	$(document).ready(function(){

    $('#selgroup').change(function(){
        var groupid = $(this).val();
        console.log(groupid);
        $.ajax({
          type: 'GET',
          url:'http://localhost:8000/admin/group/'+groupid, 
          data: groupid,
          success: function(data){
            console.log(data);
            // $('#user').empty(); 
            $('#userslist').empty(); 
            // var html = "<option value=none>--Select a user--</option>";
           var html = "<ul id='depusers'>";
            for(var x=0; x<data.length;x++){
           //  html+="<option value="+data[x].user_id+">"+data[x].lastname+", "+data[x].firstname+"</option>";
            html += "<a href='javascript:submitUser("+data[x].user_id+")'><li id="+data[x].user_id+">"+data[x].lastname+", "+data[x].firstname+"</li></a>";
          }
          html+="</ul>";
          // $('#user').append(html);
          $('#userslist').append(html);
          }
        });
    });

    $('#find-user').click(function(){
      var string = $('#search').val();
      var group = $('#selgroup').val();
      $.ajax({
        type: 'GET',
        url: 'http://localhost:8000/admin/group/user/find/'+group+'/'+string+'/',
        data: string,
        success: function(data){
          console.log(data);
          $('#userslist').empty(); 
           var html = "<ul id='depusers'>";
            for(var x=0; x<data.length;x++){
               html += "<a href='javascript:submitUser("+data[x].user_id+")'><li id="+data[x].user_id+">"+data[x].lastname+", "+data[x].firstname+"</li></a>";
          }
          html+="</ul>";
          $('#userslist').append(html);
        }
        
        
      });
    });

		$('#dept').change(function(){
			var value = $(this).val();
			console.log(value);
			$.ajax({
				type: 'GET',
				url: 'http://localhost:8000/admin/assignment/'+value,
				data: value,
				success: function(data){
					console.log(data);
					$('#assign-table tr:not(:first)').remove();
					for(var i=0;i<data.length;i++){
						var html = "<tr><form method='post'>";
						html+="<input type='hidden' name='_token' value='{{csrf_token()}}'>";
						
						html+="<td>"+data[i].lastname+", "+data[i].firstname+"</td>";
            html+="<td>"+data[i].posName+"</td>";
						html+="<td>"+data[i].rightsName+"</td>";
						html+="<td><a href=http://localhost:8000/admin/assignment/delete/"+data[i].upg_id+">Remove</a></td>";
						html+="</form></tr>";
						console.log(html);
						$('#assign-table').append(html);
					}
				}
			});
		});	

    // $('#user-role').change(function(){
    //   var value = $(this).val();
    //   if(value=="1")
    //   {
    //     console.log(value);
    //     var text1 = "Admin";

    //     $('#user-position option:contains('+text1+')').prop('selected',true);
    //   }
    // });	
	});
</script>

<div class="row" style="margin-left: 60px; margin-top: 20px;" id="dep">
	
  {{--Add assignment button--}}
  <div class="col-sm-8" style="margin-top: 20px;">
  <input type="button" class="btn btn-primary" name="addAssign" value="Add Position Assignment" id="addAssign">
	</div>
  {{--Filter by department--}}
  <div class="col-sm-4">
  <form id="list" name="depList">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
    <select name="dept" id="dept" class="form-control col-md-6">
    <option value="none">--Select a group--</option>
      @foreach($groups as $group)
        <option value="{{$group->group_id}}">{{$group->groupName}}</option>
      @endforeach
    </select>
  </form>
  </div>
</div>

{{--Assignment Table--}}
<div class="row" style="margin-left: 60px; margin-top: 20px;">
	<table class="table" id="assign-table">
	<tr>
		<th>Name</th>
    <th>Position</th>
		<th>Right</th>
		<th></th>
	</tr>
	
	
	</table><br><br>

 <!-- The Modal for Assignment -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  	<div class="modal-header">
  		<h5 class="modal-title" id="exampleModalLabel">Assignment</h5>
  		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  		 <span class="close">&times;</span>
  		 </button>
  	</div>
  	<div class="modal-body">
    <form method="post" action="{{route('newAssign',['upgid'=>$upgid])}}">
    {{csrf_field()}}
    <div class="form-group row">
    	<label class="col-2 col-form-label">Department</label>
    	<div class="col-10">
    		<select class="form-control" name="group" id="selgroup">
          <option value="none">--Select a department--</option>
    				@foreach($groups as $group)
    					<option value="{{$group->group_id}}">{{$group->groupName}}</option>
    				@endforeach
    			</select><br><br>
    	</div>
    </div>

    <div class="form-group row">
    	<label class="col-2 col-form-label">Position</label>
    	<div class="col-10">
    	 	<select class="form-control" name="position" id="user-position">
          <option value="none">--Select a position--</option>
    				@foreach($positions as $position)
    					<option value="{{$position->pos_id}}">{{$position->posName}}</option>
    				@endforeach
    			</select><br><br>
    	</div>
    </div>

    <div class="form-group row">
    <label class="col-2 col-form-label">User</label>
    <div class="col-10">
          <input type="text" name="user" id="user">&nbsp;&nbsp;<input type="button" id="chooseuser" value="..." onclick="openUsers()"><input type="hidden" size="8" name="userid" id="userid">
          <br><br>

          <div class="modal" id="searchuser">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  Choose a user 
                  <div>
                    <input type="text" id="search" name="search"><input type="button" id="find-user" value="Find">
                  </div>
                </div>
                <div class="modal-body">
                  
                  <div id="userslist">
                  </div>
                 
                  <div class="modal-footer">
                    <input class="btn btn-primary" type="button" name="back" id="back" value="Back" onclick="closeUsers()">
                  </div>
                </div>
              </div>
              
            </div>
          </div>

          <script type="text/javascript">
            function openUsers()
            {
              var modal = document.getElementById('searchuser');
              var dep = document.getElementById('selgroup');
              var depVal = dep.options[dep.selectedIndex].value;

              console.log(depVal);
              if(depVal=="none")
                alert('Select a department first');
              else if(depVal!="none")
                 modal.style.display = "block";
            
            }

            function closeUsers()
            {
              var modal = document.getElementById('searchuser');
              modal.style.display = "none";
            }

            function submitUser($id)
            {
              var txt = document.getElementById('user');
              var txt2 = document.getElementById('userid');
              var list = document.getElementById($id);
              txt.value = list.innerHTML;
              txt2.value = $id;

              var modal = document.getElementById('searchuser');
              modal.style.display = "none";
            }
          </script>
    </div>
    </div>

    <div class="form-group row">
   	<label class="col-2 col-form-label">Right:</label>
   	<div class="my-lg-auto">
    			{{-- <select name="role" id="user-role">
    				@foreach($roles as $role)
            @if($role->rightsName=="User")
    					<option value="{{$role->rights_id}}" selected="selected">{{$role->rightsName}}</option>
            @else
              <option value="{{$role->rights_id}}">{{$role->rightsName}}</option>
            @endif
    				@endforeach
    			</select><br><br> --}}
          <input type="text" name="role" value="2" style="display: none">
          User
    </div>
    </div>

    <div class="modal-footer">

    			<input type="submit" class="btn btn-primary" name="addNewAssign" value="Submit">
   	</div>
    </form>
  </div>
</div>
</div>
</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("addAssign");

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

	</div><br><br>
@endsection