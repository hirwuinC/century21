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
      if (respuesta) {
        //console.log(respuesta)
        $('#nombreCliente').val(respuesta.nombre_cliente);
        $('#correoCliente').val(respuesta.correoCliente);
        $('#contratoExclusiva').val(respuesta.fechaExclusiva);
        $('#rotuloComercial').val(respuesta.promocionRotulo);
        $('#volanteoDigital').val(respuesta.promocionVolanteo);
        $('#codigoVenezuela').val(respuesta.publicacionVenezuela);
        $('#codigoCaracas').val(respuesta.publicacionCaracas);
        $('#codigoTuInmueble').val(respuesta.publicacionTuInmueble);
        $('#codigoConLaLlave').val(respuesta.publicacionLlave);
        $('#modalReport').modal('show');
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
      codigoVenezuela:{
        required:true
      },
      codigoCaracas:{
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
    codigoVenezuela:{
      required:"Debe indicar el código de la propiedad en este portal"
    },
    codigoCaracas:{
      required:"Debe indicar el código de la propiedad en este portal"
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
    console.log(form);
    url="/admin/guardarInforme";
    $.post(url,form,function(respuesta){
      console.log(respuesta);
      /*var mensajes={0:"Error Inesperado, pongase en contacto con el administrador",
                    1:"El rif ya esta registrado para otro usuario",
                    2:"El email ya esta registrado para otro usuario",
                    3:"El email y el rif ya estan registrados para otro usuario",
                    4:"El nombre ya existe para otro usuario",
                    5:"El nombre y el email ya existen para otro usuario",
                    6:"El nombre y el rif ya existen para otro usuario",
                    7:"El nombre, el email y el rif ya existen para otro usuario",
                   10:"Usuario actualizado",
                   20:"Nuevo usuario registrado"
                 };
      if(respuesta==10 || respuesta==20){
        swal(
          'Buen Trabajo!!',
          mensajes[respuesta],
          'success'
        );
      }
      else {
        swal(
          'Casi Terminamos!!',
          mensajes[respuesta],
          'error'
        );
      }*/
    });
  }
});


});
