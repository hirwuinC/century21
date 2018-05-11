$(document).ready(function(){
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
	  };
///////////////////////////////////////////////////// cargar interesado Nuestro Equipo ///////////////////////////////////////////////////////
	$("#uneteEquipo").validate({
			onfocusout: false,
			rules: {
				nombreInteresado:{
					required:true
				},
				apellidoInteresado:{
					required:true
				},
				emailInteresado:{
					required:true,
					email:true
				},
				phoneInteresado:{
					required:true
				},
				adjuntarCv:{
					required:true
				}
			},
		messages: {
			nombreInteresado:{
				required:"Debe indicar sus nombres"
			},
			apellidoInteresado:{
				required:"Debe indicar sus apellidos"
			},
			emailInteresado:{
				required:"Debe indicar su cuenta de correo electrónico",
				email:"El correo electrónico debe tener un formato minombre@midominio.com"
			},
			phoneInteresado:{
				required:"Debe indicar un teléfono de contacto"
			},
			adjuntarCv:{
				required:"Debe adjuntar su hoja de vida"
			}
		},
		submitHandler: function(form) {
      var formulario = new FormData(document.getElementById('uneteEquipo'));
			url="/enviarCurriculum";
      $.ajax({
					beforeSend:mostrarPreload(),
          url: url,
          type: "post",
          dataType: "html",
          data: formulario,
          cache: false,
          contentType: false,
          processData: false
      })
      .done(function(res){
				//console.log(res);
				ocultarPreload();
				if (res==1) {
          swal(
            'Gracias por tu interes de pertenecer a nuestro equipo!!',
            'Hemos recibido tus datos, en caso de calificar a alguna vacante nos comunicaremos contigo ',
            'success'
          );
					$('.limpiar').val('');
        }
      }).fail( function() {
				ocultarPreload();
				swal(
					'Imposible Realizar la acción',
					'Algo sucedio con la conexión, intentelo nuevamente',
					'error'
				);
			});
    }
	});

	///////////////////////////////////////////////////// cargar interesado publicar inmueble ///////////////////////////////////////////////////////
		$("#nuevoVendedor").validate({
				onfocusout: false,
				rules: {
					nombreVendedor:{
						required:true
					},
					apellidoVendedor:{
						required:true
					},
					emailVendedor:{
						required:true,
						email:true
					},
					phoneVendedor:{
						required:true
					},
					tipoInmueble:{
						required:true
					},
					tipoNegocio:{
						required:true
					},
					comentarioVendedor:{
						required:true
					},
					direccion:{
						required:true
					}
				},
			messages: {
				nombreVendedor:{
					required:"Debe indicar sus nombres"
				},
				apellidoVendedor:{
					required:"Debe indicar sus apellidos"
				},
				emailVendedor:{
					required:"Debe indicar su cuenta de correo electrónico",
					email:"El correo electrónico debe tener un formato minombre@midominio.com"
				},
				phoneVendedor:{
					required:"Debe indicar un teléfono de contacto"
				},
				tipoInmueble:{
					required:"Debe seleccionar un tipo de inmueble"
				},
				tipoNegocio:{
					required:"Debe seleccionar un tipo de Negocio"
				},
				comentarioVendedor:{
					required:"Debe indicar las caracteristicas del inmueble"
				},
				direccion:{
					required:"Indique la dirección donde se encuentra ubicado el inmueble"
				}
			},
			submitHandler: function(form) {
	      var formulario = new FormData(document.getElementById('nuevoVendedor'));
				url="/interesadoPublicar";
	      $.ajax({
						beforeSend:mostrarPreload(),
	          url: url,
	          type: "post",
	          dataType: "html",
	          data: formulario,
	          cache: false,
	          contentType: false,
	          processData: false
	      })
	      .done(function(res){
					//console.log(res);
					ocultarPreload();
					if (res==1) {
	          swal(
	            'Gracias por su interes de publicar con nosotros!!',
	            'En poco tiempo nos estaremos comunicando con usted.',
	            'success'
	          );
						$('.limpiarVendedor').val('');
	        }
	      }).fail( function() {
					ocultarPreload();
					swal(
						'Imposible Realizar la acción',
						'Algo sucedio con la conexión, intentelo nuevamente',
						'error'
					);
				});
	    }
		});

////////////////////////////////////////////// Scroll Infinito ///////////////////////////////////////////////////////////////////////
		window.sr = ScrollReveal();
		sr.reveal('.hijo');
});
