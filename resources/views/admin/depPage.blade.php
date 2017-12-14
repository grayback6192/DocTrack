@extends('mastertemplate')
@section('menu')
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color:black;" data-toggle="collapse" href="{{route('UserManage')}}" data-placement="right" title="Inbox">
                <i class="fa fa-user fa-fw"></i>
                <span class="nav-link-text">
                  Users</span>
              </a>
 </li>

 <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link" style="color: black;" data-toggle="collapse" href="{{'viewDep',['status'=>'active']}}" data-placement="right" title="Inbox">
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
<script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" ></script>

   <script type="text/javascript"> 
         $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});  
      $(document).ready(function(){
      
        $('#useroption').change(function(){
          var value = $(this).val();
          //console.log(value);
          $.ajax({
            type: 'GET',
            url: 'http://localhost:8000/admin/department/status/'+value,
            success: function(data){
               $("#depList").empty();
              console.log(value);
             
              for(var i=0;i<data.length;i++){
              // var html = "<div class='row' style='margin-left: 60px;'>";
              var html="<div class='col-sm-6' style='margin-top: 15px; text-align:center'>";
              html+="<a href=http://localhost:8000/admin/department/depID="+data[i].group_id+">";
              html+="<div class='card' style='width: 15rem; border:none;'><i class='fa fa-5x fa-building'></i>";
              html+="<div class='card-block'>";
              html+= "<h3 class='card-title' style='margin-top: 1rem;'><h4>"+data[i].groupName+"</h3>";
              html+="</div>";
              html+= "</div></a></div></div>";

              //$html+=data[i].groupName;
            $("#depList").append(html);
          }
          console.log(data);
            }
          });
        });


      });

  </script>

<div class="row" style="margin-left: 60px;">
<input type="button" class="btn btn-primary" id="adddep" value="Add Department" onclick="window.location='{{ route('regDep') }}'">
<form id="choice" action="#" style="margin-left: 10px;">
<input type="hidden" name="_token" value="{{csrf_token()}}">
  <select class="btn btn-secondary dropdown-toggle" style="color: black; background-color: white;" name="view" id="useroption">
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
    <option value="all">All</option>
  </select>
</form>
</div>

<div class="content-div">
<div class="row" style="margin-left: 60px;" id="depList">
@if(isset($departments))
@foreach($departments as $department)
 <div class="col-sm-6" style="margin-top: 15px;text-align:center;">
    <a href="{{route('showDep',['depid'=>$department->group_id])}}">
      <div class="card" style="width: 15rem; border: none;">
       <i class="fa fa-5x fa-building"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">{{$department->groupName}}</h3>
      </div>
    </div>
  </a>
  </div>
@endforeach
@endif
</div>
</div>

@endsection