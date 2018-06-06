@extends('admin/base_admin')

@section('content')

<h2 class="titleSection">FECHAS</h2>
<div class="row">
  <div class="col-xs-2">
    <ul class="viewRadio viewRadioEstadistica">
        <li>
            <div class="styled-input-single">

                <input type="checkbox" name="checkFecha"   id="checkFecha" readonly />
                <label for="radio-example-one">Rango de fecha</label>
            </div>
        </li>
        <li>
            <div class="styled-input-single">
                <input type="checkbox" name="checkPrecio"   id="checkPrecio" readonly />
                <label for="mostrar_precio">Rango de precio</label>
            </div>
        </li>
          <li>
            <div class="styled-input-single">
                 <input type="checkbox" name="mostrar_"   id="mostrar_" />
                <label for="mostrar_">Mostrar todo</label>
            </div>
        </li>



        <!-- <li>
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
        </li> -->
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
    
    <input type="number" class="inputs inputsLight form-control" id="precioI_" name="precioI_" placeholder="Precio inicial">
  </div>
  <div class="col-xs-4">
    <br>
    <br>
    <input type="number" class="inputs inputsLight form-control" id="precioF_" name="precioF_" placeholder="Precio final">
  </div>

</div>
<h2 class="titleSection">constructor de reporte</h2>
<div class="row contPadre">
    <div class="col-xs-3">
      <select  class="inputs inputsLight form-control" id="elemento">
          <option value="0" selected >- Elemento a analizar -</option>
          @foreach ($reportes as $reporte)
          <option value="{{$reporte->id}}">{{$reporte->descripcionReporte}}</option>
          @endforeach
      </select>
    </div>
    <div class="col-xs-3">
      <select  class="inputs inputsLight form-control" id="tipoReporte">
          <option value="0" data-name="" selected > - Tipo de reporte - </option>
      </select>
    </div>
   
    
</div>
 <div class="col-xs-3">
        <button type="submit" id="buttonReporte" class="btnYellow">Generar</button>
    </div>





@endsection
@section('js')
  <script type="text/javascript" src="{{ asset('js/admin/estadisticas/filtro.js') }}"></script>
@endSection
