<!-- Modal -->
<div class="modal fade" id="modalpublishHere" tabindex="-1" role="dialog" aria-labelledby="modalpublishHereLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="columnsHeader">
                    <div class="row">
                        <div class="col-xs-2">
                            <img src="images/logo-header.png" alt="">
                        </div>
                        <div class="col-xs-9">
                            <h4 class="modal-title textCenter" id="modalpublishHereLabel">publica con nosotros</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form class="form">
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
                                <label for="email">Correo electrónico</label>
                                <input type="text" class="form-control" id="email" placeholder="ejemplo@ejemplo.com">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="phone">teléfono</label>
                                <input type="text" class="form-control" id="phone" placeholder="+58 999 9999999">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>tipo de inmueble</label>
                                <select class="form-control">
                                    <option class="displayNone">seleccionar</option>
                                    <option>residencial</option>
                                    <option>comercial</option>
                                    <option>industrial</option>
                                    <option>vacacional</option>
                                    <option>terrenos</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>tipo de negociación</label>
                                <select class="form-control">
                                    <option class="displayNone">seleccionar</option>
                                    <option>venta</option>
                                    <option>alquiler</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>ubicación del inmueble</label>
                                <div class="googleMap">
                                    <iframe style="width: 100%" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6660.605222999498!2d-70.60553820000001!3d-33.415354099999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2scl!4v1508169047050" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>comentarios</label>
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <button type="button" class="btnYellow">ENVIAR</button>
                </div>
            </div>
        </div>
    </div>
</div>