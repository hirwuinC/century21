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
			 //console.log(respuesta[7]);

///////////////////// HABILITAR CAMPOS ///////////////////////////////////////////////////

				$('#datePropuesta').attr('disabled',false);
				$('#datePropuestaSubmit').attr('disabled',false);
				$('#dateGarantia').attr('disabled',false);
				$('#garantiaSubmit').attr('disabled',false);
				$('#dateBilateral').attr('disabled',false);
				$('#submitBilateral').attr('disabled',false);
				$('#dateRegistro').attr('disabled',false);
				$('#registroSubmit').attr('disabled',false);
				$('#dateReporte').attr('disabled',false);
				$('#reporteSubmit').attr('disabled',false);

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

/////////////////////////// LLENAR CAMPOS DE PASOS DE NEGOCIACION DEL FORMULARIO ///////////////////////////////
				$('#propiedadGeneral').val(respuesta[7].id)
				$('#datePropuesta').val(respuesta[1].fechaEstatus);
				$('#idNegociacion').val(respuesta[6].id)
				$('#dateGarantia').val(respuesta[2].fechaEstatus);
				$('#idNegociacionGarantia').val(respuesta[6].id)
				$('#dateBilateral').val(respuesta[3].fechaEstatus);
				$('#idNegociacionBilateral').val(respuesta[6].id)
				$('#dateRegistro').val(respuesta[4].fechaEstatus);
				$('#idNegociacionRegistro').val(respuesta[6].id);
				$('#dateReporte').val(respuesta[5].fechaEstatus);
				$('#idNegociacionReporte').val(respuesta[6].id);

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
				if (respuesta[4].fechaEstatus!='') {
					$('#dateRegistro').attr('disabled',true);
					$('#registroSubmit').attr('disabled',true);
				}
				if (respuesta[5].fechaEstatus!='') {
					$('#dateReporte').attr('disabled',true);
					$('#reporteSubmit').attr('disabled',true);
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
			 $('#propiedadGeneral').val(respuesta[1].id)
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
				//console.log (respuesta);

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
						$('#datePropuesta').attr('disabled',true);
						$('#datePropuestaSubmit').attr('disabled',true);
						//setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

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
						//console.log (respuesta);
						swal({
							title:'Buen trabajo!!',
							text:"Deposito en garantia aprobado con exito",
							icon:'success',
							timer: 2000,
							button:false,
						});
						$('#dateGarantia').attr('disabled',true);
						$('#garantiaSubmit').attr('disabled',true);
						//setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

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
	    text: "Al ingresar la fecha, esta no podra ser modificada, ¿Desea Continuar?",
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
							title:'Promesa Bilateral guardada con exito',
							text:"El inmueble toma estatus procesado, por lo que el vendedor debe cancelar el pago de la comisión por servicios prestados",
							icon:'success',
							//timer: 2000,
							button:true,
						});
						$('#dateBilateral').attr('disabled',true);
						$('#bilateralSubmit').attr('disabled',true);
						//setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

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

