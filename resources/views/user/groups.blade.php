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
                                    <p class="category">Choose a specific department in order to send a document</p>
                                </div>

                            </div>
                       
                    </div>
                    <div class="container-fluid">
                      <div class="row">
                        @if(isset($departments))  
                          @foreach($departments as $department)
                             <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                              <a href="{{route('Template',['upgid'=>$upgid,'gid'=>$department->group_id])}}">
                                <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">business</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Department</p>
                                    <h3 class="title">{{$department->groupName}}
                                    </h3>
                                </div>
                                </a>
                            </div>
                          
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
{{-- <div class="row" style="margin-left: 60px; margin-top: 20px;">
 
    @if(isset($departments))
@foreach($departments as $department)
 <div class="col-sm-6" style="margin-top: 15px;">
    <a href="{{route('Template',['upgid'=>$upgid,'gid'=>$department->group_id])}}"><div class="card" style="width: 15rem; border: none;">
       <i class="fa fa-5x fa-building"></i>
      <div class="card-block">
        <h3 class="card-title" style="margin-top: 1rem">{{$department->groupName}}</h3>
      </div>
    </div></a>
  </div>
@endforeach
@endif 
</div> --}}

</div>


@endsection