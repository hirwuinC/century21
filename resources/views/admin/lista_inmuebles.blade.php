@extends('admin/base_admin')

@section('content')
    <h2 class="titleSection">inmuebles</h2>
    @include('admin/common/search_bar')
    <section>
        <div class="row">
            @for( $i = 0; $i < 12 ; $i++)
                @component('admin/partials/inmueble')
                    @slot('type') alquiler @endslot
                    @slot('price') 100.000.000 @endslot
                    @slot('residencia') Residencias Mohecastel @endslot
                    @slot('code') 831312 @endslot
                    @slot('img') img-demo.jpg @endslot
                    @slot('url') # @endslot
                @endcomponent
            @endfor
        </div>
    </section>
    @include('admin/modals/cambio_estatus')
@endsection

@section('js')
    <script>
        var redirectUrlDetalleInmueble = "{{route('admin_detalle_inmueble',1)}}";
        $('#detalleAction').on('click', function(){
            window.location.href = redirectUrlDetalleInmueble
        })
    </script>
@endSection