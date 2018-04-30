@extends('admin/base_admin')

@section('content')
    <div class="contentDetail">
        <h2 class="titleSection">Detalle Del Proyecto</h2>
        <div class="row">
              <div class="col-xs-5">
                  <input type="hidden" id="positionPropiety" value="{{$proyecto->posicionMapa}}">
                  <p><span>Código:</span> {{$proyecto->id}}</p>
                  <p><span>Nombre del Proyecto:</span> {{$proyecto->nombreProyecto}}</p>
                  <p><span>Tipo de Negociacion:</span> {{$proyecto->tipoNegocio}}</p>
                  <p><span>Fecha estimada de Culminación: </span>{{date("d-m-Y", strtotime($proyecto->fechaEntrega))}}</p>
                  <p><span>Metros de Construcción:</span> {{ number_format($proyecto->metrosConstruccion, 2, ',', '.') }} Mts</p>
              </div>
              <div class="col-xs-3">
                  <p><span>Estado:</span> {{$proyecto->nombre_estado}}</p>
                  <p><span>Ciudad:</span> {{$proyecto->nombre_ciudad}}</p>
                  <p><span>Visitas:</span> {{$proyecto->visitas}}</p>
                  <p><span>Compradores Interesados:</span> {{$proyecto->compradorInteresado}}</p>
              </div>
              <div class="col-xs-4 cont-imagen">
                  <img src="{{ asset('images/proyectos')}}/{{$proyecto->nombre_imagen}}" alt="">
              </div>
          </div>
          <h2 class="titleSection">DESCRIPCIÓN DEL PROYECTO</h2>
          <div class="row">
              <div class="col-xs-12">
                  <p>{{$proyecto->descripcionProyecto}}</p>
              </div>
          </div>
          <h2 class="titleSection">DIRECCION EXACTA</h2>
          <div class="row">
              <div class="col-xs-12">
                  <p>{{$proyecto->direccionProyecto}}</p>
              </div>
          </div>
          <h2 class="titleSection">INMUEBLES ASOCIADOS</h2>
          <div class="infoDetailProperties">
            <div class="descriptionProperties">
              @foreach($inmuebles as $inmueble)
              <hr>
                <section class="characteristicsProperties">

                    <ul>
                        <li title="Tipo de Inmueble" class="tipoInmueble"><i class="fa fa-building-o" aria-hidden="true"></i> {{$inmueble->nombre_tipo}}</li>
                        <li title="Metros de Construcción"><i class="fa fa-object-group" aria-hidden="true"></i> {{$inmueble->metrosConstruccion}}</li>
                        <li title="Habitaciones"><i class="fa fa-bed" aria-hidden="true"></i> {{$inmueble->habitaciones}}</li>
                        <li title="Baños"><i class="fa fa-bath" aria-hidden="true"></i> {{$inmueble->banos}}</li>
                        <li title="Estacionamientos"><i class="fa fa-car" aria-hidden="true"></i> {{$inmueble->estacionamientos}}</li>
                        <li title="Precio" class="precioTipo"><p>BS. {{number_format($inmueble->precio, 2, ',', '.')}}</P></li>
                    </ul>
                    <p>{{$inmueble->descripcionInmueble}}</p>
                </section>
              @endforeach
            </div>
          </div>
        <h2 class="titleSection">UBICACIÓN DEL PROYECTO</h2>
        <div class="row">
            <div class="col-xs-12">
              <div id="map" class="googleMap">
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

@endSection
