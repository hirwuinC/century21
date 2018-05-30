$(document).ready(function() 
{
    $('#fechaI_').prop('disabled',true);
    $('#fechaF_').prop('disabled',true);
    $('#mostrar_').prop('disabled',true);
  


  

  function filtroMostrar(reporte_id)
  {
    var reglas={'4':{fechaI:true,fechaF:true,mostrar:true},'5':{fechaI:true,fechaF:true,mostrar:true},
                '6':{fechaI:true,fechaF:true,mostrar:true}};

    $('#fechaI_').prop('disabled',reglas[reporte_id]['fechaI']);
    $('#fechaF_').prop('disabled',reglas[reporte_id]['fechaF']);
    $('#mostrar_').prop('disabled',reglas[reporte_id]['mostrar']);


   //  console.log(name);
   // console.log(reglas[name]['fechaI']);
  }

  
  $('body').on('change','#elemento', function() {
    var elemento=$(this).val();
    var url='/admin/listarTipoReporte';
    $.ajax({
      data:{elemento:elemento},
      url:url,
      type:'post',
      success:function(respuesta){
        console.log(respuesta);
        $('.opcion').remove();
        $.each(respuesta,function(e){
          $('#tipoReporte').append("<option value="+respuesta[e].id+ " class='opcion' >"+respuesta[e].descripcionReporte+"</option>");
        });
      }
    });
  });

  $('#buttonReporte').click(function() 
  {
    var reporte=$('#tipoReporte').val();
     var filtro=$('#mostrar_').prop('checked');
     var rutas={
                '4':'/admin/distribucionUs','5':'/admin/distribucionCiu',
                '6':'/admin/distribucionTipInm','7':'/admin/visitasProp/'+0,
                '8':'/admin/visitasAsesor/'+0,'9':'/admin/visitasTipoInm/'+0,
                '10':'/admin/fechaCrea/'+0};
    
     window.open(rutas[reporte]);
  });

  $('body').on('change','#tipoReporte', function() {

    
    var reporte=$(this).val();
    filtroMostrar(reporte);



    //$('.fecha').css('display','block');
    // var elemento=$(this).val();
    // var url='/admin/listarTipoReporte';
    // $.ajax({
    //   data:{elemento:elemento},
    //   url:url,
    //   type:'post',
    //   success:function(respuesta){
    //     console.log(respuesta);
    //     $('.opcion').remove();
    //     $.each(respuesta,function(e){
    //       $('#tipoReporte').append("<option value="+respuesta[e].id+" class='opcion' >"+respuesta[e].descripcionReporte+"</option>");
    //     });
    //   }
    // });
  });

});
