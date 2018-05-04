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
