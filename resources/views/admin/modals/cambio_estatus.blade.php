<div class="modal fade" id="cambioStatus" tabindex="-1" role="dialog" aria-labelledby="myModalStatus">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="titleSection">Cambio de estatus</h1>
                <input type="hidden" id="propiedadGeneral" value="">
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs marginForm" role="tablist">
                    <li role="presentation"><a href="#home" id="tabNewNegotiation" aria-controls="home" role="tab" data-toggle="tab">NUEVA NEGOCIACIÓN</a></li>
                    <li role="presentation"><a href="#profile" id="tabNegotiation" aria-controls="profile" role="tab" data-toggle="tab">NEGOCIACIÓN EN CURSO</a></li>
                    <li role="presentation"><a href="#messages" id="tabHistory" aria-controls="messages" role="tab" data-toggle="tab">HISTORIAL DE NEGOCIACIONES</a></li>
                </ul>

                <!-- Tab panes -->

          <!-- //////// NUEVA NEGOCIACIÓN /////////////////////////-->
                <div class="tab-content marginForm">
                    <div role="tabpanel" class="tab-pane " id="home">
                        <form action="" class="newNegotation" id="newNegotation">
                            <input type="hidden" name="asesorCaptador" id="asesorCaptador" value="">
                            <input type="hidden" name="propiedad" id="propiedad" value="">
                            <input type="hidden" name="comisionCaptacion" id="comisionCaptacion" value="">
                            <div class="row marginBottom20">
                                <div class="col-xs-12">
                                    <label for="asesorCerrador">Asesor cerrador de la operación</label>
                                    <select id="asesorCerrador" class="" name="asesorCerrador">
                                        <option value="">Seleccione un asesor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row marginBottom20"  id="comisionCompartida">
                                <div class="col-xs-12">
                                    <label for="">Porcentaje de comisión correspondiente por la operación compartida</label>
                                    <input type="number" min="0" max="100" name="comisionCompartida" id="comisionCompartidaInput" class="form-control" placeholder="% de comisión compartida" value="">
                                </div>
                            </div>
                            <div class="row marginBottom20" id="personaComparte">
                                <div class="col-xs-12">
                                    <label for="">Responsable de la otra punta</label>
                                      <input type="text" name="personaComparte" id="personaComparteInput" class="form-control" placeholder="oficina, asesor...">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-12">
                                    <label for="">Monto final de la negociación</label>
                                    <input type="number" name="montoFinal" class="form-control" placeholder="Monto en Bs.">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-12">
                                    <label for="">Porcentaje de comisión de Cierre</label>
                                    <input type="number" min="0" max="100" name="comisionCierre" class="form-control" placeholder="% de comisión de cierre">
                                </div>
                            </div>
                            <div class="row">
                                <div class="modal-footer">
                                    <div class="col-xs-4 col-xs-offset-8">
                                        <button type="submit" class="btnYellow">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

    <!-- //////// NEGOCIACION EN CURSO /////////////////////////-->

                    <div role="tabpanel" class="tab-pane" id="profile">
                      <div class="row cont-negotiation">
                        <div class="col-xs-3 ">
                          <div class="row  estatusInmueble ">
                              <div class="col-xs-12">
                                  <label for="estatusInmueble">Estatus del inmueble</label>
                                  <select id="estatusInmueble" class="inputs inputsLight form-control " name="asesorCerrador">
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <button type="button" id="cancelNegotiation" class="btnRed">Cancelar Negociación</button>
                              </div>
                          </div>
                        </div>
                        <div class="col-xs-9 newNegotation">
                          <div class="title-progress" style="text-align:center;">
                              <span>Progreso de Negociación<span>
                          </div>
                          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                              <div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="paso1">
                                      <h4 class="panel-title">
                                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#paso1collapse" aria-expanded="true" aria-controls="paso1collapse">
                                              Propuesta de compra aprobada
                                          </a>
                                      </h4>
                                  </div>
                                  <div id="paso1collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="paso1collapse">
                                      <div class="panel-body">
                                        <div class="row marginBottom20">
                                          <form id="newPropuesta">
                                            <div class="col-xs-8">
                                                <label for="datePropuesta">Fecha de aprobacion de propuesta</label>
                                                <input type="date" class="form-control paso" name="datePropuesta" id="datePropuesta">
                                                <input type="hidden" class="form-control" name="idNegociacion" id="idNegociacion">
                                            </div>
                                            <div class="col-xs-4">
                                                <button type="submit" class="btnYellow" id="datePropuestaSubmit" >Guardar</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="paso2">
                                      <h4 class="panel-title">
                                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#paso2collapse" aria-expanded="false" aria-controls="paso2collapse">
                                              Depósito en garantía
                                          </a>
                                      </h4>
                                  </div>
                                  <div id="paso2collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="paso2">
                                      <div class="panel-body">
                                        <div class="row marginBottom20">
                                          <form id="newDeposito">
                                            <div class="col-xs-8">
                                                <label for="dateGarantia">Fecha de depósito en garantía</label>
                                                <input type="date" class="form-control paso" name="dateGarantia" id="dateGarantia">
                                                <input type="hidden" class="form-control" name="idNegociacionGarantia" id="idNegociacionGarantia">
                                            </div>
                                            <div class="col-xs-4">
                                                <button class="btnYellow" id="garantiaSubmit" type="submit">Guardar</button>
                                            </div>
                                          </form>

                                        </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="paso3">
                                      <h4 class="panel-title">
                                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#paso3collapse" aria-expanded="false" aria-controls="paso3collapse">
                                              Promesa Bilateral
                                          </a>
                                      </h4>
                                  </div>
                                  <div id="paso3collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="paso3">
                                      <div class="panel-body">
                                        <div class="row marginBottom20">
                                          <form id="newBilateral">
                                            <div class="col-xs-6">
                                                <label for="dateBilateral">Fecha de promesa bilateral</label>
                                                <input type="date" class="form-control paso" name="dateBilateral" id="dateBilateral">
                                                <input type="hidden" class="form-control" name="idNegociacionBilateral" id="idNegociacionBilateral">
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="styled-input-single" style="margin-top:20px;">
                                                    <input type="checkbox" name="pagoComision" value="1" id="comision1" />
                                                    <label for="comision1" id="prueba">¿Comisión Pagada?</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <button class="btnYellow  btnYellowEstatus" id="bilateralSubmit" type="submit">Guardar</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="paso4">
                                      <h4 class="panel-title">
                                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#paso4collapse" aria-expanded="false" aria-controls="paso4collapse">
                                              Firma Registro
                                          </a>
                                      </h4>
                                  </div>
                                  <div id="paso4collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="paso4">
                                      <div class="panel-body">
                                        <div class="row marginBottom20">
                                          <form id="newRegistro">
                                            <div class="col-xs-6">
                                                <label for="dateBilateral">Fecha de firma en registro</label>
                                                <input type="date" class="form-control paso" name="dateRegistro" id="dateRegistro">
                                                <input type="hidden" class="form-control" name="idNegociacionRegistro" id="idNegociacionRegistro">
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="styled-input-single ocultarComision" style="margin-top:20px;">
                                                    <input type="checkbox" name="pagoComision" value="1" id="comision2" />
                                                    <label for="comision2">¿Comisión Pagada?</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <button class="btnYellow btnYellowEstatus" id="registroSubmit" type="submit">Guardar</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="paso5">
                                      <h4 class="panel-title">
                                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#paso5collapse" aria-expanded="false" aria-controls="paso5collapse">
                                              Reporte de Inmueble Vendido
                                          </a>
                                      </h4>
                                  </div>
                                  <div id="paso5collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="paso5">
                                      <div class="panel-body">
                                        <div class="row marginBottom20">
                                          <form id="newReporte">
                                            <div class="col-xs-8">
                                                <label for="dateBilateral">Fecha de reporte de inmueble</label>
                                                <input type="date" name="dateReporte" class="form-control paso" id="dateReporte">
                                                <input type="hidden" name="idNegociacionReporte" id="idNegociacionReporte" value="">
                                            </div>
                                            <div class="col-xs-4">
                                                <button class="btnYellow" id="reporteSubmit" type="submit">Guardar</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>

<!-- //////// HISTORIAL DE NEGOCIACIÓN /////////////////////////-->

                    <div role="tabpanel" class="tab-pane" id="messages">
                        <div class="panel-group areaResultado" id="accordion1" role="tablist" aria-multiselectable="true">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
