<section class="filterForm">
    <form action="/buscarInmueblesPublico" method="get">
        <h3>FILTROS</h3>
        <div class="form-group range">
            <label>Código de Propiedad</label>
            <div class="rangePrice">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="int" class="form-control" id="codigo" name="codigo" placeholder="Código del inmueble">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>tipo de propiedad</label>
            <select class="form-control js-example-basic-multiple select-2" name="tipo[]" id="tipo" multiple="multiple">
              @foreach($tipos as $tipo)
                  @if(in_array($tipo->id, $tipoP))
                   <option value="{{$tipo->id}}" selected>{{$tipo->nombre}}</option>
                  @else
                   <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                  @endif
              @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>tipo de negociación</label>
            <select class="form-control select-2" name="tipoNegocio[]" id="tipoNegocio" multiple="multiple">
              @foreach($modeloNegocio as $key=>$value)
                  @if(in_array($modeloNegocio[$key], $tipoNegocio))
                   <option value="{{$modeloNegocio[$key]}}" selected>{{$modeloNegocio[$key]}}</option>
                  @else
                   <option value="{{$modeloNegocio[$key]}}">{{$modeloNegocio[$key]}}</option>
                  @endif
              @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Estados</label>
            <select class="form-control js-example-basic-multiple select-2" name="states[]" id="states" multiple="multiple">
              @foreach($estadosLista as $estado)
                @if(in_array($estado->id,$estados))
                  <option value="{{$estado->id}}" selected>{{$estado->nombre}}</option>
                @else
                  <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                @endif
              @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Ciudades</label>
            <select class="form-control js-example-basic-multiple select-2" name="ciudades[]" id="ciudades" multiple="multiple">
              @foreach($ciudadPorEstado as $ciudad)
                @if(in_array($ciudad->id,$ciudades))
                  <option class="opcion" value="{{$ciudad->id}}" selected>{{$ciudad->nombre}}</option>
                @else
                  <option class="opcion" value="{{$ciudad->id}}">{{$ciudad->nombre}}</option>
                @endif
              @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Urbanizaciones</label>
            <select class="form-control js-example-basic-multiple select-2" name="urbanizaciones[]" id="urbanizaciones" multiple="multiple">
              @foreach($urbanizacionPorCiudad as $urbanizacion)
                @if(in_array($urbanizacion->id,$urbanizaciones))
                  <option class="opcionUrbanizacion" value="{{$urbanizacion->id}}" selected>{{$urbanizacion->nombre}}</option>
                @else
                  <option class="opcionUrbanizacion" value="{{$urbanizacion->id}}">{{$urbanizacion->nombre}}</option>
                @endif
              @endforeach
            </select>
        </div>
        <div class="form-group">
          @php $cantidadHabitaciones=[1,2,3,4];
          @endphp
            <label>Habitaciones</label>
              <select class="form-control js-example-basic-multiple select-2" name="habitaciones[]" id="habitaciones" multiple="multiple">
                @foreach($cantidadHabitaciones as $key=>$value)
                    @if(in_array($cantidadHabitaciones[$key], $habitaciones))
                      @if($cantidadHabitaciones[$key]==4)
                        <option class="mayorH" value="{{$cantidadHabitaciones[$key]}}" selected>{{$cantidadHabitaciones[$key]}}H +</option>
                      @else
                        <option class="menorH" value="{{$cantidadHabitaciones[$key]}}" selected>{{$cantidadHabitaciones[$key]}}H</option>
                      @endif
                    @else
                      @if($cantidadHabitaciones[$key]==4)
                        <option  class="mayorH" value="{{$cantidadHabitaciones[$key]}}">{{$cantidadHabitaciones[$key]}}H +</option>
                      @else
                        <option class="menorH" value="{{$cantidadHabitaciones[$key]}}">{{$cantidadHabitaciones[$key]}}H</option>
                      @endif
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
          @php $cantidadBanos=[1,2,3];
          @endphp
            <label>Baños</label>
            <select class="form-control js-example-basic-multiple select-2" name="banos[]" id="banos" multiple="multiple">
              @foreach($cantidadBanos as $key=>$value)
                  @if(in_array($cantidadBanos[$key], $banos))
                    @if($cantidadBanos[$key]==3)
                      <option class="mayorB" value="{{$cantidadBanos[$key]}}" selected>{{$cantidadBanos[$key]}}B +</option>
                    @else
                      <option class="menorB" value="{{$cantidadBanos[$key]}}" selected>{{$cantidadBanos[$key]}}B</option>
                    @endif
                  @else
                    @if($cantidadBanos[$key]==3)
                      <option  class="mayorB" value="{{$cantidadBanos[$key]}}">{{$cantidadBanos[$key]}}B +</option>
                    @else
                      <option class="menorB" value="{{$cantidadBanos[$key]}}">{{$cantidadBanos[$key]}}B</option>
                    @endif
                  @endif
              @endforeach
            </select>
        </div>
        <div class="form-group selector">
          @php $cantidadEst=[1,2,3];
          @endphp
            <label>Estacionamiento</label>
            <select class="form-control js-example-basic-multiple select-2" name="estacionamientos[]" id="estacionamientos" multiple="multiple">
              @foreach($cantidadEst as $key=>$value)
                  @if(in_array($cantidadEst[$key], $estacionamientos))
                    @if($cantidadEst[$key]==3)
                      <option class="mayorE" value="{{$cantidadEst[$key]}}" selected>{{$cantidadEst[$key]}}E +</option>
                    @else
                      <option class="menorE" value="{{$cantidadEst[$key]}}" selected>{{$cantidadEst[$key]}}E</option>
                    @endif
                  @else
                    @if($cantidadEst[$key]==3)
                      <option  class="mayorE" value="{{$cantidadEst[$key]}}">{{$cantidadEst[$key]}}E +</option>
                    @else
                      <option class="menorE" value="{{$cantidadEst[$key]}}">{{$cantidadEst[$key]}}E</option>
                    @endif
                  @endif
              @endforeach
            </select>
        </div>
        <div class="form-group range">
            <label>precio</label>
            <div class="rangePrice">
                <div class="row">
                    <div class="col-xs-6">
                        <input type="int" class="form-control" id="precioMin" name="precioMin" placeholder="Mínimo" value="{{$precioMin}}">
                    </div>
                    <div class="col-xs-6">
                        <input type="int" class="form-control" id="precioMax" name="precioMax" placeholder="Máximo" value="{{$precioMax}}">
                    </div>
                </div>
                <!-- <b>€ 10</b> <input id="ex2" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/> <b>€ 1000</b>-->
            </div>
        </div>
        <button type="submit" class="btnYellow" id="buscar">BUSCAR</button>
    </form>
</section>
