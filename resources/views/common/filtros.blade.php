<section class="filterForm">
    <form action="">
        <h3>FILTROS</h3>
        <div class="form-group">
            <label>tipo de propiedad</label>
            <select class="form-control js-example-basic-multiple" name="propiedad" multiple="multiple">
                <option value="apartamento">Apartamento</option>
                <option value="casa">Casa</option>
                <option value="residencial">Residencial</option>
                <option value="vacacional">Vacacional</option>
                <option value="terreno">Terreno</option>
                <option value="comercial">Comercial</option>
                <option value="industrial">Industrial</option>
            </select>
        </div>
        <div class="form-group">
            <label>tipo de negociación</label>
            <select class="form-control select-2" name="tipo" multiple="multiple">
                <option value="venta">Venta</option>
                <option value="alquiler">Alquiler</option>
            </select>
        </div>
        <div class="form-group">
            <label>Zona de propiedad</label>
            <select class="form-control js-example-basic-multiple" name="states[]" multiple="multiple">
                <option value="CA">Caracas</option>
                <option value="SA">San antonio de los altos</option>
                <option value="LT">Los teques</option>
                <option value="GU">Guatire</option>
            </select>
        </div>
        <div class="form-group">
            <label>Habitaciones</label>
            <select class="form-control js-example-basic-multiple" name="states[]" multiple="multiple">
                <option value="ON">1H</option>
                <option value="TW">2H</option>
                <option value="TH">3H</option>
                <option value="FO">4H +</option>
            </select>
        </div>
        <div class="form-group">
            <label>Baños</label>
            <select class="form-control js-example-basic-multiple" name="states[]" multiple="multiple">
                <option value="B1">1B</option>
                <option value="B2">2B</option>
                <option value="B+">3B +</option>
            </select>
        </div>
        <div class="form-group selector">
            <label>Estacionamiento</label>
            <select class="form-control js-example-basic-multiple" name="states[]" multiple="multiple">
                <option value="1E">1E</option>
                <option value="2E">2E</option>
                <option value="3E">3E +</option>
            </select>
        </div>
        <div class="form-group range">
            <label>precio</label>
            <div class="rangePrice">
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="form-control" id="min" placeholder="Mínimo">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="form-control" id="max" placeholder="Máximo">
                    </div>
                </div>
                <!-- <b>€ 10</b> <input id="ex2" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/> <b>€ 1000</b>-->
            </div>
        </div>
        <button type="button" class="btnYellow">ENVIAR</button>
    </form>
</section>