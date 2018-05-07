<!-- Modal -->
<div class="modal fade" id="modalpublishHere" tabindex="-1" role="dialog" aria-labelledby="modalpublishHereLabel">
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
                            <h4 class="modal-title textCenter" id="modalpublishHereLabel">publica con nosotros</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="nuevoVendedor" enctype="multipart/form-data" class="form">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="name">Nombres</label>
                                <input type="text" class="form-control limpiarVendedor" id="nombreVendedor" name="nombreVendedor" placeholder="Nombres">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="lastname">Apellidos</label>
                                <input type="text" class="form-control limpiarVendedor" id="apellidoVendedor" name="apellidoVendedor" placeholder="Apellidos">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="text" class="form-control limpiarVendedor" id="emailVendedor"  name="emailVendedor" placeholder="ejemplo@ejemplo.com">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="phone">teléfono</label>
                                <input type="text" class="form-control limpiarVendedor" id="phoneVendedor" name="phoneVendedor" placeholder="+58 999 9999999">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>tipo de inmueble</label>
                                <select class="form-control limpiarVendedor" id="tipoInmueble" name="tipoInmueble">
                                    <option class="displayNone"value="">Seleccione una opción</option>
                                    @foreach($tipoInmuebles as $tipoInmueble)
                                      <option value="{{$tipoInmueble->id}}">{{$tipoInmueble->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>tipo de negociación</label>
                                <select class="form-control limpiarVendedor" id="tipoNegocio" name="tipoNegocio">
                                    <option class="displayNone" value="">seleccione una opción</option>
                                    <option value="venta">Venta</option>
                                    <option value="alquiler">Alquiler</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                          <div class="form-group">
                              <label>Dirección del inmueble</label>
                              <textarea class="form-control limpiarVendedor" id="direccion" name="direccion"></textarea>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Caracteristicas del inmueble</label>
                                <textarea class="form-control limpiarVendedor" id="comentarioVendedor" name="comentarioVendedor"></textarea>
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
