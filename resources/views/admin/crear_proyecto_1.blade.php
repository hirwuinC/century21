@extends('admin/base_admin')

@section('content')

<h2 class="titleSection">información básica</h2>
<form enctype="multipart/form-data" name="proyectCreate" id="proyectCreate" class="agenteForm">
  {{csrf_field()}}
@if(count($datos)==0)
    <input type="hidden" id="positionPropiety" name="positionPropiety" value=''>
    <input type="hidden" name="register" value=''>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-4">
                  <select name="typeBussisness" id="typeBussisness" >
                      <option value="" selected >Tipo de Negociación</option>
                      <option value="alquiler">Alquiler</option>
                      <option value="venta">Venta</option>
                  </select>
                </div>
                <div class="col-xs-4">
                    <input type="text" class="inputs inputsLight form-control" name="nameProyect" id="nameProyect" value="" placeholder="Nombre del inmueble">
                </div>
                <div class="col-xs-4">
                    <div class="styled-input-single">
                      <input type="checkbox" name="destacado" value="1" id="checkbox-example-two" />
                      <label for="checkbox-example-two">¿Proyecto Destacado?</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                  <select id="estateProyect" name="estateProyect" >
                      <option value="" selected >Estado</option>
                      @foreach($estados as $estado)
                      <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-xs-6">
                    <select id="cityProyect" name="cityProyect">
                        <option value="">Ciudad</option>
                        <option class="opcion" value""> - </option>
                    </select>
                </div>
            </div>
            <div class="row" style="padding-top:30px">
                <div class="col-xs-12">
                    <input type="text" class="inputs inputsLight form-control" name="addressProyect" id="addressProyect" placeholder="Dirección del proyecto (Incluir ubicacion en el mapa)">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div id="map" class="googleMap">
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                  <input type="number" min="0" class="inputs inputsLight form-control" name="constructionProyect" id="constructionProyect" placeholder="Construcción (Mtr2)">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                  <label for="fechaEntrega">Fecha estimada de Culminación</label>
                  <input type="date" class="inputs inputsLight form-control" name="dateEnd" id="dateEnd">
              </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <textarea class="inputs inputsLight" id="descriptionProyect" name="descriptionProyect" placeholder="Descripción del proyecto"></textarea>
                </div>
            </div>
@else
<input type="hidden" id="positionPropiety" name="positionPropiety" value='{{$datos->posicionMapa}}'>
<input type="hidden" name="register" value='{{$datos->id}}'>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
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
            <div class="col-xs-4">
                <input type="text" class="inputs inputsLight form-control" name="nameProyect" id="nameProyect" value='{{$datos->nombreProyecto}}' placeholder="Nombre del inmueble">
            </div>
            <div class="col-xs-4">
                <div class="styled-input-single">
                  @if($datos->destacado==1)
                    <input type="checkbox" name="destacado" value="1" checked="checked" id="checkbox-example-two" />
                  @else
                    <input type="checkbox" name="destacado" value="1" id="checkbox-example-two" />
                  @endif
                   <label for="checkbox-example-two">¿Proyecto Destacado?</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
              <select id="estateProyect" name="estateProyect">
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
                <select id="cityProyect" name="cityProyect">
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
                <input type="text" class="inputs inputsLight form-control" value='{{$datos->direccionProyecto}}' name="addressProyect" id="addressProyect" placeholder="Dirección del proyecto (Incluir ubicacion en el mapa)">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div id="map" class="googleMap">
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
              <input type="number" class="inputs inputsLight form-control" value='{{$datos->metrosConstruccion}}' name="constructionProyect" id="constructionProyect" placeholder="Construcción (Mtr2)">
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
              <label for="fechaEntrega">Fecha estimada de Culminación</label>
              <input type="date" class="inputs inputsLight form-control" name="dateEnd" value="{{$datos->fechaEntrega}}" id="dateEnd">
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <textarea class="inputs inputsLight" id="descriptionProyect" name="descriptionProyect" placeholder="Descripción del proyecto">{{$datos->descripcionProyecto}}</textarea>
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
<script type="text/javascript" src="{{ asset('js/admin/proyectos/nuevoproyecto.js') }}"></script>
    <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG6RQhkoAPuKs-2VSCbNisZ0NQt5Qf3Co&callback=initMap">
   </script>

@endSection