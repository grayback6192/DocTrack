<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="assets/img/favicon.png" />
  <title>Register | User</title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

  <!-- CSS Files -->
     <link rel="stylesheet" type="text/css" href="{{URL::asset('css/logincss/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{URL::asset('css/logincss/css/paper-bootstrap-wizard.css')}}">

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link href="assets/css/demo.css" rel="stylesheet" /> -->

  <!-- Fonts and Icons -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
 <link rel="stylesheet" type="text/css" href="{{URL::asset('css/logincss/css/themify-icons.css')}}">
</head>

<body>
  <div class="image-container set-full-height">
    

    

      <!--   Big container   -->
      <div class="container">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">

                <!--      Wizard container        -->
                <div class="wizard-container">

                    <div class="card wizard-card" data-color="blue" id="wizardProfile">
                      @foreach($user as $profile)
                        <form action="{{Route("Update",['id'=>$profile->user_id])}}" method="post" enctype="multipart/form-data">
                    <!--        You can switch " data-color="orange" "  with one of the next bright colors: "blue", "green", "orange", "red", "azure"          -->
                    
                      {{csrf_field()}}
                          <div class="wizard-header text-center">
                              <h3 class="wizard-title">User Profile</h3>
                                    <input type="submit" class="btn btn-fill btn-info btn-wd" name="edit" value="Save">
                                     <a href="{{route('UserProfile',['id'=>$profile->user_id])}}" class='btn btn-fill btn-info btn-wd' name='edit'>Cancel</a> 
                          </div>

                <div class="wizard-navigation">
                  <div class="progress-with-circle">
                       <div class="progress-bar" role="progressbar" aria-placeholdernow="1" aria-placeholdermin="1" aria-placeholdermax="3" style="width: 21%;"></div>
                  </div>
                  <ul>
                                  <li>
                      <a href="#about" data-toggle="tab">
                        <div class="icon-circle">
                          <i class="ti-user"></i>
                        </div>
                        Your Info
                      </a>
                    </li>
                                  <li>
                      <a href="#address" data-toggle="tab">
                        <div class="icon-circle">
                          <i class="ti-map"></i>
                        </div>
                        Address
                      </a>
                    </li>
                              </ul>
                </div>
                            <div class="tab-content">
                                <div class="tab-pane" id="about">
                                  <div class="row">
                      <h5 class="info-text">Personal Information</h5>
                      <div class="col-sm-4 col-sm-offset-1">
                        <div class="picture-container">
                          <div class="picture">
                            <img src="assets/img/default-avatar.jpg" class="picture-src" id="wizardPicturePreview" title= />
                            <input type="file" name="image" id="wizard-picture">
                          </div>
                          <h6></h6>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>First Name</label>
                          <input name="fname" input type="text" class="form-control" name="fname" placeholder="First Name" value="{{$profile->firstname}}">
                        </div>
                        <div class="form-group">
                          <label>Last Name </label>
                          <input name="lname"  input type="text" class="form-control" name="lname" placeholder="Last Name" value="{{$profile->lastname}}">
                        </div>
                        <div class="form-group">
                          <label>Address</label>
                          <input name="address"  input type="text" class="form-control" name="address" placeholder="Address" value="{{$profile->address}}">
                        </div>
                        <div class="form-group">
                          <label>Gender<small>(required)</small></label>
                          <label class="radio-inline">
                              <input type="radio" name="gender" id="optionsRadiosInline1" value="Male" > Male</label>

                          <label class="radio-inline">
                              <input type="radio" name="gender" id="optionsRadiosInline2" value="Female"> Female</label>
                              @if($profile->gender=="Male")
                                <script type="text/javascript">
                                  document.getElementById("optionsRadiosInline1").checked = true;
                                </script>
                              @elseif($profile->gender=="Female")
                                <script type="text/javascript">
                                  document.getElementById("optionsRadiosInline2").checked = true;
                                </script>
                              @endif

                        </div>
                         <div class="form-group">
                          <label>Signature</label>
                          <input name="sign"  input type="text" class="form-control" name="address" placeholder="Address" value="{{$profile->signature}}">
                        </div>
                      </div>
                    
                    </div>
                                </div>
                                <div class="tab-pane" id="address">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h5 class="info-text">  Account </h5>
                                        </div>
                                        <div class="col-sm-7 col-sm-offset-1">
                                          <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" input type="text"  class="form-control" placeholder="example@gmail.com" value="{{$profile->email}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-7 col-sm-offset-1">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input input type="password"  class="form-control" name = "password" placeholder="Password" value="{{$profile->password}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-7 col-sm-offset-1">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input input type="password"  name = "password_confirmation" class="form-control" placeholder="Confirm Password" value="{{$profile->password}}">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-footer">
                                <div class="pull-right">
                                    <input type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Next' />
                                   <!--  <input type='submit' class='btn btn-finish btn-fill btn-info btn-wd' name='finish' placeholder='Finish' /> -->
                                </div>

                                <div class="pull-left">
                                    <input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Previous' />
                                </div>
                                <div class="clearfix"></div>
                            </div>    
                        </form>
                        @endforeach
                    </div>
                </div> <!-- wizard container -->
            </div>
        </div><!-- end row -->
    </div> <!--  big container -->

      <div class="footer">
          <div class="container text-center">
              ONCINUE
          </div>
      </div>
  </div>

</body>

  <!--   Core JS Files   -->
  <script src="{{URL::asset('css/logincss/js/jquery-2.2.4.min.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('css/logincss/js/bootstrap.min.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('css/logincss/js/jquery.bootstrap.wizard.js')}}" type="text/javascript"></script>

  <!--  Plugin for the Wizard -->
  <script src="{{URL::asset('css/logincss/js/paper-bootstrap-wizard.js')}}" type="text/javascript"></script>

  <!--  More information about jquery.validate here: http://jqueryvalidation.org/  -->
  <script src="{{URL::asset('logincss/js/jquery.validate.min.js')}}" type="text/javascript"></script>

</html>
