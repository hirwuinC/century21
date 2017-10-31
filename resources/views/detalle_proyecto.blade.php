@extends('base')

@section('content')
    <div class="container">
        <div class="row">
            <!-- GO CONTENT INFO -->
            <div class="col-xs-12 col-sm-8">
                <section class="detailProperties">
                    <div class="galleryProperties">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner" role="listbox">
                                        <div class="item active">
                                            <img src="http://placehold.it/1400x600&text=slide1" alt="..." class="img-responsive">
                                        </div>
                                        <div class="item">
                                            <img src="http://placehold.it/1400x600&text=slide2" alt="..." class="img-responsive">
                                        </div>
                                    </div>
                                    <!-- Controls
                                    <a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev">
                                        <i class="fa fa-chevron-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next">
                                        <i class="fa fa-chevron-right"></i>
                                        <span class="sr-only">Next</span>
                                    </a>-->
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators visible-sm-block hidden-xs-block visible-md-block visible-lg-block">
                                        <li data-target="#carousel-custom" data-slide-to="0" class="active">
                                            <img src="http://placehold.it/100x50&text=slide1" alt="..." class="img-responsive">
                                        </li>
                                        <li data-target="#carousel-custom" data-slide-to="1">
                                            <img src="http://placehold.it/100x50&text=slide2" alt="..." class="img-responsive">
                                        </li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="infoDetailProperties">
                        <h2>PROYECTO "RESIDENCIAS MOHECASTEL"</h2>
                        <h3>Caracas, La Castellana</h3>
                        <p>Propiedad ID: 20055, Casa.</p>
                        <br>
                        <div class="descriptionProperties">
                            <section class="genaralInfo">
                                <h1 class="titleSection">Descripción del proyecto</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla placerat augue tellus.
                                    Sed sollicitudin aliquet massa sed efficitur. Cras semper orci neque, nec laoreet
                                    dui mollis eu. Quisque ante nibh, interdum ac ligula eget, scelerisque interdum
                                    augue. Phasellus ultricies tincidunt nunc, nec dignissim diam hendrerit at. Donec
                                    pellentesque dictum lacus, non placerat urna consectetur nec. Phasellus tempus nunc
                                    ac convallis laoreet.</p>
                                <p>Fusce interdum, nisi nec venenatis mollis, nibh diam fringilla magna, condimentum
                                    ornare velit metus eu dui. Nulla ut nunc diam. Nunc id blandit nibh. Mauris eu
                                    tempor metus. Integer sed vehicula dolor. Sed lobortis metus ut risus sollicitudin
                                    ultricies. Aliquam lobortis nec eros in posuere. Suspendisse consequat lectus risus,
                                    in iaculis ex sodales ultrices. Donec est justo, vehicula id efficitur at, facilisis
                                    quis justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tristique,
                                    erat vehicula feugiat tempor, lacus nibh tincidunt eros, id auctor purus nulla non
                                    lectus. Donec id nunc non massa sagittis tristique. Quisque dapibus semper maximus.
                                    Vivamus viverra ex libero, sed volutpat mauris laoreet ac. Donec eu lorem lobortis,
                                    porttitor velit eget, congue dui. Suspendisse potenti.</p>
                            </section>
                            <hr>
                            <section class="characteristicsProperties">
                                <ul>
                                    <li><p>Consultar Precio</li>
                                    <li><i class="fa fa-object-group" aria-hidden="true"></i> 120Mts</li>
                                    <li><i class="fa fa-bed" aria-hidden="true"></i> 3</li>
                                    <li><i class="fa fa-bath" aria-hidden="true"></i> 2</li>
                                    <li><i class="fa fa-car" aria-hidden="true"></i> 1</li>
                                </ul>
                                <p>Fusce interdum, nisi nec venenatis mollis, nibh diam fringilla magna, condimentum
                                    ornare velit metus eu dui. Nulla ut nunc diam. Nunc id blandit nibh. Mauris eu
                                    tempor metus. Integer sed vehicula dolor. Sed lobortis metus ut risus sollicitudin
                                    ultricies. Aliquam lobortis nec eros in posuere. Suspendisse consequat lectus risus,
                                    in iaculis ex sodales ultrices. Donec est justo, vehicula id efficitur at, facilisis
                                    quis justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tristique,
                                    erat vehicula feugiat tempor, lacus nibh tincidunt eros, id auctor purus nulla non
                                    lectus. Donec id nunc non massa sagittis tristique. Quisque dapibus semper maximus.
                                    Vivamus viverra ex libero, sed volutpat mauris laoreet ac. Donec eu lorem lobortis,
                                    porttitor velit eget, congue dui. Suspendisse potenti.</p>
                            </section>
                            <hr>
                            <section class="characteristicsProperties">
                                <ul>
                                    <li><p>Consultar Precio</li>
                                    <li><i class="fa fa-object-group" aria-hidden="true"></i> 90Mts</li>
                                    <li><i class="fa fa-bed" aria-hidden="true"></i> 2</li>
                                    <li><i class="fa fa-bath" aria-hidden="true"></i> 2</li>
                                    <li><i class="fa fa-car" aria-hidden="true"></i> 1</li>
                                </ul>
                                <p>Fusce interdum, nisi nec venenatis mollis, nibh diam fringilla magna, condimentum
                                    ornare velit metus eu dui. Nulla ut nunc diam. Nunc id blandit nibh. Mauris eu
                                    tempor metus. Integer sed vehicula dolor. Sed lobortis metus ut risus sollicitudin
                                    ultricies. Aliquam lobortis nec eros in posuere. Suspendisse consequat lectus risus,
                                    in iaculis ex sodales ultrices. Donec est justo, vehicula id efficitur at, facilisis
                                    quis justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tristique,
                                    erat vehicula feugiat tempor, lacus nibh tincidunt eros, id auctor purus nulla non
                                    lectus. Donec id nunc non massa sagittis tristique. Quisque dapibus semper maximus.
                                    Vivamus viverra ex libero, sed volutpat mauris laoreet ac. Donec eu lorem lobortis,
                                    porttitor velit eget, congue dui. Suspendisse potenti.</p>
                            </section>
                        </div>
                    </div>
                    <div class="ubicationProperties">
                        <h1 class="titleSection">Ubicación</h1>
                        <div class="googleMap">
                            <iframe style="width: 100%" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6660.605222999498!2d-70.60553820000001!3d-33.415354099999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2scl!4v1508169047050" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                </section>
            </div>
            <!-- END CONTENT INFO -->
            <!-- GO CONTENT SIDEBAR -->
            <div class="col-xs-12 col-sm-4">
                <!-- FORM ADVISERS -->
                <section class="contactAdviser">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>CONTACTA A NUESTROS ASESORES</h3>
                            <form action="">
                                <div class="form-group">
                                    <label for="name">Nombres</label>
                                    <input type="text" class="form-control" id="name" placeholder="Nombres">
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Apellidos</label>
                                    <input type="text" class="form-control" id="lastname" placeholder="Apellidos">
                                </div>
                                <div class="form-group">
                                    <label for="phone">teléfono</label>
                                    <input type="text" class="form-control" id="phone" placeholder="+58 999 9999999">
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input type="text" class="form-control" id="email" placeholder="ejemplo@ejemplo.com">
                                </div>
                                <div class="form-group">
                                    <label>comentarios</label>
                                    <textarea class="form-control"></textarea>
                                </div>
                                <button type="button" class="btnGray">ENVIAR</button>
                            </form>
                        </div>
                    </div>
                </section>
                @include('common/inmueblesLaterales')
        </div>
    </div>
@endsection