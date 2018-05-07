@extends('base')

@section('content')
<div class="container">
    <div class="row">
        <!-- GO CONTENT INFO -->
        <div class="col-xs-12 col-sm-8">
            <h1 class="titleSection">Contactanos</h1>
            <section class="detailProperties">
                <form id="contactanos" class="contactForm">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="name">Nombres</label>
                                <input type="text" class="form-control limpiar" id="nombreInteresado" name="nombreInteresado" placeholder="Nombres">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="lastname">Apellidos</label>
                                <input type="text" class="form-control limpiar" id="apellidoInteresado" name="apellidoInteresado" placeholder="Apellidos">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="phone">teléfono</label>
                                <input type="text" class="form-control limpiar" id="phoneInteresado" name="phoneInteresado" placeholder="+58 999 9999999">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="text" class="form-control limpiar" id="emailInteresado"  name="emailInteresado" placeholder="ejemplo@ejemplo.com">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>comentarios</label>
                                <textarea class="form-control limpiar" id="comentario" name="comentario"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                            <button type="submit" class="btnYellow">ENVIAR</button>
                        </div>
                    </div>
                </form>
                <div class="ubicationProperties">
                  <h1 class="titleSection">OFICINA</h1>
                  <p><span>Direccion: </span>Urbanización San Luis del Cafetal, Torre Mayupan, Piso 7, Oficina 702. Caracas, Municipio Baruta, Estado Miranda. Código postal 1060.</p>
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="map" class="googleMap">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-xs-12 col-sm-4">
            @include('common/proyectosLaterales')
            @include('common/inmueblesLaterales')
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
//////////////////////////////////////// Funcionalidad del mapa ////////////////////////////////////////////////////
  function initMap() {
    var oficina = {lat: 10.4684443, lng: -66.8460197};
    var ubicacion = oficina;
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: ubicacion
    });
    var marker = new google.maps.Marker({
      position: ubicacion,
      map: map

    });
  }
</script>
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG6RQhkoAPuKs-2VSCbNisZ0NQt5Qf3Co&callback=initMap">
</script>
  <script type="text/javascript" src="{{ asset('js/contacto.js') }}"></script>
@endsection
