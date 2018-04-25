@extends('admin/base_admin')

@section('content')
    <h2 class="titleSection">inmuebles</h2>
    @include('admin/common/search_bar')
    <section id="padre">
        <div class="row">
            @foreach($inmuebles as $inmueble)
                @component('admin/partials/inmueble')
                    @slot('type') {{$inmueble->tipoNegocio}} @endslot
                    @slot('price')
                      @if($inmueble->visible==1)
                        <span>Bs. </span>{{ number_format($inmueble->precio, 0, '', '.')}}
                      @else
                        Consultar Precio
                      @endif
                    @endslot
                    @slot('residencia')
                      {{$inmueble->nombreUrbanizacion}}
                    @endslot
                    @slot('tipoInmueble')
                      {{$inmueble->nombreInmueble}}
                    @endslot
                    @slot('codeMLS')
                      @if($inmueble->id_mls==0)
                        <span>No Aplica</span>
                      @else
                        {{$inmueble->id_mls}}
                      @endif
                    @endslot
                    @slot('code')
                      {{$inmueble->id}}
                    @endslot
                    @slot('asesor')
                      {{$inmueble->nombreAsesor}}
                    @endslot
                    @slot('img')
                      @if($inmueble->id_mls==0)
                        <img src="{{ asset('images/inmuebles')}}/{{$inmueble->nombre_imagen}}" alt="">
                      @else
                        <img src="{{$inmueble->nombre_imagen}}" alt="">
                      @endif
                    @endslot
                    @slot('editar')
                      @if($usuario->rol_id==1)
                        <a href="/admin/editar-inmueble1/{{$inmueble->id}}">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                      @endif
                    @endslot
                    @slot('eliminar')
                      @if($usuario->rol_id==1)
                        <a href="">
                            <i class="fa fa-trash" aria-hidden="true"></i>
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
          <center>{{ $inmuebles->links() }}</center>
        </div>
    </section>
    @include('admin/modals/cambio_estatus')
    @include('admin/modals/add_comprador')
@endsection

@section('js')
    <script>
        $('body').on('click','.detalleAction', function(){
          var parametro=$(this).parent().find('.id');
          var redirectUrlDetalleInmueble = "/admin/inmueble/"+parametro.val();
            window.location.href = redirectUrlDetalleInmueble;
        })
    </script>
    <script type="text/javascript" src="{{ asset('js/admin/propiedades/estatus.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/propiedades/buscadorInmueble.js') }}"></script>
@endSection
