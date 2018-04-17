$(document).ready(function() {
//////////////////////////////////////// Select dependiente de Ciudad ///////////////////////////////////////////////
  $('body').on('change','#estatePropiety',function(){
    var estado=$(this).val();
    var url='/admin/listarCiudades';
    $.ajax({
      data:{estado:estado},
      url:url,
      type:'post',
      success:function(respuesta){
        //console.log(respuesta);
        $('.opcion').remove();
        $('.opcionUrbanizacion').remove();
        $.each(respuesta.ciudades,function(e){
          $('#cityPropiety').append("<option value="+respuesta.ciudades[e].id+" class='opcion' >"+respuesta.ciudades[e].nombre+"</option>");
        });
      }
    });
  });
  //////////////////////////////////////// Select dependiente de urbanizacion ///////////////////////////////////////////////
    $('body').on('change','#cityPropiety',function(){
      var ciudad=$(this).val();
      var url='/admin/listarUrbanizaciones';
      $.ajax({
        data:{ciudad:ciudad},
        url:url,
        type:'post',
        success:function(respuesta){
          $('.opcionUrbanizacion').remove();
          $.each(respuesta.urbanizaciones,function(e){
            $('#urbanizacionPropiety').append("<option value="+respuesta.urbanizaciones[e].id+" class='opcionUrbanizacion' >"+respuesta.urbanizaciones[e].nombre+"</option>");
          });
        }
      });
    });
/////////////////////////////////////////MOSTRAR Y OCULTAR PRELOAD ///////////////////////////////////////////////////////
  function mostrarPreload(){
    var ancho = 0;
    var alto = 0;
    if (window.innerWidth == undefined) ancho = window.screen.width;
    else ancho = window.innerWidth;
    if (window.innerHeight == undefined) alto = window.screen.height;
    else alto = window.innerHeight;
    div = document.createElement("div");
    div.id = "WindowLoad"
    div.style.width = ancho + "px";
    div.style.height = alto + "px";
    $("body").append(div);
    $('#load').css('display','block');
  };
  function ocultarPreload(){
    $("#WindowLoad").remove();
    $('#load').css('display','none');
  }

//////////////////////////////////////// Abrir modal nueva ciudad///////////////////////////////////////////////
  $('body').on('click', '#bttnNuevaCiudad', function() {
    var estado=$('#estatePropiety').val();
    if (estado=='') {
      swal(
        'Imposible Realizar la acción',
        'Debe seleccionar un estado',
        'error'
      );
    }
    else {
      $('#estado').val(estado);
      var estado=$('#estatePropiety option:selected').html();
      $('#estadoTag').html(estado);
      $('#nuevaCiudad').modal('show');
    }
  });

//////////////////////////////////////// Abrir modal nueva urbanización ///////////////////////////////////////////////
    $('body').on('click', '#bttnNuevaUrbanizacion', function() {
      var ciudad=$('#cityPropiety').val();
      if (ciudad=='') {
        swal(
          'Imposible Realizar la acción',
          'Debe seleccionar una ciudad',
          'error'
        );
      }
      else {
        //console.log(ciudad);
        $('#ciudadId').val(ciudad);
        $('#nuevaUrbanizacion').modal('show');
      }
    });
///////////////////////////////////////// GUARDAR CIUDAD /////////////////////////////////////////////////////////////
  $("#nuevaCiudadForm").validate({
    onfocusout: false,
    rules: {
      ciudad:{
        required:true
      }
    },
    messages: {
      ciudad:{
        required:"Debe indicar el nombre de la ciudad"
      }
    },
    submitHandler: function(form) {
      var form = new FormData(document.getElementById('nuevaCiudadForm'));
      url="/admin/guardarCiudad";
      //console.log($('#evento').val());
      $.ajax({
          beforeSend:mostrarPreload(),
          url: url,
          type: "post",
          dataType: "json",
          data: form,
          cache: false,
          contentType:false,
          processData: false
      })
      .done(function(respuesta){
        ocultarPreload();
        //console.log(res);
        var estado=$('#estatePropiety option:selected').html();
        if (respuesta[0]==1) {
          swal(
            'Buen Trabajo!!',
            'La ciudad fue cargada correctamente para el estado '+estado,
            'success'
          );
          $('.limpiarCiudad').val('');
          $('.opcion').remove();
          $.each(respuesta[1],function(e){
            $('#cityPropiety').append("<option value="+respuesta[1][e].id+" class='opcionUrbanizacion' >"+respuesta[1][e].nombre+"</option>");
          });
        }
        else{
          swal(
            'Imposible Realizar la acción',
            'Ya existe una ciudad cargada para este estado con ese nombre',
            'error'
          );
        }
      })
      .fail(function(){
        ocultarPreload();
        swal(
          'Imposible Realizar la acción',
          'Comuniquese con el administrador del sistema',
          'error'
        );
      });
    }
  });

});
