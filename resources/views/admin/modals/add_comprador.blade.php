<!-- GO MODAL REPORTS -->
<div class="modal fade" id="modalAddComprador" tabindex="-1" role="dialog" aria-labelledby="modalReport">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h1 class="titleSection">Perfil del Comprador</h1>
          </div>
          <div class="modal-body">
              <form class="form marginForm" id="formularioComprador">
                <input type="hidden" name="idPropiedadComprador" id="idPropiedadComprador" value="">
                  <div class="modal-body-top">
                    <div class="row">
                      <div class="col-xs-4">
                          <div class="form-group">
                              <label>Cédula de Identidad del Comprador:</label>
                          </div>
                      </div>
                      <div class="col-xs-8">
                          <div style="padding-bottom:20px;" >
                              <input type="text" class="inputs inputsLight form-control limpiarComprador" maxlength="25" name="cedulaComprador" id="cedulaComprador" placeholder="V0123456789">
                          </div>
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Nombre del comprador:</label>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div style="padding-bottom:20px;" >
                                <input type="text" class="inputs inputsLight form-control limpiarComprador" maxlength="100" name="nombreComprador" id="nombreComprador" placeholder="Nombre Completo">
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Correo electrónico del comprador:</label>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div style="padding-bottom:20px;" >
                                <input type="text" class="inputs inputsLight form-control limpiarComprador" maxlength="100" name="correoComprador" id="correoComprador" placeholder="micorreo@midominio.com">
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Fecha de Nacimiento:</label>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div style="padding-bottom:20px;" >
                                <input type="date" class="inputs inputsLight form-control limpiarComprador" min="0" maxlength="10" name="edad" id="edad" placeholder="Años">
                            </div>
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <ul class="viewRadio marginBottom20">
                                  <li><h6>Sexo</h6></li>
                                  <li>
                                      <div class="styled-input-single">
                                          <input type="radio" name="sexoComprador" value="1" id="masculino" checked="checked"/>
                                          <label for="masculino">M</label>
                                      </div>
                                  </li>
                                  <li>
                                      <div class="styled-input-single">
                                          <input type="radio" name="sexoComprador" value="0" id="femenino" />
                                          <label for="femenino" >F</label>
                                      </div>
                                  </li>
                              </ul>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Ocupación</label>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div style="padding-bottom:20px;" >
                                <input type="text" class="inputs inputsLight form-control limpiarComprador" maxlength="100" name="ocupacion" id="ocupacion" placeholder="Profesión u Ocupación">
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Grupo Familiar:</label>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div style="padding-bottom:20px;" >
                                <input type="number" class="inputs inputsLight form-control limpiarComprador" min="0" maxlength="10" name="grupoFamiliar" id="grupoFamiliar" placeholder="Cantidad de Personas">
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="modal-body-bottom">
                      <div class="row">
                          <div class="col-xs-7">
                              <div class="row marginBottom20">
                                <div class="col-xs-4 col-sm-offset-8">
                                    <button type="submit" class="btnYellow right">Cargar</button>
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
