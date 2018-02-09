@extends('base')

@section('content')
    <!-- SHORTCUTS -->
    @include('common/carrucel')
    <section id="shortcuts">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="joinTeam">
                    <img src="{{asset('images/demo-unete.jpg')}}" alt="">
                    <div class="caption">
                        <a href="" data-toggle="modal" data-target="#modaljoinTeam"><p>UNETE A NUESTRO EQUIPO DE ASESORES</p></a>
                    </div>
                    @include('modals/modal')
                </div>
            </div>
            <div class="col-sm-4">
                <div class="publishHere">
                    <img src="{{asset('images/demo-public.jpg')}}" alt="">
                    <div class="caption">
                        <a href="" data-toggle="modal" data-target="#modalpublishHere">
                            <p><span>publica tu </span>propiedad</p>
                            <h2>aquí</h2>
                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                        </a>
                    </div>
                    @include('modals/modal2')
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- FEATURED PROJECTS -->
    @include('common/proyectosDestacados')
    <!-- FEATURED PROPERTIES -->
    <section id="featuredProperties">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="titleSection">Inmuebles destacados</h1>
            </div>
        </div>
        <div class="row">
            @foreach($inmuebles as $inmueble)
                <div class="col-sm-4">
                    @component('partials/inmueble')
                        @slot('type'){{$inmueble->tipoNegocio}} @endslot
                        @slot('precio')
                          @if($inmueble->visible==1)
                            <p><span>Bsf.:</span>{{$inmueble->precio}}<p>
                          @else
                            <p>Consultar Precio<p>
                          @endif
                        @endslot
                        @slot('titulo')
                          <h4><a href="{{ route('detalle_inmueble',$inmueble->id) }}">{{$inmueble->urbanizacion}}</a></h4>
                        @endslot
                        @slot('direccion'){{$inmueble->direccion}}@endslot
                        @slot('metros'){{$inmueble->metros_construccion}}@endslot
                        @slot('baños') {{$inmueble->banos}} @endslot
                        @slot('cuartos') {{$inmueble->habitaciones}}@endslot
                        @slot('estacionamientos') {{$inmueble->estacionamientos}} @endslot
                        @slot('img')/inmuebles/{{$inmueble->nombre_imagen}} @endslot
                    @endcomponent
                </div>
            @endforeach
      </div>
    </div>
    </section>
@endsection
