<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login | DocTrack</title>

    <!-- Bootstrap core CSS -->
    <link href="homecss/cssnav/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
   <link href="homecss/fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
     <link href="homecss/css/sb-admin.css" rel="stylesheet">

  </head>

  {{-- <body style="background-image: url('login.jpg')"> --}}
<body>
    <div class="container">

      <h1 class="mt-5">DocTrack</h1>

      <div class="card card-login mt-5 border-0">
        <div class="card-body p-0">
          <form action = "{{Route("Credentials")}}" method = "post">
            {{csrf_field()}}
            <div class="form-group">
              <label for="exampleInputEmail1">Email</label>
              <input type="username" class="form-control form-blank" id="username" name = "email" placeholder="example@gmail.com">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control form-blank" id="password" name = "password" placeholder="Password">
            </div>
            <div class="form-group">
            </div>
            <div class="justify-content-center mt-5">
              <input type = "submit" class="btn btn-primary btn-block" value = "Login">
            </div>
          </form>
          <div class="text-center small"><br>
            Register as: <a href="{{route('RegisterClient')}}">Client</a> or <a href="{{route('RegisterUser')}}">User</a>
            
          </div>
        </div>
      </div>
    </div>
    <br>
    <!-- Bootstrap core JavaScript -->
   <script src="homejs/homejquery/jquery.min.js"></script>
    <script src="homejs/popper/popper.min.js"></script>
     <script src="homejs/bootstrap/bootstrap.min.js"></script>

  </body>

</html>
