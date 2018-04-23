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
                            <input type="text" class="inputs form-control buscador" id="exampleInputEmail1" placeholder="Código Inmueble">
                        </div>
                    </div>
                    <form id="buscadorInmuebleForm">
                        <input type="hidden" name="data" value="1">
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
