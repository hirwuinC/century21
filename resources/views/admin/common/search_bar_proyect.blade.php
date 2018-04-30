@if($arreglo)
  <section>
      <div class="row">
          <div class="col-xs-12">
              <div class="alert alertSearch" role="alert">
                  <div class="row">
                          <div class="col-xs-4">
                              <div>
                                  <div class="iconInput">
                                      <i class="fa fa-search" aria-hidden="true"></i>
                                  </div>
                                  <input type="text" class="inputs form-control buscador" name="codigo" id="searchProyecto" placeholder="Código /Nombre Proyecto">
                                  <input type="hidden" id="valor" name="valor" value="">
                              </div>
                          </div>
                  <form id="buscadorProyecto" method="get" action="/admin/buscarProyecto">
                          <div class="col-xs-3">
                              <select class="form-control right " name="estatePropiety" id="estatePropiety">
                                  <option value="">Estados</option>
                                  @foreach($estados as $estado)
                                    @if($estado->id==$arreglo['proyectos.estado_id'])
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
                                    @if($arreglo['proyectos.estado_id']!='')
                                      @if($ciudad->id==$arreglo['proyectos.ciudad_id'])
                                        <option value="{{$ciudad->id}}" class="opcion" selected>{{$ciudad->nombre}}</option>
                                      @else
                                        <option value="{{$ciudad->id}}" class="opcion">{{$ciudad->nombre}}</option>
                                      @endif
                                    @endif
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-xs-2 ">
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
                          <div class="col-xs-4">
                              <div>
                                  <div class="iconInput">
                                      <i class="fa fa-search" aria-hidden="true"></i>
                                  </div>
                                  <input type="text" class="inputs form-control buscador" name="codigo" id="searchProyecto" placeholder="Código /Nombre Proyecto">
                                  <input type="hidden" id="valor" name="valor" value="">
                              </div>
                          </div>
                      <form id="buscadorProyecto" method="get" action="/admin/buscarProyecto">
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
                          <div class="col-xs-2 ">
                              <input type="submit" class="btnYellow" id="buscadorInmueble" value="Buscar">
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </section>
@endif
