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
                        <h1 class="titleSection">Inmuebles destacados</h1>
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
                                  @if($inmueble->id_mls==0)
                                    <img src="{{ asset('images/inmuebles')}}/{{$inmueble ->nombre_imagen}}" alt="">
                                  @else
                                    <img src="{{$inmueble->nombre_imagen}}" alt="">
                                  @endif
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

            var url = new URL(window.location.href);
            var p1 = JSON.parse(url.searchParams.get("type")).split(',');
            console.log(p1);
            $('select[name=tipo]').val(p1).trigger("change");

            var p2 = JSON.parse(url.searchParams.get("propiedad")).split(',');
            $('select[name=propiedad]').val(p2).trigger("change");
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/buscadorInmueblePublico.js') }}"></script>
@endsection
