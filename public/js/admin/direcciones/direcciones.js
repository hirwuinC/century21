$(document).ready(function() {
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
          $('#cityPropiety').append("<option value="+respuesta.ciudades[e].id+" class='opcion' >"+respuesta.ciudades[e].nombre+"</option>");
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
          $('.opcionUrbanizacion').remove();
          $.each(respuesta.urbanizaciones,function(e){
            $('#urbanizacionPropiety').append("<option value="+respuesta.urbanizaciones[e].id+" class='opcionUrbanizacion' >"+respuesta.urbanizaciones[e].nombre+"</option>");
          });
        }
      });
    });
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
  }

//////////////////////////////////////// Abrir modal nueva ciudad///////////////////////////////////////////////
  $('body').on('click', '#bttnNuevaCiudad', function() {
    var estado=$('#estatePropiety').val();
    if (estado=='') {
      swal(
        'Imposible Realizar la acción',
        'Debe seleccionar un estado',
        'error'
      );
    }
    else {
      $('#estado').val(estado);
      var estado=$('#estatePropiety option:selected').html();
      $('#estadoTag').html(estado);
      $('#nuevaCiudad').modal('show');
    }
  });

//////////////////////////////////////// Abrir modal nueva urbanización ///////////////////////////////////////////////
  $('body').on('click', '#bttnNuevaUrbanizacion', function() {
    var ciudad=$('#cityPropiety').val();
    if (ciudad=='') {
      swal(
        'Imposible Realizar la acción',
        'Debe seleccionar una ciudad',
        'error'
      );
    }
    else {
      //console.log(ciudad);
      $('#ciudadId').val(ciudad);
      var ciudad=$('#cityPropiety option:selected').html();
      $('#cityTag').html(ciudad);
      $('#nuevaUrbanizacion').modal('show');
    }
  });
///////////////////////////////////////// GUARDAR CIUDAD /////////////////////////////////////////////////////////////
  $("#nuevaCiudadForm").validate({
    onfocusout: false,
    rules: {
      ciudad:{
        required:true
      }
    },
    messages: {
      ciudad:{
        required:"Debe indicar el nombre de la ciudad"
      }
    },
    submitHandler: function(form) {
      var form = new FormData(document.getElementById('nuevaCiudadForm'));
      url="/admin/guardarCiudad";
      //console.log($('#evento').val());
      $.ajax({
          beforeSend:mostrarPreload(),
          url: url,
          type: "post",
          dataType: "json",
          data: form,
          cache: false,
          contentType:false,
          processData: false
      })
      .done(function(respuesta){
        ocultarPreload();
        //console.log(res);
        var estado=$('#estatePropiety option:selected').html();
        if (respuesta[0]==1) {
          swal(
            'Buen Trabajo!!',
            'La ciudad fue cargada correctamente para el estado '+estado,
            'success'
          );
          $('.limpiarCiudad').val('');
          $('.opcion').remove();
          $.each(respuesta[1],function(e){
            $('#cityPropiety').append("<option value="+respuesta[1][e].id+" class='opcion' >"+respuesta[1][e].nombre+"</option>");
          });
        }
        else{
          swal(
            'Imposible Realizar la acción',
            'Ya existe una ciudad cargada para este estado con ese nombre',
            'error'
          );
        }
      })
      .fail(function(){
        ocultarPreload();
        swal(
          'Imposible Realizar la acción',
          'Comuniquese con el administrador del sistema',
          'error'
        );
      });
    }
  });
///////////////////////////////////////// GUARDAR URBANIZACION /////////////////////////////////////////////////////////////
  $("#nuevaUrbanizacionForm").validate({
    onfocusout: false,
    rules: {
      urbanizacion:{
        required:true
      }
    },
    messages: {
      urbanizacion:{
        required:"Debe indicar el nombre de la urbanización"
      }
    },
    submitHandler: function(form) {
      var form = new FormData(document.getElementById('nuevaUrbanizacionForm'));
      url="/admin/guardarUrbanizacion";
      //console.log($('#evento').val());
      $.ajax({
          beforeSend:mostrarPreload(),
          url: url,
          type: "post",
          dataType: "json",
          data: form,
          cache: false,
          contentType:false,
          processData: false
      })
      .done(function(respuesta){
        ocultarPreload();
        //console.log(res);
        var ciudad=$('#cityPropiety option:selected').html();
        if (respuesta[0]==1) {
          swal(
            'Buen Trabajo!!',
            'La urbanización fue cargada correctamente para la ciudad '+ciudad,
            'success'
          );
          $('.limpiarUrbanizacion').val('');
          $('.opcionUrbanizacion').remove();
          $.each(respuesta[1],function(e){
            $('#urbanizacionPropiety').append("<option value="+respuesta[1][e].id+" class='opcionUrbanizacion' >"+respuesta[1][e].nombre+"</option>");
          });
        }
        else{
          swal(
            'Imposible Realizar la acción',
            'Ya existe una ciudad cargada para este estado con ese nombre',
            'error'
          );
        }
      })
      .fail(function(){
        ocultarPreload();
        swal(
          'Imposible Realizar la acción',
          'Comuniquese con el administrador del sistema',
          'error'
        );
      });
    }
  });
