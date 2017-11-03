<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="homecss/cssnav/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
   <link href="homecss/fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
     <link href="homecss/css/sb-admin.css" rel="stylesheet">

  </head>

  <body style="background-image: url('login.jpg')">

    <div class="container">

      <div class="card card-login mx-auto mt-5">
        <div class="card-header">
          Login
        </div>
        <div class="card-body">
          <form action = "{{Route("Credentials")}}" method = "post">
            {{csrf_field()}}
            <div class="form-group">
              <label for="exampleInputEmail1">Email</label>
              <input type="username" class="form-control" id="username" name = "email" placeholder="example@gmail.com">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="password" name = "password" placeholder="Password">
            </div>
            <div class="form-group">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input">
                  Remember Password
                </label>
              </div>
            </div>
            <input type = "submit" class="btn btn-primary btn-block" value = "Login">
          </form>
          <div class="text-center small"><br>
            Register as: <a href="{{route('RegisterClient')}}">Client</a> or <a href="{{route('RegisterUser')}}">User</a>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
   <script src="homejs/homejquery/jquery.min.js"></script>
    <script src="homejs/popper/popper.min.js"></script>
     <script src="homejs/bootstrap/bootstrap.min.js"></script>

  </body>

</html>
