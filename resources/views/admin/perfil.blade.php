@extends('admin/base_admin')

@section('content')
<form action="" class="avatarForm">
    <div class="row">
        <div class="col-xs-3">
            <div class="containertAvatar">
                <img src="{{ asset('images/img-avatar.jpg') }}" alt="">
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
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Email">
                </div>
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Email">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Email">
                </div>
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Email">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Email">
                </div>
                <div class="col-xs-6">
                    <input type="text" class="inputs inputsLight form-control" id="" placeholder="Email">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <input type="text" class="inputs inputsLight form-control" id="exampleInputEmail1" placeholder="Email">
                </div>
            </div>
            <div class="row">
                <div class="buttons">
                    <div class="col-xs-3 col-xs-offset-6">
                        <button type="button" class="btnGray">CANCELAR</button>
                    </div>
                    <div class="col-xs-3">
                        <button type="button" class="btnYellow">ENVIAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
