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
<div class="container">
  @foreach($userinfos as $userinfo)
  <div class="row justify-content-center">
    <div class="card border-0" style="width: 80rem; padding: 15px;">
      <form action="{{Route("Update",['upgid'=>$upgid,'id'=>$userinfo->user_id])}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset class="mt-3">
          <legend>Personal Information</legend>
          <div class="media">
            <div class="media-left">
            <div class="img-circle profilepic" id="pic" data-toggle="tooltip" data-placement="bottom" title="Change Profile Picture">
             <div class="media-object">
              <input type="file" name="profpic" id="profilepic" style="display: none;" />
              <img id="user-prof-pic" src="{{url('./users/pictures/'.$userinfo->profilepic)}}" alt="prof-pic"/> {{--image here--}}

              <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
              <script type="text/javascript">
                $(document).ready(function(){

                  // $('#prof-frame').hover(function(){
                  //   $(this).css('border','2px solid blue');
                  //   $(this).css('cursor','pointer');
                  // });

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
          </div>
          </div>
          <div class="media-body" style="padding: 0 20px;">

            <div class="form-group">
              <label>First Name</label>
              <input type="text" name="fname" class="form-control" placeholder="First Name" value="{{$userinfo->firstname}}">
            </div>
          
            <div class="form-group">
              <label>Last Name</label> 
              <input type="text" name="lname" class="form-control" placeholder="Last Name" value="{{$userinfo->lastname}}">
            </div>

          <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" placeholder="Address" value="{{$userinfo->address}}">
          </div>

          <div class="form-group">
            <label>Gender</label><br>
              <input type="radio" name="gender" id="male" value="male"> Male&nbsp;&nbsp;&nbsp;
            
          
              <input type="radio" name="gender" id="female" value="female"> Female
             

            @if($userinfo->gender=="Male" || $userinfo->gender=="male")
                                <script type="text/javascript">
                                  document.getElementById("male").checked = true;
                                </script>
                              @elseif($userinfo->gender=="Female" || $userinfo->gender=="female")
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
            <div class="signaturediv">
              <img src="{{url('./users/signatures/'.$userinfo->signature)}}" alt="sign" id="sign-view">

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

         {{--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePass">Change Password</button>

           <div class="modal fade" tabindex="-1" role="dialog" id="changePass">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                  <form action="#">
                    <div class="form-group">
                      <label>Old Password</label>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div> --}}
          <div class="form-group">
            <button class="btn btn-warning" type="button" onclick="#">Change to default password</button>
          </div>
          

        </fieldset>
        <div class="row">
          <div class="col-md-3 col-md-offset-9">
          <div class="btn-toolbar">
            <input type="submit" name="edit" class="btn btn-primary mr-3" value="Save">
            <a href="{{route('UserProfile',['upgid'=>$upgid,'id'=>$userinfo->user_id])}}" class="btn btn-default">Cancel</a>
          </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endforeach
</div>
@endsection