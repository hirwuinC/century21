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

	////////////////////////////////////////////// Scroll Infinito ///////////////////////////////////////////////////////////////////////
	window.sr = ScrollReveal();
	sr.reveal('.hijo');

	//////////////////////////////////////////////// Buscador por codigo o nombre //////////////////////////////////////////////////////////////
	var options = {

			url:function(){
					var textSearch = $('#searchProyecto').val();
					return "/admin/buscarProyectoCodigo?data="+textSearch;
			},
			getValue: function (element) {
				$('#valor').val(element.id);
				return element.nombreProyecto;
			},
			template:{
					type:"description",
					fields:{
							fullName:"nombreProyecto",
							description:"id"
					}
			},
			list: {
					match: { enabled: false },
					onChooseEvent: function() {
						var valor = $('#valor').val();
						window.location="/admin/proyectos?data="+valor;
					},

			},
	}
	$("#searchProyecto").easyAutocomplete(options);

});
