$(document).ready(function() {
////////////////////////////////////////  ///////////////////////////////////////////////
	$('.cambioEstatus').on('click', function(){
		var parametro=$(this).parent().find('.inmueble').val();
		//console.log(parametro);
	  url="/admin/llenarModalNegociacion";
	  $.ajax({
	    url: url,
	    type: "post",
	    dataType: "json",
	    data:{parametro:parametro},

	  })
	  .done(function(respuesta){
			console.log(respuesta.estatus_id);
		 /* if (respuesta) {
	      console.log(respuesta)
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
	    }*/
	  });
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
      url: url,
      type: "post",
      dataType: "html",
      data: form,
      cache: false,
      contentType: false,
      processData: false
    })
    .done(function(respuesta){
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
        url: url,
        type: "post",
        dataType: "html",
        data:{id:id,register:register}
      })
      .done(function(respuesta){
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
      url: url,
      type: "post",
      dataType: "html",
      data:{id:proyecto}
    })
    .done(function(respuesta){
        console.log(respuesta);
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
      form.append('desicion',1);
      url="/admin/guardarImagenProyecto";
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
        $("#"+ubicacion+"").val(id);
        $("#radio-example-"+valor).val(id);
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
      form.append('desicion',1);
      form.append('imgSelected',imgSelected);
      url="/admin/guardarProyecto";
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
