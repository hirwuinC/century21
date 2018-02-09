@extends('admin/base_admin')

@section('content')

<h2 class="titleSection">Cargar Inmueble</h2>
<form enctype="multipart/form-data" name="proyectEdit2" id="proyectEdit2" class="agenteForm">
  {{csrf_field()}}
    <input type="hidden" name="register" value="{{Session::get('proyectoEdit')}}">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                  <select name="typeProyect" id="typeProyect" class="inputs">
                      <option value="" selected >Tipo de Inmueble</option>
                      @foreach($inmuebles as $inmueble)
                        <option value="{{$inmueble->id}}">{{$inmueble->nombre}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-xs-6">
                    <input type="number" min="0" class="inputs inputsLight form-control" name="quantityProyect" id="quantityProyect" placeholder="Cantidad de viviendas">
                </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                  <input type="number" min="0" class="inputs inputsLight form-control" name="priceProyect" id="priceProyect" placeholder="Precio">
              </div>
              <div class="col-xs-4">
                  <ul class="viewRadio">
                      <li><h6>Visible</h6></li>
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
                  <input type="number" min="0" class="inputs inputsLight form-control" id="construction" name="construction" placeholder="Area de Construcción (Mtrs2)">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                  <input type="number" min="0" class="inputs inputsLight form-control" id="roomProyect"name="roomProyect" placeholder="Habitaciones">
              </div>
              <div class="col-xs-4">
                  <input type="number" min="0" class="inputs inputsLight form-control" id="batroomProyect" name="batroomProyect" placeholder="Baños">
              </div>
              <div class="col-xs-4">
                  <input type="number" min="0" class="inputs inputsLight form-control" id="parkingProyect" name="parkingProyect" placeholder="Estacionamiento (Cantidad de Puestos)">
              </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <textarea class="inputs inputsLight" id="descriptionProyect" name="descriptionProyect" placeholder="Descripción de la vivienda"></textarea>
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
<script type="text/javascript" src="{{ asset('js/admin/proyectos/editarproyecto.js') }}"></script>
 <script>
     var redirectButtomUrl1 = "{{ route('editar-proyecto-1', Session::get('proyectoEdit')) }}";
     $('#redirectButtomAction1').on('click',function(){
         window.location.href = redirectButtomUrl1;
     })
 </script>

@endSection
