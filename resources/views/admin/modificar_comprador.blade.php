@extends('admin/base_admin')

@section('content')
<h2 class="titleSection">PERFIL COMPRADOR</h2>
<form class="form marginForm" id="formularioComprador">
  <input type="hidden" name="idComprador" id="idComprador" value="{{$comprador->id}}">
    <div class="row">
      <div class="col-xs-6">
          <div class="form-group">
              <label>Cédula de Identidad</label>
          </div>
          <div style="padding-bottom:20px;" >
              <input type="text" class="inputs inputsLight form-control limpiarComprador" maxlength="25" name="cedulaComprador" id="cedulaComprador" placeholder="V0123456789" value="{{$comprador->cedula}}">
          </div>
      </div>
      <div class="col-xs-6">
          <div class="form-group">
              <label>Nombre Completo</label>
          </div>
          <div style="padding-bottom:20px;" >
              <input type="text" class="inputs inputsLight form-control limpiarComprador" maxlength="100" name="nombreComprador" id="nombreComprador" placeholder="Nombre Completo" value="{{$comprador->fullNameComprador}}">
          </div>
      </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label>Correo electrónico</label>
            </div>
            <div style="padding-bottom:20px;" >
                <input type="text" class="inputs inputsLight form-control limpiarComprador" maxlength="100" name="correoComprador" id="correoComprador" placeholder="micorreo@midominio.com" value="{{$comprador->email}}">
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label>Fecha de Nacimiento:</label>
            </div>
            <div style="padding-bottom:20px;" >
                <input type="date" class="inputs inputsLight form-control limpiarComprador" min="0" maxlength="10" name="edad" id="edad" placeholder="Años" value="{{$comprador->edad}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label>Grupo Familiar:</label>
            </div>
            <div style="padding-bottom:20px;" >
                <input type="number" class="inputs inputsLight form-control limpiarComprador" min="0" maxlength="10" name="grupoFamiliar" id="grupoFamiliar" placeholder="Cantidad de Personas" value="{{$comprador->grupoFamilia}}">
            </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
              <label>Ocupación</label>
          </div>
            <div style="padding-bottom:20px;" >
                <input type="text" class="inputs inputsLight form-control limpiarComprador" maxlength="100" name="ocupacion" id="ocupacion" placeholder="Profesión u Ocupación" value="{{$comprador->ocupacion}}">
            </div>
        </div>
    </div>
      <div class="row">
        <div class="col-xs-6">
            <ul class="viewRadio marginBottom20">
                <li><h6>Sexo</h6></li>
                @if($comprador->sexo==1)
                  <li>
                      <div class="styled-input-single">
                          <input type="radio" name="sexoComprador" value="1" id="masculino" checked="checked"/>
                          <label for="masculino">M</label>
                      </div>
                  </li>
                  <li>
                      <div class="styled-input-single">
                          <input type="radio" name="sexoComprador" value="0" id="femenino" />
                          <label for="femenino" >F</label>
                      </div>
                  </li>
                @else
                  <li>
                      <div class="styled-input-single">
                          <input type="radio" name="sexoComprador" value="1" id="masculino" />
                          <label for="masculino">M</label>
                      </div>
                  </li>
                  <li>
                      <div class="styled-input-single">
                          <input type="radio" name="sexoComprador" value="0" id="femenino" checked="checked" />
                          <label for="femenino" >F</label>
                      </div>
                  </li>
                @endif
            </ul>
        </div>
      </div>
      <h2 class="titleSection">Inmuebles Comprados</h2>
      <div class="row">
          <div class="col-xs-12">
            <table class="table table-hover">
              <tr>
                <th>Código Interno</th>
                <th>MLS</th>
                <th>Tipo de Inmueble</th>
                <th>Estado</th>
                <th>Ciudad</th>
                <th>Urbanización</th>
                <th>Referencia $</th>
              </tr>
              @foreach($propiedades as $propiedad)
              <tr>
                <td>{{$propiedad->id}}</td>
                <td>{{$propiedad->id_mls}}</td>
                <td>{{$propiedad->nombreTipoInmueble}}</td>
                <td>{{$propiedad->nombreEstado}}</td>
                <td>{{$propiedad->nombreCiudad}}</td>
                <td>{{$propiedad->nombreUrbanizacion}}</td>
                <td>{{$propiedad->referenciaDolares}}</td>
              </tr>
              @endforeach
            </table>
          </div>
      </div>
      <div class="row">
          <div class="buttons">
              <div class="col-xs-3 col-xs-offset-4">
                  <button type="submit" id="buttonCreate" class="btnYellow">Guardar Perfil</button>
              </div>
          </div>
      </div>
  </form>

@endsection('content')
@section('js')
    <script type="text/javascript" src="{{ asset('js/admin/compradores/guardarComprador.js') }}"></script>
@endSection
