@extends('admin/base_admin')

@section('content')
<form enctype="multipart/form-data" class="agenteForm" id="perfilEdit" method="post">
     {{ csrf_field() }}
    <div class="row">
        <div class="col-xs-3 containers">
            <div class="containertAvatar">
                <img class="image" src="{{ asset($avatar->src)}}" alt="">
                <div class="editAvatar">
                  <button class="file-upload">
                    <input type="file" name="image" accept="image/png, .jpeg, .jpg, image/gif" class="file-input"><i class="fa fa-camera" aria-hidden="true"></i>
                  </button>
                </div>
            </div>
        </div>
        <div class="col-xs-9">
            <div class="row">
                <div class="col-xs-6">
                    <label for="">Nombres</label>
                    <input type="hidden" name="argument" value="{{ $asesor->id}}">
                    <input type="text" value="{{ $fullname[0] }}" disabled="disabled" class="inputs inputsLight form-control"  placeholder="Nombre">
                </div>
                <div class="col-xs-6">
                    <label for="">Apellidos</label>
                    <input type="text" value="{{ $fullname[1] }}" class="inputs inputsLight form-control" disabled="disabled"  placeholder="Apellido">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <label for="">Cédula de Identidad</label>
                    <input type="text" value="{{ $asesor->cedula }}" class="inputs inputsLight form-control" disabled="disabled"  placeholder="Cédula de Identidad">
                </div>
                <div class="col-xs-6">
                    <label for="">Telefóno Fijo</label>
                    <input type="text" value="{{$asesor->telefono}}" class="inputs inputsLight form-control" disabled="disabled"  placeholder="Telefóno">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <label for="">Telefóno Móvil</label>
                    <input type="text" disabled="disabled" value="{{$asesor->celular}}" class="inputs inputsLight form-control"  placeholder="Celular">
                </div>
                <div class="col-xs-6">
                    <div class="styled-input-single">
                      @if($asesor->certified_asesor==1)
                        <input type="checkbox" name="certified" disabled="disabled" value="{{$asesor->certified_asesor}}" checked="checked" id="checkbox-example-two" />
                      @else
                        <input type="checkbox" name="certified"  disabled="disabled" value="1" id="checkbox-example-two" />
                      @endif
                       <label for="checkbox-example-two">¿Certificado?</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="">Usuario</label>
                        <input type="text" class="inputs inputsLight form-control" name="user" id="user" disabled="disabled" value="{{ $userall->name }}" placeholder="Usuario">
                    </div>
                    <div class="col-xs-6">
                        <label for="">Correo Electrónico</label>
                        <input type="text" class="inputs inputsLight form-control" id="emailUser" disabled="disabled" name="emailUser" value="{{ $userall->email }}" placeholder="Correo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <label for="">Contraseña</label>
                        <input type="password" class="inputs inputsLight form-control" id="pass" name="pass" value="{{ $password }}" placeholder="Contraseña">
                    </div>
                    <div class="col-xs-6">
                        <label for="">Repetir Contraseña</label>
                        <input type="password" class="inputs inputsLight form-control" id="repeatPass" name="repeatPass" value="{{ $password }}"placeholder="Repetir Contraseña">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <label for="dateEntry">Fecha de Ingreso</label>
                        <input type="date" class="inputs inputsLight form-control" name="dateEntry" id="dataEntry" disabled="disabled" value="{{ $userall->date_entry }}" placeholder="Fecha de Ingreso">
                    </div>
                    <div class="col-xs-6">
                      <label for="dateBirth">Fecha de Nacimiento</label>
                        <input type="date" class="inputs inputsLight form-control" id="dateBirth" name="dateBirth" value="{{$userall->date_birth}}" placeholder="Fecha de Nacimiento">
                    </div>

                </div>
                 <div class="row">
                    <div class="col-xs-6">
                        <label for="">Dirección de Habitación</label>
                        <input type="text" class="inputs inputsLight form-control" id="addressUser" name="addressUser" value="{{$userall->address_user}}" placeholder="Dirección">
                    </div>
                    <div class="col-xs-6">
                        <label for="">RIF</label>
                        <input type="text" class="inputs inputsLight form-control" id="rifUser" name="rifUser" disabled="disabled" value="{{ $userall->rif_user }}" placeholder="Rif (V123456789)">
                    </div>
                </div>
                <div class="row">
                    <div class="buttons">
                        <div class="col-xs-3 col-xs-offset-6">
                            <button type="button" id="buttonReset" class="btnGrayHight">LIMPIAR</button>
                        </div>
                        <div class="col-xs-3">
                            <button type="submit" id="buttonCreate" class="btnYellow">ENVIAR</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</form>
@endsection('content')
@section('js')
    <script type="text/javascript" src="{{ asset('js/admin/perfilValidador.js') }}""></script>
@endSection
