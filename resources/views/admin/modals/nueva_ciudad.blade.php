  <!-- GO MODAL REPORTS -->
<div class="modal fade" id="nuevaCiudad" tabindex="-1" role="dialog" aria-labelledby="modalReport">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="titleSection"><span id="estadoTag"></span> > Nueva Ciudad </h1>
            </div>
            <div class="modal-body">
                <form class="form marginForm" id="nuevaCiudadForm">
                    <div class="row">
                        <div class="col-xs-1 col-xs-offset-1">
                            <div class="form-group">
                                <label>Nombre:</label>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div class="form-group">
                                <input type="text" class="form-control limpiarCiudad" maxlength="150" name="ciudad" id="ciudad"></input>
                                <input type="hidden" name="estado" id="estado" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body-bottom">
                        <div class="row">
                            <div class="col-xs-7">
                                <div class="row marginBottom20">
                                  <div class="col-xs-6 col-sm-offset-8">
                                      <button type="submit" class="btnYellow right">Crear Ciudad</button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL REPORTS -->
