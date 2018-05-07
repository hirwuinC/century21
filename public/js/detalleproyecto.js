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
///////////////////////////////////////////////////// cargar comprador interesado ///////////////////////////////////////////////////////
	$("#compradorInteresadoProyecto").validate({
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
				comentario:{
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
			comentario:{
				required:"Especifique un comentario"
			}
		},
		submitHandler: function(form) {
      var formulario = new FormData(document.getElementById('compradorInteresadoProyecto'));
			url="/compradorInteresadoProyecto";
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
            'Gracias por interesarse en uno de nuestros proyectos!!',
            'En poco tiempo nuestro asesor se estara comunicando con usted.',
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
