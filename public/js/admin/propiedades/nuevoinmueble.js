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
        console.log(respuesta);
        $('.opcion').remove();
        $.each(respuesta.ciudades,function(e){
          $('#cityPropiety').append("<option value="+respuesta.ciudades[e].id+" class='opcion' >"+respuesta.ciudades[e].nombre+"</option>");
        });
      }
    });
  });
//////////////////////////////////////// Validador del formulario///////////////////////////////////////////////

$("#propietyCreate").validate({
    onfocusout: true,
    rules: {
      namePropiety: {
        required:true,
        minlength: 3
      },
      typePropiety: {
        required: true
      },
      estatePropiety:{
        required:true
      },
      cityPropiety:{
        required:true
      },
      addressPropiety:{
        required:true
      },
      pricePropiety:{
        required:true
      },
      visiblePrice:{
        required:true
      },
      constructionPropiety:{
        required:true
      },
      areaPropiety:{
        required:true
      },
      roomPropiety:{
        required:true
      },
      batroomPropiety:{
        required:true
      },
      parkingPropiety:{
        required:true
      },
      descriptionPropiety:{
        required:true
      },
      asesorPropiety:{
        required:true
      },
      typeBussisness:{
          required:true
      }
    },
  messages: {
    namePropiety: {
      required:"Indique el nombre del Inmueble (Residencia, Urbanizacion...)",
      minlength: "El nombre debe tener minimo 3 caracteres"
    },
    typePropiety: {
      required: "Indique el tipo de inmueble que desea crear"
    },
    estatePropiety:{
      required:"Indique el estado donde se encuentra el inmueble"
    },
    cityPropiety:{
      required:"Debe indicar la ciudad donde se encuentra el inmueble"
    },
    addressPropiety:{
      required:"Describa la dirección especifica del inmueble"
    },
    pricePropiety:{
      required:"El precio del inmueble es un campo requerido"
    },
    visiblePrice:{
      required:"Debe especificar si desea que se muestre o no el precio de venta"
    },
    constructionPropiety:{
      required:"Los metros cuadrados de construcción del inmueble son requeridos"
    },
    areaPropiety:{
      required:"Debe indicar los metros de terreno del inmueble "
    },
    roomPropiety:{
      required:"Indique la cantidad de habitaciones del inmueble"
    },
    batroomPropiety:{
      required:"Indique la cantidad de baños del inmueble"
    },
    parkingPropiety:{
      required:"Indique la cantidad de puestos de estacionamiento del inmueble"
    },
    descriptionPropiety:{
      required:"Comente las caracteristicas del inmueble"
    },
    asesorPropiety:{
      required:"Debe indicar el asesor que capto el inmueble"
    },
    typeBussisness:{
      required:"Debe seleccionar el tipo de Negociación"
    }
  },
  submitHandler: function(form) {
    var form= new FormData(document.getElementById("propietyCreate"));
    url="/admin/cargarPropiedad";
    $.ajax({
      url: url,
      type: "post",
      dataType: "json",
      data: form,
      cache: false,
      contentType: false,
      processData: false
    })
    .done(function(respuesta){
      if (respuesta) {
        console.log(respuesta)
        swal({
          title:'Buen trabajo!!',
          text:"Los datos fueron guardados temporalmente, ahora debe cargar las fotos del inmueble",
          icon:'success',
          timer: 2000,
          button:false,
        });
        setTimeout(function(){location.href = "/admin/crear-inmueble-2";},2300); // 3000ms = 3
      }
      else {
        swal(
          'Algo Sucedio',
          'Intente guardar el inmueble nuevamente',
          'error'
        );
      }
    });
  }
});
///////////////////////////////////////////// CARGA DE IMAGENES PARA EL INMUEBLE //////////////////////////////
  $('body').on('click','#addPic',function(e){
      e.preventDefault();
      $('#img').clone().prependTo('.nueva');
      var cont= $('.thumbPropiety').length;
      if (cont>7) {
        $('.addPicCont').css('display','none');
      }
  });
  $('body').on('click','.btnBorrar',function(e){
    e.preventDefault();
    var contBtn= $('.btnBorrar').length;
    if (contBtn==1) {
      swal({
        title:'Imposible realizar esa acción',
        text:"Debe cargar al menos una foto al inmueble",
        icon:'warning',
        //timer: 2000,
        button:true
      });
    }
    else {
      $(this).parent().parent().parent().parent().parent().parent().parent().remove();
    }
    var contThumb= $('.thumbPropiety').length;
    if (contThumb<8) {
      $('.addPicCont').css('display','block');
    }
  });
  $('body').on('change','.file-input',function(){
      var curElement = $(this).parent().parent().parent().parent().parent().parent().parent().find('.imgInmueble');
      var reader = new FileReader();

      reader.onload = function (e) {
          curElement.attr('src', e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
  });
});
