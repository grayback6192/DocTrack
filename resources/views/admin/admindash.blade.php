<!DOCTYPE html>
<html>
<head>
  <title>DocTrack</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="{{ URL::asset('NEWUI/css/material-dashboard.css?v=2.1.0')}}" rel="stylesheet" />
</head>
  <body class="dark-edition">
     <div class="main-panel1" style="margin-left: 60px; margin-right: 50px;">
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#"> Admin </a>
                    </div>
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  {{Auth::user()->lastname}}
                                    <i class="material-icons">person</i>
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
                    </div>
                </div>
            </nav>

<!--CONTENT HERE-->
<div class="content">
<br><br><br><br><br>
                  <div class=".col-6 .col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#">
                    <img class="img" src="/users/pictures/{{$userprof}}" />
                  </a>
                </div>
                <div class="card-body">
                 
                  <h4 class="card-title">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</h4>
                   <h6 class="card-category">ADMIN</h6>
                  <p class="card-description">
                   My address is {{Auth::user()->address}}.<br>My contact number is {{Auth::user()->contactnum}}.<br>This account is {{Auth::user()->status}}
                  </p>
                </div>
              </div>
            </div>

<div class="row" style="margin-top: 40px;"> <!--First Row-->

<div class="col-6">

              <div class="card card-profile">
                <div class="card-body">
                   <a href="#pablo">
                     <i class="material-icons" style="font-size: 100px;">group</i>
                  </a>
                  <h4 class="card-title">Workflows</h4>
                  <a href="{{route('viewWorkflow',['upgid'=>$upgid])}}" class="btn btn-info btn-round">Open</a>
                </div>
              </div>
  </div>






  <div class="col-6">
    <div class="card card-profile">
                <div class="card-body">
                   <a href="#pablo">
                     <i class="material-icons" style="font-size: 100px;">description</i>
                  </a>
                  <h4 class="card-title">Templates</h4>
                  <a href="{{route('viewOwners',['upgid'=>$upgid])}}" class="btn btn-info btn-round">Open</a>
                </div>
              </div>
  </div>

</div>

   <div class="row"> <!--Second Row-->





  <div class="col-6 col-md-4">
       <div class="card card-profile">
                <div class="card-body">
                   <a href="#pablo">
                     <i class="material-icons" style="font-size: 100px;">face</i>
                  </a>
                  <h4 class="card-title">Users</h4>
                  <a href="{{route('UserManage',['upgid'=>$upgid])}}" class="btn btn-info btn-round">Open</a>
                </div>
              </div>
  </div>




  <div class="col-6 col-md-4">
    <div class="card card-profile">
                <div class="card-body">
                   <a href="#pablo">
                     <i class="material-icons" style="font-size: 100px;">business</i>
                  </a>
                  <h4 class="card-title">Departments</h4>
                  <a href="{{route('showDep',['upgid'=>$upgid,'id'=>Session::get('groupid')])}}" class="btn btn-info btn-round">Open</a>
                </div>
              </div>
  </div>





  <div class="col-6 col-md-4">
    <div class="card card-profile">
                <div class="card-body">
                   <a href="#pablo">
                     <i class="material-icons" style="font-size: 100px;">event_seat</i>
                  </a>
                  <h4 class="card-title">Positions</h4>
                  <a href="{{route('viewRolePage',['upgid'=>$upgid])}}" class="btn btn-info btn-round">Open</a>
                </div>
              </div>
  </div>
</div>



</div>
 </div>    
  </body>

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