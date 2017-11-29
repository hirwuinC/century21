@extends('admin/base_admin')

@section('content')
<h2 class="titleSection">EDITAR AGENTE</h2>
<form action="" class="agenteForm">
    <div class="row">
        <div class="col-xs-3">
            <div class="containertAvatar">
                <img src="{{ asset('images/img-avatar.jpg')}}" alt="">
                <div class="editAvatar">
                    <a href="">
                        <i class="fa fa-camera" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xs-9">
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" value="{{ $fullname[0] }}" disabled="disabled" class="inputs inputsLight form-control" id="" placeholder="Nombre">
                </div>
                <div class="col-xs-6">
                    <input type="text" value="{{ $fullname[1]}}" class="inputs inputsLight form-control" disabled="disabled" id="" placeholder="Apellido">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" value="{{ $asesor->cedula }}" class="inputs inputsLight form-control" disabled="disabled" id="" placeholder="Cédula de Identidad">
                </div>
                <div class="col-xs-6">
                    <input type="text" value="{{$asesor->telefono}}" class="inputs inputsLight form-control" disabled="disabled" id="" placeholder="Telefóno">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" disabled="disabled" value="{{$asesor->celular}}" class="inputs inputsLight form-control" id="" placeholder="Celular">
                </div>
                <div class="col-xs-6">
                    <div class="styled-input-single">
                        <input type="checkbox" name="fieldset-5" id="checkbox-example-two" />
                        <label for="checkbox-example-two">¿Certificado?</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Usuario">
                </div>
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Correo">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Contraseña">
                </div>
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Repetir Contraseña">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Fecha de Ingreso">
                </div>
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Rif">
                </div>
            </div>
             <div class="row">
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Dirección">
                </div>
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Fecha de Nacimiento">
                </div>
            </div>
            <div class="row">
                <div class="buttons">
                    <div class="col-xs-3 col-xs-offset-6">
                        <button type="button" class="btnGrayHight">LIMPIAR</button>
                    </div>
                    <div class="col-xs-3">
                        <button type="button" class="btnYellow">ENVIAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection('content')