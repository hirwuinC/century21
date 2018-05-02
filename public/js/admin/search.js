$(document).ready(function(){
    var options = {

        url:function(){
            var textSearch = $('#exampleInputSearch').val();
            return "/admin/buscarasesor?data="+textSearch;
        },
        getValue: function (element) {
          $('#valor').val(element.id);
	        return element.fullName;
        },
        template:{
            type:"description",
            fields:{
                fullName:"fullName",
                description:"codigo_id"

            }
        },
        list: {
            match: { enabled: false },
            onChooseEvent: function() {
              var valor = $('#valor').val();
              window.location="/admin/agente?data="+valor;
            },

        },
    }
    $("#exampleInputSearch").easyAutocomplete(options);

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

    //////////////////////////////////////////////// Eliminar Asesor //////////////////////////////////////////////////////////////

    $('body').on('click','.redError',function(e){
      e.preventDefault();
      swal({
        title: "Borrar Asesor!!!",
        text: "Al borrar el asesor se perdera toda su información, ¿Desea Continuar?",
        icon: "warning",
        buttons: ['No','Sí, borrar'],
        dangerMode:true
      })
      .then((willDelete) => {
        if (willDelete) {
          var id=$(this).data('id');
          //console.log(id);
          url="/admin/borrarAsesor";
          $.ajax({
            beforeSend:mostrarPreload(),
            url: url,
            type: "post",
            dataType: "json",
            data:{id:id}
          })
          .done(function(respuesta){
            ocultarPreload();
            if (respuesta==1) {
              swal({
                title:'Asesor Borrado',
                text:"El asesor seleccionado fue borrado con exito",
                icon:'success',
                timer: 2000,
                button:false,
              });
              location.reload();
            }
            else {
              swal({
                title:'Imposible realizar la acción',
                text:"El asesor seleccionado tiene inmuebles asociados, debe asociar estos inmuebles a un nuevo asesor e intentarlo nuevamente",
                icon:'error',
                //timer: 2000,
                button:true
              });
            }

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
