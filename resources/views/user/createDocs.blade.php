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
                  In progress
                   @if($numinprogress>0)
                     ({{$numinprogress}})
                    @endif
                </p>
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
<div class="container">
  <div class="media">
 <script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        $('#workflow').change(function(){
        var value = $(this).val();
        console.log(value);
        $.ajax({
          type : 'GET',
          url: 'http://localhost:8000/admin/template/workflow/'+value,
          data: value,
          success: function(data){

            var length = Object.keys(data).length;
           console.log(data);
           //console.log(data[1][0].posName);
           var html = "Positions: <br>";
           for(var x=1;x<=length;x++){
              //html+=data[x].posName+"<br>";
               html+="<div class='media'>";
              // html+="<div class='media-left'>";
              html+="<div class='card'>";
              for(var y=0;y<=(Object.keys(data[x].length));y++)
              {
                html+="<div class='card-content'>";
                 html+=data[x][y].posName+"<br>";

                html+="</div>";
              }
              html+="</div></div></div>";
              if(x!=(length))
              {
              //   html+="<div class='media-right'>";
               //  html+="<div style='margin-top: 40px;'>";
                 html+="<i class='material-icons' style='margin-top: 50px;'>forward</i>";
               //  html+="<div></div>";
               }
              //html+="</div>";
           }
           $('#posWorkflow').empty();
           $('#posWorkflow').append(html);
           console.log(html);
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
  menubar:'file edit insert view format table tools help',
  toolbar:"table bold italic underline alignleft aligncenter alignright",
  branding:false,
  height:350,
  width:750
});
</script>



@if(!isset($title)) 
<div class="media">
<div class="media-left">
<form method = "post" action = "/test/{{$upgid}}/create">
{{csrf_field()}}

<div class="form-group">
 Title: <input type = "text" placeholder = "Title" name = "title" class="form-control"> 
 </div>

<div class="form-group">
    Workflow:
    <select name="wf" id="workflow" class="form-control">
      <option value="none">--Select Workflow--</option>
    @foreach($workflow as $flow)
      <option value="{{$flow->w_id}}">{{$flow->workflowName}}</option>
    @endforeach
    </select>
    <div class="panel panel-default">
      <div class="panel-body">
        <div id="posWorkflow" class="row justify-content-start">
          
        </div>
      </div>
    </div>
</div>

 {{-- <div class="form-group"> 
    Service Owner</td>
    <select name="group" class="form-control">
      <option value="none">--Select Service Owner--</option>
    @foreach($groups as $group)
      <option value="{{$group->group_id}}">{{$group->groupName}}</option>
    @endforeach
    </select>
 </div> --}}
  <textarea name = "text" id = "textarea"></textarea>
  <div class="btn-toolbar">
    <div class="btn-group">
      <input class="btn btn-primary" type = "submit" value = "Save" name = "submit">
    </div>
    <div class="btn-group">
      <a class="btn btn-primary" href="{{route('Template',['upgid'=>$upgid])}}">Back</a>
    </div>
  </div>
 
</form> 
</div>
<div class="media-right">
 <div class="col-md-offset-1" style="margin-bottom: 10px;">
    <a class="row btn btn-info mb-3" href="javascript:openInstructions()">Show Instructions</a>
  </div>

<div class="modal" id="instructAddTemplate" style="top:-50px;">
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
  var modal = document.getElementById('instructAddTemplate');
  modal.style.display = "block";
}  

function closeInstructions()
{
  var modal = document.getElementById('instructAddTemplate');
  modal.style.display = "none";
}
</script>

</div>
</div>
@else
{{ $content }}
<form method = "post">
{{csrf_field()}}
<table>
<tr>
  <td>Title:</td><td><input type = "text" value = "{{ $title }}" placeholder = "Title" name = "title"></td>
  </tr>
  <tr>
  <td>Subject:</td><td><input type = "text" placeholder = "Subject" name = "subject"></td>
  </tr>
</table>
  <textarea name = "text" id = "textarea">{{ $content }}</textarea>
  <input type = "submit" formaction = "/templateEdit/create" value = "Send" name = "submit">
</form> 
</div>
@endif

</div>
@endsection