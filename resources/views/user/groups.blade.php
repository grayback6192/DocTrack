@extends('mastertemplate')
@section('menu')
<li class="active">
              <a href="{{route('serviceowners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">mail</i>
                <p>
                  Inbox</p>
              </a>
 </li>

<li>
              <a href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Sent</p>
              </a>
 </li>
 
@endsection

@section('main_content')

 <div class="content">
                <div class="row">
                            <div class="card">
                                <div class="card-header" data-background-color="orange">
                                    <h4 class="title">Choose a Department</h4>
                                    <p class="category">Choose a department that owns the Request you need to make.</p>
                                </div>

                            </div>
                       
                    </div>
                    <div class="container-fluid">
                      <div class="dep-menu">
                        @if(isset($departments))  
                          @foreach($departments as $department)                            
                            <div class="card serviceowner">
                              <a href="{{route('Template',['upgid'=>$upgid,'gid'=>$department->group_id])}}">
                                <div class="card-content text-center">
                                  <div id="serviceicon">
                                    <i class="material-icons" style="font-size: 80px;">folder_open</i>
                                  </div>
                                    <h3 class="title" id="serviceicon">{{$department->groupName}}</h3>
                                </div>
                                </a>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>

</div>


@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
@endsection