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
		 	if (respuesta[0]==1) {
			 console.log(respuesta[7]);

///////////////////// RESETEAR CAMPOS ///////////////////////////////////////////////////

				$('#datePropuesta').attr('disabled',false);
				$('#datePropuestaSubmit').attr('disabled',false);
				$('#dateGarantia').attr('disabled',false);
				$('#garantiaSubmit').attr('disabled',false);
				$('#dateBilateral').attr('disabled',false);
				$('#submitBilateral').attr('disabled',false);

///////////////////////// MOSTRAR TAB DE NEGOCIACION EN CURSO ////////////////////////////////
	      $('#tabNewNegotiation').css('display','none');
				$('#tabNegotiation').css('display','block');
				$('#tabNegotiation').addClass('active');
				$('#tabNegotiation').parent().addClass('active');
				$('#profile').addClass('active');
				$('#tabnewNegotiation').removeClass('active');
				$('#tabnewNegotiation').parent().removeClass('active');
				$('#home').removeClass('active');
				$('#tabHistory').removeClass('active');
				$('#tabHistory').parent().removeClass('active');
				$('#messages').removeClass('active');


				$('#datePropuesta').val(respuesta[1].fechaEstatus);
				$('#idNegociacion').val(respuesta[6].id)
				$('#dateGarantia').val(respuesta[2].fechaEstatus);
				$('#idNegociacionGarantia').val(respuesta[6].id)
				$('#dateBilateral').val(respuesta[3].fechaEstatus);
				$('#idNegociacionBilateral').val(respuesta[6].id)
				$('#dateRegistro').val(respuesta[4].fechaEstatus);
				$('#dateReporte').val(respuesta[5].fechaEstatus);


////////////////// DESHABILITAR PASOS QUE YA FUERON INGRESADOS ////////////////////////

				if (respuesta[1].fechaEstatus!='') {
					$('#datePropuesta').attr('disabled',true);
					$('#datePropuestaSubmit').attr('disabled',true);
				}
				if (respuesta[2].fechaEstatus!='') {
					$('#dateGarantia').attr('disabled',true);
					$('#garantiaSubmit').attr('disabled',true);
				}
				if (respuesta[3].fechaEstatus!='') {
					$('#dateBilateral').attr('disabled',true);
					$('#bilateralSubmit').attr('disabled',true);
				}


//////////////////// MOSTRAR CHECK DE ESTATUS DE INMUEBLES ////////////////////////////////////

				if (respuesta[7].estatus ==1) {
					$('#publicarInmueble').attr('checked',true);
				}
				else {
					$('#publicarInmueble').attr('checked',false);
				}




				$('#cambioStatus').modal('show');
	    }
	    else if (respuesta[0]==2){
				var validator = $( "#newNegotation" ).validate();
				validator.resetForm();
	     $('#tabNegotiation').css('display','none');
			 $('#tabNewNegotiation').css('display','block');
			 $('#tabNewNegotiation').addClass('active');
			 $('#tabNewNegotiation').parent().addClass('active');
			 $('#tabNegotiation').removeClass('active');
			 $('#tabNegotiation').parent().removeClass('active');
			 $('#profile').removeClass('active');
			 $('#tabHistory').removeClass('active');
			 $('#tabHistory').parent().removeClass('active');
			 $('#messages').removeClass('active');
			 $('#home').addClass('active');
			 $('#asesorCaptador').val(respuesta[1].agente_id);
			 $('#propiedad').val(respuesta[1].id);
			 $('#comisionCaptacion').val(respuesta[1].porcentajeCaptacion);
			 $('.opcion').remove();
			 $.each( respuesta[2], function(key,valor) {
				  $('#asesorCerrador').append(`<option class="opcion" value='${valor.id}'>${valor.fullName}</option>`)
				});
				if (respuesta[1].agente_id!=5) {
					$('#comisionCompartida').css('display','none');
					$('#personaComparte').css('display','none');
					$('#comisionCompartidaInput').val('100');
				}
				else {
					$('#comisionCompartida').css('display','block');
					$('#personaComparte').css('display','block');
					$('#comisionCompartidaInput').val('0');
				}


				$('#cambioStatus').modal('show');
		 }
	  });
	});

//////////////////////////////////////// MOSTRAR CAMPO DE COMISION COMPARTIDA ////////////////////////////////////

$('body').on('change','#asesorCerrador',function(){
	var asesorCerrador=$('#asesorCerrador option:selected').val();
	var asesorCaptador=$('#asesorCaptador').val();
	if(asesorCaptador==5 || asesorCerrador==5){
		$('#comisionCompartida').css('display','block');
		$('#personaComparte').css('display','block');
		$('#comisionCompartidaInput').val('0');
		$('#personaComparteInput').val('');
	}
	else{
		$('#comisionCompartida').css('display','none');
		$('#personaComparte').css('display','none');
		$('#comisionCompartidaInput').val('100');
		$('#personaComparteInput').val('');
	}
});

//////////////////////////////////////// GUARDAR DATOS DE NUEVA NEGOCIACION ///////////////////////////////////////////////

