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
                <label for="typePropiety">Tipo de Inmueble</label>
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
            <div class="col-xs-6">
              <label for="estatePropiety">Estado</label>
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
        </div>
        <div class="row">
            <div class="col-xs-6">
                <label for="cityPropiety">Ciudad</label>
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
            <div class="col-xs-6">
                <label for="namePropiety">Urbanización</label>
                <select id="namePropiety" name="namePropiety">
                    <option value="">Urbanización</option>
                    @foreach($urbanizaciones as $urbanizacion)
                      @if($urbanizacion->id ==  $propiedad->urbanizacion)
                        <option class="opcionUrbanizacion" value='{{$urbanizacion->id}}' selected> {{$urbanizacion->nombre}} </option>
                      @else
                        <option class="opcionUrbanizacion" value='{{$urbanizacion->id}}'> {{$urbanizacion->nombre}} </option>
                      @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" style="padding-top:30px">
            <div class="col-xs-12">
                <label for="addressPropiety">Dirección</label>
                <input type="text" maxlength="150" class="inputs inputsLight form-control" value='{{$propiedad->direccion}}' name="addressPropiety" id="addressPropiety" placeholder="Dirección del inmueble (Incluir ubicacion en el mapa)">
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
              <ul class="viewRadio">
                  <li><h6>Mostrar Mapa</h6></li>
                  @if($propiedad->mostrarMapa==1)
                    <li>
                        <div class="styled-input-single">
                            <input type="radio" name="visibleMapa" value="1" id="visibleMapaSi" checked="checked"/>
                            <label for="visibleMapaSi">Si</label>
                        </div>
                    </li>
                    <li>
                        <div class="styled-input-single">
                            <input type="radio" name="visibleMapa" value="0" id="visibleMapaNo" />
                            <label for="visibleMapaNo">No</label>
                        </div>
                    </li>
                  @else
                    <li>
                        <div class="styled-input-single">
                            <input type="radio" name="visibleMapa" value="1" id="visibleMapaSi" />
                            <label for="visibleMapaSi">Si</label>
                        </div>
                    </li>
                    <li>
                        <div class="styled-input-single">
                            <input type="radio" name="visibleMapa" value="0" id="visibleMapaNo" checked="checked"/>
                            <label for="visibleMapaNo">No</label>
                        </div>
                    </li>
                  @endif
              </ul>
          </div>
          <div class="col-xs-4">
              <div class="styled-input-single">
                @if($propiedad->destacado==1)
                  <input type="checkbox" name="destacado" value="1" checked="checked" id="checkbox-example-two" />
                @else
                  <input type="checkbox" name="destacado" value="1" id="checkbox-example-two" />
                @endif
                 <label for="checkbox-example-two">¿Inmueble Destacado?</label>
              </div>
          </div>
          <div class="col-xs-4">
              <ul class="viewRadio">
                  <li><h6>Precio visible</h6></li>
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
            <div class="col-xs-4">
                <label for="">Precio de Venta</label>
                <input type="number" min="0" maxlength="20" class="inputs inputsLight form-control" value='{{$propiedad->precio}}' name="pricePropiety" id="pricePropiety" placeholder="Precio">
            </div>
            <div class="col-xs-4">
                <label for="">Porcentaje de Captación</label>
                <input type="number" min="0" maxlength="11" max="100" class="inputs inputsLight form-control" value='{{$propiedad->porcentajeCaptacion}}' name="porcentajeCaptacion" id="porcentajeCaptacion" placeholder="Porcentaje">
            </div>
            <div class="col-xs-4">
              <label for="">Referencia Dolares</label>
              <input type="number" min="0" maxlength="20" class="inputs inputsLight form-control" value='{{$propiedad->referenciaDolares}}'  name="refDolares" id="refDolares" placeholder="Referencia en dolares">
            </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
              <label for="">Metros de Construcción</label>
              <input type="number" min="0" maxlength="11" class="inputs inputsLight form-control" value='{{$propiedad->metros_construccion}}' name="constructionPropiety" id="constructionPropiety" placeholder="Construcción (Mtr2)">
          </div>
          <div class="col-xs-6">
              <label for="">Metros de Terreno</label>
              <input type="number" min="0" maxlength="11" class="inputs inputsLight form-control" value='{{$propiedad->metros_terreno}}' name="areaPropiety" id="areaPropiety" placeholder="Terreno (Mtr2)">
          </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <label for="">Habitaciones</label>
                <input type="number" min="0" maxlength="11" class="inputs inputsLight form-control" value='{{$propiedad->habitaciones}}' id="roomPropiety"name="roomPropiety" placeholder="Habitaciones">
            </div>
            <div class="col-xs-4">
                <label for="">Baños</label>
                <input type="number" min="0" maxlength="11" class="inputs inputsLight form-control" value='{{$propiedad->banos}}' id="batroomPropiety" name="batroomPropiety" placeholder="Baños">
            </div>
            <div class="col-xs-4">
                <label for="">Puestos de Estacionamiento</label>
                <input type="number" min="0" maxlength="11" class="inputs inputsLight form-control" value='{{$propiedad->estacionamientos}}' id="parkingPropiety" name="parkingPropiety" placeholder="Estacionamiento (Cantidad de Puestos)">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <label for="">Descripcion del Inmueble</label>
                <textarea class="inputs inputsLight" maxlength="3000" id="descriptionPropiety" name="descriptionPropiety" placeholder="Descripción del inmueble">{{$propiedad->comentario}}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
              <label for="">Asesor Captador</label>
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
            <div class="col-xs-4">
              <label for="">Tipo de Negociación</label>
              <select name="typeBussisness" id="typeBussisness">
                  <option value="">Tipo de Negociación</option>
                  @if($propiedad->tipoNegocio=="Alquiler")
                    <option value="Alquiler" selected>Alquiler</option>
                    <option value="Venta">Venta</option>
                  @else
                    <option value="Alquiler">Alquiler</option>
                    <option value="Venta" selected>Venta</option>
                  @endif
              </select>
            </div>
            <div class="col-xs-4">
              <label for="">Estatus del Inmueble</label>
              <select name="estatusPropiedad" id="estatusPropiedad">
                  <option value="">Estatus</option>
                  @foreach($estatus as $seleccionado)
                    @if($seleccionado->id==$propiedad->estatus)
                      <option value="{{$propiedad->estatus}}" selected>{{$seleccionado->descripcionEstatus}}</option>
                    @else
                      <option value="{{$seleccionado->id}}">{{$seleccionado->descripcionEstatus}}</option>
                    @endif
                  @endforeach
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
