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
                    <h2>{{$inmueble->urbanizacion}}</h2>
                    <h3>{{$inmueble->direccion}}</h3>
                    <p>Propiedad ID: {{$inmueble->id}}</p>
                    <hr>
                    <div class="descriptionProperties">
                        <div class="characteristicsProperties">
                            <ul>
                                @if($inmueble->visible==0)
                                  <li><p>Consultar Precio</li>
                                @else
                                  <li><p>Bs. {{$inmueble->precio}}</li>
                                @endif
                                <li><i class="fa fa-object-group" aria-hidden="true"></i> {{$inmueble->metros_construccion}}</li>
                                <li><i class="fa fa-bed" aria-hidden="true"></i> {{$inmueble->habitaciones}}</li>
                                <li><i class="fa fa-bath" aria-hidden="true"></i> {{$inmueble->banos}}</li>
                                <li><i class="fa fa-car" aria-hidden="true"></i> {{$inmueble->estacionamientos}}</li>
                            </ul>
                        </div>
                        <p>{{$inmueble->comentario}}</p>
                    </div>
                </div>
                <div class="ubicationProperties">
                    <h1 class="titleSection">Ubicación</h1>
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="map" class="googleMap">
                            </div>
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
                        <form action="">
                            <div class="form-group">
                                <label for="name">Nombres</label>
                                <input type="text" class="form-control" id="name" placeholder="Nombres">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Apellidos</label>
                                <input type="text" class="form-control" id="lastname" placeholder="Apellidos">
                            </div>
                            <div class="form-group">
                                <label for="phone">teléfono</label>
                                <input type="text" class="form-control" id="phone" placeholder="+58 999 9999999">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="text" class="form-control" id="email" placeholder="ejemplo@ejemplo.com">
                            </div>
                            <div class="form-group">
                                <label>comentarios</label>
                                <textarea class="form-control"></textarea>
                            </div>
                            <button type="button" class="btnGray">ENVIAR</button>
                        </form>
                    </div>
                </div>
            </section>
            <!-- FEATURED PROPERTIES -->
            <section id="featuredProperties">
                <div class="row">
                    @for( $i = 0; $i< 3 ; $i++)
                        <div class="col-sm-12">
                            @component('partials/inmueble')
                                @slot('type')
                                    @if($i % 2) Venta @else Alquiler @endif
                                @endslot
                                @slot('precio') 100.000.000 @endslot
                                @slot('titulo') Residencias Mohecastel @endslot
                                @slot('direccion')  Avenida Eugenio Mendoza, La Castellana @endslot
                                @slot('metros')  120 @endslot
                                @slot('baños')  1 @endslot
                                @slot('cuartos')  2 @endslot
                                @slot('estacionamientos') 2 @endslot
                                @slot('img') img-demo.jpg @endslot
                            @endcomponent
                        </div>
                    @endfor
                </div>
            </section>
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
<script type="text/javascript" src="{{ asset('js/admin/propiedades/detalleinmueble.js') }}"></script>
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG6RQhkoAPuKs-2VSCbNisZ0NQt5Qf3Co&callback=initMap">
</script>

@endSection
