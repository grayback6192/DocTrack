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
      <a class="navbar-brand" href="#" style="color:black;">DocTrack</a>
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
          <li class = "nav-item">
            {{-- Authentication Name --}}
          </li>
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
<div class="row" style="margin-left: 10px; margin-top: 20px; margin-bottom: 20px;">
  <a class="btn btn-primary" href="{{route('addGroup',['id'=>$User->user_id])}}">Choose Department</a>
</div>
   <div class="row"> <!--First Row-->
  @if(isset($usergroups))
  @foreach($usergroups as $usergroup)
  <div class="col-sm-6">
    <a href="{{route('gotogroup',['groupid'=>$usergroup->group_id,'rightid'=>$usergroup->rights_rights_id])}}">
      <div class="card" style="width: 15rem; border: none;">
      <i class="fa fa-5x fa-building"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem;">{{$usergroup->groupName}} ({{$usergroup->rightsName}})</h3>
      </div>
    </div></a>
  </div>
  @endforeach
  @endif
</div>

</div>
     
  </body>
</html>