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
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top" id="mainNav">
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
  <div class="row" style="margin-top: 20px; margin-bottom: 20px; margin-left: 10px;">
    <a class="btn btn-primary" href="{{route('chooseGroups',['userid'=>$User->user_id])}}">Back</a>
  </div>
<div class="row">
 @if(isset($groups))
    @foreach($groups as $group)
      <div class="col-sm-6">
      <a href="javascript:openGroupModal({{$group->group_id}})"><div class="card" style="width: 15rem; border: none;">
        <i class="fa fa-5x fa-building"></i>
        <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem;">{{$group->groupName}}</h3>
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
        Group Key: <input type="password" id="gkey" name="groupkey"> <a id="showgkey" href="javascript:showGKey()">Show</a><a id="hidegkey" style="display: none" href="javascript:hideGKey()">Hide</a><br>
        <script type="text/javascript">

          function showGKey()
          {
            var showbtn = document.getElementById('showgkey');
            var hidebtn = document.getElementById('hidegkey');
            var gkey = document.getElementById('gkey');

            showbtn.style.display = "none";
            hidebtn.style.display = "block";
            gkey.type="text";
          }

          function hideGKey()
          {
            var showbtn = document.getElementById('showgkey');
            var hidebtn = document.getElementById('hidegkey');
            var gkey = document.getElementById('gkey');

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
 
  </body>
</html>