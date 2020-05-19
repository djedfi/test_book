$( document ).ready(function() 
{
    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/group.ctrl.php",             
        dataType: "json",   
        data    : "opt=1",               
        success : function(data)
        {     
            if(data.success)
            {
                $.each(data.data ,function(i,post){
                    var newrow = "<tr style='cursor: pointer;'>"+
                                    "<td class='d-none'>"+post.id+"</td>"+
                                    "<td class='text-center'>"+post.name+"</td>"+
                                    "<td class='text-justify'>"+post.description+"</td>"+
                                    "<td class='text-center'>"+post.total_contacts+"</td>"+
                                    "<td class='text-center'>"+post.date+"</td>"+
                                "</tr>";
                   $(newrow).appendTo("#tbl_data_addgroup");
                });
            }               
        }
    });



});

$('#tbl_data_addgroup tbody').on('click', 'tr', function () 
{
    var currentRow=$(this).closest("tr"); 
         
    var id=currentRow.find("td:eq(0)").text(); // get current row 1st TD value
    window.location = 'form_congroup.vw.php?id='+id;
    
});

