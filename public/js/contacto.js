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
///////////////////////////////////////////////////// cargar interesado publicar inmueble ///////////////////////////////////////////////////////
	$("#contactanos").validate({
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
			}
		},
		submitHandler: function(form) {
      var formulario = $('#contactanos').serialize();
			url="/nuevoContacto";
      $.ajax({
					beforeSend:mostrarPreload(),
          url: url,
          type: "post",
          dataType: "json",
          data: formulario,
      })
      .done(function(res){
				//console.log(res);
				ocultarPreload();
				if (res==1) {
          swal(
            'Gracias por Contactarnos!!',
            'Hemos recibido sus datos, a la brevedad posible nos estaremos comunicando con usted',
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
});
