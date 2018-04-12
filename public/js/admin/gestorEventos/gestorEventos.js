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
      //console.log($('#evento').val());
      $.ajax({
          beforeSend:mostrarPreload(),
          url: url,
          type: "post",
          dataType: "html",
          data: form,
          cache: false,
          contentType:false,
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
          $('.limpiar').val('');
          $('.padreCalendario').append(res);
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
      swal(
        'Imposible Realizar la acción',
        'Comuniquese con el administrador del sistema',
        'error'
      );
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
        swal(
          'Imposible Realizar la acción',
          'Comuniquese con el administrador del sistema',
          'error'
        );
        //console.log("error");
      });
    });
//////////////////////////////////////// ABRIR MODAL PARA HISTORIAL DE EVENTOS  POR DIA ////////////////////////////////////////////
    $('body').on('click','.notification-counter',function(e) {
      e.preventDefault();
      var dia=$(this).parent().data('fecha');
      $('#contador').val(this.id);
      if (dia<10) {
        dia='0'+dia;
      }
      var fecha=$('#fechaCompleta').val();
      var mesAno =fecha.split('-',2);
      var fechaDia=mesAno[0]+'-'+mesAno[1]+'-'+dia;
      var fechamostrar=dia+'-'+mesAno[1]+'-'+mesAno[0];
      $('#fechaMostrar').html(fechamostrar);
      $.ajax({
        beforeSend:mostrarPreload(),
        url: '/admin/eventoDia',
        type: 'post',
        dataType: 'html',
        data: {fechaDia:fechaDia}
      })
      .done(function(respuesta) {
        ocultarPreload();
        $('#padreHistorial').empty();
        $('#padreHistorial').append(respuesta);
        $('#historialEvento').modal('show');
      })
      .fail(function() {
        ocultarPreload();
        swal(
          'Imposible Realizar la acción',
          'Comuniquese con el administrador del sistema',
          'error'
        );
      });
    });
//////////////////////////////////////// ELIMINAR EVENTOS DEL DIA  ///////////////////////////////////////////////////////////////////////////
  $('body').on('click', '.close-event', function(event) {
    event.preventDefault();
    var registro=$(this).parent().children('.registro').val();
    $.ajax({
      beforeSend:mostrarPreload(),
      url: '/admin/eliminarEvento',
      type: 'post',
      context:$(this),
      dataType: 'html',
      data: {registro:registro}
    })
    .done(function(respuesta) {
      ocultarPreload();
        var contador=$('#contador').val();
        var actual=$('#'+contador).html();
        var resta=actual-1;
        if (resta==0) {
          $('#'+contador).remove();
          $('#historialEvento').modal('hide');
        }
        else {
          var nuevo=$('#'+contador).html(resta);
        }
        var contHijos= $(this).parent().parent().parent().parent().children('.row').length;
        if (contHijos==1) {
          $(this).parent().parent().parent().parent().parent().remove();
          $(this).parent().parent().parent().remove();
        }
        else{
          $(this).parent().parent().parent().remove();
        }
    })
    .fail(function() {
      ocultarPreload();
      swal(
        'Imposible Realizar la acción',
        'Comuniquese con el administrador del sistema',
        'error'
      );
    });
  });
//////////////////////////////////////// MODIFICAR EVENTOS DEL DIA  ///////////////////////////////////////////////////////////////////////////
  $('body').on('focusout', '.modificarCampo', function() {
    var registro=$(this).parent().children('.registro').val();
    var texto=$(this).val();
    $.ajax({
      url: '/admin/modificarEvento',
      type: 'post',
      context:$(this),
      dataType: 'html',
      data: {registro:registro,texto:texto}
    })
    .done(function(respuesta) {
      console.log(respuesta);
    })
    .fail(function() {
      swal(
        'Imposible Realizar la acción',
        'Comuniquese con el administrador del sistema',
        'error'
      );
    });
  });
});
