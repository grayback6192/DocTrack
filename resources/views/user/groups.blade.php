@extends('mastertemplate')
@section('menu')
<li class="active">
              <a href="{{route('Template',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">send</i>
               <p>Send File</p>
              </a>
 </li>

 <li>
              <a href="{{route('viewInbox',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">mail</i>
                <p>
                  Inbox
                   @if($numUnread>0)
                     ({{$numUnread}})
                    @endif 
                </p>
              </a>
 </li>

<li>
              <a href="{{route('viewSent',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  In progress</p>
              </a>
 </li>

   <li>
              <a href="{{route('complete',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                 <i class="material-icons">drafts</i>
                <p>
                  Archive</p>
              </a>
 </li>
 
@endsection

@section('main_content')

 <div class="content">
                <div class="row">
                            <div class="card">
                                <div class="card-header" data-background-color="orange">
                                    <h4 class="title">Choose a Template</h4>
                                    <p class="category">Choose a template you wish to file.</p>
                                </div>

                            </div>
                       
                    </div>
                    <div class="row">
                       <div class="col-lg-4 col-md-6 col-sm-6">                            
                              <a href="{{route('test',['upgid'=>$upgid])}}">
                               <div class="card card-stats" style="border: none">
                                  <div class="card-header" data-background-color="blue">
                                   <i class="material-icons">folder_open</i>
                               </div>
                                  <div class="card-content">
                                    <h3 class="title">Create Document</h3>
                                </div>
                              </div>
                                </a>
                            </div>
                        @if(isset($departments))  
                          @foreach($departments as $department)
                          <div class="col-lg-3 col-md-6 col-sm-6">                            
                              <a href="{{route('Template',['upgid'=>$upgid,'gid'=>$department->group_id])}}">
                               <div class="card card-stats" style="border: none">
         <div class="card-header" data-background-color="orange">
                                   <i class="material-icons">folder_open</i>
                                </div>
                                  <div class="card-content">
                                    <h3 class="title">{{$department->groupName}}</h3>
                                </div>
                              </div>
                                </a>
                            </div>
                          @endforeach
                        @endif
                         
                      </div>
                    </div>


@endsection

@section('js')
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>  
@endsection