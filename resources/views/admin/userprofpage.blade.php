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
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewOwners')}}" data-placement="right" title="Inbox">
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

@foreach($userinfos as $userinfo)
  <div class="row justify-content-start ml-2">
    <a class="btn btn-primary" href="{{route('UserManage')}}">Back</a>
  </div>

  <div class="row justify-content-center">
    <div class="card border-0" style="width: 40rem">
      <div class="card-block">
        <div class="row justify-content-end mr-2">
          <div class="fa fa-2x mt-2 mr-2">
          <label class="switch">
            <input type="checkbox" name="userstatus" checked>
            <span class="slider round"></span>
          </label>
          </div>
          <a href="{{route('EditProfile',['id'=>$userinfo->user_id])}}"><i class="fa fa-cogs fa-2x mt-2" data-toggle="collapse" data-placement="right" title="Edit"></i></a>
        </div>
        <div class="card-title m-2">
          <div class="media mt-5">
            <div class="mr-3 ml-3 prof-pic rounded-circle" style="border: 1px solid black;">
             <img src="{{url('./users/pictures/'.$userinfo->profilepic)}}" style="display: block; width: 100%" alt="prof-pic" />{{--image here--}}
            </div>
            <div class="media-body pt-lg-3">
              <h3>{{$userinfo->firstname}} {{$userinfo->lastname}}</h3>
              <p>{{$userinfo->address}}</p>
            </div>
          </div>
          <div class="row mt-5">
          <div class="btn-toolbar mb-2 col align-self-end">
            <div class="col-4">
              <a href="#" class="hvr-underline-reveal" id="prof-group">GROUP</a>
            </div>
            <a href="#" class="hvr-underline-reveal" id="prof-account">ACCOUNT</a>
          </div>
          </div>
        </div>

        <div class="card-text m-2 prof-info" style="border: 1px solid black">
         <div id="prof-content" class="mt-2 ml-2 mr-2 mb-2">
           @foreach($usergroups as $usergroup)
            {{$usergroup->groupName}}<br>
           @endforeach
         </div>
        </div>
         <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>
          <script type="text/javascript">
            $(document).ready(function(){
              $('#prof-group').click(function(){
                console.log('group here');

                $('#prof-content').empty();
                var content = "";
              
               var userid = {{$userinfo->user_id}};
               $.ajax({
                type: 'GET',
                url: 'http://localhost:8000/admin/user/group/'+userid,
                success: function(data){
                  for(var i=0;i<data.length;i++)
                  {
                    content+=data[i].groupName+"<br>";
                  }
                    $('#prof-content').append(content);
                }
               });

               

              });

              $('#prof-account').click(function(){
                console.log('account here');

                $('#prof-content').empty();
                var content = "";

                var userid = {{$userinfo->user_id}};
               $.ajax({
                type: 'GET',
                url: 'http://localhost:8000/admin/user/account/'+userid,
                success: function(data){
                  for(var i=0;i<data.length;i++)
                  {
                    content+="Email Account: <br>";
                    content+=data[i].email;
                  }
                    $('#prof-content').append(content);
                }
               });
                 //$('#prof-content').append(content);

              });
            });
          </script>
      </div>
    </div>
  </div>
@endforeach

</div>
@endsection