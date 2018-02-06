$(document).ready(function(){
	$("#asesorCreate").validate({
			onfocusout: false,
			rules: {
				user: {
					required:true,
					minlength: 3
				},
				emailUser: {
					required: true,
					email: true
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
			user: {
				required:"Debe indicar un nombre de usuario",
				minlength: "EL nombre de usuario debe ser minimo de 3 caracteres"
			},
			emailUser: {
				required: "Debe indicar un correo electronico para el usuario",
				email: "El correo electronico debe tener un formato como el siguiente minombre@century21caracas.com"
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
			var form=$("#asesorCreate").serialize();
			url="/admin/buscaruser";
			$.post(url,form,function(respuesta){
				var mensajes={0:"Error Inesperado, pongase en contacto con el administrador",
											1:"El rif ya esta registrado para otro usuario",
											2:"El email ya esta registrado para otro usuario",
											3:"El email y el rif ya estan registrados para otro usuario",
											4:"El nombre ya existe para otro usuario",
											5:"El nombre y el email ya existen para otro usuario",
											6:"El nombre y el rif ya existen para otro usuario",
											7:"El nombre, el email y el rif ya existen para otro usuario",
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
			});
		}
	});
	$('.file-input').change(function(){
    var curElement = $(this).parent().parent().parent().find('.image');
    var reader = new FileReader();

    reader.onload = function (e) {
        curElement.attr('src', e.target.result);
    };
    reader.readAsDataURL(this.files[0]);
	});
	$('body').on('click','#buttonReset',function(){
		$('#checkbox-example-two').attr('checked',false);
		$('#user').val('');
		$('#emailUser').val('');
		$('#pass').val('');
		$('#repeatPass').val('');
		$('#dataEntry').val('');
		$('#dateBirth').val('');
		$('#addressUser').val('');
		$('#rifUser').val('');
		$("#rolUser option[value='']").attr('selected',true);
	});
});
