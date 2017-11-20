@extends('mastertemplate')



@section('menu')
 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" data-toggle="collapse" href="{{route('UserManage')}}" data-placement="right" title="Inbox">
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

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
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

<div class="content-div" id="view">
{{-- <input type="button" class="btn btn-primary" id="add" value="Add" onclick="window.location='{{ route('Reg') }}'"> --}}
<script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>
<script type="text/javascript">
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});  
    $(document).ready(function(){
        $('#status').change(function(){
            var value = $(this).val();
            console.log(value);
            $.ajax({
                type: 'GET',
                url: 'http://localhost:8000/admin/user/'+value,
                data: value,
                success: function(data){
                    console.log(data);
                    $('#users-table tr:not(:first)').remove();
                    for(var i=0;i<data.length;i++){
                    var html = "<tr>";
                    html+= "<td>"+data[i].lastname+"</td>";
                    html+="<td>"+data[i].firstname+"</td>";
                    html+="<td><a href=http://localhost:8000/admin/usermanagement/userprofile="+data[i].user_id+">View</a></td>";
                    html+="<td><a href=http://localhost:8000/admin/usermanagement/"+data[i].user_id+">Delete</a></td>";
                    html+="</tr>";
                    console.log(html);
                    $('#users-table').append(html);
                }
                }
            });
        });
    });
</script>
<form id="choice" name="choice">
<input type="hidden" name="_token" value="{{csrf_token()}}">
     <select id="status" name="dept">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
        <option value="all">All</option>
  </select> 
   </form>
</div>
<div class="content-div">
    <table class="table" id="users-table">
        <thead class="thead-default">
            <tr>
    	       <th>Last Name</th>
    	       <th>First Name</th>
    	       <th colspan="2">Actions</th>
            </tr>
    </thead>
    <tbody>
      @foreach ($users as $user) 
            <tr>
            <td>{{$user->lastname}}</td>
            <td>{{$user->firstname}}</td>
            <td><a href="{{route('UserProfile',['id' => $user->user_id])}}">View</a></td>
            <td><a href="{{route('Delete',['id' => $user->user_id])}}">Delete</a></td>
            </tr>
        @endforeach
    </tbody>
 
      
  
    </table><br>
  </div>

@endsection