
//ADMIN SIDE
 //filter users in user management
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){
         $('#status').change(function(){
            var value = $(this).val();
            console.log(value);
            $.ajax({
                type: 'GET',
                url: 'http://localhost:8000/admin/user/'+value,
                success: function(data){
                    console.log(data);
                    $('#users-table tr:not(:first)').remove();
                    for(var i=0;i<data.length;i++){
                    var html = "<tr>";
                    html+= "<td>"+data[i].lastname+"</td>";
                    html+="<td>"+data[i].firstname+"</td>";
                    html+="<td><a href=http://localhost:8000/admin/"+upgid+"/usermanagement/userprofile/"+data[i].user_id+">View</a></td>";
                    html+="<td><a href=http://localhost:8000/admin/"+upgid+"/usermanagement/"+data[i].user_id+">Delete</a></td>";
                    html+="</tr>";
                    console.log(html);
                    $('#users-table').append(html);
                }
                }
            });
        });

});

//for addWf.blade

        //USER SIDE
//filter inbox
$(document).ready(function(){
  $('#inboxstatus').change(function(){
    var statusInbox = $(this).val();
     // var upgid = <?php echo $upgid; ?>;
    console.log(statusInbox);
    $.ajax({
      type: 'GET',
      url: 'http://localhost:8000/user/'+upgid+'/inbox/'+statusInbox,
      success: function(data){
        console.log(data);

        $('#inbox-table tr:not(:first)').remove();
                    for(var i=0;i<data.length;i++){
                    var html = "<tr>";
                    html+= "<td style='text-align: center'>"+data[i].date+"</td>";
                    html+="<td style='text-align: center'>"+data[i].docname+"</td>";
                    html+="<td style='text-align: center'>"+data[i].lastname+", "+data[i].firstname  +"</td>";
                    html+="<td style='text-align: center'>"+data[i].groupName+"</td>";
                    html+="<td style='text-align: center'><a href=http://localhost:8000/documentView/"+data[i].doc_id+">View</a></td>";
                    html+="</tr>";
                    console.log(html);
                    $('#inbox-table').append(html);
          }
      }
    });
  });
});


