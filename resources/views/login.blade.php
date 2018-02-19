<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
  <link rel="icon" type="image/png" href="{{URL::asset('img/logos.png')}}"/>
<!--===============================================================================================-->

  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login/bootstrap.min.css')}}">
<!--===============================================================================================-->

  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login/font-awesome.min.css')}}">
<!--===============================================================================================-->

  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login/icon-font.min.css')}}">
<!--===============================================================================================-->

  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login/animate.css')}}">
<!--===============================================================================================-->  

  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login/hamburgers.min.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login/animsition.min.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login/select2.min.css')}}">
<!--===============================================================================================-->  

  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login/daterangepicker.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login/util.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login/main.css')}}">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
  
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form action = "{{Route("Credentials")}}" method = "post" class="login100-form validate-form">
          {{csrf_field()}}
           
          <span class="login100-form-title p-b-43">
            Login
          </span>
          
          
          <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
            <input class="input100" type="text" name="email">
            <span class="focus-input100"></span>
            <span class="label-input100">Email</span>
          </div>
          
          
          <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input class="input100" type="password" name="password">
            <span class="focus-input100"></span>
            <span class="label-input100">Password</span>
          </div>

          <div class="container-login100-form-btn">
            <input type ="submit" class="login100-form-btn" value = "Login">
          </div>
          
          <div class="text-center p-t-46 p-b-20">
            <span class="txt2">
              Register as 
            </span>
            <div class="text-center small"><br>
            <a href="{{route('RegisterClient')}}">Client</a> or <a href="{{route('RegisterUser')}}">User</a>
        </div>
          </div>

        </form>

        <div class="login100-more" style="background-image: url('{{URL::asset('img/cover.jpg')}}');">
        </div>
      </div>
    </div>
  </div>
  
  

  
  
<!--===============================================================================================-->

  <script src="{{ URL::asset('js/login/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->

  <script src="{{ URL::asset('js/login/animsition.min.js')}}"></script>
<!--===============================================================================================-->

  <script src="{{ URL::asset('js/login/popper.js')}}"></script>
  <script src="{{ URL::asset('js/login/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->

  <script src="{{ URL::asset('js/login/select2.min.js')}}"></script>
<!--===============================================================================================-->

  <script src="{{ URL::asset('js/login/moment.min.js')}}"></script>
  <script src="{{ URL::asset('js/login/daterangepicker.js')}}"></script>
<!--===============================================================================================-->

  <script src="{{ URL::asset('js/login/countdowntime.js')}}"></script>
<!--===============================================================================================-->

  <script src="{{ URL::asset('js/login/main.js')}}"></script>

</body>
</html>