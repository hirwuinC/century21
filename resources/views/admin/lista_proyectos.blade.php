@extends('admin/base_admin')

@section('content')
    <h2 class="titleSection">Proyectos</h2>
    @include('admin/common/search_bar')
    <section>
        <div class="row">
            @foreach($proyectos as $proyecto)
                @component('admin/partials/proyecto')
                    @slot('type') {{$proyecto->tipoNegocio}} @endslot
                    @slot('residencia'){{$proyecto->nombreProyecto}} @endslot
                    @slot('code')
                        <span>{{$proyecto->id}}</span>
                    @endslot
                    @slot('img') /proyectos/{{$proyecto->nombre_imagen}} @endslot
                    @slot('editar')
                        <a href="/admin/editar-proyectos-1/{{$proyecto->id}}">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                    @endslot
                    @slot('id'){{$proyecto->id}}@endslot
                @endcomponent
            @endforeach
        </div>
        <div class="row">
          {{ $proyectos->links() }}
        </div>
    </section>
@endsection

@section('js')
    <script>
        $('.detalleAction').on('click', function(){
          var parametro=$(this).parent().find('.id');
          var redirectUrlDetalleInmueble = "/admin/proyecto/"+parametro.val();
            window.location.href = redirectUrlDetalleInmueble;
        })
    </script>
@endSection
