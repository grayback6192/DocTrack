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
<div class="container">
@foreach($depInfos as $depInfo)
  <div class="row justify-content-center">
    <div class="card border-0" style="width: 40rem">
      <form action="{{route('saveDep',['upgid'=>$upgid,'depid'=>$depInfo->group_id])}}" method="post">
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
            <a href="{{route('showDep',['upgid'=>$upgid,'id'=>$depInfo->group_id])}}" class="btn btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  @endforeach
  </div>
@endsection