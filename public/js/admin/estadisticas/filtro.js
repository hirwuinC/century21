$(document).ready(function() 
{
    inicializarOpciones()
      

  
  $('body').on('change','#elemento', function() {
    inicializarOpciones()
    limpiarImputs()

    var elemento=$(this).val();
    var url='/admin/listarTipoReporte';
    $.ajax({
      data:{elemento:elemento},
      url:url,
      type:'post',
      success:function(respuesta){
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
    var fechaI=$('#fechaI_').val();
    var fechaF=$('#fechaF_').val();
    var precioI=$('#precioI_').val();
    var precioF=$('#precioF_').val();

  

            filtro=filtroPass(filtro,fechaI,fechaF,precioI,precioF);

             var rutas=
             {
                '4':'/admin/distribucionUs/'+filtro['mostrar'],'5':'/admin/distribucionCiu/'+filtro['mostrar'],
                '6':'/admin/distribucionTipInm/'+filtro['mostrar'],'7':'/admin/visitasProp/'+filtro['mostrar'],
                '8':'/admin/visitasAsesor/'+filtro['mostrar'],'9':'/admin/visitasTipoInm/'+filtro['mostrar'],
                '10':'/admin/fechaCrea/'+filtro['mostrar'],'11':'/admin/captadasAsesor/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['mostrar'],
                '12':'/admin/captadasCiudad/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['mostrar'],'13':'/admin/captadasPrecio/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['precioI']+'/'+filtro['precioF'],
                '14':'/admin/promedioAsesor/'+filtro['mostrar'],'15':'/admin/promedioTipoInmueble/'+filtro['mostrar'],
                '16':'/admin/propiedadesCaptadas/'+filtro['fechaI']+'/'+filtro['fechaF']
             };

           

           
            if ($('#tipoReporte').val()==0 || $('#elemento').val()==0) //si no se selecciona el tipo de reporte
            {
              swal(
                    'Debe seleccionar un elemento y un tipo de reporte!!','',
                    'warning'
                  );
            }
            else if ($('#tipoReporte').val()>0 && $('#elemento').val()>0) //si selecciona el tipo de reporte
            {
                var mensaje=validarFiltros(reporte,fechaI,fechaF,precioI,precioF);
                if (mensaje=='') 
                {
                  window.open(rutas[reporte]);
                }
                else
                {
                   swal('Debe indicar los siguientes datos:',mensaje,'warning');
                }
            }
           
    
     
    
    
     
  });

  $('body').on('change','#tipoReporte', function() {

    
    var reporte=$(this).val();
    inicializarOpciones()
    limpiarImputs()
    filtroMostrar(reporte);

  });

});

var reglas=
{
  '4':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true},'5':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true},
  '6':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true},'7':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true},
  '8':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true},'9':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true},
  '10':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true},'11':{fechaI:false,fechaF:false,mostrar:false,precioI:true,precioF:true},
  '12':{fechaI:false,fechaF:false,mostrar:false,precioI:true,precioF:true},'13':{fechaI:false,fechaF:false,mostrar:true,precioI:false,precioF:false},
  '14':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true},'15':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true},
  '16':{fechaI:false,fechaF:false,mostrar:false,precioI:true,precioF:true}
};

function filtroMostrar(reporte_id)
  {
    if (reporte_id>0) 
    {

        $('#fechaI_').prop('disabled',reglas[reporte_id]['fechaI']);
        $('#fechaF_').prop('disabled',reglas[reporte_id]['fechaF']);
        $('#precioI_').prop('disabled',reglas[reporte_id]['precioI']);
        $('#precioF_').prop('disabled',reglas[reporte_id]['precioF']);
        $('#mostrar_').prop('disabled',reglas[reporte_id]['mostrar']);

        if (reglas[reporte_id]['fechaI']==false && reglas[reporte_id]['fechaF']==false) 
        {
          $('#checkFecha').prop('checked',true);
        }
        else
        {
          $('#checkFecha').prop('checked',false);
        }

        if (reglas[reporte_id]['precioI']==false && reglas[reporte_id]['precioF']==false) 
        {
          $('#checkPrecio').prop('checked',true);
        }
        else
        {
          $('#checkPrecio').prop('checked',false);
        }
    }
    else
    {
       
       inicializarOpciones()
       limpiarImputs()
    }

      return 0;
  }

  function filtroPass(mostrar,fechaI='',fechaF='',precioI='',precioF='')
  {
      var filtros={'mostrar':0,'fechaI':'','fechaF':'','precioI':'','precioF':''};
      
      if (mostrar) 
      {
        filtros['mostrar']=1;
      }

      if (fechaI!='') 
      {
        filtros['fechaI']=fechaI;
      }

      if (fechaF!='') 
      {
        filtros['fechaF']=fechaF;
      }

      if (precioI!='') 
      {
        filtros['precioI']=precioI;
      }

      if (precioF!='') 
      {
        filtros['precioF']=precioF;
      }

      return filtros;
  }


function validarFiltros(reporte,fechaI,fechaF,precioI,precioF)
{
  var mensaje='';

    if (reglas[reporte]['fechaI']==false && fechaI=='') 
    {
      mensaje=mensaje+"\n - Fecha de inicio para el rango de fecha.";
    }

    if (reglas[reporte]['fechaF']==false && fechaF=='') 
    {
      mensaje=mensaje+"\n - Fecha final para el rango de fecha.";
    }

    if (reglas[reporte]['precioI']==false && precioI=='') 
    {
      mensaje=mensaje+"\n - Precio inicial para el rango de precio.";
    }

    if (reglas[reporte]['precioF']==false && precioF=='') 
    {
      mensaje=mensaje+"\n - Precio final para el rango de precio.";
    }

  return mensaje;

}

function inicializarOpciones()
{
    $('#fechaI_').prop('disabled',true);
    $('#fechaF_').prop('disabled',true);
    $('#precioI_').prop('disabled',true);
    $('#precioF_').prop('disabled',true);
    $('#mostrar_').prop('disabled',true);
    $('#checkFecha').prop('checked',false);
    $('#checkPrecio').prop('checked',false);
    $('#mostrar_').prop('checked',false);

    return 0;
}

function limpiarImputs()
{

  $('#fechaI_').val('');
  $('#fechaF_').val('');
  $('#precioI_').val('');
  $('#precioF_').val('');

  return 0;
}
