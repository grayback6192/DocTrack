@extends('mastertemplate')
@section('menu')
<li class="nav-item">
              <a class="nav-link" href="" data-placement="right" title="Inbox">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li class="nav-item active">
              <a class="nav-link" href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">mail</i>
                <p>
                  Inbox
                </p>
                  {{--  <div class="notification"> --}}
                    {{--Number of pending inbox--}}
                  {{-- </div> --}}
              </a>
 </li>

<li class="nav-item">
              <a class="nav-link" href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  In progress</p>
              </a>
 </li>

   <li class="nav-item">
              <a class="nav-link" href="{{route('complete',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Archive</p>
              </a>
 </li>
 
@endsection

@section('main_content')
<div class="content">
	
@foreach($userinfos as $userinfo)

  @if(session('edituserprof'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{session('edituserprof')}}
    </div>
  @endif

  <div class="row justify-content-center">
    <div class="card" style="width: 700px;">
       <div class="text-right" style="margin-right: 2px;">
          <a class="btn btn-primary" href="{{route('userprofedit',['upgid'=>$upgid])}}">
            <i class="material-icons" style="width: 20px;">edit_mode</i> Edit Profile
          </a>
        </div>
      <div class="card-block">
       
        <div class="card-body">
            <div class="media">
              <div class="media-left">
            <div class="picture-container">
              <div class="picture">
                <img class="media-object" src="{{url('./users/pictures/'.$userinfo->profilepic)}}" alt="profile pic"/>
              </div>
            </div>
            </div>
            <div class="media-body" style="padding-left: 50px;">
              <h1>{{$userinfo->firstname}} {{$userinfo->lastname}}</h1>
              <p class="profileinfo"><i class="material-icons">person_pin</i> {{$userinfo->gender}}</p>
              <p class="profileinfo"><i class="material-icons">directions</i> {{$userinfo->address}}</p>
              <p class="profileinfo"><i class="material-icons">email</i> {{$userinfo->email}}</p>
            </div>
            </div>

              <div class="panel panel-default" style="margin: 20px 5px;">
              <div class="panel-heading">
                <h3 class="panel-title">Groups Joined</h3>
              </div>
              <div class="panel-body" style="padding: 5px;">
                <div class="dep-menu">
                  @if(isset($usergroups))
                     @foreach($usergroups as $usergroup)
                      <div class="card" style="border:0">
                        <div class="depiconframe text-center" style="padding: 20px;">
                          <i class="material-icons" style="font-size: 80px;">business</i>
                        </div>
                        <div class="card-block">
                          <div class="card-body text-center">
                             <h4>{{$usergroup->groupName}}</h4>
                          </div>
                        </div>
                      </div>
                      @endforeach
                  @endif
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endforeach
  <div class="row justify-content-end" style="margin-right: 110px">
    <a class="btn btn-primary" href="{{route('viewInbox',['upgid'=>$upgid])}}">Back</a>
  </div>
</div>
@endsection