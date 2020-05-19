$( document ).ready(function() 
{
    var value_id_group   = $("#id_hid_idgroup").val();
    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/contact_group.ctrl.php",             
        data    : "opt=6&id_group="+value_id_group,               
        success : function(data)
        {     
            var obj = JSON.parse(data);
            $('#id_div_name_group').html(obj.data[0].name);
        }
    });
    $.fn.load_contacts_in_group();
    $.fn.load_contacts_in_group_by_group();
    
});
$(document).on('click','#id_btn_save_error_add',function()
{
    $('#modal_save_add_error').modal('hide');
});

$(document).on('click','#id_btn_save_error_del',function()
{
    $('#modal_save_del_error').modal('hide');
});

// CODE FOR MODAL OF CONTACT FROM CONTACTS BOOK
$(document).on('click', '#id_btn_add_contact_book', function()
{ 
    $('#id_modal_add_cont_book').modal('show');
    $("#id_tbl_body_modal_add_cont_book  tr").remove();
});

$('#id_modal_add_cont_book').on('shown.bs.modal', function (e) 
{
    var value_id_group   = $("#id_hid_idgroup").val();
    

    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/contact_group.ctrl.php",             
        dataType: "json",   
        data    : "opt=2&id_group="+value_id_group,               
        success : function(data)
        {     
            if(data.success)
            {
                if(data.data.length > 0)
                {
                    $.each(data.data ,function(i,post){
                        var newrow = "<tr style='cursor: pointer;'>"+
                                        "<td class='d-none'>"+post.id_contact+"</td>"+
                                        "<td class='text-justify'>"+post.first_name+" "+post.last_name+"</td>"+
                                        "<td class='text-center'>"+post.email+"</td>"+
                                    "</tr>";
                       $(newrow).appendTo("#id_tbl_modal_add_cont_book");
                    });
                }
                else
                {
                    var newrow = "<tr>"+
                                        "<td class='text-center' colspan='4'>There is no Contacts to add</td>"+
                                 "</tr>";
                    $(newrow).appendTo("#id_tbl_modal_add_cont_book");
                }

            }               
        }
    });
});

$('#id_tbl_modal_add_cont_book tbody').on('click', 'tr', function () 
{
    var currentRow=$(this).closest("tr"); 
         
    var id_contact          = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
    var value_id_group      = $("#id_hid_idgroup").val();

    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/contact_group.ctrl.php",             
        data    : "opt=3&id_group="+value_id_group+"&id_contact="+id_contact,               
        success : function(data)
        {     
            var obj = JSON.parse(data);

            if(obj.data)
            {
                $.fn.load_contacts_in_group();
                $('#id_modal_add_cont_book').modal('hide');                
            }
            else
            {
                $('#modal_save_add_error').modal('show');
            }
            
        }
    });
    
} );

$.fn.load_contacts_in_group = function() 
{
    var value_id_group   = $("#id_hid_idgroup").val();
    $("#id_tbl_body_contact_dir  tr").remove();
    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/contact_group.ctrl.php",             
        dataType: "json",   
        data    : "opt=1&id_group="+value_id_group,               
        success : function(data)
        {     
            if(data.success)
            {
                if(data.data.length > 0)
                {
                    $.each(data.data ,function(i,post){
                        var newrow = "<tr>"+
                                        "<td class='d-none'>"+post.id_contact_group+"</td>"+
                                        "<td class='text-center'>"+post.first_name+" "+post.last_name+"</td>"+
                                        "<td class='text-center'>"+post.email+"</td>"+
                                        "<td class='text-center'>"+post.name_city+"</td>"+
                                        "<td class='text-center'><i class='fas fa-user-slash' style='cursor: pointer;' onclick='delete_contact_in_group_parent("+post.id_contact_group+")'></i></td>"+
                                    "</tr>";
                       $(newrow).appendTo("#id_tbl_contact_dir");
                    });
                }
                else
                {
                    var newrow = "<tr>"+
                                        "<td class='text-center' colspan='4'>Click on button <b>Add Contacts from Book</b> to add contacts</td>"+
                                 "</tr>";
                    $(newrow).appendTo("#id_tbl_contact_dir");
                }

            }               
        }
    });
};

var delete_contact_in_group_parent = function(id)
{
    var value_id_group   = $("#id_hid_idgroup").val();
    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/contact_group.ctrl.php",             
        data    : "opt=4&id_cont_group="+id,               
        success : function(data)
        {     
            var obj = JSON.parse(data);

            if(obj.data)
            {
                $.fn.load_contacts_in_group();
            }
            else
            {
                $('#modal_save_del_error').modal('show');
            }
            
        }
    });
}
//END CODE FOR MODAL OF CONTACT FROM CONTACTS BOOK


//CODE FOR MODAL OF CONTACT FROM GROUP
$(document).on('click', '#id_btn_add_contact_group', function()
{ 
    $('#id_modal_add_cont_group').modal('show');
    $("#id_tbl_body_modal_add_cont_group  tr").remove();
});

$('#id_modal_add_cont_group').on('shown.bs.modal', function (e) 
{
    $('#id_sel_group_ex').children('option:not(:first)').remove();
    $('#id_sel_group_ex').val("");
    var value_id_group      = $("#id_hid_idgroup").val();
    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/contact_group.ctrl.php",             
        dataType: "json",    
        data    : "opt=5&id_group="+value_id_group,              
        success : function(data)
        {     
            if(data.success)
            {
              $.each(data.data ,function(i,post)
              {
                  var newrow = "<option value="+post.id+">"+post.name+"</option>";
                  $(newrow).appendTo("#id_sel_group_ex");
              });
            }               
        }
    });
});

