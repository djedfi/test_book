$( document ).ready(function() 
{
    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/addrbook.ctrl.php",             
        dataType: "json",   
        data    : "opt=1",               
        success : function(data)
        {     
            if(data.success)
            {
                $.each(data.data ,function(i,post){
                    var newrow = "<tr style='cursor: pointer;'>"+
                                    "<td class='d-none'>"+post.id+"</td>"+
                                    "<td class='text-justify'>"+post.last_name+"</td>"+
                                    "<td class='text-justify'>"+post.first_name+"</td>"+
                                    "<td class='text-center'>"+post.name_city+"</td>"+
                                    "<td class='text-center'>"+post.email+"</td>"+
                                    "<td class='text-center'>"+post.zipcode+"</td>"+
                                    "<td class='text-center'>"+post.date+"</td>"+
                                "</tr>";
                   $(newrow).appendTo("#tbl_data_addrbook");
                });
            }               
        }
    });


    
});

$('#tbl_data_addrbook tbody').on('click', 'tr', function () 
{
    var currentRow=$(this).closest("tr"); 
         
    var id=currentRow.find("td:eq(0)").text(); // get current row 1st TD value
    window.location = 'upd_addrbook.vw.php?id='+id;
} );

$(document).on('click', '#id_btn_export_xml', function()
{ 
    $.ajax({
        url: './controller/download_xml.php',
        type: 'POST',
        success: function() {
            window.location = './downloads/people_xml.xml';
        }
    });
});

$(document).on('click', '#id_btn_export_json', function()
{ 
    $.ajax({
        url: './controller/download_json.php',
        type: 'POST',
        success: function() {
            window.location = './downloads/people_json.json';
        }
    });
});