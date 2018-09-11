$(document).ready(function() 
{
  inicializarOpciones()
  limpiarImputs()
  $('body').on('change','#elemento', function() {
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

  $('body').on('change','#tipoReporte', function() {
    var elemento=$(this).val();
    inicializarOpciones()
    limpiarImputs()
    filtroMostrar(elemento);
    filtrar(elemento);
    var url='/admin/listarAsesores';
    $.ajax({
      data:{elemento:elemento},
      url:url,
      type:'post',
      success:function(respuesta){
        $('.opcionAsesores').remove();
        $('.opcionCiudades').remove();
        $('.opcionUrbanizacion').remove();
        $.each(respuesta,function(e){
          $('#asesores').append("<option value="+respuesta[e].id+ " class='opcionAsesores' >"+respuesta[e].fullName+"</option>");
        });
      }
    });
  });

  $('body').on('change','#estados', function() {
    var estados=$(this).val();
    var url='/admin/listarCiudadesReportes';
    $.ajax({
      data:{estados:estados},
      url:url,
      type:'post',
      success:function(respuesta){
        $('.opcionCiudades').remove();
        $('.opcionUrbanizacion').remove();
        $.each(respuesta.ciudades,function(a){
          $.each(respuesta.ciudades[a],function(e) {
            $('#ciudades').append("<option value="+respuesta.ciudades[a][e].id+" class='opcionCiudades'>"+respuesta.ciudades[a][e].nombre+"</option>");
          });
        });
      }
    });
  });
  $('body').on('change','#ciudades', function() {
    var ciudades=$(this).val();
    var url='/admin/listarUrbanizacionesReportes';
    $.ajax({
      data:{ciudades:ciudades},
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


  function filtrar(elemento){
    var reglas=
    {
      '0':{asesores:'none',ubicacion:'none',precio:true},
      '4':{asesores:'block',ubicacion:'none',precio:true},
      '5':{asesores:'none',ubicacion:'block',precio:true},
      '6':{asesores:'block',ubicacion:'none',precio:true},
      '7':{asesores:'none',ubicacion:'block',precio:true},
      '9':{asesores:'block',ubicacion:'none',precio:false},
      '10':{asesores:'none',ubicacion:'block',precio:false},
      '11':{asesores:'block',ubicacion:'none',precio:false},
      '12':{asesores:'none',ubicacion:'block',precio:false},
      '13':{asesores:'block',ubicacion:'none',precio:true},
      '14':{asesores:'none',ubicacion:'none',precio:true},
      '15':{asesores:'block',ubicacion:'none',precio:true},
      '16':{asesores:'block',ubicacion:'none',precio:true},
      '17':{asesores:'none',ubicacion:'block',precio:true},
      '18':{asesores:'block',ubicacion:'none',precio:true},
      '19':{asesores:'none',ubicacion:'block',precio:true},
      '20':{asesores:'block',ubicacion:'none',precio:true},
      '21':{asesores:'block',ubicacion:'none',precio:true},
    };

    $('.asesores').css('display',reglas[elemento]['asesores']);
    $('.ubicacion').css('display',reglas[elemento]['ubicacion']);

    if (reglas[elemento]['precio']==false) {
      $('#mostrar_precio').attr('disabled',false);
      $('#mostrar_precio').prop('checked',true);
      $('.precio').attr('disabled',false);
      $('.precio').val('');
    }
    else{
      $('#mostrar_precio').attr('disabled',true);
      $('#mostrar_precio').prop('checked',false);
      $('.precio').attr('disabled',true);
      $('.precio').val('');
    }
  }

  $('body').on('click','#buttonReporte',function() {

    var reporte=$('#tipoReporte').val();
    var fechaI=$('#fechaI_').val();
    var fechaF=$('#fechaF_').val();
    var precioI=$('#precioI_').val();
    var precioF=$('#precioF_').val();
    var asesores=$('#asesores').val();
    var estados=$('#estados').val();
    var ciudades=$('#ciudades').val();
    var urbanizaciones=$('#urbanizaciones').val();
    var habilitarPrecio=$('#mostrar_precio').prop('checked');

  
    filtro=filtroPass(fechaI,fechaF,precioI,precioF,asesores,estados,ciudades,urbanizaciones);

    var rutas=
    {
      '4':'/admin/distribucionAsesor/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['asesores'],
      '5':'/admin/distribucionUbicacion/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['estados']+'/'+filtro['ciudades']+'/'+filtro['urbanizaciones'],
      '6':'/admin/distribucionTipInmAsesor/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['asesores'],
      '7':'/admin/distribucionTipInmUbicacion/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['estados']+'/'+filtro['ciudades']+'/'+filtro['urbanizaciones'],
      '9':'/admin/captadasAsesor/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['precioI']+'-'+filtro['precioF']+'/'+filtro['asesores'],
      '10':'/admin/captadasUbicacion/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['precioI']+'-'+filtro['precioF']+'/'+filtro['estados']+'/'+filtro['ciudades']+'/'+filtro['urbanizaciones'],
      '11':'/admin/vendidasAsesor/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['precioI']+'-'+filtro['precioF']+'/'+filtro['asesores'],
      '12':'/admin/vendidasUbicacion/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['precioI']+'-'+filtro['precioF']+'/'+filtro['estados']+'/'+filtro['ciudades']+'/'+filtro['urbanizaciones'],
      '13':'/admin/distribucionTipoNegocio/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['asesores'],
      '14':'/admin/reporteGeneralVentas/'+filtro['fechaI']+'/'+filtro['fechaF'],    
      '15':'/admin/ventasTipoIntermediacion/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['asesores'],
      '16':'/admin/ventasTipoInmuebleAsesor/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['asesores'],
      '17':'/admin/ventasTipoInmuebleUbicacion/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['estados']+'/'+filtro['ciudades']+'/'+filtro['urbanizaciones'],
      '18':'/admin/ventasTipoNegocioAsesor/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['asesores'],
      '19':'/admin/ventasTipoNegocioUbicacion/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['estados']+'/'+filtro['ciudades']+'/'+filtro['urbanizaciones'],
      '20':'/admin/rendimientoAsesor/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['asesores'],
      '21':'/admin/negociacionesGeneral/'+filtro['fechaI']+'/'+filtro['fechaF']+'/'+filtro['asesores'],

    };
    
    if (reporte==0) {//si no se selecciona el tipo de reporte
      swal(
            'Debe seleccionar un tipo de reporte!!','',
            'warning'
          );
    }
    else if (reporte>0) //si selecciona el tipo de reporte
    {
      var mensaje=validarFiltros(reporte,fechaI,fechaF,precioI,precioF,estados,habilitarPrecio);
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


  function filtroPass(fechaI='',fechaF='',precioI='',precioF='',asesores='',estados='',ciudades='',urbanizaciones='',habilitarPrecio){

    var filtros={'fechaI':'','fechaF':'','precioI':0,'precioF':0,'asesores':0,'estados':0,'ciudades':0,'urbanizaciones':0};
  
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

    if (asesores!='') {
      filtros['asesores']=asesores;
    }

    if (estados!='') {
      filtros['estados']=estados;
    }

    if (ciudades!='') {
      filtros['ciudades']=ciudades;
    }

    if (urbanizaciones!='') {
      filtros['urbanizaciones']=urbanizaciones;
    }


    return filtros;
  }

    var reglas=
    {
      '4':{fechaI:false,fechaF:false,precioI:true,precioF:true,estado:true},
      '5':{fechaI:false,fechaF:false,precioI:true,precioF:true,estado:false},
      '6':{fechaI:false,fechaF:false,precioI:true,precioF:true,estado:true},
      '7':{fechaI:false,fechaF:false,precioI:true,precioF:true,estado:false},
      '9':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:true},
      '10':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:false},
      '11':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:true},
      '12':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:false},
      '13':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:true},
      '14':{fechaI:false,fechaF:false,precioI:true,precioF:true,estado:true},
      '15':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:true},
      '16':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:true},
      '17':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:false},
      '18':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:true},
      '19':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:false},
      '20':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:true},
      '21':{fechaI:false,fechaF:false,precioI:false,precioF:false,estado:true},
      //'20':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true}
      //'11':{fechaI:false,fechaF:false,mostrar:false,precioI:true,precioF:true},
      //'12':{fechaI:false,fechaF:false,mostrar:false,precioI:true,precioF:true},
      
      
      //'15':{fechaI:true,fechaF:true,mostrar:false,precioI:true,precioF:true},
      //'16':{fechaI:false,fechaF:false,mostrar:false,precioI:true,precioF:true}
    };

  function validarFiltros(reporte,fechaI,fechaF,precioI,precioF,estado,habilitarPrecio){
    var mensaje='';
      if (reglas[reporte]['fechaI']==false && fechaI=='') 
      {
        mensaje=mensaje+"\n - Fecha de inicio para el rango de fecha.";
      }

      if (reglas[reporte]['fechaF']==false && fechaF=='') 
      {
        mensaje=mensaje+"\n - Fecha final para el rango de fecha.";
      }

      if (habilitarPrecio==true && precioI=='') 
      {
        mensaje=mensaje+"\n - Precio mínimo para el rango de precio.";
      }

      if (habilitarPrecio==true && precioF=='') 
      {
        mensaje=mensaje+"\n - Precio máximo para el rango de precio.";
      }

      if (precioI!='' && precioF!='') {
        if (precioI > precioF) {
           mensaje=mensaje+"\n - El precio mínimo no puede ser mayor que el máximo.";
        }
      }
      if (fechaI!='' && fechaF!='') {
        if (fechaI > fechaF) {
           mensaje=mensaje+"\n - La fecha inicial no puede ser mas reciente que la fecha final.";
        }
      }
      if (reglas[reporte]['estado']==false && estado=='') 
      {
        mensaje=mensaje+"\n - Seleccione al menos un estado.";
      }
    return mensaje;
  }

  function filtroMostrar(reporte_id){
    if (reporte_id>0) 
    {

        $('#fechaI_').prop('disabled',reglas[reporte_id]['fechaI']);
        $('#fechaF_').prop('disabled',reglas[reporte_id]['fechaF']);
        $('#precioI_').prop('disabled',reglas[reporte_id]['precioI']);
        $('#precioF_').prop('disabled',reglas[reporte_id]['precioF']);


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
          $('#mostrar_precio').prop('checked',true);
        }
        else
        {
          $('#mostrar_precio').prop('checked',false);
        }
    }
    else
    {
       
       inicializarOpciones()
       limpiarImputs()
    }

      return 0;
  }
  function inicializarOpciones(){
    $('#fechaI_').prop('disabled',true);
    $('#fechaF_').prop('disabled',true);
    $('#precioI_').prop('disabled',true);
    $('#precioF_').prop('disabled',true);
    $('#checkFecha').prop('checked',false);
    $('#checkPrecio').prop('checked',false);

    return 0;
  }

  function limpiarImputs(){
    $('#fechaI_').val('');
    $('#fechaF_').val('');
    $('#precioI_').val('');
    $('#precioF_').val('');
    $('#asesores').val('');
    $('#estados').val('');
    $('#ciudades').val('');
    $('#urbanizaciones').val('');

  return 0;
  }

   $('body').on('click','.contPrecio', function() {
    if (!$('#mostrar_precio').attr('disabled')) {
      if (!$('#mostrar_precio').prop('checked')) {
        $('#mostrar_precio').prop('checked',true);
        $('.precio').attr('disabled',false);
        $('.precio').val('');
      }
      else{
        $('#mostrar_precio').prop('checked',false);
        $('.precio').attr('disabled',true);
        $('.precio').val('');
      }
    }
  });


});