$('#id_sel_group_ex').on('change', function() 
{
    var id_group_select   = $(this).val();
    var id_group_current   = $("#id_hid_idgroup").val();
    $("#id_tbl_body_modal_add_cont_group  tr").remove();

    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/contact_group.ctrl.php",             
        dataType: "json",   
        data    : "opt=7&id_group_select="+id_group_select+"&id_group_current="+id_group_current,               
        success : function(data)
        {     
            if(data.success)
            {
                if(data.data.length > 0)
                {
                    var color_tr;
                    $.each(data.data ,function(i,post)
                    {
                        if(post.flag_exist > 0)
                        {
                            color_tr = 'table-danger';
                        }
                        else
                        {
                            color_tr = 'table-success';
                        }
                        var newrow = "<tr style='cursor: pointer;' class='"+color_tr+"'>"+
                                        "<td class='d-none'>"+post.id_contact+"</td>"+
                                        "<td class='d-none'>"+post.flag_exist+"</td>"+
                                        "<td class='d-none'>"+post.id_contact_group+"</td>"+
                                        "<td class='text-center'>"+post.first_name+" "+post.last_name+"</td>"+
                                        "<td class='text-center'>"+post.email+"</td>"+
                                    "</tr>";
                       $(newrow).appendTo("#id_tbl_modal_add_cont_group");
                    });
                }
                else
                {
                    var newrow = "<tr>"+
                                        "<td class='text-center' colspan='2'>There is no Contacts to add</td>"+
                                 "</tr>";
                    $(newrow).appendTo("#id_tbl_modal_add_cont_group");
                }

            }               
        }
    });
});

$('#id_tbl_modal_add_cont_group tbody').on('click', 'tr', function () 
{
    var currentRow=$(this).closest("tr"); 
         
    var id_contact          = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
    var flag                = currentRow.find("td:eq(1)").text(); // get current row 2sd TD value
    var id_contact_group_par= currentRow.find("td:eq(2)").text(); // get current row 3rd TD value  
    var value_id_group      = $("#id_hid_idgroup").val();

    if(flag == 'null')
    {
        $.ajax
        ({    
            type    : "GET",
            url     : "./controller/contact_group.ctrl.php",             
            data    : "opt=3&id_group="+value_id_group+"&id_contact="+id_contact+"&inherited=1&idcontgrpexi="+id_contact_group_par,               
            success : function(data)
            {     
                var obj = JSON.parse(data);

                if(obj.data)
                {
                     $('#id_modal_add_cont_group').modal('hide');      
                     $.fn.load_contacts_in_group_by_group();          
                }
                else
                {
                    $('#modal_save_error').modal('show');
                }
                
            }
        });
    }

});


$.fn.load_contacts_in_group_by_group = function() 
{
    var value_id_group   = $("#id_hid_idgroup").val();
    $("#id_tbl_body_contact_inh  tr").remove();
    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/contact_group.ctrl.php",             
        dataType: "json",   
        data    : "opt=8&id_group_current="+value_id_group,               
        success : function(data)
        {     
            if(data.success)
            {
                if(data.data.length > 0)
                {
                    $.each(data.data ,function(i,post){
                        var newrow = "<tr>"+
                                        "<td class='d-none'>"+post.id_contact_group_child+"</td>"+
                                        "<td class='text-center'>"+post.name_contact+"</td>"+
                                        "<td class='text-center'>"+post.email_contact+"</td>"+
                                        "<td class='text-center'>"+post.name_group_parent+"</td>"+
                                        "<td class='text-center'><i class='fas fa-user-slash' style='cursor: pointer;' onclick='delete_contact_in_group_by_group("+post.id_contact_group_child+")'></i></td>"+
                                    "</tr>";
                       $(newrow).appendTo("#id_tbl_contact_inh");
                    });
                }
                else
                {
                    var newrow = "<tr>"+
                                        "<td class='text-center' colspan='4'>Click on button <b>Add Contacts from Groups</b> to add contacts</td>"+
                                 "</tr>";
                    $(newrow).appendTo("#id_tbl_contact_inh");
                }

            }               
        }
    });
};

var delete_contact_in_group_by_group = function(id)
{
    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/contact_group.ctrl.php",             
        data    : "opt=4&id_cont_group="+id,               
        success : function(data)
        {     
            var obj = JSON.parse(data);

            if(obj.data)
            {
                $.fn.load_contacts_in_group_by_group();
            }
            else
            {
                $('#modal_save_del_error').modal('show');
            }
            
        }
    });
}


$(document).on('click', '#id_btn_all_contacts_to_group', function()
{ 
    var value_id_group      = $("#id_hid_idgroup").val();

    $('#id_tbl_modal_add_cont_group  tbody   tr').each(function(index) 
    { 
        var col1, col2, col3;
        $(this).children("td").each(function (index2) 
        {
            switch (index2) 
            {
                case 0: 
                    col1 = $(this).text();
                break;
                case 1: 
                    col2 = $(this).text();
                break;
                case 2: 
                    col3 = $(this).text();
                break;
            }
            
        });
        if(col2=='null')
        {
            $.ajax
            ({    
                type    : "GET",
                url     : "./controller/contact_group.ctrl.php",             
                data    : "opt=3&id_group="+value_id_group+"&id_contact="+col1+"&inherited=1&idcontgrpexi="+col3,               
                success : function(data)
                {     
                    var obj = JSON.parse(data);

                    if(obj.data)
                    {
                                
                    }
                    else
                    {
                        $('#modal_save_error').modal('show');
                    }
                    
                }
            });
        }
     });
     
     $('#id_modal_add_cont_group').modal('hide');  
     setTimeout(function(){ $.fn.load_contacts_in_group_by_group();  }, 100);  
        
});