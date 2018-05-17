$(document).ready(function(){
	var alto = 0;
	alto = $( window ).height()-130;
	$('.navbar-default').css('height',alto);
	$('.padre').click(function(e){
		e.preventDefault();
	});
	$('.cerrar').click(function(e){
		e.preventDefault();
		swal({
	    title: "Cerrar Sesión",
	    text: "Estas seguro que quieres cerrar tu sesión actual?",
	    icon: "warning",
	    buttons: ['No','Sí, Cerrar'],
	    dangerMode:false
	  })
	  .then((aceptar) => {
	    if (aceptar) {
	      url="/admin/salir";
	      $.ajax({
	        url: url,
	        type: "post",
	        dataType: "html",
	      })
	      .done(function(respuesta){
					location.href = "/admin/login";
	      })
	      .fail(function(){
	        swal({
	          title:'Algo sucedio',
	          text:"Comuniquese con el administrador",
	          icon:'error',
	          timer: 2000,
	          button:false
	        });
	      });
	    }
	  });
	})
	/////////////////////////////// mantener link del sidebar activo ////////////////////////////////////
	    var page = window.location;
	    var prueba=location.pathname.split('/');

	    var data= new Array();
	   	var data={'index':1,
			'perfil':2,
			'inmuebles':3,
			'inmueble':3,
			'buscarInmueble':3,
			'crear-inmueble-1':3,
			'crear-inmueble-2':3,
			'crear-proyectos-1':6,
			'crear-proyectos-2':6,
			'crear-proyectos-3':6,
			'proyectos':6,
			'proyecto':6,
			'buscarProyecto':6,
			'agente':10,
			'crear-usuario':10,
			'compradores':9,
			'modificar-comprador':9,
			'estadisticas':12,
			'direcciones':15
			};
	   $('.links a[data-id="'+data[prueba[2]]+'"]').addClass('active');
	    //console.log(data[prueba[2]]);

	});
