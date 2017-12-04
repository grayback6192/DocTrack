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

    <!--Org Chart-->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/orgchart/css/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/orgchart/css/jquery.orgchart.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/orgchart/css/style.css')}}">

    
</head>
  <body class="fixed-nav sticky-footer " id="page-top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white" id="mainNav">
      <div class="navbar-brand bg-dark" href="#">DocTrack</div>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

            @yield('menu')
           {{--  <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" data-toggle="collapse" href="#" data-placement="right" title="Inbox">
                <i class="fa fa-send fa-fw"></i>
                <span class="nav-link-text">
                  Sent File</span>
              </a>
            </li> --}}
          </ul>
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
            <a class="nav-link dropdown-toggle mr-lg-2 top-nav-item" href="javascript:opendrop()" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{-- <input type="button" class="nav-link dropdown-toggle mr-lg-2" href="#" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> --}}
              {{$User->lastname}}
              <i class="fa fa-fw fa-user"></i>
              <span class="d-lg-none">Alerts
                <span class="badge badge-pill badge-warning">6 New</span>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="alertsDropdown" id="drop">
              <a class="dropdown-item" href="{{route('chooseGroups',['userid'=>$User->user_id])}}">
                <div class="dropdown-message small">Exit Group</div>
              </a>
            </div>
            <script type="text/javascript">
              function opendrop()
              {
                var modal = document.getElementById('drop');
                modal.className = 'dropdown-view';
              }
            </script>
          </li>
          <li class = "nav-item">
           {{--  <div class="nav-link">{{$User->lastname}} | {{Session::get('upgid')}}</div> --}} {{-- Authentication Name --}}
          </li>
          <li class="nav-item">
            <a href="{{route('Logout')}}" class="nav-link top-nav-item">
                Logout
              <i class="fa fa-fw fa-sign-out"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>


<div class="content-wrapper">
    @yield('main_content')
  </div>
      <!-- /.container-fluid -->
     

    </div>
    
  </body>
  

</html>