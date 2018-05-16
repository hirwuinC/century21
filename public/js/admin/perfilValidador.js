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
///////////////////////////////////////////////////// Modificar Perfil ///////////////////////////////////////////////////////
	$("#perfilEdit").validate({
			onfocusout: false,
			rules: {
				emailUser:{
					required:true,
					email:true
				},
				pass:{
					required:true,
					minlength: 6
				},
				repeatPass:{
					required:true,
					equalTo:"#pass"
				},
				dateBirth:{
					required:true
				},
				addressUser:{
					required:true,
					minlength: 15
				}
			},
		messages: {
			emailUser:{
				required:"Debe indicar un correo Electrónico",
				email:"El correo debe tener un formato válido"
			},
			pass:{
				required:"Debe indicar una contraseña de acceso",
				minlength: "La contraseña debe tener un minimo de 6 caracteres"
			},
			repeatPass:{
				required:"Repita la contraseña",
				equalTo:"Las contraseñas deben coincidir"
			},
			dateBirth:{
				required:"Debe indicar la fecha de nacimiento del asesor"
			},
			addressUser:{
				required:"Es necesario que indiques tu dirección",
				minlength:"La direccion debe contener un mínimo de 15 caracteres"
			}
		},
		submitHandler: function(form) {
      var formulario = new FormData(document.getElementById('perfilEdit'));
			url="/admin/actualizarPerfil";
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
            'Listo!!',
            'Tu usuario ha sido actualizado, los cambios seran aplicados una vez inicies sesión nuevamente',
            'success'
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


	$('.file-input').change(function(){
    var curElement = $(this).parent().parent().parent().find('.image');
    var reader = new FileReader();

    reader.onload = function (e) {
        curElement.attr('src', e.target.result);
    };
    reader.readAsDataURL(this.files[0]);
	});

	$('body').on('click','#buttonReset',function(){
		$('#pass').val('');
		$('#repeatPass').val('');
		$('#dateBirth').val('');
		$('#addressUser').val('');
	});
});
