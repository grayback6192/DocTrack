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
  
 <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="{{ URL::asset('NEWUI/css/material-dashboard.css?v=2.1.0')}}" rel="stylesheet" />

{{-- orgchart --}}
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/app.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/jquery.orgchart.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/jquery.orgchart.min.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('orgchart/jquery-ui-1.10.2.custom.css')}}" />
    <script type="text/javascript" src="{{ URL::asset('orgchart/jquery-1.9.1.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('orgchart/jquery-ui-1.10.2.custom.min.js')}}"></script>

    <script type="text/javascript" src="{{ URL::asset('orgchart/primitives.min.js?5000')}}"></script>
    <link href="{{ URL::asset('orgchart/primitives.latest.css?5000')}}" media="screen" rel="stylesheet" type="text/css" />
  
  @yield('orgchart')
</head>
<body class="dark-edition">
    <div class="wrapper">
        <div class="sidebar" data-color="orange" data-background-color="black" data-image="{{ URL::asset('NEWUI/css/sidebar-2.jpg')}}">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <div class="simple-text logo-normal">
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
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#"> Dashboard </a>
                    </div>
                        <button type="button" class="navbar-toggle" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        

                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav navbar-right">

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle text-dark" data-toggle="dropdown">
                                 {{Auth::user()->lastname}}
                                    <i class="material-icons">person</i>
                                </a>
                                 <ul class="dropdown-menu">
                                    <li style="padding: 3px 20px; border-bottom: 1px solid #A9A9A9;">
                                        Logged in as: <br>  
                                            {{Session::get('posName')}} ({{Session::get('groupName')}})
                                    </li>
                                    <li>
                                        <a href="{{route('viewUserProfile',['upgid'=>Session::get('userUPGID')])}}">User Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{route('chooseGroups',['userid'=>$user->user_id])}}">Exit Group</a>
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

@yield('js')
{{--  <script src="{{URL::asset('js/orgchartjs/jquery.min.js')}}" type="text/javascript"></script>       --}}
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--   Core JS Files   -->

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
<script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>

</html>