<!DOCTYPE html>
<html>
<head>
  <title>ONCINUE</title>
  <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/cssnav/bootstrap.css')}}">
     
    <!-- Custom fonts for this template -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/fonts/font-awesome.min.css')}}">

    <!-- Plugin CSS -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/datatables/dataTables.bootstrap4.css')}}">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/css/sb-admin.css')}}">
</head>
  <body class="fixed-nav sticky-footer " id="page-top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-dark" id="mainNav">
      <div class="navbar-brand bg-dark">DocTrack</div>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

        <!-- SIDE MENU BAR -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle mr-lg-2 top-nav-item" href="#" id="messagesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-fw fa-envelope"></i>
              <span class="d-lg-none">Messages
                <span class="badge badge-pill badge-primary">12 New</span>
              </span>
            </a>
          </li>



          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle mr-lg-2 top-nav-item" href="#" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{$User->lastname}}
              <i class="fa fa-fw fa-user"></i>
              <span class="d-lg-none">Alerts
                <span class="badge badge-pill badge-warning">6 New</span>
              </span>
            </a>
          </li>
         {{--  <li class = "nav-item">
            {{$User->lastname}} Authentication Name
          </li> --}}
          <li class="nav-item">
            <a class="nav-link top-nav-item" href="{{route('Logout')}}">
              Logout  
              <i class="fa fa-fw fa-sign-out"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>

<!--CONTENT HERE-->
<div class="content-wrapper">

   <div class="row mt-5"> <!--First Row-->
  <div class="col-sm-6">
    <a href="{{route('UserManage')}}">
    <div class="card text-center border-0 hvr-underline-from-center" style="width:15rem">
      <i class="fa fa-5x fa-user"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem;">Users</h3>
      </div>
    </div></a>
  </div>
  <div class="col-sm-6">
    <a href="{{route('viewDep')}}">
      <div class="card text-center border-0 hvr-underline-from-center" style="width: 15rem;">
       <i class="fa fa-5x fa-building"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">Departments</h3>
      </div>
    </div></a>
  </div>

  <div class="col-sm-6">
    <a href="{{route('viewRolePage')}}">
    <div class="card text-center border-0 hvr-underline-from-center" style="width: 15rem;">
       <i class="fa fa-5x fa-star"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">Positions</h3>
      </div>
    </div></a>
  </div>
</div>

<div class="row" style="margin-top: 10%;"> <!--Second Row-->
<div class="col-sm-6">
    <a href="{{route('viewWorkflow')}}">
      <div class="card text-center border-0 hvr-underline-from-center" style="width: 15rem;">
       <i class="fa fa-5x fa-group"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">Workflows</h3>
      </div>
    </div></a>
  </div>

  <div class="col-sm-6">
    <a href="{{route('viewOwners')}}">
      <div class="card text-center border-0 hvr-underline-from-center" style="width: 15rem;">
       <i class="fa fa-5x fa-file-o"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">Templates</h3>
      </div>
    </div></a>
  </div>

  <div class="col-sm-6">
    <a href="#"><div class="card text-center border-0 hvr-underline-from-center" style="width: 15rem;">
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