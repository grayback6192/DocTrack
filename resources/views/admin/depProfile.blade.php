@extends('mastertemplate')



@section('menu')
 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" data-toggle="collapse" href="{{route('UserManage')}}" data-placement="right" title="Inbox">
                <i class="fa fa-user fa-fw"></i>
                <span class="nav-link-text">
                  Users</span>
              </a>
 </li>

 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewDep',['status'=>'active'])}}" data-placement="right" title="Inbox">
                <i class="fa fa-building fa-fw"></i>
                <span class="nav-link-text">
                  Departments</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewRolePage')}}" data-placement="right" title="Inbox">
                <i class="fa fa-star fa-fw"></i>
                <span class="nav-link-text">
                  Positions</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewWorkflow')}}" data-placement="right" title="Inbox">
                <i class="fa fa-group fa-fw"></i>
                <span class="nav-link-text">
                  Workflows</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{route('viewOwners')}}" data-placement="right" title="Inbox">
                <i class="fa fa-file-o fa-fw"></i>
                <span class="nav-link-text">
                  Templates</span>
              </a>
 </li>

 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="#" data-placement="right" title="Inbox">
                <i class="fa fa-archive fa-fw"></i>
                <span class="nav-link-text">
                  Archive</span>
              </a>
 </li>

@endsection

@section('main_content')
<div class="container">
  @foreach($depinfos as $depinfo)
  <div class="row justify-content-start mt-2 ml-2">
      <a class="btn btn-primary" href="{{route('viewDep')}}">Back</a>
    </div>
   <div class="row justify-content-center">
    <div class="card border-0" style="width: 60rem">
       <div class="card-block">
        <div class="row justify-content-end mr-2">
        

           <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>
  <script type="text/javascript">
    $(document).ready(function(){

      $("#depSlider").change(function(){
        var depid = "<?php echo $depinfo->group_id; ?>";
        if($(this).prop('checked'))
        {
          $.ajax({
            type: 'GET',
            url: 'http://localhost:8000/admin/depactive/'+depid,
            success: function(data){
              alert('success');
            }
          });
        }
        else
        {
           $.ajax({
            type: 'GET',
            url: 'http://localhost:8000/admin/depinactive/'+depid,
            success: function(data){
              alert('success');
            }
          });
        }
      });

    });

  </script>

         
          <a href="{{route('deleteDep',['id'=>$depinfo->group_id])}}"><i class="fa fa-trash fa-2x mt-2" data-toggle="collapse" data-placement="right" title="Delete"></i></a>
          <a href="{{route('editDep',['id'=>$depinfo->group_id])}}"><i class="fa fa-cogs fa-2x mt-2 ml-3" data-toggle="collapse" data-placement="right" title="Edit"></i></a>
        </div>
      <div class="jumbotron m-3 bg-white">
        <h1 class="display-4">{{$depinfo->groupName}}</h1>
        <hr>
        <p class="mt-2" placeholder="Department Description">
          {{$depinfo->groupDescription}}
        </p>
      </div>

      <div class="m-3">
        <h3>Subgroups</h3>
        {{--Sub groups Here--}}
        <div class="row" style="margin-left: 60px; margin-top: 10px;">
          @if(isset($subgroups))
            @foreach($subgroups as $subgroup)
              <div class="col-sm-6" style="margin-top: 15px;">
                <a href="{{route('showDep',['depid'=>$subgroup->group_id])}}">
                <div class="card" style="width: 15rem; border: none;">
                <i class="fa fa-5x fa-building"></i>
                <div class="card-block">
                  <h3 class="card-title" style="margin-top: 1rem">{{$subgroup->groupName}}</h3>
                </div>
                </div></a>
              </div>
@endforeach
@endif
</div>
      </div>

      <div class="m-3">
        <div class="row justify-content-between">
          <div class="ml-3">
            <h3>Organizational Chart</h3>
          </div>
          <div class="mr-5">
            @foreach($orgchartInfos as $orgchartInfo)
            <a class="btn btn-primary" href="{{route('editOrgChart',['groupid'=>$orgchartInfo->group_id])}}">Edit</a>
            @endforeach
          </div>
        </div>
        {{--Org Chart Here--}}
        @if($deporgchart!=="none")
          <div id="chart-container">
            <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.min.js') }}" ></script>
            <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.mockjax.min.js') }}" ></script>
            <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.orgchart.min.js') }}" ></script>
            <script type="text/javascript">

            $(function() {
                $.mockjax({
                    url: '/orgchart/initdata',
                    responseTime: 1000,
                    contentType: 'application/json',
                    responseText:   
                  <?php echo $deporgchart; ?>
         
              });

                $('#chart-container').orgchart({
                  'data' : '/orgchart/initdata',
                  'depth': 2,
                  'nodeContent': 'title'
                });

             });
          </script>

          </div>
        @else
          <a class="btn btn-primary" href="{{route('AddOrgChart')}}">Add Organizational Chart</a>
        @endif
      </div>
    </div>
  </div>
</div>
 @endforeach
</div>
@endsection