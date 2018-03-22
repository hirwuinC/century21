  <!-- GO MODAL REPORTS -->
<div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="modalReport">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="titleSection">Información Básica</h1>
            </div>
            <div class="modal-body">
                <form class="form marginForm" id="formularioInforme">
                  <input type="hidden" id="idPropietyModal" value="">
                    <div class="modal-body-top">
                        <div class="row">
                          <div class="col-xs-4">
                              <div class="form-group">
                                  <label>Nombre cliente:</label>
                              </div>
                          </div>
                          <div class="col-xs-8">
                              <div style="padding-bottom:20px;" >
                                  <input type="text" class="inputs inputsLight form-control limpiar" name="nombreCliente" id="nombreCliente" value="">
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-4">
                              <div class="form-group">
                                  <label>Fecha de Inicio Contrato Exclusiva:</label>
                              </div>
                          </div>
                          <div class="col-xs-8">
                              <div style="padding-bottom:20px;" >
                                  <input type="date" class="inputs inputsLight form-control limpiar" name="contratoExclusiva" id="contratoExclusiva" value="">
                              </div>
                          </div>
                        </div>
                        <h1 class="titleSection">Promoción del Inmueble</h1>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Colocación de Rótulo Comercial:</label>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <textarea class="form-control limpiar" name="rotuloComercial" id="rotuloComercial"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Volanteo digital a base de datos del sistema:</label>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <textarea class="form-control limpiar" name="volanteoDigital" id="volanteoDigital"></textarea>
                                </div>
                            </div>
                        </div>
                        <h1 class="titleSection">Publicación en portales de internet</h1>
                        <div class="row marginBottom20">
                            <div class="col-xs-4">
                                <label>century21venezuela.com</label>
                            </div>
                            <div class="col-xs-8">
                                <input type="text" name="codigoVenezuela" id="codigoVenezuela" class="form-control limpiar">
                            </div>
                        </div>
                        <div class="row marginBottom20">
                            <div class="col-xs-4">
                                <label>century21caracas.com</label>
                            </div>
                            <div class="col-xs-8">
                                <input type="text" name="codigoCaracas" id="codigoCaracas" class="form-control limpiar">
                            </div>
                        </div>
                        <div class="row marginBottom20">
                            <div class="col-xs-4">
                                <label>tuinmueble.com</label>
                            </div>
                            <div class="col-xs-8">
                                <input type="text" name="codigoTuInmueble" id="codigoTuInmueble" class="form-control limpiar">
                            </div>
                        </div>
                        <div class="row marginBottom20">
                            <div class="col-xs-4">
                                <label>conlallave.com</label>
                            </div>
                            <div class="col-xs-8">
                                <input type="text" name="codigoConLaLlave" id="codigoConLaLlave" class="form-control limpiar">
                            </div>
                        </div>
                        <div class="row marginBottom20">
                            <div class="col-xs-4">
                                <label>Visitas totales en portales:</label>
                            </div>
                            <div class="col-xs-4">
                                <input type="number" min="0" name="visitasDigitales" id="visitasDigitales" class="form-control limpiar">
                            </div>
                        </div>
                        <h1 class="titleSection">Compradores Interesados</h1>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="viewRadio marginBottom20">
                                    <li><h6>¿Existen Compradores Interesados?</h6></li>
                                    <li>
                                        <div class="styled-input-single">
                                            <input type="radio" name="compradorInteresado" value="1" id="compradorInteresadoSi" checked="checked"/>
                                            <label for="compradorInteresadoSi">Si</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="styled-input-single">
                                            <input type="radio" name="compradorInteresado" value="0" id="compradorInteresadoNo" />
                                            <label for="compradorInteresadoNo" >No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="compradoresInteresados">
                          <div class="row marginBottom20">
                              <div class="col-xs-4">
                                  <label>Compradores Interesados Total:</label>
                              </div>
                              <div class="col-xs-4">
                                  <input type="number" min="0" name="cantidadCInteresados" id="cantidadCInteresados" class="form-control limpiar ocultoInteresado">
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Nombre Interesado 1:</label>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div style="padding-bottom:20px;" >
                                    <input type="text" class="inputs inputsLight form-control limpiar ocultoInteresado" name="interesado1" id="interesado1" value="">
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Nombre Interesado 2:</label>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div style="padding-bottom:20px;" >
                                    <input type="text" class="inputs inputsLight form-control limpiar ocultoInteresado" name="interesado2" id="interesado2" value="">
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Nombre Interesado 3:</label>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div style="padding-bottom:20px;" >
                                    <input type="text" class="inputs inputsLight form-control limpiar ocultoInteresado" name="interesado3" id="interesado3" value="">
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Nombre Interesado 4:</label>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div style="padding-bottom:20px;" >
                                    <input type="text" class="inputs inputsLight form-control limpiar ocultoInteresado" name="interesado4" id="interesado4" value="">
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Nombre Interesado 5:</label>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div style="padding-bottom:20px;" >
                                    <input type="text" class="inputs inputsLight form-control limpiar ocultoInteresado" name="interesado5" id="interesado5" value="">
                                </div>
                            </div>
                          </div>
                        </div>
                        <h1 class="titleSection">Visitas Físicas</h1>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="viewRadio marginBottom20">
                                    <li><h6>¿Nuevas Visitas físicas al inmueble?</h6></li>
                                    <li>
                                        <div class="styled-input-single">
                                            <input type="radio" name="visitasFisicas" id="visitasFisicasSi" value="1" checked="checked"/>
                                            <label for="visitasFisicasSi">Si</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="styled-input-single">
                                            <input type="radio" name="visitasFisicas" id="visitasFisicasNo" value="0" />
                                            <label for="visitasFisicasNo">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                          </div>
                          <div class="evaluaciones">
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Cantidad de visitas físicas:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" min="0" name="cantidadVisitasFisicas" id="cantidadVisitasFisicas" class="form-control limpiar ocultoEvaluacion">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Muy caro:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="text" name="caro" id="caro" class="form-control limpiar ocultoEvaluacion">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>En malas condiciones:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="text" name="malasCondiciones" id="malasCondiciones" class="form-control limpiar ocultoEvaluacion">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Mal ubicado:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="text" name="malUbicado" id="malUbicado" class="form-control limpiar ocultoEvaluacion">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Forma de pago N/A:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="text" name="formaPago" id="formaPago" class="form-control limpiar ocultoEvaluacion">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>En espera:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="text" name="enEspera" id="enEspera" class="form-control limpiar ocultoEvaluacion">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Quiere volver a visitar:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="text" name="volverVisitar" id="volverVisitar" class="form-control limpiar ocultoEvaluacion">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Otro:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="text" name="otro" id="otro" class="form-control limpiar ocultoEvaluacion">
                                </div>
                            </div>
                          </div>
                        <h1 class="titleSection">Comentarios</h1>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Observaciones:</label>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <textarea class="form-control limpiar" name="observacion" id="observacion"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Recomendaciones:</label>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <textarea class="form-control limpiar" name="recomendacion" id="recomendacion"></textarea>
                                </div>
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
