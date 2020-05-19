$( document ).ready(function() 
{

});

$(document).on('click', '#id_btn_save', function()
{ 
  var error = false;

  $('#id_form_group').find(':input:text').each(function(index) 
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

  $('#id_form_group').find(' textarea').each(function(index) 
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


  
  if(!error)
  {
      $.ajax
      ({
        url: 'controller/group.ctrl.php',
        type: 'post',
        data: $("#id_form_group").serialize(),
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
          var obj = JSON.parse(data);

          if(obj.data)
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
  location.href = 'index_group.php';
});