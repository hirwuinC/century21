@extends('base')

@section('content')
<div class="container">
    <div class="row">
        <!-- GO CONTENT INFO -->
        <div class="col-xs-12 col-sm-8">
            <h1 class="titleSection">Contactanos</h1>
            <section class="detailProperties">
                <form action="" class="contactForm">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="name">Nombres</label>
                                <input type="text" class="form-control" id="name" placeholder="Nombres">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="lastname">Apellidos</label>
                                <input type="text" class="form-control" id="lastname" placeholder="Apellidos">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="phone">teléfono</label>
                                <input type="text" class="form-control" id="phone" placeholder="+58 999 9999999">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="text" class="form-control" id="email" placeholder="ejemplo@ejemplo.com">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>comentarios</label>
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                            <button type="button" class="btnYellow">ENVIAR</button>
                        </div>
                    </div>
                </form>
                <div class="ubicationProperties">
                    <h1 class="titleSection">OFICINAS</h1>
                    <p><span>Direccion: </span>Altamira Sur con Av José Félix Sosa , Edificio Terepaima Piso 2 Oficina 203. Frente al la Torre Británica (Edificio Duncan de Altamira), Caracas 1060</p>
                    <div class="googleMap">
                        <iframe style="width: 100%" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6660.605222999498!2d-70.60553820000001!3d-33.415354099999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2scl!4v1508169047050" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-xs-12 col-sm-4">
            @include('common/proyectosLaterales')
            @include('common/inmueblesLaterales')
        </div>
    </div>
</div>

@endsection
