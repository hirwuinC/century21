  <!-- GO MODAL REPORTS -->
<div class="modal fade" id="modificarModalReport" tabindex="-1" role="dialog" aria-labelledby="modalReport">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="titleSection">Información Básica</h1>
            </div>
            <div class="modal-body">
                <form class="form marginForm" id="formularioInformeM">
                  <input type="hidden" name="idPropietyModal" id="idPropietyModalM" value="">
                  <input type="hidden" name="idInformeModal" id="idInformeModalM" value="">
                    <div class="modal-body-top">
                        <div class="row">
                          <div class="col-xs-4">
                              <div class="form-group">
                                  <label>Nombre cliente:</label>
                              </div>
                          </div>
                          <div class="col-xs-8">
                              <div style="padding-bottom:20px;" >
                                  <input type="text" class="inputs inputsLight form-control limpiar" maxlength="30" name="nombreCliente" id="nombreClienteM" value="">
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-4">
                              <div class="form-group">
                                  <label>Correo Cliente:</label>
                              </div>
                          </div>
                          <div class="col-xs-8">
                              <div style="padding-bottom:20px;" >
                                  <input type="text" class="inputs inputsLight form-control limpiar" maxlength="60" name="correoCliente" id="correoClienteM" value="">
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
                                  <input type="date" class="inputs inputsLight form-control limpiar" name="contratoExclusiva" id="contratoExclusivaM" value="">
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
                                    <textarea class="form-control limpiar" maxlength="100" name="rotuloComercial" id="rotuloComercialM"></textarea>
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
                                    <textarea class="form-control limpiar" maxlength="100" name="volanteoDigital" id="volanteoDigitalM"></textarea>
                                </div>
                            </div>
                        </div>
                        <h1 class="titleSection">Publicación en portales de internet</h1>
                        <div class="row marginBottom20">
                            <div class="col-xs-4">
                                <label>century21venezuela.com</label>
                            </div>
                            <div class="col-xs-8">
                                <input type="text" name="codigoVenezuela" maxlength="50" id="codigoVenezuelaM" class="form-control limpiar">
                            </div>
                        </div>
                        <div class="row marginBottom20">
                            <div class="col-xs-4">
                                <label>century21caracas.com</label>
                            </div>
                            <div class="col-xs-8">
                                <input type="text" name="codigoCaracas" maxlength="50" id="codigoCaracasM" class="form-control limpiar">
                            </div>
                        </div>
                        <div class="row marginBottom20">
                            <div class="col-xs-4">
                                <label>tuinmueble.com</label>
                            </div>
                            <div class="col-xs-8">
                                <input type="text" name="codigoTuInmueble" maxlength="50" id="codigoTuInmuebleM" class="form-control limpiar">
                            </div>
                        </div>
                        <div class="row marginBottom20">
                            <div class="col-xs-4">
                                <label>conlallave.com</label>
                            </div>
                            <div class="col-xs-8">
                                <input type="text" name="codigoConLaLlave" maxlength="50" id="codigoConLaLlaveM" class="form-control limpiar">
                            </div>
                        </div>
                        <div class="row marginBottom20">
                            <div class="col-xs-4">
                                <label>Visitas totales en portales:</label>
                            </div>
                            <div class="col-xs-4">
                                <input type="number" min="0" name="visitasDigitales" maxlength="11" id="visitasDigitalesM" class="form-control limpiar">
                            </div>
                        </div>
                        <h1 class="titleSection">Compradores Interesados</h1>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="viewRadio marginBottom20">
                                    <li><h6>¿Existen Compradores Interesados?</h6></li>
                                    <li>
                                        <div class="styled-input-single">
                                            <input type="radio" name="compradorInteresadoM" value="1" id="compradorInteresadoSiM" checked/>
                                            <label for="compradorInteresadoSiM">Si</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="styled-input-single">
                                            <input type="radio" name="compradorInteresadoM" value="0" id="compradorInteresadoNoM" />
                                            <label for="compradorInteresadoNoM" >No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="compradoresInteresadosM">
                          <div class="row marginBottom20">
                              <div class="col-xs-4">
                                  <label>Compradores Interesados Total:</label>
                              </div>
                              <div class="col-xs-4">
                                  <input type="number" min="0" name="cantidadCInteresados" maxlength="11" id="cantidadCInteresadosM" class="form-control limpiar ocultoInteresadoM">
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
                                    <input type="text" class="inputs inputsLight form-control limpiar ocultoInteresadoM" maxlength="30" name="interesado1" id="interesado1M" value="">
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
                                    <input type="text" class="inputs inputsLight form-control limpiar ocultoInteresadoM" maxlength="30" name="interesado2" id="interesado2M" value="">
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
                                    <input type="text" class="inputs inputsLight form-control limpiar ocultoInteresadoM" maxlength="30" name="interesado3" id="interesado3M" value="">
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
                                    <input type="text" class="inputs inputsLight form-control limpiar ocultoInteresadoM" maxlength="30" name="interesado4" id="interesado4M" value="">
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
                                    <input type="text" class="inputs inputsLight form-control limpiar ocultoInteresadoM" maxlength="30" name="interesado5" id="interesado5M" value="">
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
                                            <input type="radio" name="visitasFisicasM" id="visitasFisicasSiM" value="1" checked="checked"/>
                                            <label for="visitasFisicasSiM">Si</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="styled-input-single">
                                            <input type="radio" name="visitasFisicasM" id="visitasFisicasNoM" value="0" />
                                            <label for="visitasFisicasNoM">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                          </div>
                          <div class="evaluacionesM">
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Cantidad de visitas físicas:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" min="0" name="cantidadVisitasFisicas" maxlength="11" id="cantidadVisitasFisicasM" class="form-control limpiar ocultoEvaluacionM" value="">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Muy caro:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" maxlength="11" name="caro" id="caroM" class="form-control limpiar ocultoEvaluacionM">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>En malas condiciones:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" maxlength="11" name="malasCondiciones" id="malasCondicionesM" class="form-control limpiar ocultoEvaluacionM">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Mal ubicado:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" maxlength="11" name="malUbicado" id="malUbicadoM" class="form-control limpiar ocultoEvaluacionM">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Forma de pago N/A:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" maxlength="11" name="formaPago" id="formaPagoM" class="form-control limpiar ocultoEvaluacionM">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>En espera:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" maxlength="11" name="enEspera" id="enEsperaM" class="form-control limpiar ocultoEvaluacionM">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Quiere volver a visitar:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" maxlength="11" name="volverVisitar" id="volverVisitarM" class="form-control limpiar ocultoEvaluacionM">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-4">
                                    <label>Otro:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="number" maxlength="11" name="otro" id="otroM" class="form-control limpiar ocultoEvaluacionM">
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
                                    <textarea class="form-control limpiar" maxlength="600" name="observacion" id="observacionM"></textarea>
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
                                    <textarea class="form-control limpiar" maxlength="600" name="recomendacion" id="recomendacionM"></textarea>
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
