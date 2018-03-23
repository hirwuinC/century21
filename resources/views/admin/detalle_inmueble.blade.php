@extends('admin/base_admin')

@section('content')
    <div class="contentDetail">
        <h2 class="titleSection">DETALLE DEL INMUEBLE</h2>
        <div class="row">
              <div class="col-xs-4">
                  <input type="hidden" id="positionPropiety" value="{{$inmueble->posicionMapa}}">
                  <input type="hidden" id="idPropiety" value="{{$inmueble->id}}">
                  <p><span>Código MLS:</span>
                    @if($inmueble->id_mls==0)
                      N/A
                    @else
                      $inmueble->id_mls
                    @endif
                  </p>
                  <p><span>Código Interno:</span> {{$inmueble->id}}</p>
                  <p><span>Tipo de Negociacion:</span> {{$inmueble->tipoNegocio}}</p>
                  <p><span>Tipo de Inmueble:</span> {{$inmueble->nombreTipo}}</p>
                  <p><span>Precio: Bs</span> {{$inmueble->precio}}</p>
                  <p><span>Habitaciones:</span> {{$inmueble->habitaciones}}</p>
                  <p><span>Baños:</span> {{$inmueble->banos}}</p>
                  <p><span>Puestos de Estacionamiento:</span> {{$inmueble->estacionamientos}}</p>
                  <p><span>Metros de Construcción:</span> {{$inmueble->metros_construccion}}</p>
              </div>
              <div class="col-xs-4">
                  <p><span>Metros de terreno:</span> {{$inmueble->metros_terreno}}</p>
                  <p><span>Estado:</span> {{$inmueble->nombre_estado}}</p>
                  <p><span>Ciudad:</span> {{$inmueble->nombre_ciudad}}</p>
                  <p><span>Urbanización:</span> {{$inmueble->urbanizacion}}</p>
                  <p><span>Asesor Captador:</span> {{$inmueble->fullname}}</p>
                  <p><span>Comisión de Captación:</span>
                    @if($inmueble->porcentajeCaptacion!='')
                      {{$inmueble->porcentajeCaptacion}}%
                    @endif
                  </p>
                  <p><span>Visitas Generadas:</span> {{$inmueble->visitas}}</p>
                  <p><span>Compradores Interesados:</span> {{$inmueble->compradorInteresado}}</p>
              </div>
              <div class="col-xs-4 cont-imagen">
                  <img src="{{ asset('images/inmuebles')}}/{{$imagen->nombre}}" alt="">
              </div>
          </div>
          <h2 class="titleSection">DESCRIPCIÓN DEL INMUEBLE</h2>
          <div class="row">
              <div class="col-xs-12">
                  <p>{{$inmueble->comentario}}</p>
              </div>
          </div>
          <h2 class="titleSection">UBICACIÓN DEL INMUEBLE</h2>
          <div class="row">
              <div class="col-xs-12">
                <div id="map" class="googleMap">
                </div>
              </div>
          </div>
          @if($usuario->rol_id==1)
            <h2 class="titleSection">DATOS DE GESTIÓN DEL INMUEBLE</h2>
            <div class="row">
                <div class="col-xs-4">
                    <p><span>Asesor Captador:</span> {{$negociacion->asesorCaptador}}</p>
                    <p><span>Asesor Cerrador:</span> {{$negociacion->asesorCerrador}}</p>
                    <p><span>Monto de Venta Final:</span>
                      @if($negociacion->precioFinal!='')
                        Bs{{$negociacion->precioFinal}}
                      @endif
                    </p>
                    <p><span>Comisión Cierre:</span>
                      @if($negociacion->porcentajeCierre!='')
                        {{$negociacion->porcentajeCierre}}%
                      @endif
                    </p>
                </div>
                <div class="col-xs-4">
                    <p><span>Comisión Bruta: Bs</span> {{$negociacion->comisionBruta}}</p>
                    @if($negociacion->asesorCaptador=="Asesor Generico" || $negociacion->asesorCerrador=="Asesor Generico" )
                      <p><span>Operación Compartida:</span> Si</p>
                      <p><span>Comisión por operación Compartida:</span> {{$negociacion->porcentajeCompartido}}%</p>
                    @else
                      <p><span>Operación Compartida:</span> No</p>
                    @endif
                    <p><span>Pago Casa Nacional:Bs</span> {{$negociacion->pagoCasaMatriz}}</p>
                    <p><span>Ingreso Neto Oficina:Bs</span> {{$negociacion->ingresoNeto}}</p>
                </div>
            </div>
          @endif
        <h2 class="titleSection">INFORMES</h2>
        <div class="reports">
            <div class="row">
                <div class="col-xs-9">
                    <div class="alert alertRed" role="alert">
                        <h5>Próximo informe debe ser enviando antes de: <span>{{$inmueble->proximoInforme}}</span></h5>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="buttons">
                        <button type="submit" class="btnYellow noMargin" id="newInforme">NUEVO</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 listReports">
                    <div class="alert alertGrayLight" role="alert">
                        <div class="row">
                            <div class="col-xs-3"><h5>Informe 1</h5></div>
                            <div class="col-xs-3"><h5>16/12/2012</h5></div>
                            <div class="col-xs-6">
                                <ul>
                                    <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                    <li><a href=""><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                    <li><button type="button" class="btnGraySmall">Enviar</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="alert alertGrayLight" role="alert">
                        <div class="row">
                            <div class="col-xs-3"><h5>Informe 1</h5></div>
                            <div class="col-xs-3"><h5>16/12/2012</h5></div>
                            <div class="col-xs-6">
                                <ul>
                                    <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                    <li><a href=""><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin/modals/reporte_modal')
@endsection
@section('js')
<script>
//////////////////////////////////////// Funcionalidad del mapa ////////////////////////////////////////////////////
  function initMap() {
    var oficina = {lat: 10.4745107, lng: -66.8626197};
    var propiedad = $('#positionPropiety').val();
    var ubicacion = oficina;
    if (propiedad!="") {
      var p=JSON.parse(propiedad);
      var ubicacion=p[0];
    }
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: ubicacion
    });
    var marker = new google.maps.Marker({
      position: ubicacion,
      map: map,
      draggable: false

    });
    google.maps.event.addListener(marker, 'dragend', function(){
      capturarMarcador(marker);
    });

  }
  function capturarMarcador(marker) {
    var markerLatLng = marker.getPosition();
    var position=JSON.stringify([{lat:markerLatLng.lat(),lng:markerLatLng.lng()}]);
    $('#positionPropiety').val(position);
  }
</script>
    <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG6RQhkoAPuKs-2VSCbNisZ0NQt5Qf3Co&callback=initMap">
   </script>
   <script type="text/javascript" src="{{ asset('js/admin/informes/informe.js') }}"></script>

@endSection
