@extends('admin/base_admin')

@section('content')

<h2 class="titleSection">información básica</h2>
<form enctype="multipart/form-data" name="propietyEdit" id="propietyEdit" class="agenteForm">
  {{csrf_field()}}
<input type="hidden" id="positionPropiety" name="positionPropiety" value='{{$propiedad->posicionMapa}}'>
<input type="hidden" id="register" name="register" value='{{$propiedad->id}}'>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <input type="text" class="inputs inputsLight form-control" name="namePropiety" id="namePropiety" value='{{$propiedad->urbanizacion}}' placeholder="Nombre del inmueble">
            </div>
            <div class="col-xs-6">
                <select class="" name="typePropiety" id="typePropiety">
                    <option value="" >Tipo de inmueble</option>
                    @foreach ($tiposIn as $tipo)
                      @if($tipo->id == $propiedad->tipo_inmueble)
                        <option value='{{$propiedad->tipo_inmueble}}' selected>{{ $tipo->nombre}}</option>
                      @else
                        <option value='{{ $tipo->id }}'>{{ $tipo->nombre }}</option>
                      @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
              <select id="estatePropiety" name="estatePropiety">
                  <option value="" >Estado</option>
                  @foreach($estados as $estado)
                    @if($estado->id == $propiedad->estado_id)
                      <option value='{{$propiedad->estado_id}}' selected>{{$estado->nombre}}</option>
                    @else
                      <option value='{{ $estado->id }}'>{{$estado->nombre}}</option>
                    @endif
                  @endforeach
              </select>
            </div>
            <div class="col-xs-6">
                <select id="cityPropiety" name="cityPropiety">
                    <option value="">Ciudad</option>
                    @foreach($consulta as $ciudad)
                      @if($ciudad->id == $propiedad->ciudad_id)
                        <option class="opcion" value='{{$propiedad->ciudad_id}}' selected> {{$ciudad->nombre}} </option>
                      @else
                        <option class="opcion" value='{{$ciudad->id}}'> {{$ciudad->nombre}} </option>
                      @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" style="padding-top:30px">
            <div class="col-xs-12">
                <input type="text" class="inputs inputsLight form-control" value='{{$propiedad->direccion}}' name="addressPropiety" id="addressPropiety" placeholder="Dirección del inmueble (Incluir ubicacion en el mapa)">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div id="map" class="googleMap">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <input type="number" class="inputs inputsLight form-control" value='{{$propiedad->precio}}' name="pricePropiety" id="pricePropiety" placeholder="Precio">
            </div>
            <div class="col-xs-6">
                <ul class="viewRadio">
                    <li><h6>Visible</h6></li>
                    @if($propiedad->visible==1)
                      <li>
                          <div class="styled-input-single">
                              <input type="radio" name="visiblePrice" value="1" id="radio-example-one" checked="checked"/>
                              <label for="radio-example-one">Si</label>
                          </div>
                      </li>
                      <li>
                          <div class="styled-input-single">
                              <input type="radio" name="visiblePrice" value="0" id="radio-example-two" />
                              <label for="radio-example-two">No</label>
                          </div>
                      </li>
                    @else
                      <li>
                          <div class="styled-input-single">
                              <input type="radio" name="visiblePrice" value="1" id="radio-example-one" />
                              <label for="radio-example-one">Si</label>
                          </div>
                      </li>
                      <li>
                          <div class="styled-input-single">
                              <input type="radio" name="visiblePrice" value="0" id="radio-example-two" checked="checked"/>
                              <label for="radio-example-two">No</label>
                          </div>
                      </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
              <input type="number" class="inputs inputsLight form-control" value='{{$propiedad->metros_construccion}}' name="constructionPropiety" id="constructionPropiety" placeholder="Construcción (Mtr2)">
          </div>
          <div class="col-xs-6">
              <input type="number" class="inputs inputsLight form-control" value='{{$propiedad->metros_terreno}}' name="areaPropiety" id="areaPropiety" placeholder="Terreno (Mtr2)">
          </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <input type="number" class="inputs inputsLight form-control" value='{{$propiedad->habitaciones}}' id="roomPropiety"name="roomPropiety" placeholder="Habitaciones">
            </div>
            <div class="col-xs-4">
                <input type="number" class="inputs inputsLight form-control" value='{{$propiedad->banos}}' id="batroomPropiety" name="batroomPropiety" placeholder="Baños">
            </div>
            <div class="col-xs-4">
                <input type="number" class="inputs inputsLight form-control" value='{{$propiedad->estacionamientos}}' id="parkingPropiety" name="parkingPropiety" placeholder="Estacionamiento (Cantidad de Puestos)">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <textarea class="inputs inputsLight" id="descriptionPropiety" name="descriptionPropiety" placeholder="Descripción del inmueble">{{$propiedad->comentario}}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
              <select name="asesorPropiety" id="asesorPropiety">
                  <option value="">Asesor</option>
                  @foreach($asesores as $asesor)
                    @if($asesor->id==$propiedad->agente_id)
                      <option value='{{$propiedad->agente_id}}' selected>{{$asesor->fullName}}</option>
                    @else
                      <option value='{{$asesor->id}}'>{{$asesor->fullName}}</option>
                    @endif
                  @endforeach
              </select>
            </div>
            <div class="col-xs-6">
              <select name="typeBussisness" id="typeBussisness">
                  <option value="">Tipo de Negociación</option>
                  @if($propiedad->tipoNegocio=="alquiler")
                    <option value="alquiler" selected>Alquiler</option>
                    <option value="venta">Venta</option>
                  @else
                    <option value="alquiler">Alquiler</option>
                    <option value="venta" selected>Venta</option>
                  @endif
              </select>
            </div>
        </div>
        <div class="row">
          <div class="buttons">
              <div class="col-xs-3 right">
                  <button id="redirectButtomAction" type="submit" class="btnYellow">Siguiente</button>
              </div>
          </div>
        </div>
        </div>
    </div>
</form>
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
      console.log(p[0]);
      var ubicacion=p[0];
    }
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: ubicacion
    });
    var marker = new google.maps.Marker({
      position: ubicacion,
      map: map,
      draggable: true,
      title: 'Ubica el inmueble'
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
<script type="text/javascript" src="{{ asset('js/admin/propiedades/editarinmueble.js') }}"></script>
    <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG6RQhkoAPuKs-2VSCbNisZ0NQt5Qf3Co&callback=initMap">
   </script>

@endSection