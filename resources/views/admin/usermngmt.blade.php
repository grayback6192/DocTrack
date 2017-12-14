@extends('mastertemplate')

@section('menu')
 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" data-toggle="collapse" href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
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


<div class="mr-2 row justify-content-end">

<script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>
<script type="text/javascript" src="{{ URL::asset('js/doctrack.js') }}" ></script>

{{--Dropdown filter--}}
<form id="choice" name="choice">
<input type="hidden" name="_token" value="{{csrf_token()}}">
     <select id="status" name="dept" class="form-control">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
        <option value="all">All</option>
  </select> 
   </form>

   {{--Search Bar--}}
   <div class="col-sm-6">
    <form class="ml-1" action="#" method="post">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search user..." name="search">
        <span class="input-group-btn">
          <input type="submit" name="searchuser" class="btn btn-primary" value="Search">
        </span>
      </div> 
    </form>
   </div>
</div>

{{--Users List--}}
<div class="content-div mr-2 mt-3">
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
            <td><a href="{{route('UserProfile',['upgid'=>$upgid,'id' => $user->user_id])}}">View</a></td>
            <td><a href="{{route('Delete',['upgid'=>$upgid,'id' => $user->user_id])}}">Delete</a></td>
            </tr>
        @endforeach
    </tbody>
 
      
  
    </table><br>
    {{$users->links()}}
  </div>

@endsection