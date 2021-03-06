$(document).ready(function() {

////////////////////////////////////// ABRIR MODAL PARA NUEVO INFORME /////////////////////////////////////////

  $('body').on('click', '#newInforme', function() {
    $('.limpiar').val('');
    var propiedad=$('#idPropiety').val() ;
    var valor=$('#idPropietyModal').val(propiedad);
    url="/admin/nuevoInforme";
    $.ajax({
      url: url,
      type: "post",
      dataType: "json",
      data: {propiedad:propiedad},
    })
    .done(function(respuesta){
      if (respuesta[0]==1 || respuesta[0]==3) {
        //console.log(respuesta)
        var validator = $( "#formularioInforme" ).validate();
        validator.resetForm();
        $('#nombreCliente').val(respuesta[1].nombre_cliente);
        $('#correoCliente').val(respuesta[1].correoCliente);
        $('#contratoExclusiva').val(respuesta[1].fechaExclusiva);
        $('#rotuloComercial').val(respuesta[1].promocionRotulo);
        $('#volanteoDigital').val(respuesta[1].promocionVolanteo);
        $('#codigoTuInmueble').val(respuesta[1].publicacionTuInmueble);
        $('#codigoConLaLlave').val(respuesta[1].publicacionLlave);
        $('#modalReport').modal('show');
      }
      else if(respuesta[0]==2 ) {
        swal({
            title: "Imposible realizar la acción!!",
            text: "Debe enviar el último informe al cliente antes de poder crear uno nuevo",
            icon: "error",
            button: "Ok",
        })
      }
      else{
        swal(
          'Algo Sucedio',
          'Intente guardar el inmueble nuevamente',
          'error'
        );
      }
    });
  });
  /////////////////////////////////////////////  OCULTAR O MOSTRAR INFORMACION DE COMPRADORES INTERESADOS  ///////////////////////////////////
    $('body').on('change', 'input:radio[name=compradorInteresado]', function() {
      if ($(this).val()==0) {
        $('.compradoresInteresados').css('display','none');
        $('.ocultoInteresado').val('');
      }
      else{
        $('.compradoresInteresados').css('display','block');
      }
    });
    /////////////////////////////////////////////  OCULTAR O MOSTRAR INFORMACION DE COMPRADORES INTERESADOS  MODIFICAR///////////////////////////////////
      $('body').on('change', 'input:radio[name=compradorInteresadoM]', function() {
        //alert('hola');
        if ($(this).val()==0) {
          $('.compradoresInteresadosM').css('display','none');
          $('.ocultoInteresadoM').val('');
        }
        else{
          $('.compradoresInteresadosM').css('display','block');
        }
      });

/////////////////////////////////////////////  OCULTAR O MOSTRAR INFORMACION DE EVALUACION DE VISITAS AL INMUEBLE  ///////////////////////////////////
  $('body').on('change', 'input:radio[name=visitasFisicas]', function() {
    if ($(this).val()==0) {
      $('.evaluaciones').css('display','none');
      $('.ocultoEvaluacion').val('');
    }
    else{
      $('.evaluaciones').css('display','block');
    }
  });
  /////////////////////////////////////////////  OCULTAR O MOSTRAR INFORMACION DE EVALUACION DE VISITAS AL INMUEBLE  MODIFICAR///////////////////////////////////
    $('body').on('change', 'input:radio[name=visitasFisicasM]', function() {
      if ($(this).val()==0) {
        $('.evaluacionesM').css('display','none');
        $('.ocultoEvaluacionM').val('');
      }
      else{
        $('.evaluacionesM').css('display','block');
      }
    });

////////////////////////////////////////////// VALIDAR Y ENVIAR NUEVO INFORME ////////////////////////////////////////////////////////////
$("#formularioInforme").validate({
    onfocusout: false,
    rules: {
      nombreCliente: {
        required:true,
        minlength: 5
      },
      correoCliente: {
        required:true,
        email: true
      },
      contratoExclusiva: {
        required: true
      },
      rotuloComercial:{
        required:true
      },
      volanteoDigital:{
        required:true
      },
      codigoTuInmueble:{
        required:true
      },
      codigoConLaLlave:{
        required:true
      },
      visitasDigitales:{
        required:true
      },
      compradorInteresado:{
        required:true
      },
      cantidadCInteresados:{
        required:true
      },
      interesado1:{
        required:true
      },
      visitasFisicas:{
        required:true
      },
      cantidadVisitasFisicas:{
        required:true
      },
      observacion:{
        required:true
      },
      recomendacion:{
        required:true
      }

    },
  messages: {
    nombreCliente: {
      required:"Debe indicar el nombre del cliente",
      minlength: "EL nombre del cliente debe ser minimo de 5 caracteres"
    },
    correoCliente: {
      required:"Debe indicar el correo del cliente",
      email:"El correo debe tener el formato minombre@midominio.com"
    },
    contratoExclusiva: {
      required: "Debe indicar la fecha cuando se firmo el contrato de exclusiva"
    },
    rotuloComercial:{
      required:"Debe indicar la gestión de este punto"
    },
    volanteoDigital:{
      required:"Debe indicar la gestión de este punto"
    },
    codigoTuInmueble:{
      required:"Debe indicar el código de la propiedad en este portal"
    },
    codigoConLaLlave:{
      required:"Debe indicar el código de la propiedad en este portal"
    },
    visitasDigitales:{
      required:"Debe indicar la sumatoria de visitas de todos los portales"
    },
    compradorInteresado:{
      required:"Debe indicar si hay nuevos compradores interesados"
    },
    cantidadCInteresados:{
      required:"Debe indicar la cantidad de interesados de todos los portales"
    },
    interesado1:{
      required:"Debe indicar el nombre de al menos un comprador"
    },
    visitasFisicas:{
      required:"Debe indicar si hay nuevas visitas físicas al inmueble"
    },
    cantidadVisitasFisicas:{
      required:"Debe indicar la cantidad de visitas al inmueble"
    },
    observacion:{
      required:"Indique sus observaciones"
    },
    recomendacion:{
      required:"Indique sus recomendaciones"
    }
  },
  submitHandler: function(form) {
    var form=$("#formularioInforme").serialize();
    url="/admin/guardarInforme";
    $.ajax({
      url: url,
      type: "post",
      dataType: "json",
      data: form,
    })
    .done(function(respuesta){
      if(respuesta){
        swal({
            title: "Buen Trabajo!!",
            text: "El informe fue registrado con exito, revise la lista para visualizarlo antes de enviar al cliente",
            icon: "success",
            button: "Ok",
        })
        .then((value) => {
          location.reload();
        });
      }
      else {
        swal(
          'Imposible Realizar la acción',
          'Comuniquese con el administrador del sistema',
          'error'
        );
      }
    });
  }
});

////////////////////////////////////// ABRIR MODAL PARA EDITAR INFORME /////////////////////////////////////////

  $('body').on('click', '.editInforme', function(e) {
    e.preventDefault();
    var id=$(this).data('id');
    $('#idInformeModalM').val(id);
    var propiedad=$('#idPropiety').val() ;
    $('#idPropietyModalM').val(propiedad);
    url="/admin/modaleditarinforme";
    $.ajax({
      url: url,
      type: "post",
      dataType: "json",
      data: {id:id},
    })
    .done(function(respuesta){
      if (respuesta) {
        var validator = $( "#formularioInformeM" ).validate();
        validator.resetForm();
        //console.log(respuesta)
        $('#nombreClienteM').val(respuesta.nombre_cliente);
        $('#correoClienteM').val(respuesta.correoCliente);
        $('#contratoExclusivaM').val(respuesta.fechaExclusiva);
        $('#rotuloComercialM').val(respuesta.promocionRotulo);
        $('#volanteoDigitalM').val(respuesta.promocionVolanteo);
        $('#codigoTuInmuebleM').val(respuesta.publicacionTuInmueble);
        $('#codigoConLaLlaveM').val(respuesta.publicacionLlave);
        $('#visitasDigitalesM').val(respuesta.visitasDigitalesTotales);
        if (respuesta.existeCompradores==0) {
          $('input:radio[name="compradorInteresadoM"][value="0"]').prop('checked', true);
          $('.compradoresInteresadosM').css('display','none');
          $('.ocultoInteresadoM').val('');
        }
        else {
          $('input:radio[name="compradorInteresadoM"][value="1"]').prop('checked', true);
          $('.compradoresInteresadosM').css('display','block');
          $('#cantidadCInteresadosM').val(respuesta.cantidadCompradoresInteresados);
          $('#interesado1M').val(respuesta.primerInteresado);
          $('#interesado2M').val(respuesta.segundoInteresado);
          $('#interesado3M').val(respuesta.tercerInteresado);
          $('#interesado4M').val(respuesta.cuartoInteresado);
          $('#interesado5M').val(respuesta.quintoInteresado);
        }
        if (respuesta.existeVisitasFisicas==0) {
          $('input:radio[name="visitasFisicasM"][value="0"]').prop('checked', true);
          $('.evaluacionesM').css('display','none');
          $('.ocultoEvaluacionM').val('');
        }
        else {
          $('input:radio[name="visitasFisicasM"][value="1"]').prop('checked', true);
          $('.evaluacionesM').css('display','block');
          $('#cantidadVisitasFisicasM').val(respuesta.cantidadVisitasFisicas);
          $('#caroM').val(respuesta.evaluacionCaro);
          $('#malasCondicionesM').val(respuesta.evaluacionMalaCondicion);
          $('#malUbicadoM').val(respuesta.evaluacionMalUbicado);
          $('#formaPagoM').val(respuesta.evaluacionFormaPago);
          $('#enEsperaM').val(respuesta.evaluacionEnEspera);
          $('#volverVisitarM').val(respuesta.evaluacionVolverVisita);
          $('#otroM').val(respuesta.evaluacionOtro);
        }
        $('#observacionM').val(respuesta.observaciones);
        $('#recomendacionM').val(respuesta.recomendaciones);



        $('#modificarModalReport').modal('show');
      }
      else {
        swal(
          'Algo Sucedio',
          'Intente guardar el inmueble nuevamente',
          'error'
        );
      }
    });
  });

  ////////////////////////////////////////////// VALIDAR Y ACTUALIZAR INFORME ////////////////////////////////////////////////////////////
  $("#formularioInformeM").validate({
      onfocusout: false,
      rules: {
        nombreCliente: {
          required:true,
          minlength: 5
        },
        correoCliente: {
          required:true,
          email: true
        },
        contratoExclusiva: {
          required: true
        },
        rotuloComercial:{
          required:true
        },
        volanteoDigital:{
          required:true
        },
        codigoTuInmueble:{
          required:true
        },
        codigoConLaLlave:{
          required:true
        },
        visitasDigitales:{
          required:true
        },
        compradorInteresadoM:{
          required:true
        },
        cantidadCInteresados:{
          required:true
        },
        interesado1:{
          required:true
        },
        visitasFisicasM:{
          required:true
        },
        cantidadVisitasFisicas:{
          required:true
        },
        observacion:{
          required:true
        },
        recomendacion:{
          required:true
        }

      },
    messages: {
      nombreCliente: {
        required:"Debe indicar el nombre del cliente",
        minlength: "EL nombre del cliente debe ser minimo de 5 caracteres"
      },
      correoCliente: {
        required:"Debe indicar el correo del cliente",
        email:"El correo debe tener el formato minombre@midominio.com"
      },
      contratoExclusiva: {
        required: "Debe indicar la fecha cuando se firmo el contrato de exclusiva"
      },
      rotuloComercial:{
        required:"Debe indicar la gestión de este punto"
      },
      volanteoDigital:{
        required:"Debe indicar la gestión de este punto"
      },
      codigoTuInmueble:{
        required:"Debe indicar el código de la propiedad en este portal"
      },
      codigoConLaLlave:{
        required:"Debe indicar el código de la propiedad en este portal"
      },
      visitasDigitales:{
        required:"Debe indicar la sumatoria de visitas de todos los portales"
      },
      compradorInteresadoM:{
        required:"Debe indicar si hay nuevos compradores interesados"
      },
      cantidadCInteresados:{
        required:"Debe indicar la cantidad de interesados de todos los portales"
      },
      interesado1:{
        required:"Debe indicar el nombre de al menos un comprador"
      },
      visitasFisicasM:{
        required:"Debe indicar si hay nuevas visitas físicas al inmueble"
      },
      cantidadVisitasFisicas:{
        required:"Debe indicar la cantidad de visitas al inmueble"
      },
      observacion:{
        required:"Indique sus observaciones"
      },
      recomendacion:{
        required:"Indique sus recomendaciones"
      }
    },
    submitHandler: function(form) {
      var form=$("#formularioInformeM").serialize();
      url="/admin/actualizarInforme";
      $.ajax({
        url: url,
        type: "post",
        dataType: "json",
        data: form
      })
      .done(function(respuesta){
        //console.log(respuesta);
        if(respuesta){
          swal({
              title: "Buen Trabajo!!",
              text: "El informe fue actualizado con exito, revise la lista para visualizarlo antes de enviar al cliente",
              icon: "success",
              button: "Ok",
          })
          .then((value) => {
            $('#modificarModalReport').modal('hide');
          });
        }
        else {
          swal(
            'Imposible Realizar la acción',
            'Comuniquese con el administrador del sistema',
            'error'
          );
        }
      });
    }
  });

$('body').on('click','.enviarInforme',function(e){
  e.preventDefault();
  swal({
    title: "Enviar Informe de gestión a Cliente",
    text: "Al enviar el informe al cliente, no podra realizar mas modificaciones, ¿Desea Continuar?",
    icon: "warning",
    buttons: ['No','Sí, Enviar'],
    dangerMode:false
  })
  .then((willDelete) => {
    if (willDelete) {
      var id=$(this).data('id');
      url="/admin/enviarCorreo";
      $.ajax({
        beforeSend: function(){
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
				},
        url: url,
        type: "post",
        dataType: "json",
        data: {id:id}
      })
      .done(function(respuesta){
        //console.log(respuesta);
        if(respuesta==1){
          $("#WindowLoad").remove();
          $('#load').css('display','none');
          swal({
              title: "Buen Trabajo!!",
              text: "El informe fue enviado con exito",
              icon: "success",
              button: "Ok",
          })
          .then((value) => {
            location.reload();
          });
        }
        else {
          swal(
            'Imposible Realizar la acción',
            'Comuniquese con el administrador del sistema',
            'error'
          );
        }
      })
      .fail( function() {
        $("#WindowLoad").remove();
        $('#load').css('display','none');
        swal(
          'Imposible Realizar la acción',
          'Comuniquese con el administrador del sistema',
          'error'
        );
      });
    }
  });
});


});