//////////////////////////////////////// Borrar Ciudad y Urbanizaciones asociadas //////////////////////////////////////
  $('body').on('click', '#bttnDeleteCiudad', function() {
    var ciudad=$('#cityPropiety').val();
    var estado=$('#estatePropiety').val();
    if (ciudad=='') {
      swal(
        'Imposible Realizar la acción',
        'Debe seleccionar la ciudad que desea borrar',
        'error'
      );
    }
    else {
      swal({
    		title: "Borrar Ciudad",
    		text: "Al borrar la ciudad seleccionada se borraran sus Urbanizaciones, ¿Desea Continuar?",
    		icon: "warning",
    		buttons: ['No','Sí, Borrar'],
    		dangerMode:true
    	})
    	.then((willDelete) => {
    		if (willDelete) {
    			url="/admin/borrarCiudad";
    			$.ajax({
            beforeSend:mostrarPreload(),
    				url: url,
    				type: "post",
    				dataType: "json",
    				data:{ciudad:ciudad,estado:estado}
    			})
    			.done(function(respuesta){
            ocultarPreload();
            console.log(respuesta);
            var ciudad=$('#cityPropiety option:selected').html();
    				//console.log (respuesta);
    				if (respuesta[0]==0) {
              swal({
      		      title:'Imposible realizar la acción',
      		      text:ciudad+" esta siendo utilizada en algun proyecto o propiedad.",
      		      icon:'error',
      		      //timer: 2000,
      		      button:true
      		    });
    				}
            else if (respuesta[0]==10) {
              swal({
      		      title:'Imposible realizar la acción',
      		      text:"Existen urbanizaciones de "+ciudad+" que estan siendo usadas en una o mas propiedades.",
      		      icon:'error',
      		      //timer: 2000,
      		      button:true
      		    });
            }
            else if (respuesta[0]==1) {
              swal({
  							title:'Buen trabajo!!',
  							text:"La ciudad "+ciudad+" y sus urbanizaciones fueron borradas con exito",
  							icon:'success',
  							//timer: 2000,
  							button:true,
  						});
              $('.opcion').remove();
              $('.opcionUrbanizacion').remove();
              $.each(respuesta[1],function(e){
                $('#cityPropiety').append("<option value="+respuesta[1][e].id+" class='opcion' >"+respuesta[1][e].nombre+"</option>");
              });
            }
            else if (respuesta[0]==2) {
              swal({
                title:'Buen trabajo!!',
                text:"La ciudad "+ciudad+" fue borrada con exito",
                icon:'success',
                //timer: 2000,
                button:true,
              });
              $('.opcion').remove();
              $('.opcionUrbanizacion').remove();
              $.each(respuesta[1],function(e){
                $('#cityPropiety').append("<option value="+respuesta[1][e].id+" class='opcion' >"+respuesta[1][e].nombre+"</option>");
              });
            }
    			}).fail(function(){
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
    }
  });
  //////////////////////////////////////// Borrar Ciudad y Urbanizaciones asociadas //////////////////////////////////////
    $('body').on('click', '#bttnDeleteUrbanizacion', function() {
      var ciudad=$('#cityPropiety').val();
      var urbanizacion=$('#urbanizacionPropiety').val();
      if (urbanizacion=='') {
        swal(
          'Imposible Realizar la acción',
          'Debe seleccionar la urbanizacion que desea borrar',
          'error'
        );
      }
      else {
        swal({
      		title: "Borrar Urbanización",
      		text: " ¿Seguro que desea borrar la urbanización seleccionada?",
      		icon: "warning",
      		buttons: ['No','Sí, Borrar'],
      		dangerMode:true
      	})
      	.then((willDelete) => {
      		if (willDelete) {
      			url="/admin/borrarUrbanizacion";
      			$.ajax({
              beforeSend:mostrarPreload(),
      				url: url,
      				type: "post",
      				dataType: "json",
      				data:{ciudad:ciudad,urbanizacion:urbanizacion}
      			})
      			.done(function(respuesta){
              ocultarPreload();
              var urbanizacion=$('#urbanizacionPropiety option:selected').html();
      				if (respuesta[0]==0) {
                swal({
        		      title:'Imposible realizar la acción',
        		      text:urbanizacion+" esta siendo utilizada en una o varias propiedades.",
        		      icon:'error',
        		      //timer: 2000,
        		      button:true
        		    });
      				}
              else if (respuesta[0]==1) {
                swal({
                  title:'Buen trabajo!!',
                  text:"La urbanización "+urbanizacion+" fue borrada con exito",
                  icon:'success',
                  //timer: 2000,
                  button:true,
                });
                $('.opcionUrbanizacion').remove();
                $.each(respuesta[1],function(e){
                  $('#urbanizacionPropiety').append("<option value="+respuesta[1][e].id+" class='opcionUrbanizacion' >"+respuesta[1][e].nombre+"</option>");
                });
              }
      			}).fail(function(){
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
      }
    });

});
