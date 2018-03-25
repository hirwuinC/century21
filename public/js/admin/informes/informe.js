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
    /////////////////////////////////////////////  OCULTAR O MOSTRAR INFORMACION DE COMPRADORES INTERESADOS  ///////////////////////////////////
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
        console.log(respuesta)
        $('#nombreClienteM').val(respuesta.nombre_cliente);
        $('#correoClienteM').val(respuesta.correoCliente);
        $('#contratoExclusivaM').val(respuesta.fechaExclusiva);
        $('#rotuloComercialM').val(respuesta.promocionRotulo);
        $('#volanteoDigitalM').val(respuesta.promocionVolanteo);
        $('#codigoVenezuelaM').val(respuesta.publicacionVenezuela);
        $('#codigoCaracasM').val(respuesta.publicacionCaracas);
        $('#codigoTuInmuebleM').val(respuesta.publicacionTuInmueble);
        $('#codigoConLaLlaveM').val(respuesta.publicacionLlave);
        $('#visitasDigitalesM').val(respuesta.visitasDigitalesTotales);
        if (respuesta.existeCompradores==0) {
          $('#compradorInteresadoSiM').prop('checked',false);
          $('#compradorInteresadoNoM').prop('checked',true);
          $('.compradoresInteresadosM').css('display','none');
          $('.ocultoInteresadoM').val('');
        }
        else {
          $('#compradorInteresadoNoM').prop('checked',false);
          $('#compradorInteresadoSiM').prop('checked',true);
          $('.compradoresInteresadosM').css('display','block');

        }




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

});
