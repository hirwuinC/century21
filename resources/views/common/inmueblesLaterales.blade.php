<section id="featuredProperties">
    <div class="row">
      @foreach($inmuebles as $inmueble)
        <div class="col-sm-12">
              <a href="{{ route('detalle_inmueble',$inmueble->id) }}">
                  <div class="col-sm-12">
                      @component('partials/inmueble')
                          @slot('type'){{$inmueble->tipoNegocio}} @endslot
                          @slot('precio')
                            @if($inmueble->visible==1)
                              <p><span>Bs. </span>{{number_format($inmueble->precio, 0, '', '.')}}<p>
                            @else
                              <p>Consultar Precio<p>
                            @endif
                          @endslot
                          @slot('titulo')
                            <h4><a href="{{ route('detalle_inmueble',$inmueble->id) }}">{{$inmueble->nombreInmueble}}</a></h4>
                          @endslot
                          @slot('direccion'){{$inmueble->nombreCiudad}}@endslot
                          @slot('metros'){{$inmueble->metros_construccion}}@endslot
                          @slot('baños') {{$inmueble->banos}} @endslot
                          @slot('cuartos') {{$inmueble->habitaciones}}@endslot
                          @slot('estacionamientos') {{$inmueble->estacionamientos}} @endslot
                          @slot('img')
                            @if($inmueble->id_mls==0)
                              <img src="{{ asset('images/inmuebles')}}/{{$inmueble ->nombre_imagen}}" alt="">
                            @else
                              <img src="{{$inmueble->nombre_imagen}}" alt="">
                            @endif
                          @endslot
                      @endcomponent
                  </div>
              </a>
          </div>
        @endforeach
      </div>
</section>
