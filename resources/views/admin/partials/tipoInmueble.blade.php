@foreach($consulta as $inmueble)
  <div class="alert alertGrayLight" style="margin:15px;" role="alert">
      <div class="row">
          <div class="col-xs-5 col-xs-offset-1"style="padding-top:10px;"><strong><h4>{{ $inmueble->nombreTipoInmueble }} - Bs.{{$inmueble->precio}}</h4></strong></div>
          <div class="col-xs-1 col-xs-offset-4">
              <ul>
                  <li><a href="#" class="link" data-id="{{$inmueble->id}}"><i class="fa fa-times redError"  style="font-size:30px;" aria-hidden="true"></i></a></li>
              </ul>
          </div>
      </div>
  </div>
@endforeach
