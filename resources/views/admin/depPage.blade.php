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
<input type="button" class="btn btn-primary" id="adddep" value="Add Department" onclick="window.location='{{ route('regDep',['upgid'=>$upgid]) }}'">
{{-- <form id="choice" action="#" style="margin-left: 10px;">
<input type="hidden" name="_token" value="{{csrf_token()}}">
  <select class="btn btn-secondary dropdown-toggle" style="color: black; background-color: white;" name="view" id="useroption">
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
    <option value="all">All</option>
  </select>
</form> --}}
</div>

<div class="content-div">
<div class="row" style="margin-left: 60px;" id="depList">
@if(isset($departments))
@foreach($departments as $department)
 <div class="col-sm-6" style="margin-top: 15px;text-align:center;">
    <a href="{{route('showDep',['upgid'=>$upgid,'depid'=>$department->group_id])}}">
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