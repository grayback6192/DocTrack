@extends('mastertemplate')
@section('menu')
<li>
              <a href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li>
              <a href="{{route('showDep',['upgid'=>$upgid,'id'=>$admingroup])}}" data-placement="right" title="Inbox">
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

 <li class="active">
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
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
      $(document).ready(function(){

        $('#workflow-edit').change(function(){
        var value = $(this).val();
        console.log(value);
        $.ajax({
          type : 'GET',
          url: 'http://localhost:8000/admin/template/workflow/'+value,
          data: value,
          success: function(data){

           console.log(data);
           var html = "Positions: <br>";
           for(var x=0;x<data.length;x++){
              html+=data[x].posName+"("+data[x].action+")<br>";
           }
           $('#posedit').empty();
           $('#posedit').append(html);
          }
        });
      });

      });
    </script>    
  <script src = "{{ URL::asset("js/tinymce/tinymce.min.js") }}"></script>
<script>
tinymce.init({
  selector: "#textarea",
  plugins:"table",
  // menubar:"table",
  toolbar:"table bold italic underline alignleft aligncenter alignright",
  menubar: 'file edit insert view format table tools help',
  branding:false,
  height:350,
  width:750
});
</script>

<div>
<div class="row" style="margin-left: 60px;">
@if(!isset($title))
<form method = "post" action = "create">
{{csrf_field()}}
<table>
<tr>
  <td>Title:</td><td><input type = "text" placeholder = "Title" name = "title"></td><br>
  </tr>
  <tr>
  <td>Subject:</td><td><input type = "text" placeholder = "Subject" name = "subject"></td>
  </tr>
</table>
  <textarea name = "text" id = "textarea"></textarea>
  <input type = "submit" value = "Send" name = "submit">
</form> 
@else
{{-- {{ $content }} --}}
<div class="media">
<div class="media-left">
<form method = "post">
{{csrf_field()}}
{{-- <div class="row justify-content-end mr-2">
 <label class="switch">
    <input type="checkbox" name="userstatus" checked>
    <span class="slider round"></span>
  </label>
</div> --}}
<div class="form-group">
  Title:<input type = "text" value = "{{ $title }}" placeholder = "Title" name = "title" class="form-control">
</div>

<div class="form-group">
Workflow:
    <select name="wf" class="form-control" id="workflow-edit">
    @foreach($workflow as $flow)
      @if($flow->w_id==$wid)
        <option value="{{$flow->w_id}}" selected="selected">{{$flow->workflowName}}</option>
      @else
        <option value="{{$flow->w_id}}">{{$flow->workflowName}}</option>
      @endif
    @endforeach
    </select>
</div>

<div class="form-group"> 
    Service Owner:
    <select name="group" class="form-control">
    @foreach($groups as $group)
      @if($group->group_id==$gid)
        <option value="{{$group->group_id}}" selected="selected">{{$group->groupName}}</option>
      @else
        <option value="{{$group->group_id}}">{{$group->groupName}}</option>
      @endif
    @endforeach
    </select>
 </div> 

  <textarea name = "text" id = "textarea">{{ $content }}</textarea>
  <div class="col-md-5 col-md-offset-10">
  <div class="btn-toolbar">
  {{-- <div class="btn-group"> --}}
  <input class="btn btn-primary" type = "submit" formaction = "/admin/{{$upgid}}/templateEdit/create/{{$tempid}}" value = "Save" name = "submit">
  {{-- </div> --}}
  {{-- <div class="btn-group"> --}}
  @foreach($tempInfos as $tempInfo)
  <a class="btn btn-danger" href="{{route('getGroupTemplates',['upgid'=>$upgid,'groupid'=>$tempInfo->group_group_id])}}">Cancel</a>
  @endforeach
 {{--  </div> --}}
  </div>
  </div>
</form> 
</div>
<div class="media-right">
    <div class="col-md-offset-1" style="margin-bottom: 10px;">
    <a class="btn btn-info mb-3" href="javascript:openInstructions()">Show Instructions</a>
  </div>

 <div class="modal" id="instructEditTemplate" style="top:-50px;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Instructions</h5>
      </div>
      <div class="modal-body" style="height: 400px; overflow-y: scroll;">
         <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
  <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
  <TITLE></TITLE>
  <META NAME="GENERATOR" CONTENT="LibreOffice 4.1.6.2 (Linux)">
  <META NAME="AUTHOR" CONTENT="Grayback">
  <META NAME="CREATED" CONTENT="20180222;174000000000000">
  <META NAME="CHANGEDBY" CONTENT="Grayback">
  <META NAME="CHANGED" CONTENT="20180222;195600000000000">
  <META NAME="AppVersion" CONTENT="15.0000">
  <META NAME="DocSecurity" CONTENT="0">
  <META NAME="HyperlinksChanged" CONTENT="false">
  <META NAME="LinksUpToDate" CONTENT="false">
  <META NAME="ScaleCrop" CONTENT="false">
  <META NAME="ShareDoc" CONTENT="false">
  <STYLE TYPE="text/css">
  <!--
    @page { size: 8.5in 11in; margin: 1in }
    P { margin-bottom: 0.08in; direction: ltr; widows: 2; orphans: 2 }
  -->
  </STYLE>
