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
          //console.log(respuesta);
          $('.opcionUrbanizacion').remove();
          $.each(respuesta.urbanizaciones,function(e){
            $('#namePropiety').append("<option value="+respuesta.urbanizaciones[e].id+" class='opcionUrbanizacion' >"+respuesta.urbanizaciones[e].nombre+"</option>");
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
//////////////////////////////////////// Validador del formulario///////////////////////////////////////////////

$("#propietyEdit").validate({
    onfocusout: false,
    rules: {
      namePropiety: {
        required:true,
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
      porcentajeCaptacion:{
        required:true
      },
      refDolares:{
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
      },
      estatusPropiedad:{
        required:true
      }
    },
  messages: {
    namePropiety: {
      required:"Indique el nombre del Inmueble (Residencia, Urbanizacion...)"
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
    porcentajeCaptacion:{
      required:"El porcentaje de captación es un campo requerido"
    },
    refDolares:{
      required:"El monto en dolares es un campo requerido"
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
    },
    estatusPropiedad:{
      required:"Debe seleccionar el estatus del inmueble"
    }
  },
  submitHandler: function(form) {
    var form= new FormData(document.getElementById("propietyEdit"));
    url="/admin/actualizarInmueble";
    $.ajax({
      beforeSend: mostrarPreload(),
      url: url,
      type: "post",
      dataType: "json",
      data: form,
      cache: false,
      contentType: false,
      processData: false
    })
    .done(function(respuesta){
      ocultarPreload();
      if (respuesta[0]==1) {
        swal({
          title:'Edición Exitosa!!',
          text:"Los datos fueron actualizados",
          icon:'success',
          timer: 2000,
          button:false,
        });
        setTimeout(function(){location.href = "/admin/editar-inmueble2/"+respuesta[1];},2300); // 3000ms = 3
      }
      else if(respuesta[0]==2){
        swal({
          title:'Imposible realizar la acción!!',
          text:"Los datos de la propiedad no pueden ser modificados ya que esta se encuentra con alguna negociación activa o finalizada.",
          icon:'warning',
          timer: 2800,
          button:false,
        });
        setTimeout(function(){location.href = "/admin/editar-inmueble2/"+respuesta[1];},3000);
      }
    }).fail( function() {
      ocultarPreload();
      swal(
        'Imposible Realizar la acción',
        'Comuniquese con el administrador del sistema',
        'error'
      );
    });
  }
});
///////////////////////////////////////////// CARGA DE IMAGENES PARA EL INMUEBLE //////////////////////////////

var inicio= $('#last').val();
let contador = 1;
if (inicio!='') {
  contador=inicio;
}
$('body').on('click','#addPic',function(e){
  var protocolo = window.location.protocol;
  var dominio=window.location.host;
    contador++;
    e.preventDefault()
    $(`<div class='col-sm-3 thumbPropiety'>
        <div class='thumbProperty'>
          <div class='contentTop'>
            <img class='imgInmueble' src='${protocolo}//${dominio}/images/img-demo-images.png' alt=''>
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
                    <div class="portada">¿Portada?</div>
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
    //console.log(registro)
    var form= new FormData();
    form.append('registro',registro);
    form.append('desicion',1);
    url="/admin/borrarImagen";
    $.ajax({
      beforeSend:mostrarPreload(),
      url: url,
      type: "post",
      dataType: "json",
      data: form,
      context:$(this),
      cache: false,
      contentType: false,
      processData: false
    })
    .done(function(respuesta){
      ocultarPreload();
      if (respuesta==2) {
        swal(
          'Imposible Realizar la acción',
          'La foto que esta intentando borrar esta seleccionada como portada del inmueble, seleccione y guarde otra e intentelo de nuevo',
          'error'
        );
      }
      else{
        $(this).parent().parent().parent().parent().parent().parent().parent().remove();
      }
    }).fail( function() {
        ocultarPreload();
        swal(
          'Imposible Realizar la acción',
          'Comuniquese con el administrador del sistema',
          'error'
        );
    });
  }
  var contThumb= $('.thumbPropiety').length;
  if (contThumb<9) {
    $('.addPicCont').css('display','block');
  }
});
/////////////////////////////////////////// CARGA DE IMAGENES PARA EL INMUEBLE ///////////////////////////////////////////////////

$('body').on('change','.file-input',function(){
  var tamano=this.files[0].size/1024;
  var protocolo = window.location.protocol;
  var servidor = window.location.host;
  var dominio = protocolo+'//'+servidor+'/';
  if (tamano<=1024) {
    var form= new FormData();
    var file= this.files[0];
    //console.log(file);
    var posicion= $(this).parent().find('.register');
    var id=posicion.attr('id');
    var valor=posicion.val();
    form.append('file',file);
    form.append('register',id);
    form.append('valor',valor);
    form.append('desicion',1);
    form.append('dominio',dominio);
    url="/admin/guardarImagen";
    $.ajax({
      beforeSend:mostrarPreload(),
      url: url,
      type: "post",
      dataType: "json",
      data: form,
      cache: false,
      contentType: false,
      processData: false,
    })
    .done(function(respuesta){
      //console.log(respuesta);
      ocultarPreload();
      var ubicacion=respuesta[0];
      var id=respuesta[1];
      $("#"+ubicacion+"").val(id);
      $("#radio-example-"+valor).val(id);

    }).fail( function() {
        ocultarPreload();
        swal(
          'Imposible Realizar la acción',
          'Comuniquese con el administrador del sistema',
          'error'
        );
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
  if (marcador.length==1) {
    var imgSelected=marcador.val();
    var form= new FormData();
    form.append('imgSelected',imgSelected);
    form.append('desicion',1);
    url="/admin/guardarInmueble";
    $.ajax({
      beforeSend:mostrarPreload(),
      url: url,
      type: "post",
      dataType: "json",
      data: form,
      cache: false,
      contentType: false,
      processData: false
    })
    .done(function(respuesta){
      ocultarPreload();
      //console.log(respuesta)
      if (respuesta==1) {
        swal({
          title:'Buen trabajo!!',
          text:"El inmueble fue guardado con exito",
          icon:'success',
          timer: 2000,
          button:false,
        });
        setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3
      }
      else if(respuesta==2){
        swal({
          title:'Imposible realizar esa acción',
          text:"El elemento que seleccione debe tener foto cargada",
          icon:'error',
          button:true
        });
      }
      else {
        swal({
          title:'Imposible realizar esa acción',
          text:"Debe cargar al menos una foto para el inmueble",
          icon:'error',
          button:true
        });
      }
    }).fail( function() {
      ocultarPreload();
      swal(
        'Imposible Realizar la acción',
        'Comuniquese con el administrador del sistema',
        'error'
      );
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
