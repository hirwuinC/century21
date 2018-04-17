  <!-- GO MODAL REPORTS -->
<div class="modal fade" id="nuevaUrbanizacion" tabindex="-1" role="dialog" aria-labelledby="modalReport">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="titleSection">Nueva Urbanización</h1>
            </div>
            <div class="modal-body">
                <form class="form marginForm" id="nuevaUrbanizacionForm">
                    <div class="row">
                        <div class="col-xs-2 col-xs-offset-1 ">
                            <div class="form-group">
                                <label>Nombre:</label>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div class="form-group">
                                <input type="text" class="form-control limpiar" maxlength="150" name="urbanizacion" id="urbanizacion"></input>
                                <input type="hidden" name="ciudadId" id="ciudadId" value="">
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
