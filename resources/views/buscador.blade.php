@extends('base')

@section('content')

@include('common/proyectosDestacados')

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

                    @for( $i = 0; $i< 10 ; $i++)
                        <div class="col-sm-6">
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
@endsection
