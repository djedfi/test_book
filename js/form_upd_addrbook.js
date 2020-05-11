$( document ).ready(function() 
{
    $.ajax
    ({    
      type    : "GET",
      url     : "./controller/addrbook.ctrl.php",             
      dataType: "json",    
      data    : "opt=2",              
      success : function(data)
      {     
          if(data.success)
          {
            $.each(data.data ,function(i,post)
            {
                var newrow = "<option value="+post.id+">"+post.name+"</option>";
                $(newrow).appendTo("#id_sel_city");
            });
          }               
      }
    });

    $('#id_sel_city').on('change', function() 
    {
        var value   = $(this).val();
        $.ajax
        ({    
            type    : "GET",
            url     : "./controller/addrbook.ctrl.php",             
            dataType: "json",    
            data    : "opt=3&id_city="+value,              
            success : function(data)
            {     
                var val_zip_format_code = '';
                var pattern_final = '';
                $.each(data.data ,function(i,post)
                {
                    val_zip_format_code = post.format_code;
                });      
    
                for(i=0;i<val_zip_format_code.length;i++)
                {
                    if(val_zip_format_code[i] == 'A')
                    {
                        pattern_final += '[a-zA-Z]';
                    }
                    else
                    {
                        pattern_final += '[0-9]';
                    }
                }
                pattern_final += '+';
                $("#id_txt_zip").next('small').remove();
                $("#id_txt_zip").after('<small id="id_help_format_zip_newaddrbook" class="form-text text-muted">The format of zip code is: <b>'+val_zip_format_code+'</b>. Where "A" is letter or "0" is number, without space.</small>');         
                $("#id_txt_zip").removeAttr("pattern");
                $("#id_txt_zip").attr("pattern",pattern_final);
            }
        });
  
    }); 
    
    
    $.ajax
    ({    
        type    : "GET",
        url     : "./controller/addrbook.ctrl.php",             
        dataType: "json",    
        data    : "opt=1&id="+$("#id").val(),              
        success : function(data)
        {     
            if(data.success)
            {
                $.each(data.data ,function(i,post)
                {
                    $("#id_txt_lname").val(post.last_name);
                    $("#id_txt_fname").val(post.first_name);
                    $("#id_sel_city").val(post.id_city);
                    $("#id_txt_email").val(post.email);
                    $("#id_txt_zip").val(post.zipcode);
                    $("#id_txta_street").val(post.street);
                });
            }               
        }
    });

});


$(document).on('click', '#id_btn_save', function()
{ 
  var error = false;

  $('#id_form_addrbook').find(':input:text').each(function(index) 
  {
    id_controller_1 = ($(this).attr('id')).toString();

    if($('#'+id_controller_1).val().trim() == '')
    {
        $( "#"+id_controller_1 ).removeClass( "is-valid" ).addClass( "is-invalid ");
        error = true;
    }
    else if (document.getElementById(id_controller_1).checkValidity())
    {
      $( "#"+id_controller_1 ).removeClass( "is-invalid" ).addClass( "is-valid ");
    }
    else
    {
      $( "#"+id_controller_1 ).removeClass( "is-valid" ).addClass( "is-invalid ");
      error = true;
    }
  });

  $('#id_form_addrbook').find(':input[type=email]' ).each(function(index) 
  {
    id_controller_2 = ($(this).attr('id')).toString();

    if($('#'+id_controller_2).val().trim() == '')
    {
        $( "#"+id_controller_2 ).removeClass( "is-valid" ).addClass( "is-invalid ");
        error = true;
    }
    else if (document.getElementById(id_controller_2).checkValidity())
    {
      $( "#"+id_controller_2 ).removeClass( "is-invalid" ).addClass( "is-valid ");
    }
    else
    {
      $( "#"+id_controller_2 ).removeClass( "is-valid" ).addClass( "is-invalid ");
      error = true;
    }
  });

  $('#id_form_addrbook').find(' select').each(function(index) 
  {
    id_controller_3 = ($(this).attr('id')).toString();
    if (document.getElementById(id_controller_3).checkValidity())
    {
      $( "#"+id_controller_3 ).removeClass( "is-invalid" ).addClass( "is-valid ");
    }
    else
    {
      $( "#"+id_controller_3 ).removeClass( "is-valid" ).addClass( "is-invalid ");
      error = true;
    }
  });

  $('#id_form_addrbook').find(' textarea').each(function(index) 
  {
    id_controller_4 = ($(this).attr('id')).toString();

    if($('#'+id_controller_4).val().trim() == '')
    {
        $( "#"+id_controller_4 ).removeClass( "is-valid" ).addClass( "is-invalid ");
        error = true;
    }
    else if (document.getElementById(id_controller_4).checkValidity())
    {
      $( "#"+id_controller_4 ).removeClass( "is-invalid" ).addClass( "is-valid ");
    }
    else
    {
      $( "#"+id_controller_4 ).removeClass( "is-valid" ).addClass( "is-invalid ");
      error = true;
    }
  });

  if(!error)
  {
      $.ajax
      ({
        url: 'controller/addrbook.ctrl.php',
        type: 'post',
        data: $("#id_form_addrbook").serialize(),
        beforeSend: function()
        {
          $("#id_btn_save").val("Sending"); 
          $("#id_btn_save").attr("disabled","disabled");
        },
        complete:function(data)
        {
          $("#id_btn_save").val("Save");
          $("#id_btn_save").removeAttr("disabled");
        },
        success: function(data) 
        {
          if(data)
          {
            $('#modal_save_info').modal('show');
          }
          else
          {
            $('#modal_save_error').modal('show');
          }
        },
        error: function(data)
        {
            $('#modal_save_error').modal('show');
        }
      });
  }
  
});

$(document).on('click', '#id_btn_save_info', function()
{ 
  location.href = 'index_book.php';
});