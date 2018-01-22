@extends('mastertemplate')



@section('menu')
 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" data-toggle="collapse" href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="fa fa-user fa-fw"></i>
                <span class="nav-link-text">
                  Users</span>
              </a>
 </li>

 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
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

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
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
<div class="container">
  @foreach($depinfos as $depinfo)
  @if($depid!=$admingroup)
  <div class="row justify-content-start mt-2 ml-2">
      <a class="btn btn-primary" href="{{route('showDep',['upgid'=>$upgid,'id'=>$depinfo->group_group_id])}}">Back</a>
    </div>
  @endif
   <div class="row justify-content-center">
    <div class="card border-0" style="width: 60rem">
       <div class="card-block">
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

         
          <a href="{{route('deleteDep',['upgid'=>$upgid,'id'=>$depinfo->group_id])}}"><i class="fa fa-trash fa-2x mt-2" data-toggle="collapse" data-placement="right" title="Delete"></i></a>
          <a href="{{route('editDep',['upgid'=>$upgid,'id'=>$depinfo->group_id])}}"><i class="fa fa-cogs fa-2x mt-2 ml-3" data-toggle="collapse" data-placement="right" title="Edit"></i></a>
        </div>
      <div class="jumbotron m-3 bg-white">
        <h1 class="display-4">{{$depinfo->groupName}}</h1>
        <hr>
        <p class="mt-2" placeholder="Department Description">
          {{$depinfo->groupDescription}}
        </p>
      </div>

      <div class="m-3">
        <div class="row justify-content-between">
          <div class="ml-3">
            <h3>Department Admin</h3>
          </div>
          <div class="mr-5">
           {{--  @foreach($orgchartInfos as $orgchartInfo) --}}
            <a class="btn btn-primary" href="#" id="add-admin">Add Admin</a>
            {{-- @endforeach --}}
          </div>

           <!-- The Modal for Assignment -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Admin Assignment</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span class="close">&times;</span>
       </button>
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
         <input type="text" name="position" value="5291" style="display:none">
        Admin
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
                    @if(isset($members))
                    <ul id="dep-members">
                      @foreach($members as $member)
                        {{-- @if($admins->has($member->user_id)) --}}
                          <a href="javascript:submitUser({{$member->user_id}})"><li id="{{$member->user_id}}">{{$member->lastname}}, {{$member->firstname}}</li></a>
                        {{-- @endif --}}
                      @endforeach
                      </ul>
                    @endif
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
    <label class="col-3 col-form-label">Right:</label>
    <div class="my-lg-auto">
          <input type="text" name="role" value="1" style="display: none">
          Admin
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
var btn = document.getElementById("add-admin");

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
        {{--Admin Here--}}
         <div class="row p-4" style="margin-left: 60px; margin-top: 10px;">
          @if(isset($admins))
          @foreach($admins as $admin)
           <div class="col-6" style="margin-top: 15px;">
                <a href="#">
                  <div class="media">
                    <div class="mr-3 ml-3 prof-pic rounded-circle" style="border: 1px solid black;">
                      <img src="{{url('./users/pictures/'.$admin->profilepic)}}" style="display: block; width: 100%" alt="prof-pic" />
                    </div>
                    <div class="media-body m-lg-auto">
                      <h5>{{$admin->firstname}} {{$admin->lastname}}</h5>
                   </div>
                  </div>
                </a>
              </div>
            @endforeach
            @endif
          </div>
        
      </div>

      <div class="m-3">
          <div class="row justify-content-between">
          <div class="ml-3">
            <h3>Subgroups</h3>
          </div>
          <div class="mr-5">
           {{--  @foreach($orgchartInfos as $orgchartInfo) --}}
<input type="button" class="btn btn-primary" id="adddep" value="Add Department" onclick="window.location='{{route('regDep',['upgid'=>$upgid])}}'"> 
            {{-- @endforeach --}}
          </div>
        {{--Sub groups Here--}}
        <div class="row" style="margin-left: 60px; margin-top: 10px;">
          @if(isset($subgroups))
            @foreach($subgroups as $subgroup)
              <div class="col-sm-6" style="margin-top: 15px;">
                <a href="{{route('showDep',['upgid'=>$upgid,'depid'=>$subgroup->group_id])}}">
                <div class="card" style="width: 15rem; border: none;">
                <i class="fa fa-5x fa-building"></i>
                <div class="card-block">
                  <h3 class="card-title" style="margin-top: 1rem">{{$subgroup->groupName}}</h3>
                </div>
                </div></a>
              </div>
@endforeach
@endif
</div>
      </div>

      <div class="m-3">
        <div class="row justify-content-between">
          <div class="ml-3">
            <h3>Organizational Chart</h3>
          </div>
          <div class="mr-5">
            @foreach($orgchartInfos as $orgchartInfo)
            <a class="btn btn-primary" href="{{route('editOrgChart',['upgid'=>$upgid,'groupid'=>$orgchartInfo->group_id])}}">Edit</a>
            @endforeach
          </div>
        </div>
        {{--Org Chart Here--}}
        @if($deporgchart!=="none")
          <div id="chart-container">
            <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.min.js') }}" ></script>
            <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.mockjax.min.js') }}" ></script>
            <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.orgchart.min.js') }}" ></script>
            <script type="text/javascript">

            $(function() {
                $.mockjax({
                    url: '/orgchart/initdata',
                    responseTime: 1000,
                    contentType: 'application/json',
                    responseText:   
                  <?php echo $deporgchart; ?>
         
              });

                $('#chart-container').orgchart({
                  'data' : '/orgchart/initdata',
                  'depth': 2,
                  'nodeContent': 'title'
                });

             });
          </script>

          </div>
        @else
          <a class="btn btn-primary" href="{{route('AddOrgChart',['upgid'=>$upgid,'groupid'=>$depid])}}">Add Organizational Chart</a>
        @endif
      </div>
    </div>
  </div>
</div>
 @endforeach
</div>
@endsection