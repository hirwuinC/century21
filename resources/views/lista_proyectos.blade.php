
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
                @foreach($proyectos as $proyecto)
                    @component('partials/proyecto')
                        @slot('cantidad') 4 @endslot
                        @slot('title') {{$proyecto->nombreProyecto}} @endslot
                        @slot('zone') {{$proyecto->nombre_ciudad}} @endslot
                        @slot('img') {{$proyecto->nombre_imagen}} @endslot
                        @slot('url') {{$proyecto->id}} @endslot
                    @endcomponent
                @endforeach
            </div>
            <div class="row">
              <center>
                {{$proyectos->links()}}
              </center>
            </div>
        </div>
    </section>
@endsection