////////////////////////////////////////////// GUARDAR FIRMA DE REGISTRO  ASOCIADA A NEGOCIACION ////////////////////////
$("#newRegistro").validate({
    onfocusout: false,
    rules: {
      dateRegistro: {
        required:true
      }
    },
  messages: {
    dateRegistro: {
      required:"Seleccione la fecha cuando se realizo la protocolización de la venta"
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
				var form= new FormData(document.getElementById("newRegistro"));
		    url="/admin/guardarRegistro";
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
							title:'Protocolización guardada con exito',
							text:"El inmueble toma estatus procesado, por lo que el vendedor debe cancelar el pago de la comisión por servicios prestados",
							icon:'success',
							//timer: 2000,
							button:true,
						});
						$('#dateRegistro').attr('disabled',true);
						$('#registroSubmit').attr('disabled',true);
						//setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

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

////////////////////////////////////////////// GUARDAR REPORTE DE VENTA  ASOCIADO A NEGOCIACION ////////////////////////
$("#newReporte").validate({
    onfocusout: false,
    rules: {
      dateReporte: {
        required:true
      }
    },
  messages: {
    dateReporte: {
      required:"Seleccione la fecha cuando se realizo el reporte de la venta"
    }
  },
  submitHandler: function(form) {
		swal({
	    title: "Asociar fecha de transacción",
	    text: "Al ingresar la fecha de reporte de venta, la negociacion tomara el estatus de finalizada y el inmueble tomara estatus de vendido, ¿Desea Continuar?",
	    icon: "warning",
	    buttons: ['No','Sí, Guardar'],
	    dangerMode:false
	  })
	  .then((willDelete) => {
	    if (willDelete) {
				var form= new FormData(document.getElementById("newReporte"));
		    url="/admin/guardarReporte";
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
						//console.log (respuesta);
						swal({
							title:'Reporte de venta guardado con exito',
							text:"El inmueble toma estatus vendido, por lo que el vendedor debe cancelar el pago de la comisión por servicios prestados",
							icon:'success',
							//timer: 2000,
							button:true,
						});
						$('#dateReporte').attr('disabled',true);
						$('#reporteSubmit').attr('disabled',true);
						//setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

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
/////////////////////////////////////////////MOSTRAR HISTORIAL DE NEGOCIACIONES ////////////////////////////////////////////////////////


	$('body').on('click','#tabHistory',function(){
		$('.areaResultado').empty();
		var idpropiedad=$('#propiedadGeneral').val();
	  url="/admin/historialNegociaciones";
	  $.ajax({
	    url: url,
	    type: "post",
	    dataType: "html",
	    data:{id:idpropiedad}
		})
	  .done(function(respuesta){
			//console.log(respuesta);

			$('.areaResultado').append(respuesta);
			$('#tabHistory').addClass('active');
			$('#tabHistory').parent().addClass('active');
			$('#messages').addClass('active');
			$('#tabnewNegotiation').removeClass('active');
			$('#tabnewNegotiation').parent().removeClass('active');
			$('#home').removeClass('active');
			$('#tabNegotiation').removeClass('active');
			$('#tabNegotiation').parent().removeClass('active');
			$('#profile').removeClass('active');
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

////////////////////////////////////////////////// CANCELAR NEGOCIACION //////////////////////////////////////////////////////

$('body').on('click','#cancelNegotiation',function(){
	swal({
		title: "Cancelar Negociación",
		text: "Al cancelar la negociacion el inmueble pasara a activo en caso que este inactivo, ¿Desea Continuar?",
		icon: "warning",
		buttons: ['No','Sí, Guardar'],
		dangerMode:false
	})
	.then((willDelete) => {
		if (willDelete) {
			var idPropiedad=$('#propiedadGeneral').val();
			var idNegociacion=$('#idNegociacion').val();
			url="/admin/cancelarNegociacion";
			$.ajax({
				url: url,
				type: "post",
				dataType: "html",
				data:{idPropiedad:idPropiedad,idNegociacion:idNegociacion},
			})
			.done(function(respuesta){
				//console.log (respuesta);
				if (respuesta==4) {

					swal({
						title:'Negociación Cancelada!!',
						text:"El inmueble volvera a estar activo",
						icon:'success',
						timer: 2000,
						button:false,
					});

					$('#cambioStatus').modal('hide');
				}
				else if(respuesta==1){
					swal({
						title:'Imposible realizar la acción!!',
						text:"La negociación ya entro en promesa bilateral, por lo que el inmueble tomo estatus de procesado para el cálculo de comisiones",
						icon:'error',
						button:true
					});
				}
				else if (respuesta==2) {
					swal({
						title:'Imposible realizar la acción!!',
						text:"La negociación ya entro protocolización, por lo que el inmueble tomo estatus de procesado para el cálculo de comisiones",
						icon:'error',
						button:true
					});
				}
				else if(respuesta==3){
					swal({
						title:'Imposible realizar la acción!!',
						text:"La negociación ya fue reportado como vendido, por lo que el inmueble tomo estatus de vendido para el cálculo de comisiones",
						icon:'error',
						button:true
					});
				}
			});
		}
	});
});

});
