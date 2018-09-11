@extends('admin/base_admin')

@section('content')
  <div class="row">
    <h2 class="titleSection">constructor de reporte</h2>
    <div class="row contPadre">
        <div class="col-xs-4">
          <select  class="inputs inputsLight form-control" id="elemento">
              <option value="" selected >- Elemento a analizar -</option>
              @foreach ($reportes as $reporte)
              <option value="{{$reporte->id}}">{{$reporte->descripcionReporte}}</option>
              @endforeach
          </select>
        </div>
        <div class="col-xs-4">
          <select  class="inputs inputsLight form-control" id="tipoReporte" placeholder="Tipos de reporte">
              <option value="0"> - Tipo de reporte - </option>
          </select>
        </div>
       <div class="col-xs-4">
          <select  multiple class="inputs inputsLight form-control filtro asesores" name="asesores[]" id="asesores">
              <option value="" disabled> - Asesores - </option>
          </select>
        </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
          <select multiple class="inputs inputsLight form-control filtro ubicacion" id="estados">
              <option value="" data-name="" disabled > - Estados - </option>
              @foreach($estados as $estado)
                <option value="{{$estado->id}}">{{$estado->nombre}}</option>
              @endforeach
          </select>
        </div>
       <div class="col-xs-4">
          <select multiple class="inputs inputsLight form-control filtro ubicacion" id="ciudades">
              <option value="" data-name="" disabled > - Ciudades - </option>
          </select>
        </div>
        <div class="col-xs-4">
          <select multiple class="inputs inputsLight form-control filtro ubicacion" id="urbanizaciones">
              <option value="" data-name="" disabled > - Urbanizaciones - </option>
          </select>
        </div>
    </div>
    <h2 class="titleSection">FILTROS</h2>
    <div class="col-xs-2">
      <ul class="viewRadio viewRadioEstadistica">
          <li>
              <div class="styled-input-single">

                  <input type="checkbox" name="checkFecha"   id="checkFecha"  disabled="disabled" />
                  <label for="checkFecha">Rango de fecha</label>
              </div>
          </li>
          <li>
              <div class="styled-input-single contPrecio">
                  <input type="checkbox" name="checkPrecio"   id="mostrar_precio" disabled="disabled" />
                  <label for="mostrar_precio">Rango de precio</label>
              </div>
          </li>
      </ul>
    </div>
    <div class="col-xs-4">
      <label for="">Desde</label>
      <input type="date" class="inputs inputsLight form-control" id="fechaI_" name="fechaI_" placeholder="Desde">
    </div>
    <div class="col-xs-4">
      <label for="">Hasta</label>
      <input type="date" class="inputs inputsLight form-control" id="fechaF_" name="fechaF_" placeholder="Hasta">
    </div>
    <div class="col-xs-4">
      <br>
      <br>
      <input type="number" class="inputs inputsLight form-control precio" id="precioI_" name="precioI_" placeholder="Precio Mínimo">
    </div>
    <div class="col-xs-4">
      <br>
      <br>
      <input type="number" class="inputs inputsLight form-control precio" id="precioF_" name="precioF_" placeholder="Precio Máximo">
    </div>
  </div>
  
  <div class="col-xs-3 col-xs-offset-4">
    <button type="submit" id="buttonReporte" class="btnYellow">Generar</button>
  </div>
  
@endsection
@section('js')
  <script type="text/javascript" src="{{ asset('js/admin/estadisticas/filtro.js') }}"></script>
@endSection
