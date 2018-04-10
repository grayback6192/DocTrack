@extends('mastertemplate')



@section('menu')
 <li>
              <a href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li class="active">
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

 @if(session('edited'))
    <div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  {{session('edited')}}
</div>
  @endif
{{-- <div> --}}
  @foreach($depinfos as $depinfo)
  @if($depid!=$admingroup)
      <a class="btn btn-primary" href="{{route('showDep',['upgid'=>$upgid,'id'=>$depinfo->group_group_id])}}">Back</a>
  @endif
   {{-- <div class="row justify-content-center"> --}}
   {{--  <div class="card border-0">
       <div class="card-block"> --}}
        <div class="row justify-content-end mr-2">
        

           <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>
  <script type="text/javascript">
    $(document).ready(function(){

      $("#depSlider").change(function(){
        var depid = "<?php echo $depinfo->group_id; ?>";
        if($(this).prop('checked'))
        {
          $.ajax({
            type: 'GET',
            url: 'http://localhost:8000/admin/depactive/'+depid,
            success: function(data){
              alert('success');
            }
          });
        }
        else
        {
           $.ajax({
            type: 'GET',
            url: 'http://localhost:8000/admin/depinactive/'+depid,
            success: function(data){
              alert('success');
            }
          });
        }
      });

       $('#find-user').click(function(){
      var string = $('#search').val();
      var group = $('#dep-id').val();
      $.ajax({
        type: 'GET',
        url: 'http://localhost:8000/admin/group/user/find/'+group+'/'+string+'/',
        //data: string,
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

    });

  </script>

         
         {{--  <a href="{{route('deleteDep',['upgid'=>$upgid,'id'=>$depinfo->group_id])}}"><i class="material-icons">delete</i></a> --}}
         
        </div>
      <div class="jumbotron"> 
  
        <div class="text-right" style="margin-right: 10px;">
           <a class="btn btn-primary" href="{{route('editDep',['upgid'=>$upgid,'id'=>$depinfo->group_id])}}"><i class="material-icons">mode_edit</i></a>
        </div>
        <h1 style="margin-left: 20px">{{$depinfo->groupName}}</h1>
        <hr>
        <p style="margin-left: 20px" placeholder="Department Description">
          {{$depinfo->groupDescription}}
        </p>
      </div>

      <div class="m-3">
        <div class="row">
          <div class="col-md-8">
            <h3>Department Admin</h3>
          </div>
           <div class="col-md-offset-2">
           {{--  @foreach($orgchartInfos as $orgchartInfo) --}}
             <button type="button" class="btn btn-primary" id="add-admin">Add Admin</button>
            {{-- @endforeach --}}
          </div>
          @if(session('adminremoved'))
             <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{session('adminremoved')}}
              </div>
          @endif
         </div>

           <!-- The Modal for Assignment -->
<div id="addAdminModal" class="modal">

  <!-- Modal content -->
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
       <button type="button" class="close">
       <span class="close" id="closeAddAdminModal">&times;</span>
       </button>
      <h4 class="modal-title" id="exampleModalLabel">Admin Assignment</h4>
    </div>
    <div class="modal-body">
    <form method="post" action="{{route('newAssign',['upgid'=>$upgid])}}">
    {{csrf_field()}}
    <input type="text" name="group" value="{{$depinfo->group_id}}" id="dep-id" style="display: none">
    <div class="form-group row">
      <label class="col-3 col-form-label">Department:</label>
      <div class="my-lg-auto">
        {{$depinfo->groupName}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-3 col-form-label">Position:</label>
      <div class="my-lg-auto">
         <input type="text" name="position" value="{{$adminposid}}" style="display:none">
        Admin
      </div>
    </div>

    <div class="form-group row">
    <label class="col-2 col-form-label">User</label>
    <div class="col-10">
          {{-- <input type="text" name="user" id="user">&nbsp;&nbsp;<input type="button" id="chooseuser" value="..." onclick="openUsers()"><input type="hidden" size="8" name="userid" id="userid"> --}}
          <input type="text" name="user" id="user">&nbsp;&nbsp;

          <button style="border: 0; background-color: transparent;" type="button" id="chooseuser" onclick="openUsers()">
            <i class="material-icons">add_box</i>
          </button>

          <input type="hidden" size="8" name="userid" id="userid">
          <br><br>

          <div class="modal" id="searchuser">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                   <button type="button" class="close">
                    <span class="close" onclick="closeUsers()">&times;</span>
                   </button>
                  <h4 class="modal-title">Choose a user</h4> 
                 {{--  <div>
                    <input type="text" id="search" name="search"><input type="button" id="find-user" value="Find">
                  </div> --}}
                </div>
                <div class="modal-body" style="overflow: scroll; height: 450px;">
                  <table class="table" id="chooseuserlist">
                    <thead>
                      <th>Names</th>
                    </thead>
                    <tbody>
                      @if(isset($members))
                      @foreach($members as $member)
                      @if(!in_array($member->user_id,$adminusersarray))
                      <tr>
                        <td id="{{$member->user_id}}"> 
                          <a href="javascript:submitUser({{$member->user_id}})" id="user-{{$member->user_id}}">{{$member->lastname}}, {{$member->firstname}}</a>
                        </td>
                      </tr>
                      @endif
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                 
                 {{--  <div class="modal-footer">
                    <input class="btn btn-primary" type="button" name="back" id="back" value="Back" onclick="closeUsers()"> --}}
                     {{-- <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                  </div> --}}
                </div>
              </div>
              
            </div>  
          </div>

          <script type="text/javascript">
            function openUsers()
            {
              var modal = document.getElementById('searchuser');
              var dep = document.getElementById('dep-id');
              var depVal = dep.value;

               modal.style.display = "block";

              console.log(depVal);
                
            
            }

            function closeUsers()
            {
              var modal = document.getElementById('searchuser');
              modal.style.display = "none";
            }

            function submitUser(userid)
            {
              var txt = document.getElementById('user');
              var txt2 = document.getElementById('userid');
              var list = document.getElementById('user-'+userid);
              txt.value = list.innerHTML;
              txt2.value = userid;

              var modal = document.getElementById('searchuser');
              modal.style.display = "none";
            }
          </script>
    </div>
    </div>

    <div class="form-group row">
    <label class="col-3 col-form-label">Right:</label>
    <div class="my-lg-auto">
          <input type="text" name="role" value="1" style="display: none">
          Admin
    </div>
    </div>

    <div class="modal-footer">

          <input type="submit" class="btn btn-primary" name="addNewAssign" value="Add New Admin">
    </div>
    </form>
  </div>
</div>
</div>
</div>

<script>
// Get the modal
var modal = document.getElementById('addAdminModal');

// Get the button that opens the modal
var btn = document.getElementById("add-admin");

// Get the <span> element that closes the modal
var span = document.getElementById("closeAddAdminModal");

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

        {{-- </div> --}}
        {{--Admin Here--}}
         <div class="row p-4" style="margin-left: 60px; margin-top: 10px;">
          @if(isset($admins))
          @foreach($admins as $admin)
           <div class="col-sm-5" style="margin-top: 15px;">
                  <div class="card">
                  <div class="card-content">
                  @if($admin->position_pos_id!=$masteradminposid)
                  <div class="text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#removeAdmin-{{$admin->upg_id}}"><i class="material-icons">delete</i></button>
                  </div>
                  @endif
                  <div class="media">
                    <div class="media-left">
                    <div class="adminpic img-circle">
                      <img src="{{url('/users/pictures/'.$admin->profilepic)}}" style="display: block; width: 100%" alt="prof-pic" />
                    </div>
                    </div>
                    <div class="media-body" style="padding: 30px 0;">
                      <h4>{{$admin->firstname}} {{$admin->lastname}}</h4>
                   </div>
                  </div>
                  </div>
                  </div>
              </div>

               {{--Modal to remove admin--}}
          <div class="modal fade bs-example-modal-sm" id="removeAdmin-{{$admin->upg_id}}">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <h4>Remove Admin?</h4>
                </div>
                <div class="modal-body">
                  <form method="post" action="{{route('removeAdmin',['upgid'=>$upgid])}}">
                    {{csrf_field()}}
                  <input type="hidden" name="adminupgid" value="{{$admin->upg_id}}">
                  <input type="hidden" name="admindep" value="{{$admin->group_group_id}}">
                  <div class="btn-toolbar">
                    <div class="btn-group">
                      <input type="submit" name="removeAdmin" class="btn btn-primary" value="Yes">
                    </div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        
            @endforeach
            @endif
          </div>


      </div>

      <div class="m-3">
          <div class="row">
          <div class="col-md-8">
            <h3>Departments/Subgroups</h3>
          </div>
          <div class="col-md-offset-2">
           {{--  @foreach($orgchartInfos as $orgchartInfo) --}}
<input type="button" class="btn btn-primary" id="adddep" value="Add Department" onclick="window.location='{{route('regDep',['upgid'=>$upgid,'depid'=>$depid])}}'"> 
            {{-- @endforeach --}}
          </div>
          </div>
        {{--Sub groups Here--}}
        <div class="row" style="margin-left: 60px; margin-top: 10px;">
          @if(isset($subgroups))
            @foreach($subgroups as $subgroup)
              <div class="col-sm-4" style="margin-top: 15px;">
                <a href="{{route('showDep',['upgid'=>$upgid,'depid'=>$subgroup->group_id])}}">
                <div class="card col-xs-8">
                  <div class="card-header text-center" data-background-color="blue">
                    <i class="material-icons" style="font-size: 40px">business</i>
                </div>
                <div class="card-block text-center">
                  <h3 class="card-title" style="margin-top: 1rem">{{$subgroup->groupName}}</h3>
                </div>
                </div></a>
              </div>
@endforeach
@endif
</div>
</div>      

      <div class="m-3">
        <div class="row">
          <div class="col-md-8">
            <h3 style="margin-left: 20px">View and Add Organizational Chart</h3>
          </div>
       {{--    <div class="col-md-offset-2">
            @foreach($orgchartInfos as $orgchartInfo)
            <a class="btn btn-warning" target="_blank" href="{{route('editOrgChart',['upgid'=>$upgid,'groupid'=>$orgchartInfo->group_id])}}">View and Add Organizational Chart</a>
            @endforeach
          </div> --}}
        </div>
        {{--Org Chart Here--}}
        {{-- @if($deporgchart!=="none") --}}
         
        {{-- @else --}}
        {{--   <a class="btn btn-warning" target="_blank" href="{{route('AddOrgChart',['upgid'=>$upgid,'groupid'=>$depid])}}">Add Organizational Chart</a> --}}
        {{-- @endif --}}
        <a class="btn btn-warning" href="{{route('vieworgchart',['upgid'=>$upgid,'groupid' => $depid])}}">View Organizational Chart</a>
      </div>


    <div class="m-3">
      <div class="row">
        <div class="col-md-8">
          <h3>Department Positions</h3>
          @if(session('removerole'))
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              {{session('removerole')}}
            </div>
          @endif
        </div>
        <div class="col-md-offset-2">
          <button type="button" class="btn btn-primary" onclick="openDepPosModal({{$depid}})">
            Add Position
          </button>
        </div>

        {{--modal for adding position--}}
          <div class="modal" id="addPosModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" onclick="closeAddPos()"><span>&times;</span></button>
                <h4 class="modal-title">Add Department Position</h4>
              </div>
              <div class="modal-body" style="height: 400px; overflow: overlay;">

                <div class="modal-body" style="float: left">
                  <form method="post" action="{{route('addExistingPos',['upgid'=>$upgid,'depid'=>$depid])}}">
                    {{csrf_field()}}
                    Choose from Existing Positions<br>
                   <div class="form-group">
                      <label>Position:</label>
                         <select class="form-control" name="depPos" id="user-position">
                          <option value="none">--Select a position--</option>
                           @foreach($positions as $position)
                            @if($position->posName!="Admin" && $position->posName!="masteradmin")
                              <option value="{{$position->pos_id}}">{{$position->posName}}</option>
                            @endif
                            @endforeach
                          </select>
                    </div>
                      <div class="form-group">
                          <label>Choose Immediate Head</label>
                          <select class="form-control" name="headpos" id="user-position">
                          <option value="none">--Select a position--</option>
                           @foreach($posHeads as $posHead)
                              <option value="{{$posHead->deppos_id}}">{{$posHead->posName}} ({{$posHead->groupName}})</option>
                            @endforeach
                          </select>
                      </div>


                    <input type="hidden" name="deppos" value="{{$depid}}">
                <input type="submit" class="btn btn-primary" name="addNewPos" value="Add Selected Positions">
                </form>
                </div>

                <div class="modal-body" style="float: left; width: 100%;">
                  <hr>OR<hr>
                   <form method="post" action="{{route('AddRole',['upgid'=>$upgid])}}">

                  Add New Position<br>
                  {{csrf_field()}}
                  <label>Position Name</label>
                  <input type="text" class="form-control" data-toggle="tooltip" title="Add New Position"  name="newrole" id="newroleid" placeholder="Position Name"> 

                  <input type="checkbox" name="motherdep" id="motherdep" onclick="showMotherDep()"> Please check if this position has an immediate head.
                  <div id="motherdeps" style="display: none;">
                  <div class="form-group">
                  <label>Parent Position:</label> 
                  <select class="form-control" name="motherpos">
                  <option value=""></option>
                  @if(isset($positions))
                  @foreach($posHeads as $posHead)
                    <option value="{{$posHead->deppos_id}}">{{$posHead->posName}} ({{$posHead->groupName}})</option>
                  @endforeach
                  @endif

                  </select> 

                  </div> 
               </div><br>

               <input type="hidden" name="deppos" value="{{$depid}}">
                <input type="submit" class="btn btn-primary" name="addNewPos" value="Add New Position">
                </form>
                </div>

            
             {{--    <div class="modal-footer">
                  <button type="button" class="btn btn-danger" onclick="closeAddPos()">
                    Cancel
                  </button>
                </div> --}}
                    </div>
        </div>
      </div>
    </div>
      </div>

              <div class="row" style="margin-left: 60px; margin-top: 10px; margin-right: 20px;">
                <table class="table" id="posDep-table">
                  <thead>
                    <th>Position Name</th>
                    <th>Description</th>
                    <th></th>
                  </thead>
                     @if(isset($depPositions))
                      @foreach($depPositions as $depPosition)
                        @if($depPosition->posName!="masteradmin" && $depPosition->posName!="Admin")
                        <tbody>
                          <tr id="{{$depPosition->pos_id}}-row">
                            <form method="post" action="{{route('UpdateRole',['upgid'=>$upgid,'depid'=>$depid,'roleid'=>$depPosition->pos_id])}}">
                              {{csrf_field()}}
                            <td>
                              <div id="{{$depPosition->pos_id}}-namefield">
                                <input readonly style="border: none" name="role" id="{{$depPosition->pos_id}}-name" value="{{$depPosition->posName}}">
                              </div>
                            </td>

                             <td>
                              <div id="{{$depPosition->pos_id}}-descfield">  
                                <input readonly style="border: none; display: block;" name="roledesc" id="{{$depPosition->pos_id}}-desc" value="{{$depPosition->posDescription}}">
                              </div>
                            </td>

                           {{--  <td>
                              <a href="javascript:editMode({{$depPosition->pos_id}})" id="{{$depPosition->pos_id}}-edit"><i class="material-icons">mode_edit</i></a>
                              <input type="submit" class="btn btn-primary" id="{{$depPosition->pos_id}}-save" name="save" value="Save" style="display: none">
                            </td> --}}

                            <td>
                              <a href="javascript:showRemoveModal({{$depPosition->pos_id}})" id="{{$depPosition->pos_id}}-delete"><i class="material-icons">delete</i></a>
                              <input type="button" class="btn btn-primary" id="{{$depPosition->pos_id}}-cancel" value="Cancel" style="display: none;" onclick="viewMode({{$depPosition->pos_id}})">
                            </td>
                          </form>

                          {{--Remove Modal--}}
                              <div class="modal bs-example-modal-sm" id="{{$depPosition->pos_id}}-remove">
                                <div class="modal-dialog modal-sm" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Remove Position from Department?</h4>
                                    </div>
                                    <div class="modal-body">
                                      <div class="btn-toolbar">
                                        <div class="btn-group">
                                          <a href="{{route('DelDeppos',['upgid'=>$upgid,'depid'=>$depid,'posid'=>$depPosition->pos_id])}}" class="btn btn-primary">YES</a>
                                        </div>
                                        <div class="btn-group">
                                          <a href="javascript:closeRemoveModal({{$depPosition->pos_id}})" class="btn btn-danger">NO</a>
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

                         

                        
                        @endif
                      @endforeach
                    </tbody>
                    @endif
                </table>
              </div>
      
    </div>

     <div class="m-3">
      <div class="row">
        <div class="col-md-7">
          <h3>Department Assignments</h3>
        </div>
        <div class="col-md-offset-2">
         <input type="button" class="btn btn-primary" name="addAssign" value="Add Position Assignment" id="addAssign">
        </div>
      </div>
      {{--Assignments Table--}}
      <div class="row" style="margin-left: 60px; margin-top: 10px; margin-right: 20px;">
        <table class="table">
          <thead>
            <th>Name</th>
            <th>Position</th>
            <th>Right</th>
            <th></th>
          </thead>
          <tbody>
            @foreach($depAssignments as $depAssignment)
              @if($depAssignment->posName!='masteradmin')
                <tr id="{{$depAssignment->upg_id}}">
                  <td>{{$depAssignment->lastname}}, {{$depAssignment->firstname}}</td>
                  <td>{{$depAssignment->posName}}</td>
                  <td>{{$depAssignment->rightsName}}</td>
                  <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeupg-{{$depAssignment->upg_id}}"><i class="material-icons">delete</i></button></td>
                </tr>

                 {{--modal to remove upg--}}
                <div class="modal" id="removeupg-{{$depAssignment->upg_id}}">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4>Remove Assignment?</h4>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="{{route('removeUPG')}}">
                          {{csrf_field()}}
                          <input type="hidden" name="upgid" value="{{$depAssignment->upg_id}}"><input type="hidden" name="loginupgid" value="{{$upgid}}">
                        <div class="btn-toolbar">
                          <div class="btn-group">
                            <button type="submit" class="btn btn-primary">YES</button>
                          </div>
                          <div class="btn-group">
                             <button class="btn btn-danger" type="button" class="close" data-dismiss="modal" aria-label="Close">NO</button>
                          </div>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endforeach
          </tbody>
        </table>
        
      </div>
      {{--modal to add assignment--}}
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
    <input type="hidden" name="group" value="{{$depid}}">

    <div class="form-group row">
      <label class="col-2 col-form-label">Position</label>
      <div class="col-10">
        <select class="form-control" name="position" id="user-position">
          <option value="none">--Select a position first--</option>
           @foreach($depPositions as $position)
              <option value="{{$position->deppos_id}}">{{$position->posName}}</option>
            @endforeach
          </select><br><br>
      </div>
    </div>

    <div class="form-group row">
    <label class="col-2 col-form-label">User</label>
    <div class="col-10">
          <input type="text" name="user" id="user2">&nbsp;&nbsp;<input type="button" id="chooseuser" value="..." onclick="openUsers()"><input type="hidden" size="8" name="userid" id="userid2">
          <br><br>

          <div class="modal" id="searchuser2">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  Choose a user 
                </div>
                <div class="modal-body">
                  
                  
                  <table class="table display" id="userslist-table">
                    <thead>
                      <th>Names</th>
                    </thead>
                    <tbody>
                      <ul id="depusers">
                        @foreach($users as $user)
                          <a href="javascript:submitUser({{$user->user_id}})">
                            <li id="{{$user->user_id}}">{{$user->lastname}}, {{$user->firstname}}</li>
                          </a>
                        @endforeach
                      </ul>
                    </tbody>
                  </table>
                 
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
              var modal = document.getElementById('searchuser2');

                 modal.style.display = "block";
            
            }

            function closeUsers()
            {
              var modal = document.getElementById('searchuser2');
              modal.style.display = "none";
            }

            function submitUser($id)
            {
              var txt = document.getElementById('user2');
              var txt2 = document.getElementById('userid2');
              var list = document.getElementById($id);

              txt.value = list.innerText;
              txt2.value = $id;

              var modal = document.getElementById('searchuser2');
              modal.style.display = "none";
            }
          </script>
    </div>
    </div>

    <div class="form-group row">
    <label class="col-2 col-form-label">Right:</label>
    <div class="my-lg-auto">
          <input type="text" name="role" value="2" style="display: none">
          User
    </div>
    </div>

    <div class="modal-footer">

          <input type="submit" class="btn btn-primary" name="addNewAssign" value="Add New Assignment">
          <button type= "button" class="btn btn-danger" onclick="closeAddAssignment({{$depid}})">
            Cancel
          </button>
    </div>
    </form>
  </div>
</div>
</div>
</div>
    </div>

    <script type="text/javascript">
      function openDepPosModal(depid)
      {
        var addposmodal = document.getElementById('addPosModal');
        addposmodal.style.display = "block";
      }

      function closeAddAssignment(depid)
      {
        var addAssignModal = document.getElementById('myModal')
        addAssignModal.style.display = "none";
      }

      function closeAddPos()
      {
         var addposmodal = document.getElementById('addPosModal');
        addposmodal.style.display = "none";
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

      // Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("addAssign");

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
    </script>
 {{--  </div>
</div> --}}
 @endforeach
{{-- </div> --}}
{{-- </div> --}}
@endsection
@section('js')
<script type="text/javascript">
        $(document).ready(function () {
            $('#chooseuserlist').DataTable();
        });
    </script>
@endsection