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
	//////////////////////////////////////// Select dependiente de Ciudad ///////////////////////////////////////////////
	  $('body').on('change','#estatePropiety',function(){
	    var estado=$(this).val();
	    var url='/admin/listarCiudades';
	    $.ajax({
	      data:{estado:estado},
	      url:url,
	      type:'post',
	      success:function(respuesta){
	        //console.log(respuesta);
	        $('.opcion').remove();
					$('.opcionUrbanizacion').remove();
	        $.each(respuesta.ciudades,function(e){
	          $('#cityPropiety').append("<option value="+respuesta.ciudades[e].id+" class='opcion'>"+respuesta.ciudades[e].nombre+"</option>");
	        });
	      }
	    });
	  });
	//////////////////////////////////////// Select dependiente de urbanizacion ///////////////////////////////////////////////
	    $('body').on('change','#cityPropiety',function(){
	      var ciudad=$(this).val();
	      var url='/admin/listarUrbanizaciones';
	      $.ajax({
	        data:{ciudad:ciudad},
	        url:url,
	        type:'post',
	        success:function(respuesta){
	          //console.log(respuesta);
	          $('.opcionUrbanizacion').remove();
	          $.each(respuesta.urbanizaciones,function(e){
	            $('#namePropiety').append("<option value="+respuesta.urbanizaciones[e].id+" class='opcionUrbanizacion' >"+respuesta.urbanizaciones[e].nombre+"</option>");
	          });
	        }
	      });
	    });

////////////////////////////////////////////// Scroll Infinito ///////////////////////////////////////////////////////////////////////
window.sr = ScrollReveal();
sr.reveal('.hijo');
});
