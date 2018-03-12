@extends('admin/base_admin')

@section('content')
    <h2 class="titleSection">inmuebles</h2>
    @include('admin/common/search_bar')
    <section>
        <div class="row">
            @foreach($inmuebles as $inmueble)
                @component('admin/partials/inmueble')
                    @slot('type') {{$inmueble->tipoNegocio}} @endslot
                    @slot('price')
                      @if($inmueble->visible==1)
                        <span>Bsf.:</span>{{$inmueble->precio}}
                      @else
                        Consultar Precio
                      @endif
                    @endslot
                    @slot('residencia'){{$inmueble->urbanizacion}} @endslot
                    @slot('code')
                      @if($inmueble->id_mls==0)
                        <span>No Aplica</span>
                      @else
                        {{$inmueble->id_mls}}
                      @endif
                    @endslot
                    @slot('img') /inmuebles/{{$inmueble->nombre_imagen}} @endslot
                    @slot('editar')
                      @if($usuario->rol_id==1)
                        <a href="/admin/editar-inmueble1/{{$inmueble->id}}">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                      @endif
                    @endslot
                    @slot('cambioEstatus')
                      @if($usuario->rol_id==1)
                        <button type="button" class="btnAcction cambioEstatus"  >
                            Cambiar Estatus
                        </button>
                      @endif
                    @endslot
                    @slot('id'){{$inmueble->id}}@endslot
                @endcomponent
            @endforeach
        </div>
        <div class="row">
          {{ $inmuebles->links() }}
        </div>
    </section>
    @include('admin/modals/cambio_estatus')
@endsection

@section('js')
    <script>
        $('.detalleAction').on('click', function(){
          var parametro=$(this).parent().find('.id');
          var redirectUrlDetalleInmueble = "/admin/inmueble/"+parametro.val();
            window.location.href = redirectUrlDetalleInmueble;
        })
    </script>
    <script type="text/javascript" src="{{ asset('js/admin/propiedades/estatus.js') }}"></script>
@endSection
