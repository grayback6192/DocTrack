@extends('mastertemplate')

@section('menu')
 <li class="active">
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
   <div class="col-sm-4">
    <form class="ml-1" action="#" method="post">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search user..." name="search">
        <span class="input-group-btn">
          <button type="submit" name="searchuser" class="btn btn-white btn-round btn-just-icon">
            <i class="material-icons">search</i>
            <div class="ripple-container"></div>
          </button>
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