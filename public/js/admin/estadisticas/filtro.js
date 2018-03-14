$(document).ready(function() {
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
          $('#tipoReporte').append("<option value="+respuesta[e].id+" class='opcion' >"+respuesta[e].descripcionReporte+"</option>");
        });
      }
    });
  });
  $('body').on('change','#tipoReporte', function() {
    $('.fecha').css('display','block');
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
