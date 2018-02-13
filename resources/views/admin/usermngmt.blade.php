@extends('mastertemplate')

@section('menu')
 <li class="active">
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


<div class="row justify-content-end">
<div class="form-group col-sm-2">
{{--Dropdown filter--}}
<form id="choice" name="choice">
<input type="hidden" name="_token" value="{{csrf_token()}}">
     <select id="status" name="dept" class="form-control">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
        <option value="all">All</option>
  </select> 
   </form>
 </div>
</div>

@if(session('activeuser'))
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{session('activeuser')}}
  </div>
@endif

@if(session('userremoved'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{session('userremoved')}}
  </div>
@endif

{{--Users List--}}
{{-- <div class="content-div mr-2 mt-3"> --}}
    <table class="table" id="users-table">
      <thead>
            <tr>
    	       <th>Last Name</th>
    	       <th>First Name</th>
    	       <th></th>
             <th></th>
            </tr>
    </thead>
    <tbody>
      @foreach ($users as $user) 
            <tr id="{{$user->user_id}}">
            <td>{{$user->lastname}}</td>
            <td>{{$user->firstname}}</td>
            <td><a class="btn btn-info" href="{{route('UserProfile',['upgid'=>$upgid,'id' => $user->user_id])}}"><i class="material-icons">face</i></a></td>
            {{-- <td><a href="{{route('Delete',['upgid'=>$upgid,'id' => $user->user_id])}}"><i class="material-icons">delete</i></a></td> --}}
            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteusermodal-{{$user->user_id}}"><i class="material-icons">delete</i></button></td>

           <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="deleteusermodal-{{$user->user_id}}">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="text-center">Delete User?</h4>
                </div>
                <div class="modal-body">
                  <form method="post" action="{{route('DeleteUser')}}">
                    {{csrf_field()}}
                    <input type="text" name="userid" value="{{$user->user_id}}" hidden><input type="text" name="upgid" value="{{$upgid}}" hidden>
                    <div class="btn-group btn-group-justified">
                      <div class="btn-group">
                        <button type="submit" class="btn btn-success">
                          <i class="material-icons">done</i>
                        </button>
                      </div>
                      <div class="btn-group">
                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <i class="material-icons">clear</i>
                        </button>
                      </div>
                    </div>
                    </form>
                </div>
              </div>
            </div>
          </div>

            </tr>
        @endforeach
    </tbody>
    </table>
 {{--  </div> --}}

@endsection
@section('js')
<script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>
<script type="text/javascript">
        $(document).ready(function () {
            $('#users-table').DataTable();
        });
    </script>
<script type="text/javascript">var upgid="<?php echo $upgid; ?>";</script>
<script type="text/javascript" src="{{ URL::asset('js/doctrack.js') }}" ></script>
@endsection