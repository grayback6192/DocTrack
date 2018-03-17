<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="{{URL::asset('img/logos.png')}}" />
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
     <div class="main-panel1" style="margin-left: 60px; margin-right: 50px;">
            <nav class="navbar navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        {{-- <a class="navbar-brand" href="#"> Dashboard </a> --}}
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                           {{--  <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i> --}}
                                    {{-- <span class="notification">5</span> --}}
                                   {{--  <p class="hidden-lg hidden-md">Notifications</p>
                                </a>
                            </li> --}}
                            <li class="dropdown">
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                    {{Auth::user()->lastname}}
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                                 <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{route('Logout')}}">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                       {{--  <form class="navbar-form navbar-right" role="search">
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

<!--CONTENT HERE-->
<div class="content">
  <div class="card">
    <div class="card-header" data-background-color="orange">
    <h4 class="title">Choose a Department</h4>
    <p class="category">Choose a department you wish to log in as.</p>
   </div>
  </div>  
  <a class="btn btn-warning" href="{{route('addGroup',['id'=>$User->user_id,'depid'=>$clientId])}}">Choose Department</a>
</div>
   <div class="row"> <!--First Row-->
  @if(isset($usergroups))
  @foreach($usergroups as $usergroup)
  <div class="col-lg-3 col-md-6 col-sm-6">
    <a href="{{route('gotogroup',['groupid'=>$usergroup->group_id,'rightid'=>$usergroup->rights_rights_id])}}">
      <div class="card card-stats" style="border: none;">
         <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">business</i>
                                </div>

       <div class="card-content">
                                    <h3 class="title">{{$usergroup->groupName}}</h3>
                                    <p class="category">{{$usergroup->posName}}</p>
                                </div>
    </div></a>
  </div>
  @endforeach
  @endif
</div>

</div>
   </div>  
  </body>
   <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
<script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
</html>