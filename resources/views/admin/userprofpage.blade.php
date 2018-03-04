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
<div class="content">

@foreach($userinfos as $userinfo)
  <div class="row justify-content-start" style="margin-left: 10px">
    <a class="btn btn-primary" href="{{route('UserManage',['upgid'=>$upgid])}}">Back</a>
  </div>

  <div class="row justify-content-center">
    <div class="card" style="width: 700px;">
       <div class="text-right" style="margin-right: 2px;">
          <a class="btn btn-primary" href="{{route('EditProfile',['upgid'=>$upgid,'id'=>$userinfo->user_id])}}">
            <i class="material-icons" style="width: 20px;">edit_mode</i> Edit Profile
          </a>
        </div>
      <div class="card-block">
       
        <div class="card-body">
            <div class="media">
              <div class="media-left">
            <div class="picture-container">
              <div class="picture">
                <img class="media-object" src="{{url('./users/pictures/'.$userinfo->profilepic)}}" alt="profile pic"/>
              </div>
            </div>
            </div>
            <div class="media-body" style="padding-left: 50px;">
              <h1>{{$userinfo->firstname}} {{$userinfo->lastname}}</h1>
              <p class="profileinfo"><i class="material-icons">person_pin</i> {{$userinfo->gender}}</p>
              <p class="profileinfo"><i class="material-icons">directions</i> {{$userinfo->address}}</p>
              <p class="profileinfo"><i class="material-icons">email</i> {{$userinfo->email}}</p>
            </div>
            </div>

              <div class="panel panel-default" style="margin: 20px 5px;">
              <div class="panel-heading">
                <h3 class="panel-title">Groups Joined</h3>
              </div>
              <div class="panel-body" style="padding: 5px;">
                <div class="dep-menu">
                  @if(isset($usergroups))
                     @foreach($usergroups as $usergroup)
                      <div class="card" style="border:0">
                        <div class="depiconframe text-center" style="padding: 20px;">
                          <i class="material-icons" style="font-size: 80px;">business</i>
                        </div>
                        <div class="card-block">
                          <div class="card-body text-center">
                             <h4>{{$usergroup->groupName}}</h4>
                          </div>
                        </div>
                      </div>
                      @endforeach
                  @endif
                </div>
              </div>
            </div>
        </div>

{{--          <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>
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
          </script> --}}
      </div>
    </div>
  </div>
@endforeach

</div>
@endsection

 {{--  <div class="fa fa-2x mt-2 mr-2">
          <label class="switch">
            <input type="checkbox" name="userstatus" checked>
            <span class="slider round"></span>
          </label>
          </div> --}}