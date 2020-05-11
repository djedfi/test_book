$( document ).ready(function() 
{
  $.ajax
    ({    
        type    : "GET",
        url     : "./controller/city.ctrl.php",             
        dataType: "json",    
        data    : "opt=2",              
        success : function(data)
        {     
            if(data.success)
            {
              $.each(data.data ,function(i,post)
              {
                  var newrow = "<option value="+post.id+">"+post.name+"</option>";
                  $(newrow).appendTo("#id_sel_country");
              });
            }               
        }
  });
});

$(document).on('click', '#id_btn_save', function()
{ 
  var error = false;

  $('#id_form_city').find(':input:text').each(function(index) 
  {
    id_controller_1 = ($(this).attr('id')).toString();
    if (document.getElementById(id_controller_1).checkValidity())
    {
      $( "#"+id_controller_1 ).removeClass( "is-invalid" ).addClass( "is-valid ");
    }
    else
    {
      $( "#"+id_controller_1 ).removeClass( "is-valid" ).addClass( "is-invalid ");
      error = true;
    }
  });

  $('#id_form_city').find(' select').each(function(index) 
  {
    id_controller_2 = ($(this).attr('id')).toString();
    if (document.getElementById(id_controller_2).checkValidity())
    {
      $( "#"+id_controller_2 ).removeClass( "is-invalid" ).addClass( "is-valid ");
    }
    else
    {
      $( "#"+id_controller_2 ).removeClass( "is-valid" ).addClass( "is-invalid ");
      error = true;
    }
  });


  if($('#id_txt_city').val().trim() == '')
  {
    $( "#id_txt_city" ).removeClass( "is-valid" ).addClass( "is-invalid ");
    error = true;
  }
  else
  {
    $( "#id_txt_city").removeClass( "is-invalid" ).addClass( "is-valid ");
  }
  
  if(!error)
  {
      $.ajax
      ({
        url: 'controller/city.ctrl.php',
        type: 'post',
        data: $("#id_form_city").serialize(),
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
  location.href = 'index_city.php';
});