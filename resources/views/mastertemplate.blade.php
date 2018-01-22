<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>DocTrack</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
  
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-grid.min.css')}}">
  {{--   <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-reboot.min.css')}}"> --}}
    
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/material-dashboard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/datatables/dataTables.bootstrap4.css')}}">
   
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/demo.css') }}">
    <link href="{{ URL::asset('css/fresh-bootstrap-table.css')}}" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/fonts.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/googlefonts.css') }}">
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="orange" data-image="../assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <div class="simple-text">
                    Doctrack
                </div>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                   @yield('menu')
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Dashboard </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    {{-- <span class="notification">5</span> --}}
                                    <p class="hidden-lg hidden-md">Notifications</p>
                                </a>
                               {{--  <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Mike John responded to your email</a>
                                    </li>
                                    <li>
                                        <a href="#">You have 5 new tasks</a>
                                    </li>
                                    <li>
                                        <a href="#">You're now friend with Andrew</a>
                                    </li>
                                    <li>
                                        <a href="#">Another Notification</a>
                                    </li>
                                    <li>
                                        <a href="#">Another One</a>
                                    </li>
                                </ul> --}}
                            </li>
                            <li class="dropdown">
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                    {{Auth::user()->lastname}}
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                                 <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{route('chooseGroups',['userid'=>$User->user_id])}}">Exit Group</a>
                                    </li>
                                    <li>
                                        <a href="{{route('Logout')}}">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        {{-- <form class="navbar-form navbar-right" role="search">
                            <div class="form-group  is-empty">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </form> --}}
                    </div>
                </div>
            </nav>
<div class="content">
@yield('main_content')
</div>
</div>

</body>
@yield('datatables')

 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>    
<script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/material.min.js')}}" type="text/javascript"></script>
<!--  Dynamic Elements plugin -->
<script src="{{URL::asset('js/arrive.min.js')}}"></script>
<!--  PerfectScrollbar Library -->
<script src="{{URL::asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
<!--  Notifications Plugin    -->
<script src="{{URL::asset('js/bootstrap-notify.js')}}"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{URL::asset('js/material-dashboard.js?v=1.2.0')}}"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="{{URL::asset('js/demo.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

    });
</script>
</html>