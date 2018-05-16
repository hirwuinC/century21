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
/////////////////////////////////////////////// Agregar o modificar usuarios /////////////////////////////////////////////////
	$("#asesorCreate").validate({
			onfocusout: false,
			rules: {
				emailUser:{
					required:true,
					email:true
				},
				user: {
					required:true,
					minlength: 3
				},
				cedula: {
					required: true
				},
				pass:{
					required:true,
					minlength: 6
				},
				repeatPass:{
					required:true,
					equalTo:"#pass"
				},
				dateEntry:{
					required:true
				},
				dateBirth:{
					required:true
				},
				addressUser:{
					required:true,
					minlength: 15
				},
				rifUser:{
					required:true,
					minlength: 8,
				},
				rolUser:{
					required:true
				}
			},
		messages: {
			emailUser:{
				required:"Debe indicar un correo Electrónico",
				email:"El correo debe tener un formato válido"
			},
			user: {
				required:"Debe indicar un nombre de usuario",
				minlength: "EL nombre de usuario debe ser mínimo de 3 caracteres"
			},
			cedula: {
				required: "Debe indicar la cédula del asesor"
			},
			pass:{
				required:"Debe indicar una contraseña de acceso",
				minlength: "La contraseña debe tener un minimo de 6 caracteres"
			},
			repeatPass:{
				required:"Repita la contraseña",
				equalTo:"Las contraseñas deben coincidir"
			},
			dateEntry:{
				required:"Debe indicar la fecha de ingreso del asesor"
			},
			dateBirth:{
				required:"Debe indicar la fecha de nacimiento del asesor"
			},
			addressUser:{
				required:"Debe indicar el domicilio del asesor",
				minlength:"La direccion debe contener un minimo de 15 caracteres"
			},
			rifUser:{
				required:"Debe indicar el rif del asesor",
				minlength:"El formato del rif debe tener un minimo de 8 caracteres sin guiones ni puntos"
			},
			rolUser:{
				required:"Debe indicar que rol tendra el usuario en el sistema"
			}
		},
		submitHandler: function(form) {
			var form= new FormData(document.getElementById("asesorCreate"));
			url="/admin/buscaruser";
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
				//console.log(respuesta);
				ocultarPreload();
				var mensajes={0:"Error Inesperado, pongase en contacto con el administrador",
											1:"El rif ya esta registrado para otro usuario",
											2:"La cédula ya esta registrada para otro usuario",
											3:"La cédula y el rif ya estan registrados para otro usuario",
											4:"El nombre ya existe para otro usuario",
											5:"El nombre y la cédula ya existen para otro usuario",
											6:"El nombre y el rif ya existen para otro usuario",
											7:"El nombre, la cédula y el rif ya existen para otro usuario",
										 10:"Usuario actualizado",
										 20:"Nuevo usuario registrado"
									 };
				if(respuesta==10 || respuesta==20){
					swal(
					  'Buen Trabajo!!',
					  mensajes[respuesta],
					  'success'
					);
				}
				else {
					swal(
					  'Casi Terminamos!!',
					  mensajes[respuesta],
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
///////////////////////////////////////////////// Cargar foto en contenedor //////////////////////////////////////////////
	$('.file-input').change(function(){
    var curElement = $(this).parent().parent().parent().find('.image');
    var reader = new FileReader();

    reader.onload = function (e) {
        curElement.attr('src', e.target.result);
    };
    reader.readAsDataURL(this.files[0]);
	});

///////////////////////////////////////////////// CAMPOS RESETEADOS  ////////////////////////////////////////////////////
	$('body').on('click','#buttonReset',function(){
		$('#checkbox-example-two').attr('checked',false);
		$('#user').val('');
		$('#cedula').val('');
		$('#pass').val('');
		$('#repeatPass').val('');
		$('#dataEntry').val('');
		$('#dateBirth').val('');
		$('#addressUser').val('');
		$('#rifUser').val('');
		$("#rolUser option[value='']").attr('selected',true);
	});
});
