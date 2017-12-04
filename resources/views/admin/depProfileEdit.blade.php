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
@foreach($depInfos as $depInfo)
  <div class="row justify-content-center">
    <div class="card border-0" style="width: 40rem">
      <form action="{{route('saveDep',['depid'=>$depInfo->group_id])}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group mt-3">
          <label>Department Name</label>
          <input type="text" name="depname" class="form-control" value="{{$depInfo->groupName}}">
        </div>

        <div class="form-group">
          <label>Description</label>
            <textarea class="form-control" name="depDesc"><?php echo $depInfo->groupDescription; ?></textarea>
        </div>

        <hr>
        <div class="m-3">

          {{--important! if sub-group check na daan ang box with pre-checked mother group--}}
          <input type="checkbox" name="sub" id="sub" onclick="showSub()"> Please check if it's a Sub-Department
            {{-- (please leave it blank if not sub-department)<br> --}}
          <div id="fillsub" style="display: none;">
            Parent Department: <select class="form-control" name="mothergroup">
            <option value="">--Select a Department--</option>
              @foreach($motherGroups as $motherGroup)
                <option value="{{$motherGroup->group_id}}">{{$motherGroup->groupName}}</option>
              @endforeach 
            </select> 
          </div> 
          </div>
        <hr>

        <div class="form-group">
          <label>Department Key</label>
          <div class="form-inline">
            <input type="password" name="depKey" id="key" class="form-control" placeholder="Password" value="{{$depInfo->businessKey}}">

            <a id="show" class="col-sm-4 col-form-label" href="javascript:showKey()">Show</a> 
            <a id="hide" class="col-sm-4 col-form-label" href="javascript:hideKey()" style="display: none;">Hide</a> 
          </div>

          <script type="text/javascript">
              function showKey()
              {
                var showbtn = document.getElementById('show');
                var hidebtn = document.getElementById('hide');
                var pass = document.getElementById('key');

                showbtn.style.display = "none";
                hidebtn.style.display = "block";
                pass.type="text";

              }  

              function hideKey()
              {
                var showbtn = document.getElementById('show');
                var hidebtn = document.getElementById('hide');
                var pass = document.getElementById('key');

                showbtn.style.display = "block";
                hidebtn.style.display = "none";
                pass.type="password";
              }

              function showSub()
              {
                var subdepfill = document.getElementById('fillsub');
                if(document.getElementById('sub').checked == true)
                {
                  subdepfill.style.display = "block";
                }
                else if(document.getElementById('sub').checked == false)
                {
                  subdepfill.style.display = "none";
                }
              }
          </script>

        </div>
        <div class="row justify-content-end mr-2 mt-4">
          <div class="btn-toolbar mb-3">
            <input type="submit" name="edit" class="btn btn-primary mr-3" value="Save">
            <a href="{{route('showDep',['id'=>$depInfo->group_id])}}" class="btn btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  @endforeach
  </div>
@endsection