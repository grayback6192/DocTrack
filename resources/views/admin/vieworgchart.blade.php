<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
   <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/app.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/jquery.orgchart.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/jquery.orgchart.min.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/style.css') }}">
  <style type="text/css">
  #try{visibility: hidden; position: absolute;}
    #ul-data {
      position: relative;
      top: -60px;
      display: inline-block;
      margin-left: 10%;
      width: 30%;
      margin-right: 6%;
    }
    #chart-container { display: inline-block; width: 98%;  top: 10px;}
    #ul-data li { font-size: 32px; }
  </style>
</head>
<body>
 <div id="try">
  <?php
  echo $files;
  ?>
</div>
  <div id="chart-container"></div>
<script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.min.js') }}"></script>

<script type="text/javascript">
  
 $("#try ul:first").attr("id","ul-data");
</script>
 

  <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/html2canvas.min.js') }}"></script>

  <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.orgchart.js') }}"></script>


  <script type="text/javascript">
    $(function() {

      $('#chart-container').orgchart({
        'data' : $('#ul-data')
      });

    });
  </script>
  </body>
</html>
