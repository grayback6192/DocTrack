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
<div class="container">
  @foreach($userinfos as $userinfo)
  <div class="row justify-content-center">
    <div class="card border-0" style="width: 60rem">
      <form action="{{Route("Update",['upgid'=>$upgid,'id'=>$userinfo->user_id])}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset class="mt-3">
          <legend>Personal Information</legend>
          <div class="media">
             <div class="mr-3 ml-3 mt-3 prof-pic rounded-circle" style="border: 1px solid black" id="prof-frame">
              <input type="file" name="profpic" id="profilepic" style="display: none;" />
              <img id="user-prof-pic" src="{{url('./users/pictures/'.$userinfo->profilepic)}}" alt="prof-pic" style="display: block; width: 100%"/> {{--image here--}}

              <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
              <script type="text/javascript">
                $(document).ready(function(){

                  $('#prof-frame').hover(function(){
                    $(this).css('border','2px solid blue');
                    $(this).css('cursor','pointer');
                  });

                  $('#user-prof-pic').click(function(){
                    $('#profilepic').click();
                  });

                  function previewImage(input)
                  {
                    if(input.files && input.files[0])
                    {
                      var reader = new FileReader();

                      reader.onload = function(e){
                         $('#user-prof-pic').attr('src', e.target.result);
                        //$('#prof-frame').css('background', 'transparent url('+e.target.result+') left top no-repeat');
                      }

                      reader.readAsDataURL(input.files[0]);
                    }
                  }

                  $('#profilepic').change(function(){
                    previewImage(this);
                  });

                });  
              </script>

            </div>
          <div class="media-body">
          <div class="form-inline">
              <label class="mr-2">First Name</label>
            <div class="col">
              <input type="text" name="fname" class="form-control" placeholder="First Name" value="{{$userinfo->firstname}}">
            </div>
          
              <label class="mr-2">Last Name</label>
            <div class="col">
              <input type="text" name="lname" class="form-control" placeholder="Last Name" value="{{$userinfo->lastname}}">
            </div>
          </div>

          <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" placeholder="Address" value="{{$userinfo->address}}">
          </div>

          <div class="form-group">
            <label>Gender</label><br>
              <input type="radio" name="gender" value="male"> Male&nbsp;&nbsp;&nbsp;
            
          
              <input type="radio" name="gender" value="female"> Female
             

            @if($userinfo->gender=="Male")
                                <script type="text/javascript">
                                  document.getElementById("male").checked = true;
                                </script>
                              @elseif($userinfo->gender=="Female")
                                <script type="text/javascript">
                                  document.getElementById("female").checked = true;
                                </script>
                              @endif
          </div>

          <div class="form-group">
            <label>Signature</label><br>
            <label class="custom-file">
                <input type="file" class="form-control-file" name="sign" id="file-sign">
            </label>
            <div class="ml-3" id="signView" style="height: 50px; width: 50px;">
              <img src="{{url('./users/pictures/'.$userinfo->signature)}}" style="display: block; width: 100%;" alt="sign" id="sign-view">

              <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
              <script type="text/javascript">
                $(document).ready(function(){

                  function previewSign(input)
                  {
                    if(input.files && input.files[0])
                    {
                      var reader = new FileReader();

                      reader.onload = function(e){
                         $('#sign-view').attr('src', e.target.result);
                        //$('#prof-frame').css('background', 'transparent url('+e.target.result+') left top no-repeat');
                      }

                      reader.readAsDataURL(input.files[0]);
                    }
                  }

                  $('#file-sign').change(function(){
                    previewSign(this);
                  });

                });
                </script>  

            </div>
          </div>
        </div>  
          </div>
        </fieldset>

        <fieldset class="mt-3">
          <legend>Account</legend>
          <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" placeholder="E-mail" value="{{$userinfo->email}}">
          </div>
          {{--  <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" placeholder="New Password">
          </div>
           <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">
          </div> --}}
          {{-- <div class="form-group">
            <label>Password</label>
            <input type="password" name="userpassword" value="{{$userinfo->password}}">
          </div> --}}
        </fieldset>
        <div class="row justify-content-end mr-2 mt-3">
          <div class="btn-toolbar mb-3">
            <input type="submit" name="edit" class="btn btn-primary mr-3" value="Save">
            <a href="{{route('UserProfile',['upgid'=>$upgid,'id'=>$userinfo->user_id])}}" class="btn btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endforeach
</div>
@endsection