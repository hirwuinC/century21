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
    swal({
      title: "Notificación Importante!!!",
      text: "El inmueble sera mostrado hasta que se le asocie al menos una fotografía en el próximo paso",
      icon: "warning",
      buttons: ['Seguir Aqui',true],
      dangerMode:false
    })
    .then((willDelete) => {
      if (willDelete) {
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
            swal({
              title:'Buen trabajo!!',
              text:"Datos guardados con exito",
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
  }
});
///////////////////////////////////////////// CARGA DE IMAGENES PARA EL INMUEBLE //////////////////////////////
  var cont= $('.thumbPropiety').length;
  if (cont>7) {
    $('.addPicCont').css('display','none');
  }
  var inicio= $('#last').val();
  let contador = 1;
  if (inicio!='') {
    contador=inicio;
  }
  $('body').on('click','#addPic',function(e){
    var dominio=window.location.host;
      contador++;
      e.preventDefault()
      $(`<div class='col-sm-3 thumbPropiety'>
          <div class='thumbProperty'>
            <div class='contentTop'>
              <img class='imgInmueble' src='http://${dominio}/images/img-demo-images.jpg' alt=''>
            </div>
            <div class='contentInfo'>
              <div class='buttonsAction'>
                <div class='row'>
                  <div class='col-xs-12'>
                    <div class='col-xs-6' >
                      <button type='button' class='btnAcction btnCargar'>
                        <input type='file' id="imagen-${contador}" name='image[]' accept='image/png, .jpeg, .jpg, image/gif' class='file-input'>Cargar
                        <input type="hidden" class="register" value="${contador}" id="index-${contador}">
                      </button>
                    </div>
                    <div class='col-xs-6'>
                      <button type='button' class='btnAcction btnBorrar'>Borrar</button>
                    </div>
                  </div>
                </div>
                <div class='row'>
                  <div class='col-xs-12'>
                    <div class='col-xs-6 col-xs-offset-4' >
                      <div class="styled-input-single">
                          <input type="radio" name="fotovisible" value="${contador}" id="radio-example-${contador}"/>
                          <label for="radio-example-${contador}"></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>`).prependTo('.nueva');
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
        button:true
      });
    }
    else {
      var input= $(this).parent().parent().find('.register');
      var registro=input.val();
      console.log(registro)
      var form= new FormData();
      form.append('registro',registro);
      url="/admin/borrarImagen";
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
        console.log(respuesta);
      });
      $(this).parent().parent().parent().parent().parent().parent().parent().remove();
    }
    var contThumb= $('.thumbPropiety').length;
    if (contThumb<8) {
      $('.addPicCont').css('display','block');
    }
  });
  $('body').on('change','.file-input',function(){
    var tamano=this.files[0].size/1024;
    if (tamano<=1024) {
      var form= new FormData();
      var file= this.files[0];
      var posicion= $(this).parent().find('.register');
      var id=posicion.attr('id');
      var valor=posicion.val();
      form.append('file',file);
      form.append('register',id);
      form.append('valor',valor);
      url="/admin/guardarImagen";
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
        var ubicacion=respuesta[0];
        var id=respuesta[1];
        console.log(respuesta);
        $("#"+ubicacion+"").val(id);
      });
        var curElement = $(this).parent().parent().parent().parent().parent().parent().parent().find('.imgInmueble');
        var reader = new FileReader();
        reader.onload = function (e) {
            curElement.attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
    else {
      swal({
        title:'Error al cargar Imagen!!!',
        text:"La imagen es demasiado pesada, debe pesar menos de 1mb",
        icon:'error',
        button:true,
      });
    }

  });
  $('body').on('submit','#picPropiety',function(e){
    e.preventDefault();
    var marcador=$('input[name=fotovisible]:checked');
    if (marcador.length>0) {
      var imgSelected=marcador.val();
      var form= new FormData();
      form.append('imgSelected',imgSelected);
      url="/admin/guardarInmueble";
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
        if (respuesta==1) {
          swal({
            title:'Buen trabajo!!',
            text:"El inmueble fue guardado con exito",
            icon:'success',
            timer: 2000,
            button:false,
          });
          setTimeout(function(){location.href = "/admin/crear-inmueble-1";},2300); // 3000ms = 3
        }
        else {
          swal({
            title:'Imposible realizar esa acción',
            text:"Debe cargar al menos una foto al inmueble",
            icon:'error',
            button:true
          });
        }
      });
    }
    else {
      swal({
        title:'Imposible realizar esa acción',
        text:"Debe seleccionar una foto como portada del inmueble",
        icon:'error',
        button:true
      });
    }


  });
});
