@extends('admin/base_admin')

@section('content')

<h2 class="titleSection">FECHAS</h2>
<div class="row">
  <div class="col-xs-2">
    <ul class="viewRadio viewRadioEstadistica">
        <li>
            <div class="styled-input-single">
                <input type="radio" name="fecha" value="1" checked="checked" id="radio-example-one"/>
                <label for="radio-example-one">Rango</label>
            </div>
        </li>
        <li>
            <div class="styled-input-single">
                <input type="radio" name="fecha" value="0" id="radio-example-two" />
                <label for="radio-example-two">Mes en curso</label>
            </div>
        </li>
        <li>
            <div class="styled-input-single">
                <input type="radio" name="fecha" value="2" id="radio-example-tree" />
                <label for="radio-example-tree">Mes anterior</label>
            </div>
        </li>
    </ul>
  </div>
  <div class="col-xs-4">
    <label for="">Desde</label>
    <input type="date" class="inputs inputsLight form-control" id="" name="" placeholder="Desde">
  </div>
  <div class="col-xs-4">
    <label for="">Hasta</label>
    <input type="date" class="inputs inputsLight form-control" id="" name="" placeholder="Hasta">
  </div>
</div>
<h2 class="titleSection">constructor de reporte</h2>
<div class="row contPadre">
    <div class="col-xs-3">
      <select  class="inputs inputsLight form-control" id="elemento">
          <option value="" selected >- Elemento a analizar -</option>
          @foreach ($reportes as $reporte)
          <option value="{{$reporte->id}}">{{$reporte->descripcionReporte}}</option>
          @endforeach
      </select>
    </div>
    <div class="col-xs-3">
      <select  class="inputs inputsLight form-control" id="tipoReporte">
          <option value="" selected > - Tipo de reporte - </option>
      </select>
    </div>
    <div class="col-xs-3 ocultos fecha ">
      <select  class="inputs inputsLight form-control" id="estados">
          <option value="" selected > - Estados - </option>
      </select>
    </div>
    <div class="col-xs-3 ocultos fecha">
      <select  class="inputs inputsLight form-control" id="ciudades">
          <option value="" selected > - Ciudades - </option>
      </select>
    </div>
    <div class="col-xs-3 ocultos fecha">
      <select  class="inputs inputsLight form-control" id="urbanizaciones">
          <option value="" selected > - Urbanizaciones - </option>
      </select>
    </div>
    <div class="col-xs-3 ocultos estatus">
      <select  class="inputs inputsLight form-control" id="estatus">
          <option value="" selected > - Estatus - </option>
      </select>
    </div>
    <div class="col-xs-3 ocultos">
      <select  class="inputs inputsLight form-control" id="estatus">
          <option value="" selected > - Pasos de Gestion - </option>
      </select>
    </div>
</div>





@endsection
@section('js')
  <script type="text/javascript" src="{{ asset('js/admin/estadisticas/filtro.js') }}"></script>
@endSection
