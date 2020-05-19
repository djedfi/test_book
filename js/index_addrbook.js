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
                $.each(data.data ,function(i,post)
                {
                    var tag_slice   =   post.tags;
                    tag_slice       =   tag_slice.slice(0,20);

                    if(post.tags.length > 20)
                    {
                        tag_slice = tag_slice + '...';
                    }
                    var newrow = "<tr style='cursor: pointer;'>"+
                                    "<td class='d-none'>"+post.id+"</td>"+
                                    "<td class='text-justify'>"+post.last_name+"</td>"+
                                    "<td class='text-justify'>"+post.first_name+"</td>"+
                                    "<td class='text-center'>"+post.name_city+"</td>"+
                                    "<td class='text-center'>"+post.email+"</td>"+
                                    "<td class='text-center'>"+post.zipcode+"</td>"+
                                    "<td class='text-center'>"+tag_slice+"</td>"+
                                    "<td class='text-center'>"+post.date+"</td>"+
                                "</tr>";
                   $(newrow).appendTo("#tbl_data_addrbook");
                });
            }               
        }
    });


    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/addrbook.ctrl.php",             
        dataType: "json",   
        data    : "opt=6",               
        success : function(data)
        { 
            if(data.success)
            {
                $.each(data.data ,function(i,post)
                {
                    var newrow = "<option value='"+post+"'>"+post+"</option>";
                    $(newrow).appendTo("#id_sel_tag");
                });
            }
        }
    });


    $('#id_sel_tag').on('change', function() 
    {
      var value   = $(this).val();
        $.ajax
        ({    
          type    : "GET",
          url     : "./controller/addrbook.ctrl.php",             
          dataType: "json",   
          data    : "opt=1&tag="+value,               
          success : function(data)
          {    
            $("#tbl_data_tbody_addrbook  tr").remove();
            $.each(data.data ,function(i,post)
            {
                var tag_slice   =   post.tags;
                tag_slice       =   tag_slice.slice(0,20);

                if(post.tags.length > 20)
                {
                    tag_slice = tag_slice + '...';
                }
                var newrow = "<tr style='cursor: pointer;'>"+
                                "<td class='d-none'>"+post.id+"</td>"+
                                "<td class='text-justify'>"+post.last_name+"</td>"+
                                "<td class='text-justify'>"+post.first_name+"</td>"+
                                "<td class='text-center'>"+post.name_city+"</td>"+
                                "<td class='text-center'>"+post.email+"</td>"+
                                "<td class='text-center'>"+post.zipcode+"</td>"+
                                "<td class='text-center'>"+tag_slice+"</td>"+
                                "<td class='text-center'>"+post.date+"</td>"+
                            "</tr>";
               $(newrow).appendTo("#tbl_data_addrbook");
            });
          }
        });
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
    var value   = $("#id_sel_tag").val(); 
    $('#id_download').attr('src', './controller/download_xml.php?tag='+value);
});

$(document).on('click', '#id_btn_export_json', function()
{ 
    var value   = $("#id_sel_tag").val(); 
    $('#id_download').attr('src', './controller/download_json.php?tag='+value);
});