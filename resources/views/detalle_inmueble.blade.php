@extends('base')

@section('content')

<div class="container">
    <div class="row">
        <!-- GO CONTENT INFO -->
        <div class="col-xs-12 col-sm-8">
            <section class="detailProperties">
                @include('common/galeria')
                <div class="infoDetailProperties">
                    <input type="hidden" id="positionPropiety"value="{{$inmueble->posicionMapa}}">
                    <h2>{{$inmueble->nombre_tipo}}</h2>
                    <p>{{$inmueble->nombre_estado}}</p>
                    <p>{{$inmueble->nombre_ciudad}}</p>
                    <p>{{ucwords(mb_strtolower($inmueble->nombre_urbanizacion))}}</p>
                    <p>ID: {{ $inmueble->id}}</p>
                    <p>MLS ID: {{ $inmueble->id_mls}}</p>
                    <hr>
                    <div class="descriptionProperties">
                        <div class="characteristicsProperties">
                            <ul>
                                @if($inmueble->visible==0)
                                  <li><p>Consultar Precio</li>
                                @else
                                  <li><p>Bs. {{number_format($inmueble->precio, 0, '', '.')}}</li>
                                @endif
                                <li title="Metros de Construccion" ><i class="fa fa-object-group" aria-hidden="true"></i> {{$inmueble->metros_construccion}} <span>Mts</span></li>
                                <li title="Habitaciones"><i class="fa fa-bed" aria-hidden="true"></i> {{$inmueble->habitaciones}}</li>
                                <li title="Baños"><i class="fa fa-bath" aria-hidden="true"></i> {{$inmueble->banos}}</li>
                                <li title="Estacionamientos"><i class="fa fa-car" aria-hidden="true"></i> {{$inmueble->estacionamientos}}</li>
                            </ul>
                        </div>
                        <p>{{$inmueble->comentario}}</p>
                    </div>
                </div>
                @if($inmueble->mostrarMapa==1)
                  <div class="ubicationProperties">
                      <h1 class="titleSection">Ubicación</h1>
                      <div class="row">
                          <div class="col-xs-12">
                              <div id="map" class="googleMap">
                              </div>
                          </div>
                      </div>
                  </div>
                @endif
            </section>
        </div>
        <!-- END CONTENT INFO -->
        <!-- GO CONTENT SIDEBAR -->
        <div class="col-xs-12 col-sm-4">
            <!-- FORM ADVISERS -->
            <section class="contactAdviser">
                <div class="row">
                    <div class="col-sm-12">
                        <h3>CONTACTA A NUESTROS ASESORES</h3>
                        <form id="compradorInteresado" enctype="multipart/form-data" class="form">
                            <input type="hidden" name="registro" value="{{$inmueble->id}}">
                            <input type="hidden" name="mls" value="{{$inmueble->id_mls}}">
                            <div class="form-group">
                                <label for="name">Nombres</label>
                                <input type="text" class="form-control limpiar" id="nombreInteresado" name="nombreInteresado" placeholder="Nombres">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Apellidos</label>
                                <input type="text" class="form-control limpiar" id="apellidoInteresado" name="apellidoInteresado" placeholder="Apellidos">
                            </div>
                            <div class="form-group">
                                <label for="phone">teléfono</label>
                                <input type="text" class="form-control limpiar" id="phoneInteresado" name="phoneInteresado" placeholder="+58 999 9999999">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="text" class="form-control limpiar" id="emailInteresado"  name="emailInteresado" placeholder="ejemplo@ejemplo.com">
                            </div>
                            <div class="form-group">
                                <label>comentarios</label>
                                <textarea class="form-control" id="comentario" name="comentario">Me gustaría obtener información de la propiedad #{{$inmueble->id}}</textarea>
                            </div>
                            <button type="submit" class="btnGray">ENVIAR</button>
                        </form>
                    </div>
                </div>
            </section>
            <!-- FEATURED PROPERTIES -->
            @include('common/inmueblesLaterales')
        </div>
        <!-- END CONTENT SIDEBAR -->
    </div>
</div>
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
      map: map

    });
  }
</script>
<script type="text/javascript" src="{{ asset('js/detalleinmueble.js') }}"></script>
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG6RQhkoAPuKs-2VSCbNisZ0NQt5Qf3Co&callback=initMap">
</script>

@endSection
