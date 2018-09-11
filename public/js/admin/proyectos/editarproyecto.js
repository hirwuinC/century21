$(document).ready(function() {
//////////////////////////////////////// Select dependiente de Ciudad ///////////////////////////////////////////////
  $('body').on('change','#estateProyect',function(){
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
          $('#cityProyect').append("<option value="+respuesta.ciudades[e].id+" class='opcion' >"+respuesta.ciudades[e].nombre+"</option>");
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
//////////////////////////////////////// Validador del formulario 1///////////////////////////////////////////////

$("#proyectEdit").validate({
    onfocusout: false,
    rules: {
      nameProyect: {
        required:true,
        minlength: 3
      },
      estateProyect:{
        required:true
      },
      cityProyect:{
        required:true
      },
      addressProyect:{
        required:true
      },
      constructionProyect:{
        required:true
      },
      dateEnd:{
        required:true
      },
      descriptionProyect:{
        required:true
      },
      typeBussisness:{
          required:true
      }
    },
  messages: {
    nameProyect: {
      required:"Indique el nombre del proyecto que se mostrara",
      minlength:"El nombre debe tener un mínimo de 3 caracteres"
    },
    estateProyect:{
      required:"Seleccione el estado donde se encuentra el proyecto"
    },
    cityProyect:{
      required:"Seleccione la ciudad donde se encuentra el proyecto"
    },
    addressProyect:{
      required:"Indique la direccion del proyecto"
    },
    constructionProyect:{
      required:"Debe indicar los metros de construcción del proyecto"
    },
    dateEnd:{
      required:"Indique la fecha estimada de culminación"
    },
    descriptionProyect:{
      required:"Describa las características del proyecto"
    },
    typeBussisness:{
        required:"Seleccione el tipo de negociación"
    }
  },
  submitHandler: function(form) {
      var form= new FormData(document.getElementById("proyectEdit"));
      url="/admin/actualizarProyecto1";
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
        if (respuesta) {
          swal({
            title:'Buen trabajo!!',
            text:"Datos guardados con exito",
            icon:'success',
            timer: 2000,
            button:false,
          });
          setTimeout(function(){location.href = "/admin/editar-proyectos-2/"+respuesta+""},2300); // 3000ms = 3
        }
        else {
          swal(
            'Algo Sucedio',
            'Intente guardar el proyecto nuevamente',
            'error'
          );
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
//////////////////////////////////////// Validador del formulario 2///////////////////////////////////////////////
$("#proyectEdit2").validate({
    onfocusout: false,
    rules: {
      typeProyect: {
        required:true
      },
      quantityProyect:{
        required:true
      },
      priceProyect:{
        required:true
      },
      visiblePrice:{
        required:true
      },
      construction:{
        required:true
      },
      roomProyect:{
        required:true
      },
      batroomProyect:{
        required:true
      },
      parkingProyect:{
        required:true
      },
      descriptionProyect:{
        required:true
      }
    },
  messages: {
    typeProyect: {
      required:"Seleccione un tipo de inmueble"
    },
    quantityProyect:{
      required:"Debe Indicar cuantos inmuebles de este tipo tiene el proyecto"
    },
    priceProyect:{
      required:"Debe Indicar el precio del proyecto"
    },
    visiblePrice:{
      required:"Indique si el precio estara oculto"
    },
    construction:{
      required:"Debe expresar los metros cuadrados del inmueble"
    },
    roomProyect:{
      required:"Debe Indicar la cantidad de habitaciones"
    },
    batroomProyect:{
      required:"Debe Indicar la cantidad de baños"
    },
    parkingProyect:{
      required:"Debe Indicar el número de puestos de estacionamiento"
    },
    descriptionProyect:{
      required:"Describa las caracteristicas del inmueble"
    }
  },
  submitHandler: function(form) {
    var form= new FormData(document.getElementById("proyectEdit2"));
    url="/admin/cargarInmuebleProyectos";
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
    .done(function(respuesta){
      ocultarPreload();
      if (respuesta==0) {
        swal({
          title:'Imposible realizar la acción!!',
          text:"El tipo de inmueble seleccionado ya existe para el proyecto",
          icon:'warning',
          button:true
        });
      }
      else{
        swal({
          title:'Buen trabajo!!',
          text:"Datos guardados con exito",
          icon:'success',
          timer: 2000,
          button:false,
        });
        $('.inputs').val('');
        $('#listado').empty();
        $('#listado').append(respuesta);
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

////////////////////////////////////////////// BORRAR INMUEBLES ASOCIADOS AL PROYECTO ////////////////////////

$('body').on('click','.link',function(e){
  e.preventDefault();
  swal({
    title: "Borrar Inmueble!!!",
    text: "Estas seguro de borrar el inmueble asociado al proyecto?",
    icon: "warning",
    buttons: ['No','Sí, borrar'],
    dangerMode:false
  })
  .then((willDelete) => {
    if (willDelete) {
      var id=$(this).data('id');
      var register=$('input[name=register]').val();
      url="/admin/borrarInmuebleProyectos";
      $.ajax({
        beforeSend: mostrarPreload(),
        url: url,
        type: "post",
        dataType: "html",
        data:{id:id,register:register}
      })
      .done(function(respuesta){
          ocultarPreload();
          swal({
            title:'Inmueble Borrado',
            text:"El inmueble seleccionado fue borrado con exito",
            icon:'success',
            timer: 2000,
            button:false,
          });
          $('#listado').empty();
          $('#listado').append(respuesta);
      })
      .fail(function(){
        ocultarPreload();
        swal({
          title:'Algo sucedio',
          text:"Comuniquese con el administrador",
          icon:'error',
          timer: 2000,
          button:false
        });
      });
    }
  });
});
////////////////////////////////////////////// VALIDAR LA CARGA DE INMUEBLES ASOCIADOS AL PROYECTO ////////////

$('body').on('click','#nextPict',function(e){
    var proyecto=$('input[name=register]').val();
    url="/admin/evaluarInmueble";
    $.ajax({
      beforeSend: mostrarPreload(),
      url: url,
      type: "post",
      dataType: "html",
      data:{id:proyecto}
    })
    .done(function(respuesta){
        ocultarPreload();
        //console.log(respuesta);
        if (respuesta==1) {
          swal({
            title:'Buen trabajo!!',
            text:"Datos guardados con exito",
            icon:'success',
            timer: 2000,
            button:false,
          });
          setTimeout(function(){location.href = "/admin/editar-proyectos-3/"+proyecto+"";},2300); // 3000ms = 3
        }
        else {
          swal({
            title:'Imposible realizar esta acción!!',
            text:"Debe cargar al menos un tipo de inmueble al proyecto",
            icon:'error',
            //timer: 2000,
            button:true,
          });
        }
    })
    .fail(function(){
      ocultarPreload();
      swal({
        title:'Algo sucedio',
        text:"Comuniquese con el administrador",
        icon:'error',
        timer: 2000,
        button:false
      });
    });
});


///////////////////////////////////////////// CARGA DE IMAGENES PARA EL INMUEBLE //////////////////////////////

  var inicio= $('#last').val();
  let contador = 1;
  if (inicio!='') {
    contador=inicio;
  }
  $('body').on('click','#addPic',function(e){
    var dominio=window.location.host;
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

/////////////////////////////////////// BORRAR IMAGENES CARGADAS ////////////////////////////////////////////////

  $('body').on('click','.btnBorrar',function(e){
    e.preventDefault();
    var contBtn= $('.btnBorrar').length;
    if (contBtn==1) {
      swal({
        title:'Imposible realizar esa acción',
        text:"Debe cargar al menos una foto al proyecto",
        icon:'warning',
        button:true
      });
    }
    else {
      var input= $(this).parent().parent().find('.register');
      var registro=input.val();
      var form= new FormData();
      form.append('registro',registro);
      form.append('desicion',1);
      url="/admin/borrarImagenProyecto";
      $.ajax({
        beforeSend:mostrarPreload(),
        url: url,
        type: "post",
        dataType: "json",
        context:$(this),
        data: form,
        cache: false,
        contentType: false,
        processData: false
      })
      .done(function(respuesta){
        ocultarPreload();
        if (respuesta==2) {
          swal(
            'Imposible Realizar la acción',
            'La foto que esta intentando borrar esta seleccionada como portada del proyecto, seleccione otra como portada e intentelo de nuevo',
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

/////////////////////////////////////////// CARGA DE IMAGENES PARA EL PROYECTO ///////////////////////////////////////////////////
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
      form.append('desicion',1);
      url="/admin/guardarImagenProyecto";
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
///////////////////////////////////// GUARDAR ULTIMO PASO DEL PROYECTO /////////////////////////////////////////////////////////////

  $('body').on('submit','#picPropiety',function(e){
    e.preventDefault();
    var marcador=$('input[name=fotovisible]:checked');
    if (marcador.length==1) {
      var imgSelected=marcador.val();
      var form= new FormData();
      form.append('desicion',1);
      form.append('imgSelected',imgSelected);
      url="/admin/guardarProyecto";
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
        if (respuesta==1) {
          swal({
            title:'Buen trabajo!!',
            text:"El proyecto fue guardado con exito",
            icon:'success',
            timer: 2000,
            button:false,
          });
          setTimeout(function(){location.href = "/admin/proyectos";},2300); // 3000ms = 3
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
            text:"Debe cargar al menos una foto para el proyecto",
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
        text:"Debe seleccionar una foto como portada del proyecto",
        icon:'error',
        button:true
      });
    }


  });
});
