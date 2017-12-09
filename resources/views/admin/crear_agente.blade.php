@extends('admin/base_admin')

@section('content')
<h2 class="titleSection">EDITAR ASESOR</h2>
<form action="" class="agenteForm" id="asesorCreate" method="post">
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
                    <input type="text" value="{{ $fullname[1] }}" class="inputs inputsLight form-control" disabled="disabled" id="" placeholder="Apellido">
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
            @if($usuario)
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" name="user" id="user" value="{{ $usuario->name }}" placeholder="Usuario">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="emailUser" name="emailUser" value="{{ $usuario->email }}" placeholder="Correo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="pass" name="pass" value="{{ $usuario->password }}" placeholder="Contraseña">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="repeatPass" placeholder="Repetir Contraseña">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" name="dataEntry" id="dataEntry" value="{{$usuario->data_entry}}" placeholder="Fecha de Ingreso">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="rifUser" name="rifUser" value="{{$usuario->rif_user}}" placeholder="Rif">
                    </div>
                </div>
                 <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="addressUser" name="addressUser" value="$usuario->address_user" placeholder="Dirección">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="dateBirth" name="dateBirth" value="{{$usuario->date_birth}}" placeholder="Fecha de Nacimiento">
                    </div>
                </div>
                 <div class="row">
                    <div class="col-xs-6">
                        <select class="inputs inputsLight form-control" id="rolUser" name="rolUser" >
                            <option>Seleccione un perfil</option>
                            <option value="1">Adeministrador</option>
                            <option value="2">Asesor</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="buttons">
                        <div class="col-xs-3 col-xs-offset-6">
                            <button type="button" class="btnGrayHight">LIMPIAR</button>
                        </div>
                        <div class="col-xs-3">
                            <button type="submit" id="buttonCreate" class="btnYellow">ENVIAR</button>
                        </div>
                    </div>
                </div>
               

            @else
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" name="user" id="user" placeholder="Usuario">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="emailUser" name="emailUser" placeholder="Correo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="pass" name="pass" placeholder="Contraseña">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="repeatPass" placeholder="Repetir Contraseña">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" name="dataEntry" id="dataEntry" placeholder="Fecha de Ingreso">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="rifUser" name="rifUser" placeholder="Rif">
                    </div>
                </div>
                 <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="addressUser" name="addressUser" placeholder="Dirección">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="inputs inputsLight form-control" id="dateBirth" name="dateBirth" placeholder="Fecha de Nacimiento">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <select class="inputs inputsLight form-control" id="rolUser" name="rolUser">
                            <option>Seleccione un perfil</option>
                            <option value="1">Administrador</option>
                            <option value="2">Asesor</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="buttons">
                        <div class="col-xs-3 col-xs-offset-6">
                            <button type="button" class="btnGrayHight">LIMPIAR</button>
                        </div>
                        <div class="col-xs-3">
                            <button type="submit" id="buttonCreate" class="btnYellow">ENVIAR</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</form>
@endsection('content')
@section('js')
    <script type="text/javascript" src="{{ asset('js/admin/asesor/validador.js') }}""></script>
@endSection