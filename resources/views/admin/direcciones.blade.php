@extends('admin/base_admin')
@section('content')
<h2 class="titleSection">CARGAR DIRECCIONES</h2>
  <div class="row">
      <div class="col-xs-3 col-xs-offset-2">
          <label for="">Estados</label>
          <select class="inputs inputsLight" id="estatePropiety">
              <option value="">Seleccione un estado</option>
              @foreach($estados as $estado)
                <option value="{{$estado->id}}">{{$estado->nombre}}</option>
              @endforeach
          </select>
      </div>
      <div class="botones" style="padding-top:6px;">
        <div class="col-xs-2">
            <button type="button" id="bttnNuevaCiudad" class="btnGreen btnGreenAjuste">Nueva Ciudad</button>
        </div>
      </div>
  </div>
  <div class="row">
      <div class="col-xs-3 col-xs-offset-2">
          <label for="">Ciudades</label>
          <select class="inputs inputsLight" id="cityPropiety">
              <option value="">Seleccione una ciudad</option>
          </select>
      </div>
      <div class="botones" style="padding-top:6px;">
        <div class="col-xs-2">
            <button type="button" id='bttnDeleteCiudad' class="btnRed">BORRAR CIUDAD</button>
        </div>
        <div class="col-xs-2">
            <button type="button" id="bttnNuevaUrbanizacion" class="btnGreen btnGreenAjuste">Nueva Urbanización</button>
        </div>
      </div>
  </div>
  <div class="row">
      <div class="col-xs-3 col-xs-offset-2">
          <label for="">Urbanizaciones</label>
          <select class="inputs inputsLight" id="urbanizacionPropiety">
              <option value="">Seleccione una urbanización</option>
          </select>
      </div>
      <div class="botones" style="padding-top:6px;">
        <div class="col-xs-2">
            <button type="button" id='bttnDeleteUrbanizacion' class="btnRed">BORRAR URBANIZACION</button>
        </div>
      </div>
  </div>
  @include('admin/modals/nueva_ciudad')
  @include('admin/modals/nueva_urbanizacion')
@endsection('content')
@section('js')
    <script type="text/javascript" src="{{ asset('js/admin/direcciones/direcciones.js') }}"></script>
@endSection
