<section id="featuredProjects">
    <div class="row">
      @foreach($proyectos as $proyecto)
          @component('partials/proyecto')
              @slot('cantidad') 12 @endslot
              @slot('title') {{$proyecto->nombreProyecto}} @endslot
              @slot('zone') {{$proyecto->nombre_ciudad}} @endslot
              @slot('img') {{$proyecto->nombre_imagen}} @endslot
              @slot('url'){{$proyecto->id}}  @endslot
          @endcomponent
      @endforeach
    </div>
</section>
