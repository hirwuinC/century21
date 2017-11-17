@extends('admin/base_admin')

@section('content')

<h2 class="titleSection">información básica</h2>
<form action="" class="agenteForm">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Nombre del inmueble">
                </div>
                <div class="col-xs-6">
                    <select class="" name="">
                        <option value="">Tipo de inmueble</option>
                        <option value="TW">1</option>
                        <option value="TH">2</option>
                        <option value="FO">3</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Dirección del inmueble">
                </div>
                <div class="col-xs-6">
                    <select class="" name="">
                        <option value="">Tipo de negociación</option>
                        <option value="TW">Venta</option>
                        <option value="TH">Alquiler</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Dirección del inmueble (Mapa)">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="googleMap">
                        <iframe style="width: 100%" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6660.605222999498!2d-70.60553820000001!3d-33.415354099999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2scl!4v1508169047050" height="450" frameborder="0" allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Precio">
                </div>
                <div class="col-xs-4">
                    <ul class="viewRadio">
                        <li><h6>Visible</h6></li>
                        <li>
                            <div class="styled-input-single">
                                <input type="radio" name="fieldset-1" id="radio-example-one" />
                                <label for="radio-example-one">Si</label>
                            </div>
                        </li>
                        <li>
                            <div class="styled-input-single">
                                <input type="radio" name="fieldset-1" id="radio-example-two" />
                                <label for="radio-example-two">No</label>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-4">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Mtr2">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Habitaciones">
                </div>
                <div class="col-xs-4">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Baños">
                </div>
                <div class="col-xs-4">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Estacionamiento">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <textarea class="inputs inputsLight" placeholder="Descripción del inmueble"></textarea>
                </div>
            </div>
            <div class="row">
            <div class="buttons">
                <div class="col-xs-3 right">
                    <button id="redirectButtomAction" type="button" class="btnYellow">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
    <script>
        var redirectButtomUrl = "{{ route('crear-inmueble-2')}}";
        $('#redirectButtomAction').on('click',function(){
            console.log('click');
            window.location.href = redirectButtomUrl;
        })
    </script>
@endSection