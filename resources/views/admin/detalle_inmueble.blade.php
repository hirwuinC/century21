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
                      {{$inmueble->id_mls}}
                    @endif
                  </p>
                  <p><span>Código Interno:</span> {{$inmueble->id}}</p>
                  <p><span>Estatus: {{$inmueble->descripcionEstatus}}</span></p>
                  <p><span>Tipo de Negociacion:</span> {{$inmueble->tipoNegocio}}</p>
                  <p><span>Tipo de Inmueble:</span> {{$inmueble->nombreTipo}}</p>
                  <p><span>Precio: Bs</span> {{number_format($inmueble->precio, 0, '', '.')}}</p>
                  <p><span>Habitaciones:</span> {{$inmueble->habitaciones}}</p>
                  <p><span>Baños:</span> {{$inmueble->banos}}</p>
                  <p><span>Puestos de Estacionamiento:</span> {{$inmueble->estacionamientos}}</p>
                  <p><span>Metros de Construcción:</span> {{number_format($inmueble->metros_construccion, 0, '', '.')}}</p>
              </div>
              <div class="col-xs-4">
                  <p><span>Metros de terreno:</span> {{number_format($inmueble->metros_terreno, 0, '', '.')}}</p>
                  <p><span>Estado:</span> {{$inmueble->nombre_estado}}</p>
                  <p><span>Ciudad:</span> {{$inmueble->nombre_ciudad}}</p>
                  <p><span>Urbanización:</span> {{$inmueble->nombreUrbanizacion}}</p>
                  <p><span>Asesor Captador:</span> {{$inmueble->fullname}}</p>
                  <p><span>Comisión de Captación:</span>
                    @if($inmueble->porcentajeCaptacion!='')
                      {{number_format($inmueble->porcentajeCaptacion, 1, ',', '.')}}%
                    @endif
                  </p>
                  <p><span>Referencia $: </span> {{number_format($inmueble->referenciaDolares, 0, '', '.')}}</p>
                  <p><span>Visitas Generadas:</span> {{$inmueble->visitas}}</p>
                  <p><span>Compradores Interesados:</span> {{$inmueble->compradorInteresado}}</p>
              </div>
              <div class="col-xs-4 cont-imagen">
                @if($inmueble->id_mls==0)
                  <img src="{{ asset('images/inmuebles')}}/{{$imagen->nombre}}" alt="">
                @else
                  <img src="{{$imagen->nombre}}" alt="">
                @endif
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
            <h2 class="titleSection">Ultima negociación</h2>
            <div class="row">
                <div class="col-xs-4">
                    <p><span>Estatus:</span> {{$negociacion->descripcionEstatus}}</p>
                    <p><span>Asesor Captador:</span> {{$negociacion->asesorCaptador}}</p>
                    <p><span>Asesor Cerrador:</span> {{$negociacion->asesorCerrador}}</p>
                    <p><span>Monto de Venta Final:</span>
                      @if($negociacion->precioFinal!='')
                        Bs{{number_format($negociacion->precioFinal, 0, '', '.')}}
                      @endif
                    </p>
                    <p><span>Comisión Cierre:</span>
                      @if($negociacion->porcentajeCierre!='')
                        {{number_format($negociacion->porcentajeCierre, 1, ',', '.')}}%
                      @endif
                    </p>
                </div>
                <div class="col-xs-4">
                    <p><span>Comisión Bruta: Bs</span>
                      @if($negociacion->comisionBruta!='')
                        {{number_format($negociacion->comisionBruta, 2, ',', '.')}}
                      @endif
                    </p>
                    @if($negociacion->asesorCaptador=="Asesor Generico" || $negociacion->asesorCerrador=="Asesor Generico" )
                      <p><span>Operación Compartida:</span> Si</p>
                      <p><span>Comisión por operación Compartida:</span> {{$negociacion->porcentajeCompartido}}%</p>
                    @else
                      <p><span>Operación Compartida:</span> No</p>
                    @endif
                    <p><span>Pago Casa Nacional:Bs</span>
                      @if($negociacion->pagoCasaMatriz!='')
                        {{number_format($negociacion->pagoCasaMatriz, 2, ',', '.')}}
                      @endif
                    </p>
                    <p><span>Ingreso Neto Oficina:Bs</span>
                      @if($negociacion->ingresoNeto!='')
                        {{number_format($negociacion->ingresoNeto, 2, ',', '.')}}
                      @endif
                    </p>
                </div>
            </div>
          @endif
        @if($usuario->rol_id==1 || $usuario->agente_id==$inmueble->agente_id)
          @if($inmueble->agente_id!=5)
              <h2 class="titleSection">INFORMES</h2>
              <div class="reports">
                  <div class="row">
                    @if($inmueble->estatus!=11)
                      @if($dia<-4)
                        <div class="col-xs-9">
                            <div class="alert alertGreen" role="alert">
                                <h5>Próximo informe debe ser enviando antes de: <span>{{$fecha}}</span></h5>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="buttons">
                                <button type="submit" class="btnYellow noMargin" id="newInforme">NUEVO</button>
                            </div>
                        </div>
                      @elseif($dia>-4 && $dia<=0)
                        <div class="col-xs-9">
                            <div class="alert alertOrange" role="alert">
                                <h5>Próximo informe debe ser enviando antes de: <span>{{$fecha}}</span></h5>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="buttons">
                                <button type="submit" class="btnYellow noMargin" id="newInforme">NUEVO</button>
                            </div>
                        </div>
                      @else
                        <div class="col-xs-9">
                            <div class="alert alertRed" role="alert">
                                <h5>Próximo informe debió ser enviando antes de: <span>{{$fecha}}</span></h5>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="buttons">
                                <button type="submit" class="btnYellow noMargin" id="newInforme">NUEVO</button>
                            </div>
                        </div>
                      @endif
                    @else
                      <div class="col-xs-12">
                          <div class="alert alertGreen" role="alert">
                              <Center><h5>INMUEBLE VENDIDO</h5></center>
                          </div>
                      </div>
                    @endif
                  </div>
                  <div class="row">
                      <div class="col-xs-12 listReports">
                        @foreach($informes as $informe)
                          <div class="alert alertGrayLight" role="alert">
                              <div class="row">
                                  <div class="col-xs-3"><h5>Informe {{$informe->id}}</h5></div>
                                  <div class="col-xs-3"><h5>{{ date("d-m-Y", strtotime($informe->fechaCreado))}}</h5></div>
                                  <div class="col-xs-6">
                                      <ul>
                                          <li><a href="/admin/previewInforme/{{$informe->id}}" target="_blank"><i class="fa fa-eye preview" aria-hidden="true"></i></a></li>
                                          @if($informe->estatusEnviado==0)
                                            <li><a href=""><i class="fa fa-pencil editInforme" data-id="{{$informe->id}}" aria-hidden="true"></i></a></li>
                                            <li><button type="button" data-id="{{$informe->id}}" class="btnGraySmall enviarInforme">Enviar</button></li>
                                          @endif
                                      </ul>
                                  </div>
                              </div>
                          </div>
                        @endforeach
                      </div>
                  </div>
              </div>
            @endif
        @endif

    @include('admin/modals/reporte_modal')
    @include('admin/modals/modificar_reporte_modal')
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
