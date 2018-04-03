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
	  .then((willDelete) => {
	    if (willDelete) {
	      url="/admin/salir";
	      $.ajax({
	        url: url,
	        type: "post",
	        dataType: "html",
	      })
	      .done(function(respuesta){
					  setTimeout(function(){location.href = "/admin/login";},1000);
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
});
