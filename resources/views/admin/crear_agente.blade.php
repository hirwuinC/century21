@extends('admin/base_admin')

@section('content')
<h2 class="titleSection">EDITAR ASESOR</h2>
<form action="{{ route('buscar_user') }}" enctype="multipart/form-data" class="agenteForm" id="asesorCreate" method="post">
     {{ csrf_field() }}
    <div class="row">
        <div class="col-xs-3 containers">
            <div class="containertAvatar">
                <img class="image" src="{{ asset('images/asesores')}}/{{$avatar->src}}" alt="">
                <div class="editAvatar">
                  <button class="file-upload">
                    <input type="file" name="image" accept="image/png, .jpeg, .jpg, image/gif" class="file-input"><i class="fa fa-camera" aria-hidden="true"></i>
                  </button>
                </div>
            </div>
        </div>
        <div class="col-xs-9">
            <div class="row">
                <div class="col-xs-12">
                    <label for="">Nombre Asesor</label>
                    <input type="hidden" name="argument" value="{{ $asesor->id}}">
                    <input type="text" value="{{$asesor->fullName}}" disabled="disabled" class="inputs inputsLight form-control"  placeholder="Nombre">
                </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                  <label for="">Correo Electrónico</label>
                  <input type="text" class="inputs inputsLight form-control" name="emailUser" value="{{ $asesor->email }}" placeholder="Correo">
              </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <label for="">Telefono Fijo</label>
                    <input type="text" value="{{$asesor->telefono}}" class="inputs inputsLight form-control" disabled="disabled"  placeholder="Telefóno">
                </div>

                <div class="col-xs-6">
                    <label for="">Telefono Móvil</label>
                    <input type="text" disabled="disabled" value="{{$asesor->celular}}" class="inputs inputsLight form-control"  placeholder="Celular">
                </div>
            </div>
        </div>
        <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="">Cédula de Identidad</label>
                        <input type="text"  class="inputs inputsLight form-control" value="{{ $usuario->cedula }}" name="cedula" id="cedula" maxlength="20" placeholder="V-123456789">
                    </div>
                    <div class="col-xs-6">
                        <label for="">Usuario</label>
                        <input type="text" class="inputs inputsLight form-control" maxlength="20" name="user" id="user" value="{{ $usuario->name }}" placeholder="Usuario">
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <label for="">Contraseña</label>
                        <input type="password" class="inputs inputsLight form-control" maxlength="20" id="pass" name="pass" value="{{ $password }}" placeholder="Contraseña">
                    </div>
                    <div class="col-xs-6">
                        <label for="">Repetir Contraseña</label>
                        <input type="password" class="inputs inputsLight form-control" maxlength="20" id="repeatPass" name="repeatPass" value="{{ $password }}"placeholder="Repetir Contraseña">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <label for="dateEntry">Fecha de Ingreso</label>
                        <input type="date" class="inputs inputsLight form-control" name="dateEntry" id="dataEntry" value="{{ $usuario->date_entry }}" placeholder="Fecha de Ingreso">
                    </div>
                    <div class="col-xs-6">
                      <label for="dateBirth">Fecha de Nacimiento</label>
                        <input type="date" class="inputs inputsLight form-control" id="dateBirth" name="dateBirth" value="{{$usuario->date_birth}}" placeholder="Fecha de Nacimiento">
                    </div>

                </div>
                 <div class="row">
                    <div class="col-xs-6">
                        <label for="">Dirección de Habitación</label>
                        <input type="text" class="inputs inputsLight form-control" maxlength="150" id="addressUser" name="addressUser" value="{{$usuario->address_user}}" placeholder="Dirección">
                    </div>
                    <div class="col-xs-6">
                        <label for="">RIF</label>
                        <input type="text" class="inputs inputsLight form-control" maxlength="20" id="rifUser" name="rifUser" value="{{ $usuario->rif_user }}" placeholder="Rif (V123456789)">
                    </div>
                </div>
                 <div class="row">
                    <div class="col-xs-6">
                        <label for="">Perfil de usuario</label>
                        <select class="inputs inputsLight form-control" id="rolUser" name="rolUser" >
                            <option value="">Seleccione un perfil</option>
                            @foreach($roles as $rol)
                              @if($rol->id == $usuario->rol_id)
                                <option value="{{$usuario->rol_id}}"selected>{{$rol->nombre}}</option>
                              @else
                                <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                              @endif

                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <div class="styled-input-single">
                          @if($usuario->certified_asesor==1)
                            <input type="checkbox" name="certified" value="1" checked="checked" id="checkbox-example-two" />
                          @else
                            <input type="checkbox" name="certified" value="1" id="checkbox-example-two" />
                          @endif
                          <label for="checkbox-example-two">¿Asesor Certificado?</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="buttons">
                        <div class="col-xs-3 col-xs-offset-6">
                            <button type="button" id='buttonReset' class="btnGrayHight">LIMPIAR</button>
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
    <script type="text/javascript" src="{{ asset('js/admin/asesor/validador.js') }}"></script>
@endSection
