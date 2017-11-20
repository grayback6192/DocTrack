<!DOCTYPE html>
<html>
<head>
  <title>ONCINUE</title>
  <!-- Bootstrap core CSS -->
    {{-- <link href="../homecss/cssnav/bootstrap.css" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/cssnav/bootstrap.css')}}">
     
    <!-- Custom fonts for this template -->
    {{-- <link href="../homecss/fonts/font-awesome.min.css" rel="stylesheet" type="text/css"> --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/fonts/font-awesome.min.css')}}">

    <!-- Plugin CSS -->
    {{-- <link href="../homecss/datatables/dataTables.bootstrap4.css" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/datatables/dataTables.bootstrap4.css')}}">

    <!-- Custom styles for this template -->
    {{-- <link href="../homecss/css/sb-admin.css" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/css/sb-admin.css')}}">
</head>
  <body class="fixed-nav sticky-footer " id="page-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top" id="mainNav">
      <a class="navbar-brand" href="#">DocTrack</a>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

        <!-- SIDE MENU BAR -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="messagesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-fw fa-envelope"></i>
              <span class="d-lg-none">Messages
                <span class="badge badge-pill badge-primary">12 New</span>
              </span>
            </a>
          </li>



          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-fw fa-user"></i>
              <span class="d-lg-none">Alerts
                <span class="badge badge-pill badge-warning">6 New</span>
              </span>
            </a>
          </li>
          <li class = "nav-item">
            {{$User->lastname}} {{-- Authentication Name --}}
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('Logout')}}">
              <i class="fa fa-fw fa-sign-out"></i>
              Logout</a>
          </li>
        </ul>
      </div>
    </nav>

<!--CONTENT HERE-->
<div class="content-wrapper">

   <div class="row" style="margin-top: 40px;"> <!--First Row-->
  <div class="col-sm-6">
    <a href="{{route('UserManage')}}"><div class="card" style="width: 15rem; border: none;">
      <i class="fa fa-5x fa-user"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem;">Users</h3>
      </div>
    </div></a>
  </div>
  <div class="col-sm-6">
    <a href="{{route('viewDep')}}"><div class="card" style="width: 15rem; border: none;">
       <i class="fa fa-5x fa-building"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">Departments</h3>
      </div>
    </div></a>
  </div>

  <div class="col-sm-6">
    <a href="{{route('viewRolePage')}}"><div class="card" style="width: 15rem; border: none;">
       <i class="fa fa-5x fa-star"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">Positions</h3>
      </div>
    </div></a>
  </div>
</div>

<div class="row" style="margin-top: 10%;"> <!--Second Row-->
<div class="col-sm-6">
    <a href="{{route('viewWorkflow')}}"><div class="card" style="width: 15rem; border: none;">
       <i class="fa fa-5x fa-group"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">Workflows</h3>
      </div>
    </div></a>
  </div>

  <div class="col-sm-6">
    <a href="{{route('AdminTemplate')}}"><div class="card" style="width: 15rem; border: none;">
       <i class="fa fa-5x fa-file-o"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">Templates</h3>
      </div>
    </div></a>
  </div>

  <div class="col-sm-6">
    <a href="#"><div class="card" style="width: 15rem; border: none;">
       <i class="fa fa-5x fa-archive"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">Archive</h3>
      </div>
    </div></a>
  </div>
</div>

</div>
     
  </body>
</html>