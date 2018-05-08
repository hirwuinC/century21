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
	  $('body').on('change','#states',function(){
	    var estado=$(this).val();
	    var url='/listarCiudadesPublico';
	    $.ajax({
	      data:{estado:estado},
	      url:url,
	      type:'post',
	      success:function(respuesta){
	        //console.log(respuesta);
					$('.opcion').remove();
					$('.opcionUrbanizacion').remove();
	        $.each(respuesta.ciudades,function(a){
						$.each(respuesta.ciudades[a],function(e) {
							$('#ciudades').append("<option value="+respuesta.ciudades[a][e].id+" class='opcion'>"+respuesta.ciudades[a][e].nombre+"</option>");
						});
	        });
	      }
	    });
	  });
	//////////////////////////////////////// Select dependiente de urbanizacion ///////////////////////////////////////////////
	    $('body').on('change','#ciudades',function(){
	      var ciudad=$(this).val();
	      var url='/listarUrbanizacionesPublico';
	      $.ajax({
	        data:{ciudad:ciudad},
	        url:url,
	        type:'post',
	        success:function(respuesta){
	          //console.log(respuesta);
	          $('.opcionUrbanizacion').remove();
	          $.each(respuesta.urbanizaciones,function(a){
							$.each(respuesta.urbanizaciones[a],function(e) {
	            $('#urbanizaciones').append("<option value="+respuesta.urbanizaciones[a][e].id+" class='opcionUrbanizacion' >"+respuesta.urbanizaciones[a][e].nombre+"</option>");
	          	});
						});
	        }
	      });
	    });

////////////////////////////////////////////// ruta de busqueda /////////////////////////////////////////////////////////////////

$('body').on('click', '#buscar', function(event) {
	event.preventDefault();
	var codigo=$('#codigo').val();
	var tipo=$('#tipo').val();
	var tipoNegocio=$('#tipoNegocio').val();
	var estados=$('#states').val();
	var ciudades=$('#ciudades').val();
	var urbanizaciones=$('#urbanizaciones').val();
	var habitaciones=$('#habitaciones').val();
	var banos=$('#banos').val();
	var estacionamientos=$('#estacionamientos').val();
	var precioMin=$('#precioMin').val();
	var precioMax=$('#precioMax').val();
	var host=location.host;
	location.href='http://'+host+'/buscarInmueblesPublico?codigo='+codigo+'&tipo='+tipo+'&tipoNegocio='+tipoNegocio+'&estados='+estados+'&ciudades='+ciudades+'&urbanizaciones='+urbanizaciones+'&habitaciones='+habitaciones+'&banos='+banos+'&estacionamientos='+estacionamientos+'&precioMin='+precioMin+'&precioMax='+precioMax;
});
////////////////////////////////////////////// Scroll Infinito ///////////////////////////////////////////////////////////////////////
window.sr = ScrollReveal();
sr.reveal('.hijo');
});