$("#newNegotation").validate({
    onfocusout: false,
    rules: {
      asesorCerrador: {
        required:true
      },
      montoFinal:{
        required:true
      },
			comisionCompartida:{
        required:true
      },
      comisionCierre:{
        required:true
      }
    },
  messages: {
    asesorCerrador: {
      required:"Seleccione un asesor"
    },
    montoFinal:{
      required:"Debe indicar el monto final de la negociación"
    },
		comisionCompartida:{
			required:"Debe indicar el porcentaje de la comisión que le corresponde por la transacción"
		},
    comisionCierre:{
      required:"Debe Indicar el porcentaje de la comisión de cierre"
    }
  },
  submitHandler: function(form) {
    var form= new FormData(document.getElementById("newNegotation"));
    url="/admin/guardarNegociacion";
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
    	if (respuesta) {
				console.log (respuesta);

				swal({
					title:'Buen trabajo!!',
					text:"Datos guardados con exito",
					icon:'success',
					timer: 2000,
					button:false,
				});
				setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

      }
      else{
				swal({
          title:'Imposible realizar la acción!!',
          text:"Comuniquese con el administrador del sistema",
          icon:'error',
          button:true
        });
			}
    });
  }
});

////////////////////////////////////////////// GUARDAR PROPUESTA ASOCIADO A NEGOCIACION ////////////////////////
$("#newPropuesta").validate({
    onfocusout: false,
    rules: {
      datePropuesta: {
        required:true
      }
    },
  messages: {
    datePropuesta: {
      required:"Seleccione la fecha de aprobación de propuesta de compra"
    }
  },
  submitHandler: function(form) {
		swal({
	    title: "Asociar fecha de transacción",
	    text: "Al ingresar la fecha, esta no podra ser modificada, ¿Desea Continuar?",
	    icon: "warning",
	    buttons: ['No','Sí, Guardar'],
	    dangerMode:false
	  })
	  .then((willDelete) => {
	    if (willDelete) {
				var form= new FormData(document.getElementById("newPropuesta"));
		    url="/admin/guardarPaso";
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
		    	if (respuesta) {
						console.log (respuesta);
						swal({
							title:'Buen trabajo!!',
							text:"Propuesta aprobada guardada con exito",
							icon:'success',
							timer: 2000,
							button:false,
						});
						setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

		      }
		      else{
						swal({
		          title:'Imposible realizar la acción!!',
		          text:"Comuniquese con el administrador del sistema",
		          icon:'error',
		          button:true
		        });
					}
		    });
  		}
		});
	}
});

////////////////////////////////////////////// GUARDAR DEPOSITO ASOCIADO A NEGOCIACION ////////////////////////
$("#newDeposito").validate({
    onfocusout: false,
    rules: {
      dateGarantia: {
        required:true
      }
    },
  messages: {
    dateGarantia: {
      required:"Seleccione la fecha cuando se realizo el deposito"
    }
  },
  submitHandler: function(form) {
		swal({
	    title: "Asociar fecha de transacción",
	    text: "Al ingresar la fecha, esta no podra ser modificada, ¿Desea Continuar?",
	    icon: "warning",
	    buttons: ['No','Sí, Guardar'],
	    dangerMode:false
	  })
	  .then((willDelete) => {
	    if (willDelete) {
				var form= new FormData(document.getElementById("newDeposito"));
		    url="/admin/guardarDeposito";
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
		    	if (respuesta) {
						console.log (respuesta);
						swal({
							title:'Buen trabajo!!',
							text:"Deposito en garantia aprobado con exito",
							icon:'success',
							timer: 2000,
							button:false,
						});
						setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

		      }
		      else{
						swal({
		          title:'Imposible realizar la acción!!',
		          text:"Comuniquese con el administrador del sistema",
		          icon:'error',
		          button:true
		        });
					}
		    });
  		}
		});
	}
});
////////////////////////////////////////////// GUARDAR PROMESA BILATERAL ASOCIADA A NEGOCIACION ////////////////////////
$("#newBilateral").validate({
    onfocusout: false,
    rules: {
      dateBilateral: {
        required:true
      }
    },
  messages: {
    dateBilateral: {
      required:"Seleccione la fecha cuando se realizo la promesa bilateral"
    }
  },
  submitHandler: function(form) {
		swal({
	    title: "Asociar fecha de transacción",
	    text: "Al ingresar la fecha de promesa bilateral la negociacion no podra ser cancelada nuevamente, ¿Desea Continuar?",
	    icon: "warning",
	    buttons: ['No','Sí, Guardar'],
	    dangerMode:false
	  })
	  .then((willDelete) => {
	    if (willDelete) {
				var form= new FormData(document.getElementById("newBilateral"));
		    url="/admin/guardarBilateral";
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
		    	if (respuesta) {
						console.log (respuesta);
						swal({
							title:'Buen trabajo!!',
							text:"Promesa Bilateral aprobada con exito",
							icon:'success',
							timer: 2000,
							button:false,
						});
						setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

		      }
		      else{
						swal({
		          title:'Imposible realizar la acción!!',
		          text:"Comuniquese con el administrador del sistema",
		          icon:'error',
		          button:true
		        });
					}
		    });
  		}
		});
	}
});
/////////////////////////////////////////////////////////////////////////////////////////////////////


$('body').on('click','#datePropuestasubmit',function(){
  swal({
    title: "Asociar fecha de transacción",
    text: "Al ingresar la fecha esta no podra ser modificada, ¿Desea Continuar?",
    icon: "warning",
    buttons: ['No','Sí, Guardar'],
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
