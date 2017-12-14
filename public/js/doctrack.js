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
                    html+="<td><a href=http://localhost:8000/admin/usermanagement/userprofile="+data[i].user_id+">View</a></td>";
                    html+="<td><a href=http://localhost:8000/admin/usermanagement/"+data[i].user_id+">Delete</a></td>";
                    html+="</tr>";
                    console.log(html);
                    $('#users-table').append(html);
                }
                }
            });
        });
    });