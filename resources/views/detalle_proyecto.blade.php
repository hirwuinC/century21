@extends('base')

@section('content')
    <div class="container">
        <div class="row">
            <!-- GO CONTENT INFO -->
            <div class="col-xs-12 col-sm-8">
                <section class="detailProperties">
                  <div class="galleryProperties">
                      <div class="row">
                          <div class="col-lg-12">
                              <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                                  <!-- Wrapper for slides -->
                                  <div class="carousel-inner" role="listbox">
                                    @foreach($imagenes as $imagen)
                                    @if($imagen->vista==1)
                                        <div class="item active inmueble">
                                              <img src="{{ asset('images/proyectos')}}/{{$imagen ->nombre}}" alt="" class="img-responsive">
                                        </div>
                                      @else
                                        <div class="item inmueble">
                                            <img src="{{ asset('images/proyectos')}}/{{$imagen ->nombre}}" alt="" class="img-responsive">
                                        </div>
                                      @endif
                                    @endforeach
                                  </div>
                                  <!-- Controls
                                  <a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev">
                                      <i class="fa fa-chevron-left"></i>
                                      <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next">
                                      <i class="fa fa-chevron-right"></i>
                                      <span class="sr-only">Next</span>
                                  </a>-->
                                  <!-- Indicators -->
                                  <ol class="carousel-indicators visible-sm-block hidden-xs-block visible-md-block visible-lg-block">
                                    <input type="hidden" value="{{$contador=-1}}">
                                    @foreach($imagenes as $imagen)
                                      @if($imagen->vista==1)
                                        <li data-target="#carousel-custom" data-slide-to="{{$contador++}}" class="active">
                                            <img src="{{ asset('images/proyectos')}}/{{$imagen->nombre}}" alt="" class="img-responsive">
                                        </li>
                                      @else
                                        <li data-target="#carousel-custom" data-slide-to="{{$contador++}}">
                                            <img src="{{ asset('images/proyectos')}}/{{$imagen->nombre}}" alt="" class="img-responsive">
                                        </li>
                                      @endif
                                    @endforeach
                                  </ol>
                              </div>

                          </div>
                      </div>
                  </div>
                    <div class="infoDetailProperties" style="margin-top: 20px;">
                      <div class="row">
                        <h1 class="titleSection">Proyecto {{$proyecto->nombreProyecto}}</h1>
                        <div class="col-xs-6">
                            <input type="hidden" id="positionPropiety" value="{{$proyecto->posicionMapa}}">
                            <p><span>Código:</span> {{$proyecto->id}}</p>
                            <p><span>Nombre del Proyecto:</span> {{$proyecto->nombreProyecto}}</p>
                            <p><span>Tipo de Negociacion:</span> {{$proyecto->tipoNegocio}}</p>
                            <p><span>Estado:</span> {{$proyecto->nombre_estado}}</p>
                        </div>
                        <div class="col-xs-6">
                            <p><span>Ciudad:</span> {{$proyecto->nombre_ciudad}}</p>
                            <p><span>Fecha estimada de Culminación: </span>{{date("d-m-Y", strtotime($proyecto->fechaEntrega))}}</p>
                            <p><span>Metros de Construcción:</span> {{ number_format($proyecto->metrosConstruccion, 0, ',', '.') }} Mts</p>
                        </div>
                      </div>
                      <br>
                        <div class="row">
                          <div class="descriptionProperties">
                              <section class="genaralInfo">
                                  <h1 class="titleSection">Descripción del proyecto</h1>
                                  <p>{{$proyecto->descripcionProyecto}}</p>
                              </section>

                              <section class="characteristicsProperties">
                                  <h1 class="titleSection">Inmuebles asociados</h1>
                                  @foreach($inmueblesProyectos as $inmueble)
                                    <ul>
                                      <li title="Precio" class="precioTipo"><p>BS. {{number_format($inmueble->precio, 0, ',', '.')}}</P></li>
                                      <li title="Tipo de Inmueble" class="tipoInmueble"><i class="fa fa-building-o" aria-hidden="true"></i> {{$inmueble->nombre}}</li>
                                      <li title="Metros de Construcción"><i class="fa fa-object-group" aria-hidden="true"></i> {{$inmueble->metrosConstruccion}}</li>
                                      <li title="Habitaciones"><i class="fa fa-bed" aria-hidden="true"></i> {{$inmueble->habitaciones}}</li>
                                      <li title="Baños"><i class="fa fa-bath" aria-hidden="true"></i> {{$inmueble->banos}}</li>
                                      <li title="Estacionamientos"><i class="fa fa-car" aria-hidden="true"></i> {{$inmueble->estacionamientos}}</li>
                                    </ul>
                                  <p>{{$inmueble->descripcionInmueble}}</p>
                                @endforeach
                              </section>
                              <hr>
                          </div>
                        </div>
                    </div>
                    <h2 class="titleSection">UBICACIÓN DEL PROYECTO</h2>
                    <div class="row">
                        <div class="col-xs-12">
                          <div id="map" class="googleMap">
                          </div>
                        </div>
                    </div>
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
                            <form id="compradorInteresadoProyecto" enctype="multipart/form-data" class="form">
                                <input type="hidden" name="registro" value="{{$proyecto->id}}">
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
                                    <textarea class="form-control" id="comentario" name="comentario">Me gustaría obtener información del proyecto #{{$proyecto->id}}</textarea>
                                </div>
                                <button type="submit" class="btnGray">ENVIAR</button>
                            </form>
                        </div>
                    </div>
                </section>
                @include('common/proyectosLaterales')
                @include('common/inmueblesLaterales')
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
  <script type="text/javascript" src="{{ asset('js/detalleproyecto.js') }}"></script>
@endsection
