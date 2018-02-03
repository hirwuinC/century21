<div class="galleryProperties">
    <div class="row">
        <div class="col-lg-12">
            <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                  @foreach($imagenes as $imagen)
                    @if($imagen->vista==1)
                      <div class="item active inmueble">
                          <img src="{{ asset('images/inmuebles/'.$imagen->nombre.'')}}" alt="..." class="img-responsive">
                      </div>
                    @else
                      <div class="item inmueble">
                          <img src="{{ asset('images/inmuebles/'.$imagen->nombre.'')}}" alt="..." class="img-responsive">
                      </div>
                    @endif
                  @endforeach
                </div>
                <!-- Controls
                <a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev">
                    <i class="fa fa-chevron-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next">
                    <i class="fa fa-chevron-right"></i>
                    <span class="sr-only">Next</span>
                </a>-->
                <!-- Indicators -->
                <ol class="carousel-indicators visible-sm-block hidden-xs-block visible-md-block visible-lg-block">
                  <input type="hidden" value="{{$contador=0}}">
                  @foreach($imagenes as $imagen)
                    @if($imagen->vista==1)
                      <li data-target="#carousel-custom" data-slide-to="{{$contador++}}" class="active">
                          <img src="{{ asset('images/inmuebles/'.$imagen->nombre.'')}}" alt="..." class="img-responsive">
                      </li>
                    @else
                      <li data-target="#carousel-custom" data-slide-to="{{$contador++}}">
                          <img src="{{ asset('images/inmuebles/'.$imagen->nombre.'')}}" alt="..." class="img-responsive">
                      </li>
                    @endif
                  @endforeach
                </ol>
            </div>

        </div>
    </div>
</div>
