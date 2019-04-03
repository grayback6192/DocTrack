@extends('mastertemplate')
@section('menu')
<li class="nav-item">
              <a class="nav-link" href="" data-placement="right" title="Inbox">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li class="nav-item active">
              <a class="nav-link" href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">mail</i>
                <p>
                  Inbox
                </p>
                  {{--  <div class="notification"> --}}
                    {{--Number of pending inbox--}}
                  {{-- </div> --}}
              </a>
 </li>

<li class="nav-item">
              <a class="nav-link" href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  In progress</p>
              </a>
 </li>

   <li class="nav-item">
              <a class="nav-link" href="{{route('complete',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Archive</p>
              </a>
 </li>
 
@endsection

@section('main_content')
<div class="container">
  @foreach($userinfos as $userinfo)
  <div class="row justify-content-center">
    <div class="card border-0" style="width: 80rem; padding: 15px;">
      <form action="{{Route("Update",['upgid'=>$upgid,'id'=>$User->user_id])}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset class="mt-3">
          <legend class="text-light">Personal Information</legend>
          <div class="media">
            <div class="media-left">
             <div class="picture-container">
               <div class="picture">
                <img id="user-prof-pic" src="{{url('./users/pictures/'.$userinfo->profilepic)}}" alt="prof-pic"/>
                <input type="file" name="profpic" id="wizard-picture" class="" />
               </div>
             </div>

              <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
              <script type="text/javascript">
                $(document).ready(function(){

                  $('#user-prof-pic').click(function(){
                    $('#profilepic').click();
                  });

                  function previewImage(input)
                  {
                    if(input.files && input.files[0])
                    {
                      var reader = new FileReader();

                      reader.onload = function(e){
                         var img = $('#user-prof-pic').attr('src', e.target.result);
                      }

                      reader.readAsDataURL(input.files[0]);
                    }
                  }

                  $('#wizard-picture').change(function(){
                    previewImage(this);
                  });

                });  
              </script>
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

          <div class="form-group text-light">
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
                {{-- <input type="file" class="form-control-file" name="sign" id="file-sign"> --}}
            </label>
            <div class="signdiv">
              {{-- <img src="{{url('./users/signatures/'.$userinfo->signature)}}" alt="sign" id="sign-view"> --}}
              @if($userinfo->signature!="")
              <img src="{{URL::to('/'.$userinfo->signature)}}" alt="sign" id="sign-view">
              @else
              <p class="text-center text-light">No signature uploaded.</p>
              @endif

              <input type="file" class="form-control-file" name="sign" id="file-sign">
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
          <legend class="text-light">Account</legend>
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
            <button class="btn btn-success" type="button" onclick="#">Change password</button>
          </div>
          

        </fieldset>
        <div class="row justify-content-end">
          <div class="col-md-3 col-md-offset-9">
          <div class="btn-toolbar">
            <input type="submit" name="edit" class="btn btn-success mr-3" value="Save">
            <a href="{{route('viewUserProfile',['upgid'=>$upgid])}}" class="btn btn-primary">Cancel</a>
          </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endforeach
</div>
@endsection