</HEAD>
<BODY LANG="en-US" DIR="LTR">
<P STYLE="margin-bottom: 0.11in"><FONT SIZE=3><B>Template Creation
Tutorial</B></FONT></P>
<P STYLE="margin-bottom: 0.11in">Upon creating the template, the user
must create a placeholder that is enclosed by <B>${   } </B>to give
the users the ability to replace the <B>${   }</B> with their desired
value.<BR><B><BR></B><U><B>Example <BR></B></U>Hello my name is
<B>${Name}</B></P>
<P STYLE="margin-bottom: 0.11in">This example specifies that upon
entering the placeholder into the text editor, the users can put a
value upon sending the file. 
</P>
<P STYLE="margin-bottom: 0.11in">So from “<I><U><B>Hello my name is
${Name}</B></U></I>”Into “<I><U><B>Hello my name is Juan</B></U></I>”
when the user enters his name <B>Juan</B> in the form field.</P>
<P STYLE="margin-bottom: 0.11in"><FONT COLOR="#c00000"><B>IMPORTANT!</B></FONT>
You can name any placeholders you like as long as it suits the
placeholder to be replaced.<BR><BR><BR>
</P>
<P STYLE="margin-bottom: 0.11in"><B>Predefined Placeholders</B></P>
<P STYLE="margin-bottom: 0.11in"><U><B>${Date}</B></U><B> </B>-<B>
</B>The input form will automatically be set into a date
field.<BR><U><B>${Body}</B></U> - The input form will automatically
be set into text field.<BR><BR><BR>
</P>
<P STYLE="margin-bottom: 0.11in"><B>Predefined Signature Block</B></P>
<P STYLE="margin-bottom: 0.11in"><U><B>${“Position”}</B></U><B> -
</B>Replace the <I><B>“Position”</B></I> into one of the
positions that is being displayed at the right side of the screen.
This replaces the placeholder into a signature image from the
approver of the document.<BR><U><B>${“Position”-Name}</B></U> -
Displays the approver’s name.<BR><U><B>${“Position”-Position}</B></U>
- Displays the approver’s position.</P>
<P STYLE="margin-bottom: 0.11in"><FONT COLOR="#c00000"><B>IMPORTANT!
</B></FONT>You must enclose the signature block with a table in the
text editor to prevent any misalignments.</P>
<P STYLE="margin-bottom: 0.11in"><U><B>Example</B></U></P>
<TABLE WIDTH=186 CELLPADDING=7 CELLSPACING=0>
  <COL WIDTH=170>
  <TR>
    <TD WIDTH=170 HEIGHT=46 VALIGN=TOP STYLE="border: 1px solid #00000a; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
      <P STYLE="margin-bottom: 0in">             ${Secretary}</P>
      <P STYLE="margin-bottom: 0in">         ${Secretary-Name}</P>
      <P>       ${Secretary-Position}</P>
    </TD>
  </TR>
</TABLE>
<P STYLE="margin-bottom: 0.11in"><B>Output:</B></P>
<P STYLE="margin-bottom: 0.11in">         <IMG SRC="Template_html_cdfb5234.png" NAME="Picture 1" ALIGN=LEFT HSPACE=12 WIDTH=107 HEIGHT=37 BORDER=0>
</P>
<P STYLE="margin-bottom: 0.11in"><BR><BR>
</P>
<P STYLE="margin-bottom: 0.11in"><A NAME="_GoBack"></A>            
Dela Cruz, Juan</P>
<P STYLE="margin-bottom: 0.11in">                Secretary</P>
<P STYLE="margin-bottom: 0.11in">         
</P>
</BODY>
</HTML>
      </div>
      <div class="modal-footer">
      <a class="btn btn-info" href="javascript:closeInstructions()">Close</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
function openInstructions()
{
  var modal = document.getElementById('instructEditTemplate');
  modal.style.display = "block";
}  

function closeInstructions()
{
  var modal = document.getElementById('instructEditTemplate');
  modal.style.display = "none";
}
</script>

  <div style="padding-left: 150px;">
  
      <button class="btn btn-danger" onclick="openRemoveTemplateModal({{$tempid}})"><i class="material-icons">delete</i></button>

      <div class="modal" id="deltemplate-{{$tempid}}">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4>Remove Template?</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="{{route('removeTemplate',['upgid'=>$upgid,'id'=>$tempid])}}">
                {{csrf_field()}}
              <input type="hidden" name="tempid" value="{{$tempid}}">
              <input type="hidden" name="tempupgid" value="{{$upgid}}">
              <div class="btn-toolbar">
                <div class="btn-group">
                  <button type="submit" class="btn btn-primary">YES</a>
                </div>
                <div class="btn-group">
                  <button class="btn btn-danger" onclick="closeRemoveTemplateModal({{$tempid}})">NO</button>
                </div>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div id="posedit">
    Workflow Positions:<br><br>
      @foreach($workflowpositions as $workflowposition)
        {{$workflowposition->posName}}<br>
      @endforeach
</div>
</div>
</div>
</div>
@endif
</div>

<script type="text/javascript">
  function openRemoveTemplateModal(tempid)
  {
    var modal = document.getElementById('deltemplate-'+tempid);
    modal.style.display = "block";
  }

   function closeRemoveTemplateModal(tempid)
  {
    var modal = document.getElementById('deltemplate-'+tempid);
    modal.style.display = "none";
  }
</script>

@endsection