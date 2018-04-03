  <!-- GO MODAL REPORTS -->
<div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="modalReport">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="titleSection">Nuevo Evento</h1>
            </div>
            <div class="modal-body">
                <form class="form marginForm" id="formularioInforme">
                  <input type="hidden" name="idPropietyModal" id="idPropietyModal" value="">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Observaciones:</label>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div class="form-group">
                                <textarea class="form-control limpiar" maxlength="600" name="observacion" id="observacion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body-bottom">
                        <div class="row">
                            <div class="col-xs-7">
                                <div class="row marginBottom20">
                                  <div class="col-xs-4 col-sm-offset-8">
                                      <button type="submit" class="btnYellow right">Crear</button>
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
