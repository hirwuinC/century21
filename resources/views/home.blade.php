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
            @for( $i = 0; $i < 9; $i++)
                <div class="col-sm-4">
                    @component('partials/inmueble')
                        @slot('type') Alquiler @endslot
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
    </div>
    </section>
@endsection
