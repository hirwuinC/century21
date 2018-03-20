@extends('admin/base_admin')

@section('content')

<h2 class="titleSection">información básica</h2>
<form enctype="multipart/form-data" name="propietyCreate" id="propietyCreate" class="agenteForm">
  {{csrf_field()}}
@if(count($datos)==0)
    <input type="hidden" id="positionPropiety" name="positionPropiety" value=''>
    <input type="hidden" name="register" value=''>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                    <label for="">Urbanización</label>
                    <input type="text" class="inputs inputsLight form-control" name="namePropiety" id="namePropiety" value="" placeholder="urbanización">
                </div>
                <div class="col-xs-6">
                    <label for="">Tipo de Inmueble</label>
                    <select class="" name="typePropiety" id="typePropiety">
                        <option value="" selected >Tipo de inmueble</option>
                        @foreach ($tiposIn as $tipo)

                            <option value="{{ $tipo->id }}">{{ $tipo->nombre}}</option>

                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                  <label for="">Estado</label>
                  <select id="estatePropiety" name="estatePropiety">
                      <option value="" selected >Estado</option>
                      @foreach($estados as $estado)
                      <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-xs-6">
                    <label for="">Ciudad</label>
                    <select id="cityPropiety" name="cityPropiety">
                        <option value="">Ciudad</option>
                        <option class="opcion" value""> - </option>
                    </select>
                </div>
            </div>
            <div class="row" style="padding-top:30px">
                <div class="col-xs-12">
                    <label for="">Dirección del inmueble</label>
                    <input type="text" class="inputs inputsLight form-control" name="addressPropiety" id="addressPropiety" placeholder="Dirección del inmueble (Incluir ubicacion en el mapa)">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div id="map" class="googleMap">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <label for="">Precio de Venta</label>
                    <input type="number" min="0" class="inputs inputsLight form-control" name="pricePropiety" id="pricePropiety" placeholder="Precio">
                </div>
                <div class="col-xs-4">
                    <ul class="viewRadio">
                        <li><h6>Precio visible</h6></li>
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
                    </ul>
                </div>
                <div class="col-xs-4">
                    <div class="styled-input-single">
                        <input type="checkbox" name="destacado" value="1" id="checkbox-example-two" />
                       <label for="checkbox-example-two">¿Inmueble Destacado?</label>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                  <label for="">Metros de Construccion</label>
                  <input type="number" min="0" class="inputs inputsLight form-control" name="constructionPropiety" id="constructionPropiety" placeholder="Construcción (Mtr2)">
              </div>
              <div class="col-xs-6">
                  <label for="">Metros de terreno</label>
                  <input type="number" min="0" class="inputs inputsLight form-control" name="areaPropiety" id="areaPropiety" placeholder="Terreno (Mtr2)">
              </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <label for="">Cantidad de habitaciones</label>
                    <input type="number" min="0" class="inputs inputsLight form-control" id="roomPropiety"name="roomPropiety" placeholder="Habitaciones">
                </div>
                <div class="col-xs-4">
                    <label for="">Cantidad de baños</label>
                    <input type="number" min="0" class="inputs inputsLight form-control" id="batroomPropiety" name="batroomPropiety" placeholder="Baños">
                </div>
                <div class="col-xs-4">
                    <label for="">Cantidad de estacionamientos</label>
                    <input type="number" min="0" class="inputs inputsLight form-control" id="parkingPropiety" name="parkingPropiety" placeholder="Estacionamiento (Cantidad de Puestos)">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <label for="">Comentarios sobre el inmueble</label>
                    <textarea class="inputs inputsLight" id="descriptionPropiety" name="descriptionPropiety" placeholder="Descripción del inmueble"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                  <label for="">Asesor Captador</label>
                  <select name="asesorPropiety" id="asesorPropiety">
                      <option value="" selected >Asesor</option>
                      @foreach($asesores as $asesor)
                      <option value="{{$asesor->id}}">{{$asesor->fullName}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-xs-6">
                  <label for="">Tipo de Negociación</label>
                  <select name="typeBussisness" id="typeBussisness">
                      <option value="" selected >Seleccione una opción</option>
                      <option value="alquiler">Alquiler</option>
                      <option value="venta">Venta</option>
                  </select>
                </div>
            </div>
@else
<input type="hidden" id="positionPropiety" name="positionPropiety" value='{{$datos->posicionMapa}}'>
<input type="hidden" name="register" value='{{$datos->id}}'>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <label for="">Urbanización</label>
                <input type="text" class="inputs inputsLight form-control" name="namePropiety" id="namePropiety" value='{{$datos->urbanizacion}}' placeholder="Urbanización">
            </div>
            <div class="col-xs-6">
                <label for="">Tipo de Inmueble</label>
                <select class="" name="typePropiety" id="typePropiety">
                    <option value="" >Tipo de inmueble</option>
                    @foreach ($tiposIn as $tipo)
                      @if($tipo->id == $datos->tipo_inmueble)
                        <option value='{{$datos->tipo_inmueble}}' selected>{{ $tipo->nombre}}</option>
                      @else
                        <option value='{{ $tipo->id }}'>{{ $tipo->nombre }}</option>
                      @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
              <label for="">Estado</label>
              <select id="estatePropiety" name="estatePropiety">
                  <option value="" >Estado</option>
                  @foreach($estados as $estado)
                    @if($estado->id == $datos->estado_id)
                      <option value='{{$datos->estado_id}}' selected>{{$estado->nombre}}</option>
                    @else
                      <option value='{{ $estado->id }}'>{{$estado->nombre}}</option>
                    @endif
                  @endforeach
              </select>
            </div>
            <div class="col-xs-6">
                <label for="">Ciudad</label>
                <select id="cityPropiety" name="cityPropiety">
                    <option value="">Ciudad</option>
                    @foreach($consulta as $ciudad)
                      @if($ciudad->id ==  $datos->ciudad_id)
                        <option class="opcion" value='{{$datos->ciudad_id}}' selected> {{$ciudad->nombre}} </option>
                      @else
                        <option class="opcion" value='{{$ciudad->id}}'> {{$ciudad->nombre}} </option>
                      @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" style="padding-top:30px">
            <div class="col-xs-12">
                <label for="">Dirección</label>
                <input type="text" class="inputs inputsLight form-control" value='{{$datos->direccion}}' name="addressPropiety" id="addressPropiety" placeholder="Dirección del inmueble (Incluir ubicacion en el mapa)">
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
                <label for="">Ciudad</label>
                <input type="number" min="0" class="inputs inputsLight form-control" value='{{$datos->precio}}' name="pricePropiety" id="pricePropiety" placeholder="Precio">
            </div>
            <div class="col-xs-6">
                <ul class="viewRadio">
                    <li><h6>Precio visible</h6></li>
                    @if($datos->visible==1)
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
            <div class="col-xs-6">
                <div class="styled-input-single">
                  @if($datos->destacado==1)
                    <input type="checkbox" name="destacado" value="1" checked="checked" id="checkbox-example-two" />
                  @else
                    <input type="checkbox" name="destacado" value="1" id="checkbox-example-two" />
                  @endif
                   <label for="checkbox-example-two">¿Inmueble Destacado?</label>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
              <label for="">Metros de Construcción</label>
              <input type="number" min="0" class="inputs inputsLight form-control" value='{{$datos->metros_construccion}}' name="constructionPropiety" id="constructionPropiety" placeholder="Construcción (Mtr2)">
          </div>
          <div class="col-xs-6">
              <label for="">Metros de Terreno</label>
              <input type="number" min="0" class="inputs inputsLight form-control" value='{{$datos->metros_terreno}}' name="areaPropiety" id="areaPropiety" placeholder="Terreno (Mtr2)">
          </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <label for="">Cantidad de Habitaciones</label>
                <input type="number" min="0" class="inputs inputsLight form-control" value='{{$datos->habitaciones}}' id="roomPropiety"name="roomPropiety" placeholder="Habitaciones">
            </div>
            <div class="col-xs-4">
                <label for="">Cantidad de Baños</label>
                <input type="number" min="0" class="inputs inputsLight form-control" value='{{$datos->banos}}' id="batroomPropiety" name="batroomPropiety" placeholder="Baños">
            </div>
            <div class="col-xs-4">
                <label for="">Cantidad de Estacionamientos</label>
                <input type="number" min="0" class="inputs inputsLight form-control" value='{{$datos->estacionamientos}}' id="parkingPropiety" name="parkingPropiety" placeholder="Estacionamiento (Cantidad de Puestos)">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <label for="">Caracteristicas de la Propiedad</label>
                <textarea class="inputs inputsLight" id="descriptionPropiety" name="descriptionPropiety" placeholder="Descripción del inmueble">{{$datos->comentario}}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
              <label for="">AsesorCaptador</label>
              <select name="asesorPropiety" id="asesorPropiety">
                  <option value="">Asesor</option>
                  @foreach($asesores as $asesor)
                    @if($asesor->id==$datos->agente_id)
                      <option value='{{$datos->agente_id}}' selected>{{$asesor->fullName}}</option>
                    @else
                      <option value='{{$asesor->id}}'>{{$asesor->fullName}}</option>
                    @endif
                  @endforeach
              </select>
            </div>
            <div class="col-xs-6">
              <label for="">Tipo de Negociación</label>
              <select name="typeBussisness" id="typeBussisness">
                  <option value="">Tipo de Negociación</option>
                  @if($datos->tipoNegocio=="alquiler")
                    <option value="alquiler" selected>Alquiler</option>
                    <option value="venta">Venta</option>
                  @else
                    <option value="alquiler">Alquiler</option>
                    <option value="venta" selected>Venta</option>
                  @endif
              </select>
            </div>
        </div>
@endif
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
<script type="text/javascript" src="{{ asset('js/admin/propiedades/nuevoinmueble.js') }}"></script>
    <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG6RQhkoAPuKs-2VSCbNisZ0NQt5Qf3Co&callback=initMap">
   </script>

@endSection
