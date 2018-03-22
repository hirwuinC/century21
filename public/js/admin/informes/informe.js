$(document).ready(function() {

////////////////////////////////////// ABRIR MODAL PARA NUEVO INFORME /////////////////////////////////////////

  $('body').on('click', '#newInforme', function() {
    $('.limpiar').val('');
    var propiedad=$('#idPropiety').val() ;
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

////////////////////////////////////////////// VALIDAR Y ENVIAR NUEVO INFORME ////////////////////////////////////////////////////////////
$("#formularioInforme").validate({
    onfocusout: false,
    rules: {
      nombreCliente: {
        required:true,
        minlength: 5
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
      visitasFisicas:{
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
    contratoExclusiva: {
      required: "Debe indicarla fecha cuando se firmo el contrato de exclusiva"
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
    visitasFisicas:{
      required:"Debe indicar si hay nuevas visitas físicas al inmueble"
    },
    observacion:{
      required:"Indique sus observaciones"
    },
    recomendacion:{
      required:"Indique sus recomendaciones"
    }
  },
  submitHandler: function(form) {
    var form=$("#asesorCreate").serialize();
    url="/admin/buscaruser";
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
