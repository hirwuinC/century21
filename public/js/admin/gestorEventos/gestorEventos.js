$(document).ready(function() {
//////////////////////////////////////// ABRIR MODAL PARA NUEVO EVENTO //////////////////////////////////////////////////////
  $('body').on('click','.celdallena',function(e) {
    var validator = $( "#nuevoEventoForm" ).validate();
    validator.resetForm();
    $('.limpiar').val('');
    if (e.target !== this)
    return;
    var dia=$(this).data('fecha');
    if (dia<10) {
      dia='0'+dia;
    }
    var fecha=$('#fechaCompleta').val();
    var mesAno =fecha.split('-',2);
    var fechaDia=mesAno[0]+'-'+mesAno[1]+'-'+dia;
    $('#fechaCompletaModal').val(fechaDia);
    $('#nuevoEvento').modal('show');
  });
///////////////////////////////////////// GUARDAR NUEVO EVENTO /////////////////////////////////////////////////////////////
  $("#nuevoEventoForm").validate({
    onfocusout: false,
    rules: {
      evento:{
        required:true
      }
    },
    messages: {
      evento:{
        required:"Debe indicar la descripción del evento"
      }
    },
    submitHandler: function(form) {
      var form = new FormData(document.getElementById('nuevoEventoForm'));
      url="/admin/guardarEvento";
      $.ajax({
          beforeSend:mostrarPreload(),
          url: url,
          type: "post",
          dataType: "html",
          data: form,
          cache: false,
          contentType: false,
          processData: false
      })
      .done(function(res){
        ocultarPreload();
        //console.log(res);
        if (res) {
          swal(
            'Buen Trabajo!!',
            'El evento fue agendado correctamente',
            'success'
          );
          $('.padreCalendario').empty();
          $('.padreCalendario').append(res);
          $('#nuevoEvento').modal('hide');
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

/////////////////////////////////////////ABRIR MODAL DE HISTORIAL DE EVENTOS //////////////////////////////////////////////////////////
  $('body').on('click','.notification-counter',function(e) {
    e.preventDefault();
    $('#historialEvento').modal('show');
  });
  /////////////////////////////////////////MOSTRAR Y OCULTAR PRELOAD ////////////////////////////////////////////////////////////////
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

//////////////////////////////////////////////////MOSTRAR MES PROXIMO  ////////////////////////////////////////////////////////////////

  $('body').on('click', '.arrow-right', function(event) {
    event.preventDefault();
    var valor=$('#fechaCompleta').val();
    $.ajax({
      beforeSend:mostrarPreload(),
      url: '/admin/proximoMes',
      type: 'post',
      dataType: 'html',
      data: {parametro:valor}
    })
    .done(function(respuesta) {
      ocultarPreload();
      $('.padreCalendario').empty();
      $('.padreCalendario').append(respuesta);
    })
    .fail(function() {
      ocultarPreload();
      //console.log("error");
    });
  });
////////////////////////////////////////////////// MOSTRAR MES ANTERIOR  ////////////////////////////////////////////////////////////////

    $('body').on('click', '.arrow-left', function(event) {
      event.preventDefault();
      var valor=$('#fechaCompleta').val();
      $.ajax({
        beforeSend:mostrarPreload(),
        url: '/admin/mesAnterior',
        type: 'post',
        dataType: 'html',
        data: {parametro:valor}
      })
      .done(function(respuesta) {
        ocultarPreload();
        $('.padreCalendario').empty();
        $('.padreCalendario').append(respuesta);
      })
      .fail(function() {
        ocultarPreload();
        //console.log("error");
      });
    });
});
