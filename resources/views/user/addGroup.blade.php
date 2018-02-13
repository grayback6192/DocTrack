<!DOCTYPE html>
<html>
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
                            <li>
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">dashboard</i>
                                    <p class="hidden-lg hidden-md">Dashboard</p>
                                </a>
                            </li>
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
                                   {{--  <li>
                                        <a href="{{route('chooseGroups',['userid'=>$User->user_id])}}">Exit Group</a>
                                    </li> --}}
                                    <li>
                                        <a href="{{route('Logout')}}">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <form class="navbar-form navbar-right" role="search">
                            <div class="form-group  is-empty">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
   

<!--CONTENT HERE-->
<div class="content">
  <div class="row" style="margin-top: 20px; margin-bottom: 20px; margin-left: 10px;">
    <a class="btn btn-primary" href="{{route('chooseGroups',['userid'=>$User->user_id])}}">Back</a>
  </div>
<div class="row">
 @if(isset($groups))
    @foreach($groups as $group)
      <div class="col-sm-6">

      <a href="javascript:openGroupModal({{$group->group_id}})">
      <div class="card card-stats" style="width: 15rem; border: none;">
        <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">business</i>
                                </div>
         <div class="card-content">
                                    <h3 class="title">{{$group->groupName}}</h3>
                                </div>
    </div></a>

        <!--Enter Group Modal-->
        <div id="entergroup-{{$group->group_id}}" class="modal">
          <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Enter a Group</h5>
          </div>
          <div class="modal-body">
    <form method="post" action="{{route('enterGroup')}}">
    {{csrf_field()}}
    <input type="hidden" name="groupid" value="{{$group->group_id}}"><br>
    <input type="hidden" name="clientid" value="{{$group->client_id}}"><br> 
        Group Key: <input type="password" id="gkey-{{$group->group_id}}" name="groupkey"> <a id="showgkey-{{$group->group_id}}" href="javascript:showGKey({{$group->group_id}})">Show</a><a id="hidegkey-{{$group->group_id}}" style="display: none" href="javascript:hideGKey({{$group->group_id}})">Hide</a><br>
        <script type="text/javascript">

          function showGKey(groupid)
          {
            var showbtn = document.getElementById('showgkey-'+groupid);
            var hidebtn = document.getElementById('hidegkey-'+groupid);
            var gkey = document.getElementById('gkey-'+groupid);

            showbtn.style.display = "none";
            hidebtn.style.display = "block";
            gkey.type="text";
          }

          function hideGKey(groupid)
          {
            var showbtn = document.getElementById('showgkey-'+groupid);
            var hidebtn = document.getElementById('hidegkey-'+groupid);
            var gkey = document.getElementById('gkey-'+groupid);

            showbtn.style.display = "block";
            hidebtn.style.display = "none";
            gkey.type="password";
          }

          
        </script>
        Join as: <br>
            <input type="radio" name="position" value="Student">Student<br>
            <input type="radio" name="position" value="Employee">Employee<br><br>

            <input type="submit" class="btn btn-primary" name="submit" value="Enter Group">&nbsp;&nbsp;
            {{-- <input type="button" id="exit" value="Cancel" onclick="closeGroupModal({{$group->group_id}})"> --}}
            <a class="btn btn-primary" href="javascript:closeGroupModal({{$group->group_id}})">Cancel</a>
    </form>
  </div>
  </div>
  </div>
        </div>

        <script type="text/javascript">
          function openGroupModal(gid)
          {
            var modal = document.getElementById('entergroup-'+gid);
            modal.style.display = "block";
          }

          function closeGroupModal(gid)
          {
            var modal2 = document.getElementById('entergroup-'+gid);
            modal2.style.display = "none";
          }
        </script>  
</div>
@endforeach
@endif
</div>
 </div>
  </body>

  <script src="{{URL::asset('js/orgchartjs/jquery.min.js')}}" type="text/javascript"></script>  

<script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript"></script>    
<script src="{{URL::asset('js/material.min.js')}}" type="text/javascript"></script>
{{--AJAX Search--}}
<script type="text/javascript" src="{{URL::asset('css/datatables/jQuery.dataTables.js')}}"></script>

{{--For Mobile--}}
<script src="{{URL::asset('js/arrive.min.js')}}" type="text/javascript"></script>
<!--  PerfectScrollbar Library -->
<script src="{{URL::asset('js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
<!--  Notifications Plugin    -->
<script src="{{URL::asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{URL::asset('js/material-dashboard.js?v=1.2.0')}}" type="text/javascript"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="{{URL::asset('js/demo.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

    });
</script>
</html>