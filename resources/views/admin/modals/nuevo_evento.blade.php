  <!-- GO MODAL REPORTS -->
<div class="modal fade" id="nuevoEvento" tabindex="-1" role="dialog" aria-labelledby="modalReport">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="titleSection">Nuevo Evento</h1>
            </div>
            <div class="modal-body">
                <form class="form marginForm" id="nuevoEventoForm">
                    <div class="row">
                        <div class="col-xs-1">
                            <div class="form-group">
                                <label>Evento:</label>
                            </div>
                        </div>
                        <div class="col-xs-11">
                            <div class="form-group">
                                <textarea class="form-control limpiar" maxlength="150" name="evento" id="evento"></textarea>
                                <input type="hidden" name="fechaCompletaModal" id="fechaCompletaModal" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body-bottom">
                        <div class="row">
                            <div class="col-xs-7">
                                <div class="row marginBottom20">
                                  <div class="col-xs-6 col-sm-offset-8">
                                      <button type="submit" class="btnYellow right">Crear Evento</button>
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
