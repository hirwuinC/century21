$(document).ready(function() {

	////////////////////////////////// MOSTRAR Y OCULTAR PRELOAD ////////////////////////////////////////////////
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
		};

//////////////////////////////////////// ABRIR MODAL PARA GESTION DE NEGOCIACION ///////////////////////////////////////////////
	$('.cambioEstatus').on('click', function(){
		var parametro=$(this).parent().find('.inmueble').val();
		//console.log(parametro);
	  url="/admin/llenarModalNegociacion";
	  $.ajax({
			beforeSend:mostrarPreload(),
	    url: url,
	    type: "post",
	    dataType: "json",
	    data:{parametro:parametro},

	  })
	  .done(function(respuesta){
			ocultarPreload();
		 	if (respuesta[0]==1) {
			 //console.log(respuesta);


////////////////////////////////// RESETEAR FORMULARIOS DE PASOS ///////////////////////////////////////////

				var validator1 = $( "#newPropuesta" ).validate();
				validator1.resetForm();
				var validator2 = $( "#newDeposito" ).validate();
				validator2.resetForm();
				var validator3 = $( "#newBilateral" ).validate();
				validator3.resetForm();
				var validator4 = $( "#newRegistro" ).validate();
				validator4.resetForm();
				var validator5 = $( "#newReporte" ).validate();
				validator5.resetForm();

///////////////////// HABILITAR CAMPOS ///////////////////////////////////////////////////

				$('#datePropuesta').attr('disabled',false);
				$('#datePropuestaSubmit').attr('disabled',false);
				$('#dateGarantia').attr('disabled',false);
				$('#garantiaSubmit').attr('disabled',false);
				$('#dateBilateral').attr('disabled',false);
				$('#comision1').attr('disabled',false);
				$('#bilateralSubmit').attr('disabled',false);
				$('#dateRegistro').attr('disabled',false);
				$('#comision2').attr('disabled',false);
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
				if (respuesta[3].comisionPagada==1) {
					$('#comision1').attr('checked',true);

				}
				else {
					$('#comision1').attr('checked',false);
				}

				$('#dateRegistro').val(respuesta[4].fechaEstatus);
				$('#idNegociacionRegistro').val(respuesta[6].id);
				if (respuesta[4].comisionPagada==1) {
					$('#comision2').attr('checked',true);
				}
				else {
					$('#comision2').attr('checked',false);
				}

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
					$('#comision1').attr('disabled',true);
				}
				if (respuesta[4].fechaEstatus!='') {
					$('#dateRegistro').attr('disabled',true);
					$('#registroSubmit').attr('disabled',true);
					$('#comision2').attr('disabled',true);
				}
				if (respuesta[5].fechaEstatus!='') {
					$('#dateReporte').attr('disabled',true);
					$('#reporteSubmit').attr('disabled',true);
				}

//////////////////// MOSTRAR LISTA DE ESTATUS DE INMUEBLES  CON ESTATUS ACTUAL ////////////////////////////////////

				$('.estatusInmueble').css('display','block');
				if (respuesta[7].estatus==11) {
					$('.estatusInmueble').css('display','none');
				}
				else {
					$('.opcion').remove();
					$.each(respuesta[8],function(e){
						$('#estatusInmueble').append("<option value="+respuesta[8][e].id+" class='opcion' >"+respuesta[8][e].descripcionEstatus+"</option>");
					});

					if (respuesta[7].estatus ==1) {
						$('#estatusInmueble option[value="1"]').prop("selected", true);
					}
					else {
						$('#estatusInmueble option[value="2"]').prop("selected", true);
					}
				}
				var opcion=$("#estatusInmueble option:selected").val();
				$('#anterior').val(opcion);

//////////////////// MOSTRAR CAMPOS DE PAGO DE COMISION  /////////////////////////////////////////////////
				$('.ocultarComision').css('display','block');
				if (respuesta[9]==1) {
					$('.ocultarComision').css('display','none');
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
////////////////// LIMPIAR CAMPOS DEL MODAL //////////////////////////////////////////////////////

				$('#asesorCerrador').val('');
				$('#personaComparteInput').val('');
				$('#montoFinal').val('');
				$('#comisionCierre').val('');


				$('#cambioStatus').modal('show');
		 }
	 }).fail(function(){
		 ocultarPreload();
		 swal({
				title:'Imposible realizar la acción!!',
				text:"Comuniquese con el administrador del sistema",
				icon:'error',
				button:true
			});
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
			beforeSend: mostrarPreload(),
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
				ocultarPreload();
				swal({
					title:'Buen trabajo!!',
					text:"Datos guardados con exito",
					icon:'success',
					timer: 2000,
					button:false,
				});
				setTimeout(function(){$('#cambioStatus').modal('hide');},2300); // 3000ms = 3
      }
      else{
				$("#WindowLoad").remove();
				$('#load').css('display','none');
				swal({
          title:'Imposible realizar la acción!!',
          text:"Comuniquese con el administrador del sistema",
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
		    	if (respuesta==1) {
						ocultarPreload();
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
					else if(respuesta==2){
						swal({
		          title:'Imposible realizar la acción!!',
		          text:"Fueron cargadas etapas del proceso superiores a la propuesta aprobada",
		          icon:'error',
		          button:true
		        });
					}
					else if (respuesta==3) {
						swal({
		          title:'Imposible realizar la acción!!',
		          text:"La negociación ha sido finalizada por lo que ya no se pueden cargar mas etapas",
		          icon:'error',
		          button:true
		        });
					}
		    }).fail(function() {
					ocultarPreload();
					swal({
						title:'Imposible realizar la acción!!',
						text:"Comuniquese con el administrador del sistema",
						icon:'error',
						button:true
					});
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
	    text: "Al ingresar la fecha, esta no podra ser modificada, y todos los pasos previos seran inhabilitados ¿Desea Continuar?",
	    icon: "warning",
	    buttons: ['No','Sí, Guardar'],
	    dangerMode:false
	  })
	  .then((willDelete) => {
	    if (willDelete) {
				var form= new FormData(document.getElementById("newDeposito"));
		    url="/admin/guardarDeposito";
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
		    	if (respuesta==1) {
						ocultarPreload();
						swal({
							title:'Buen trabajo!!',
							text:"Deposito en garantia guardado con exito",
							icon:'success',
							timer: 2000,
							button:false,
						});
						$('#dateGarantia').attr('disabled',true);
						$('#garantiaSubmit').attr('disabled',true);
						//setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

		      }
					else if(respuesta==2){
						swal({
		          title:'Imposible realizar la acción!!',
		          text:"Ya fueron cargadas etapas del proceso superiores al deposito en garantia",
		          icon:'error',
		          button:true
		        });
					}
					else if (respuesta==3) {
						swal({
		          title:'Imposible realizar la acción!!',
		          text:"La negociación ha sido finalizada por lo que ya no se pueden cargar mas etapas",
		          icon:'error',
		          button:true
		        });
					}
		    }).fail(function() {
					ocultarPreload();
					swal({
						title:'Imposible realizar la acción!!',
						text:"Comuniquese con el administrador del sistema",
						icon:'error',
						button:true
					});
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
	    text: "Al ingresar la fecha, esta no podra ser modificada y todos los pasos previos seran inhabilitados ¿Desea Continuar?",
	    icon: "warning",
	    buttons: ['No','Sí, Guardar'],
	    dangerMode:false
	  })
	  .then((willDelete) => {
	    if (willDelete) {
				var form= new FormData(document.getElementById("newBilateral"));
		    url="/admin/guardarBilateral";
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
		    	if (respuesta[0]==1) {
						//console.log (respuesta);
						swal({
							title:'Buen Trabajo',
							text:"Promesa Bilateral guardada con exito",
							icon:'success',
							//timer: 2000,
							button:true,
						});
						$('#dateBilateral').attr('disabled',true);
						$('#bilateralSubmit').attr('disabled',true);
						$('#comision1').attr('disabled',true);
						if (respuesta[1]==1) {
							$('.ocultarComision').css('display','none');
						}
						//setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

		      }
					else if(respuesta[0]==2){
						swal({
		          title:'Imposible realizar la acción!!',
		          text:"Fue cargada la etapa de firma en registro por lo que esta etapa quedo inhabilitada",
		          icon:'error',
		          button:true
		        });
					}
					else if (respuesta[0]==3) {
						swal({
		          title:'Imposible realizar la acción!!',
		          text:"La negociación ha sido finalizada por lo que ya no se pueden cargar mas etapas",
		          icon:'error',
		          button:true
		        });
					}
		    }).fail(function() {
					ocultarPreload();
					swal({
						title:'Imposible realizar la acción!!',
						text:"Comuniquese con el administrador del sistema",
						icon:'error',
						button:true
					});
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
	    text: "Al ingresar la fecha, esta no podra ser modificada y todos los pasos previos seran inhabilitados ¿Desea Continuar?",
	    icon: "warning",
	    buttons: ['No','Sí, Guardar'],
	    dangerMode:false
	  })
	  .then((willDelete) => {
	    if (willDelete) {
				var form= new FormData(document.getElementById("newRegistro"));
		    url="/admin/guardarRegistro";
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
		    	if (respuesta[0]==1) {
						//console.log (respuesta);
						swal({
							title:'Buen Trabajo',
							text:'Protocolización guardada con exito',
							icon:'success',
							//timer: 2000,
							button:true,
						});
						$('#dateRegistro').attr('disabled',true);
						$('#registroSubmit').attr('disabled',true);
						$('#comision2').attr('disabled',true);
		      }
					else if (respuesta[0]==2) {
						swal({
		          title:'Imposible realizar la acción!!',
		          text:"La negociación ha sido finalizada por lo que ya no se pueden cargar mas etapas",
		          icon:'error',
		          button:true
		        });
					}
		    })
				.fail(function() {
					ocultarPreload();
					swal({
						title:'Imposible realizar la acción!!',
						text:"Comuniquese con el administrador del sistema",
						icon:'error',
						button:true
					});
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
		    	if (respuesta) {
						//console.log (respuesta);
						swal({
							title:'Reporte de venta guardado con exito',
							text:"Negociación Finalizada",
							icon:'success',
							//timer: 2000,
							button:true,
						});
						$('#dateReporte').attr('disabled',true);
						$('#reporteSubmit').attr('disabled',true);
						$('.estatusInmueble').css('display','none');
						//setTimeout(function(){location.href = "/admin/inmuebles";},2300); // 3000ms = 3

		      }
		    }).fail(function() {
					ocultarPreload();
					swal({
						title:'Imposible realizar la acción!!',
						text:"Comuniquese con el administrador del sistema",
						icon:'error',
						button:true
					});
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
			beforeSend: mostrarPreload(),
	    url: url,
	    type: "post",
	    dataType: "html",
	    data:{id:idpropiedad}
		})
	  .done(function(respuesta){
			//console.log(respuesta);
			ocultarPreload();
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
				dataType: "json",
				data:{idPropiedad:idPropiedad,idNegociacion:idNegociacion}
			})
			.done(function(respuesta){
				//console.log (respuesta);
				if (respuesta[0]==1) {
					if (respuesta[1]==1) {
						swal({
							title:'Negociación Cancelada con Exito!!',
							text:"La negociacion fue cancelada sin embargo esta propiedad genero ingresos por gestion de venta, el inmueble volvera a estar activo",
							icon:'success',
							//timer: 2000,
							button:true,
						});
					}
					else{
						swal({
							title:'Negociación Cancelada con Exito!!',
							text:"El inmueble volvera a estar activo",
							icon:'success',
							//timer: 2000,
							button:true,
						});
					}


					setTimeout(function(){$('#cambioStatus').modal('hide');},2300);
				}
				else if(respuesta[0]==2){
					swal({
						title:'Imposible realizar la acción!!',
						text:"La negociacion a finalizado, por lo que el inmueble tomo estatus de vendido para el cálculo de comisiones",
						icon:'error',
						button:true
					});
				}
			});
		}
	});
});
//////////////////////////////////////////////////CAMBIAR ESTATUS PROPIEDAD //////////////////////////////////////////////////////
$('body').on('change','#estatusInmueble',function(){
	//console.log(opcion);
	var anterior=$('#anterior').val();
	$("#estatusInmueble option[value="+ anterior +"]").removeAttr("selected");
	swal({
		title: "Estatus de publicación de Inmueble",
		text: "¿Esta seguro que desea cambiar el estatus del inmueble?",
		icon: "warning",
		buttons: ['No','Sí, Cambiar'],
		dangerMode:false
	})
	.then((cambiarEstatus) => {
		if (cambiarEstatus) {
			var opcion=$("#estatusInmueble option:selected").val();
			var idPropiedad=$('#propiedadGeneral').val();
			url="/admin/cambiarEstatusInmueble";
			$.ajax({
				url: url,
				type: "post",
				dataType: "html",
				data:{idPropiedad:idPropiedad,opcion:opcion}
			})
			.done(function(respuesta){
				//console.log (respuesta);
				if (respuesta) {
					var opcion=$("#estatusInmueble option:selected").val();
					$("#estatusInmueble option[value="+ opcion +"]").attr("selected",true);
					$('#anterior').val(opcion);
						swal({
							title:'Buen Trabajo!!',
							text:"El estatus fue cambiado con exito",
							icon:'success',
							//timer: 2000,
							button:true,
						});
				}
				else {
					swal({
						title:'Imposible realizar la acción!!',
						text:"Comuniquese con el administrador del sistema",
						icon:'error',
						button:true
					});
				}
			});
		}
		else{
			var anterior=$('#anterior').val();
			//console.log(anterior);
			$("#estatusInmueble option[value="+ anterior +"]").attr("selected",true);
		}
	});
});

});
