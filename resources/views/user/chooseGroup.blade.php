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
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    {{Auth::user()->lastname}}
                                    <i class="material-icons">person</i>
                                </a>
                                 <ul class="dropdown-menu">
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
  <br><br><br>
              <div class="">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#">
                    <img class="img" src="/users/pictures/{{$userprof}}" />
                  </a>
                </div>
                <div class="card-body">
                 
                  <h4 class="card-title">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</h4>
                   <h6 class="card-category">{{Auth::user()->email}}</h6>
                  <p class="card-description">
                   My address is {{Auth::user()->address}}.<br>My contact number is {{Auth::user()->contactnum}}.<br>This account is {{Auth::user()->status}}
                  </p>
                </div>
              </div>
            </div>

</div>
   <div class="row"> <!--First Row-->
  @if(isset($usergroups))
  @foreach($usergroups as $usergroup)

  <div class="col-6 col-md-4">
    <div class="card card-profile">
      <div class="card-body">
       <a href="#">
         <i class="material-icons" style="font-size: 50px">business</i>
       </a>
       <h6 class="card-category">{{$usergroup->posName}}</h6>
       <h4 class="card-title">{{$usergroup->groupName}}</h4>
       <a href="{{route('gotogroup',['groupid'=>$usergroup->group_id,'rightid'=>$usergroup->rights_rights_id])}}" class="btn btn-info btn-round">Open</a>
     </div>
   </div>
 </div>

  @endforeach
  @endif

  @if(isset($usergroups2))
  @foreach($usergroups2 as $usergroup)
  <div class="col-6 col-md-4">
    <div class="card card-profile">
      <div class="card-body">
       <a href="#">
         <i class="material-icons" style="font-size: 50px">business</i>
       </a>
       <h6 class="card-category">{{$usergroup->posName}}</h6>
       <h4 class="card-title">{{$usergroup->groupName}}</h4>
       <a href="{{route('gotogroup',['groupid'=>$usergroup->group_id,'rightid'=>$usergroup->rights_rights_id])}}" class="btn btn-info btn-round">Open</a>
     </div>
   </div>
 </div>
  @endforeach
  @endif

</div>
<br>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <a href="{{route('addGroup',['id'=>$User->user_id,'depid'=>$clientId])}}">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">business</i>
                  </div>
                  <p class="card-category">New</p>
                  <h4 class="card-title">Choose Department</h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">add_box</i> Add New Department
                  </div>
                </div>
              </a>
              </div>
            </div>

</div>

  </body>
   <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
<script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/perfect-scrollbar.jquery.min.js')}}"></script>



<script src="{{ URL::asset('NEWUI/js/jquery.min.js')}}"></script>
  <script src="{{ URL::asset('NEWUI/js/popper.min.js')}}"></script>
  <script src="{{ URL::asset('NEWUI/js/bootstrap-material-design.min.js')}}"></script>
  <script src="https://unpkg.com/default-passive-events"></script>
  <script src="{{ URL::asset('NEWUI/js/perfect-scrollbar.jquery.min.js')}}"></script>
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
 
  <!-- Chartist JS -->
  <script src="{{ URL::asset('NEWUI/js/chartist.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{ URL::asset('NEWUI/js/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="  {{ URL::asset('NEWUI/js/material-dashboard.js?v=2.1.0')}}"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{ URL::asset('NEWUI/js/demo.js')}}"></script>
</html>