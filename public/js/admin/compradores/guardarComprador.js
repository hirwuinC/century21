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

////////////////////////////////////////////// GUARDAR COMPRADOR DEL INMUEBLE ///////////////////////////////////////////////////////
	$("#formularioComprador").validate({
	    onfocusout: false,
	    rules: {
	      cedulaComprador: {
	        required:true
	      },
				nombreComprador: {
	        required:true
	      },
				correoComprador: {
	        required:true,
					email:true
	      },
				edad: {
	        required:true
	      },
				sexoComprador: {
	        required:true
	      },
				ocupacion: {
	        required:true
	      },
				grupoFamiliar: {
	        required:true
	      }
	    },
	  messages: {
	    cedulaComprador: {
	      required:"La cédula del comprador es requerida"
	    },
			nombreComprador: {
				required:"Debe indicar el nombre del comprador"
			},
			correoComprador: {
				required:"Debe indicar el correo electrónico del comprador",
				email:"El correo debe ser válido"
			},
			edad: {
				required:"Debe indicar la fecha de nacimiento del comprador"
			},
			sexoComprador: {
				required:"Debe indicar el género del comprador"
			},
			ocupacion: {
				required:"Debe indicar la ocupación del comprador"
			},
			grupoFamiliar: {
				required:"Debe indicar el número de personas que componen el grupo familiar del comprador"
			}
	  },
	  submitHandler: function(form) {
			var form= new FormData(document.getElementById("formularioComprador"));
	    url="/admin/actualizarComprador";
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
					//console.log (respuesta);
					swal({
						title:'Comprador Actualizado',
						text:'EL comprador fue actualizado correctamente',
						icon:'success',
						//timer: 2000,
						button:true,
					});
	      }
				else if (respuesta==2) {
					swal({
						title:'Imposible realizar la acción!!',
						text:"La cédula ingresada ya se encuentra registrada para otro comprador",
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

});
