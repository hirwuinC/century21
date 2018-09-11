<!-- Modal 1-->
<div class="modal fade" id="modaljoinTeam" tabindex="-1" role="dialog" aria-labelledby="modaljoinTeamLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="columnsHeader">
                    <div class="row">
                        <div class="col-xs-2">
                            <img src="{{asset('images/logo-header.png')}}" alt="">
                        </div>
                        <div class="col-xs-9">
                            <h4 class="modal-title textCenter" id="modaljoinTeamLabel">UNETE A NUESTRO EQUIPO DE ASESORES</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body modal-b">
                <form id="uneteEquipo" enctype="multipart/form-data" class="form">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="name">Nombres</label>
                                <input type="text" class="form-control limpiar" id="nombreInteresado" name="nombreInteresado" placeholder="Nombres">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="lastname">Apellidos</label>
                                <input type="text" class="form-control limpiar" id="apellidoInteresado" name="apellidoInteresado" placeholder="Apellidos">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="text" class="form-control limpiar" id="emailInteresado"  name="emailInteresado" placeholder="ejemplo@ejemplo.com">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="phone">teléfono</label>
                                <input type="text" class="form-control limpiar" id="phoneInteresado" name="phoneInteresado" placeholder="+58 999 9999999">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>adjunta tu CV</label>
                                <input type="file" class="limpiar" id="adjuntarCv" name="adjuntarCv">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>comentarios</label>
                                <textarea class="form-control limpiar" id="comentario" name="comentario"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <button type="submit" class="btnYellow">ENVIAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
