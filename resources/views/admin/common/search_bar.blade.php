@if($arreglo)
  <section>
      <div class="row">
          <div class="col-xs-12">
              <div class="alert alertSearch" role="alert">
                  <div class="row">
                    <form id="buscadorInmuebleForm" method="get" action="/admin/buscarInmueble">
                          <div class="col-xs-4">
                              <div>
                                  <div class="iconInput">
                                      <i class="fa fa-search" aria-hidden="true"></i>
                                  </div>
                                  <input type="text" class="inputs form-control buscador" name="codigo" placeholder="Código Inmueble">
                              </div>
                          </div>
                          <div class="col-xs-4">
                              <select class="form-control right " name="asesor" id="asesor">
                                  <option value="">Asesores</option>
                                  @foreach($asesores as $asesor)
                                    @if($arreglo['propiedades.agente_id']==$asesor->id)
                                      <option value="{{$asesor->id}}" selected>{{$asesor->fullName}}</option>
                                    @else
                                      <option value="{{$asesor->id}}">{{$asesor->fullName}}</option>
                                    @endif
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-xs-4">
                              <select class="form-control right" name="estatus" id="estatus">
                                  <option value="">Estatus</option>
                                  @foreach($estatus as $opcion)
                                    @if($arreglo['propiedades.estatus']==$opcion->id)
                                      <option value="{{$opcion->id}}" selected>{{$opcion->descripcionEstatus}}</option>
                                    @else
                                      <option value="{{$opcion->id}}">{{$opcion->descripcionEstatus}}</option>
                                    @endif
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-xs-3">
                              <select class="form-control right " name="estatePropiety" id="estatePropiety">
                                  <option value="">Estados</option>
                                  @foreach($estados as $estado)
                                    @if($estado->id==$arreglo['propiedades.estado_id'])
                                      <option value="{{$estado->id}}" selected>{{$estado->nombre}}</option>
                                    @else
                                      <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                    @endif
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-xs-3">
                              <select class="form-control right" name="cityPropiety" id="cityPropiety">
                                  <option value="">Ciudades</option>
                                  @foreach($ciudades as $ciudad)
                                    @if($arreglo['propiedades.estado_id']!='')
                                      @if($ciudad->id==$arreglo['propiedades.ciudad_id'])
                                        <option value="{{$ciudad->id}}" class="opcion" selected>{{$ciudad->nombre}}</option>
                                      @else
                                        <option value="{{$ciudad->id}}" class="opcion">{{$ciudad->nombre}}</option>
                                      @endif
                                    @endif
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-xs-3">
                              <select class="form-control right" name="namePropiety" id="namePropiety">
                                <option value="">Urbanizaciones</option>
                                @foreach($urbanizaciones as $urbanizacion)
                                  @if($arreglo['propiedades.ciudad_id']!='')
                                    @if($urbanizacion->id==$arreglo['propiedades.urbanizacion'])
                                      <option value="{{$urbanizacion->id}}" class="opcionUrbanizacion" selected>{{$urbanizacion->nombre}}</option>
                                    @else
                                      <option value="{{$urbanizacion->id}}" class="opcionUrbanizacion">{{$urbanizacion->nombre}}</option>
                                    @endif
                                  @endif
                                @endforeach
                              </select>
                          </div>
                          <div class="col-xs-3 ">
                              <input type="submit" class="btnYellow" id="buscadorInmueble" value="Buscar">
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </section>
@else
  <section>
      <div class="row">
          <div class="col-xs-12">
              <div class="alert alertSearch" role="alert">
                  <div class="row">
                    <form id="buscadorInmuebleForm" method="get" action="/admin/buscarInmueble">
                          <div class="col-xs-4">
                              <div>
                                  <div class="iconInput">
                                      <i class="fa fa-search" aria-hidden="true"></i>
                                  </div>
                                  <input type="text" class="inputs form-control buscador" name="codigo" placeholder="Código Inmueble">
                              </div>
                          </div>
                          <div class="col-xs-4">
                              <select class="form-control right " name="asesor" id="asesor">
                                  <option value="">Asesores</option>
                                  @foreach($asesores as $asesor)
                                    <option value="{{$asesor->id}}">{{$asesor->fullName}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-xs-4">
                              <select class="form-control right" name="estatus" id="estatus">
                                  <option value="">Estatus</option>
                                  @foreach($estatus as $opcion)
                                    <option value="{{$opcion->id}}" >{{$opcion->descripcionEstatus}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-xs-3">
                              <select class="form-control right " name="estatePropiety" id="estatePropiety">
                                  <option value="">Estados</option>
                                  @foreach($estados as $estado)
                                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-xs-3">
                              <select class="form-control right" name="cityPropiety" id="cityPropiety">
                                  <option value="">Ciudades</option>
                              </select>
                          </div>
                          <div class="col-xs-3">
                              <select class="form-control right" name="namePropiety" id="namePropiety">
                                  <option value="">Urbanizaciones</option>
                              </select>
                          </div>
                          <div class="col-xs-3 ">
                              <input type="submit" class="btnYellow" id="buscadorInmueble" value="Buscar">
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </section>
@endif
