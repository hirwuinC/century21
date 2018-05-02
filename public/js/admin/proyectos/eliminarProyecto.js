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

	//////////////////////////////////////////////// Eliminar Proyecto //////////////////////////////////////////////////////////////

	$('body').on('click','.deleteProperty',function(e){
	  e.preventDefault();
	  swal({
	    title: "Borrar Proyecto!!!",
	    text: "Al borrar el proyecto se borraran las imagenes y los inmuebles asociados, ¿Desea Continuar?",
	    icon: "warning",
	    buttons: ['No','Sí, borrar'],
	    dangerMode:true
	  })
	  .then((willDelete) => {
	    if (willDelete) {
	      var id=$(this).data('id');
				//console.log(id);
	      url="/admin/borrarProyecto";
	      $.ajax({
	        beforeSend:mostrarPreload(),
	        url: url,
	        type: "post",
	        dataType: "json",
	        data:{id:id}
	      })
	      .done(function(respuesta){
	        ocultarPreload();
	          swal({
	            title:'Proyecto Borrado',
	            text:"El proyecto seleccionado fue borrado con exito",
	            icon:'success',
	            timer: 2000,
	            button:false,
	          });
						location.reload();
	      })
	      .fail(function(){
	        ocultarPreload();
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
	});
});
