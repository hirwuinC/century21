@extends('base')

@section('content')


<div class="container">
    <div class="row">
        <!-- GO CONTENT SIDEBAR -->
        <div class="col-xs-12 col-sm-4">
            @include('common/filtros')
        </div>
        <!-- END CONTENT SIDEBAR -->
        <!-- GO CONTENT INFO -->
        <div class="col-xs-12 col-sm-8">
            <!-- FEATURED PROPERTIES -->
            <section id="featuredProperties">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="titleSection">Inmuebles destacados</h1><span class="totalizador">{{$inmuebles->total()}}</span></h2>
                    </div>
                </div>
                <div class="row">
                    @foreach( $inmuebles as $inmueble)
                      <a href="{{ route('detalle_inmueble',$inmueble->id) }}">
                        <div class="col-sm-6">
                            @component('partials/inmueble')
                                @slot('type')
                                    {{$inmueble->tipoNegocio}}
                                @endslot
                                @slot('precio')
                                  @if($inmueble->visible==1)
                                    <p><span>Bs. </span>{{number_format($inmueble->precio, 0, '', '.')}}<p>
                                  @else
                                    <p>Consultar Precio<p>
                                @endif
                                @endslot
                                @slot('titulo')
                                  <h4><a href="{{ route('detalle_inmueble',$inmueble->id) }}">{{$inmueble->nombreInmueble}}</a></h4>
                                @endslot
                                @slot('direccion')
                                  {{$inmueble->nombreCiudad}}
                                @endslot
                                @slot('metros') {{$inmueble->metros_construccion}} @endslot
                                @slot('baños')  {{$inmueble->banos}}  @endslot
                                @slot('cuartos')  {{$inmueble->habitaciones}} @endslot
                                @slot('estacionamientos'){{$inmueble->estacionamientos}} @endslot
                                @slot('img')
                                    <img src="{{$inmueble->nombre_imagen}}" alt="">                      
                                @endslot
                            @endcomponent
                        </div>
                      </a>
                    @endforeach
                </div>
                <div class="row">
                  <center>
                    {{$inmuebles->links()}}
                  </center>
                </div>
            </section>
        </div>
        <!-- END CONTENT INFO -->
    </div>
</div>


@endsection

@section('js')
    <script >
        $(document).ready(function () {
            $('.select-2').select2({
                placeholder: 'Seleccionar',
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/buscadorInmueblePublico.js') }}"></script>
@endsection
