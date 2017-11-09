
@extends('base')

@section('content')
    <section id="featuredProjects">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="titleSection">Proyectos</h1>
                </div>
            </div>
            <div class="row">
                @for( $i = 0; $i < 12 ; $i++)
                    @component('partials/proyecto')
                        @slot('title') Flamingo Cerro Alto @endslot
                        @slot('zone') San Antonio de los Altos @endslot
                        @slot('img') img-demo.jpg @endslot
                        @slot('url') # @endslot
                    @endcomponent
                @endfor
            </div>
        </div>
    </section>
@endsection