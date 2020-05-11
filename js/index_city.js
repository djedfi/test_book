$( document ).ready(function() 
{
    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/city.ctrl.php",             
        dataType: "json",   
        data    : "opt=1",               
        success : function(data)
        {     
            if(data.success)
            {
                $.each(data.data ,function(i,post){
                    var newrow = "<tr>"+
                                    "<td class='text-justify'>"+post.name_city+"</td>"+
                                    "<td class='text-justify'>"+post.name_country+"</td>"+
                                    "<td class='text-center'>"+post.format_code+"</td>"+
                                    "<td class='text-center'>"+post.date+"</td>"+
                                "</tr>";
                   $(newrow).appendTo("#tbl_data_citites");
                });
            }               
        }
    });



});
