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
                    <div class="col-xs-4">
                        <select class="form-control right ">
                            <option>Asesores</option>
                            @foreach($asesores as $asesor)
                              <option value="{{$asesor->id}}">{{$asesor->fullName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select class="form-control right">
                            <option>Todos</option>
                            <option>Activos</option>
                            <option>Inactivos</option>
                            <option>Vendidos</option>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <select class="form-control right ">
                            <option>Estados</option>
                            @foreach($estados as $estado)
                              <option value="{{$asesor->id}}">{{$estado->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <select class="form-control right ">
                            <option>Ciudades</option>
                              <option value="">-</option>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <select class="form-control right ">
                            <option>Urbanizaciones</option>
                              <option value="">-</option>
                        </select>
                    </div>
                    <div class="col-xs-3 ">
                        <input type="submit" class="btnYellow" name="" value="Buscar">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
