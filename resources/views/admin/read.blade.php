
@extends('mastertemplate')
@section('menu')
 <li>
              <a href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li class="active">
              <a href="{{route('showDep',['upgid'=>$upgid,'id'=>Session::get('groupid')])}}" data-placement="right" title="Inbox">
                <i class="material-icons">business</i>
               <p>Departments</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewRolePage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">event_seat</i>
                <p>Positions</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewWorkflow',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">group</i>
               <p>Workflows</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewOwners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">description</i>
                <p>Templates</p>
              </a>
 </li>

 <li>
              <a href="#" data-placement="right" title="Inbox">
                <i class="material-icons">archive</i>
                <p>Archive</p>
              </a>
 </li>
@endsection

@section('main_content')
<div id="chart-container"></div>
 <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.min.js') }}" ></script>
 <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.mockjax.min.js') }}" ></script>
 <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.orgchart.min.js') }}" ></script>s
  <script type="text/javascript">

    $(function() {
          $.mockjax({
        url: '/orgchart/initdata',
        responseTime: 1000,
        contentType: 'application/json',
        responseText:   
          <?php echo $files; ?>
         
      });

      $('#chart-container').orgchart({
        'data' : '/orgchart/initdata',
        'depth': 2,
        'nodeContent': 'title'
      });

    });
  </script>
@endsection