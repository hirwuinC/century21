@extends('admin/base_admin')

@section('content')

<h2 class="titleSection">Cargar Inmueble</h2>
<form enctype="multipart/form-data" name="propietyCreate2" id="propietyCreate2" class="agenteForm">
  {{csrf_field()}}
    <input type="hidden" name="register" value='{{Session::get('proyecto')}}'>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                  <label>Tipo de Inmueble</label>
                  <select name="typeProyect" id="typeProyect" class="inputs">
                      <option value="" selected >Seleccione una Opción</option>
                      @foreach($inmuebles as $inmueble)
                        <option value="{{$inmueble->id}}">{{$inmueble->nombre}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-xs-6">
                    <label>Cantidad de Unidades</label>
                    <input type="number" min="0" class="inputs inputsLight form-control" maxlength="10" name="quantityProyect" id="quantityProyect" placeholder="Apartamentos/Casas/Locales">
                </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                  <label>Precio</label>
                  <input type="number" min="0" class="inputs inputsLight form-control" maxlength="30" name="priceProyect" id="priceProyect" placeholder="Precio">
              </div>
              <div class="col-xs-4">
                  <ul class="viewRadio">
                      <li><h6>Precio visible</h6></li>
                      <li>
                          <div class="styled-input-single">
                              <input type="radio" name="visiblePrice" value="1" id="radio-example-one" checked="checked"/>
                              <label for="radio-example-one">Si</label>
                          </div>
                      </li>
                      <li>
                          <div class="styled-input-single">
                              <input type="radio" name="visiblePrice" value="0" id="radio-example-two" />
                              <label for="radio-example-two">No</label>
                          </div>
                      </li>
                  </ul>
              </div>
              <div class="col-xs-4">
                  <label>Metros de Construcción</label>
                  <input type="number" min="0" class="inputs inputsLight form-control" maxlength="10" id="construction" name="construction" placeholder="(Mtrs2)">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                  <label>Habitaciones</label>
                  <input type="number" min="0" class="inputs inputsLight form-control" maxlength="10" id="roomProyect"name="roomProyect" placeholder="Habitaciones">
              </div>
              <div class="col-xs-4">
                  <label>Baños</label>
                  <input type="number" min="0" class="inputs inputsLight form-control" maxlength="10" id="batroomProyect" name="batroomProyect" placeholder="Cantidad">
              </div>
              <div class="col-xs-4">
                  <label>Puestos de Estacionamientos</label>
                  <input type="number" min="0" class="inputs inputsLight form-control" maxlength="10" id="parkingProyect" name="parkingProyect" placeholder="(Cantidad de Puestos)">
              </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <label>Descripcion del tipo de inmueble</label>
                    <textarea class="inputs inputsLight" id="descriptionProyect" maxlength="600" name="descriptionProyect" placeholder="Características Destacables"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="buttons">
                    <div class="col-xs-3 col-xs-offset-9">
                        <button type="submit" id="savePropiety" type="submit" class="btnYellow">Guardar</button>
                    </div>
                </div>
            </div>
            <h2 class="titleSection">Inmuebles Disponibles</h2>
            <div class="row" id="listado">
              @foreach($consulta as $inmueble)
                <div class="alert alertGrayLight" style="margin:15px;" role="alert">
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-1"style="padding-top:10px;"><strong><h4>{{ $inmueble->nombreTipoInmueble }} - Bs.{{$inmueble->precio}} </h4></strong></div>
                        <div class="col-xs-1 col-xs-offset-4">
                            <ul>
                                <li><a href="#" class="link" data-id="{{$inmueble->id}}"><i class="fa fa-times redError"  style="font-size:30px;" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
              @endforeach
            </div>
            <div class="row">
                <div class="buttons">
                    <div class="col-xs-3 col-xs-offset-6">
                        <button id="redirectButtomAction1" type="button" class="btnGrayHight">ATRAS</button>
                    </div>
                    <div class="col-xs-3">
                        <button id="nextPict" type="button" class="btnYellow">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/admin/proyectos/nuevoproyecto.js') }}"></script>
 <script>
     var redirectButtomUrl1 = "{{ route('crear-proyecto-1') }}";
     $('#redirectButtomAction1').on('click',function(){
         window.location.href = redirectButtomUrl1;
     })
 </script>

@endSection
