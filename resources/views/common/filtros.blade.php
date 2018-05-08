<section class="filterForm">
    <form action="/buscarInmueblesPublico" method="get">
        <h3>FILTROS</h3>
        <div class="form-group range">
            <label>Código de Propiedad</label>
            <div class="rangePrice">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del inmueble">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>tipo de propiedad</label>
            <select class="form-control js-example-basic-multiple select-2" name="tipo[]" id="tipo" multiple="multiple">
              @foreach($tipos as $tipo)
                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
              @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>tipo de negociación</label>
            <select class="form-control select-2" name="tipoNegocio[]" id="tipoNegocio" multiple="multiple">
                <option value="venta">Venta</option>
                <option value="alquiler">Alquiler</option>
            </select>
        </div>
        <div class="form-group">
            <label>Estados</label>
            <select class="form-control js-example-basic-multiple select-2" name="states[]" id="states" multiple="multiple">
              @foreach($estados as $estado)
                <option value="{{$estado->id}}">{{$estado->nombre}}</option>
              @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Ciudades</label>
            <select class="form-control js-example-basic-multiple select-2" name="ciudades[]" id="ciudades" multiple="multiple">
            </select>
        </div>
        <div class="form-group">
            <label>Urbanizaciones</label>
            <select class="form-control js-example-basic-multiple select-2" name="urbanizaciones[]" id="urbanizaciones" multiple="multiple">
            </select>
        </div>
        <div class="form-group">
            <label>Habitaciones</label>
            <select class="form-control js-example-basic-multiple select-2" name="habitaciones[]" id="habitaciones" multiple="multiple">
                <option value="1">1H</option>
                <option value="2">2H</option>
                <option value="3">3H</option>
                <option value="4">4H +</option>
            </select>
        </div>
        <div class="form-group">
            <label>Baños</label>
            <select class="form-control js-example-basic-multiple select-2" name="banos[]" id="banos" multiple="multiple">
                <option value="1">1B</option>
                <option value="2">2B</option>
                <option value="3">3B +</option>
            </select>
        </div>
        <div class="form-group selector">
            <label>Estacionamiento</label>
            <select class="form-control js-example-basic-multiple select-2" name="estacionamientos[]" id="estacionamientos" multiple="multiple">
                <option value="1">1E</option>
                <option value="2">2E</option>
                <option value="3">3E +</option>
            </select>
        </div>
        <div class="form-group range">
            <label>precio</label>
            <div class="rangePrice">
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="form-control" id="precioMin" name="precioMin" placeholder="Mínimo">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="form-control" id="precioMax" name="precioMax" placeholder="Máximo">
                    </div>
                </div>
                <!-- <b>€ 10</b> <input id="ex2" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/> <b>€ 1000</b>-->
            </div>
        </div>
        <button type="submit" class="btnYellow" id="buscar">BUSCAR</button>
    </form>
</section>
