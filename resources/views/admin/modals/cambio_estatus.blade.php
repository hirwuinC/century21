<div class="modal fade" id="cambioStatus" tabindex="-1" role="dialog" aria-labelledby="myModalStatus">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="titleSection">Cambio de estatus</h1>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs marginForm" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">NUEVA NEGOCIACIÓN</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">NEGOCIACIÓN EN CURSO</a></li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">HISTORIAL DE NEGOCIACIONES</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content marginForm">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <form action="" class="newNegotation">
                            <div class="row marginBottom20">
                                <div class="col-xs-6">
                                    <div class="styled-input-single right">
                                        <input type="checkbox" name="fieldset-5" id="checkbox-example-two" />
                                        <label for="checkbox-example-two">¿Compartido?</label>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" placeholder="% de comisión compartida">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-12">
                                    <select class="" name="">
                                        <option value="">Tipo de negociación</option>
                                        <option value="TW">Venta</option>
                                        <option value="TH">Alquiler</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-12">
                                    <input type="text" class="form-control" placeholder="Monto final de negociación">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-12">
                                    <input type="text" class="form-control" placeholder="% comisión de captación">
                                </div>
                            </div>
                            <div class="row marginBottom20">
                                <div class="col-xs-12">
                                    <input type="text" class="form-control" placeholder="% de comisión de cierre">
                                </div>
                            </div>
                            <div class="row">
                                <div class="modal-footer">
                                    <div class="col-xs-4 col-xs-offset-8">
                                        <button type="button" class="btnYellow">ENVIAR</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        2
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Negociación desde 12/12/2012  Hasta : 12/01/2013
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <div class="alert alertGrayLight marginBottom20" role="alert">
                                            Propuesta de compra aprobada 12/12
                                        </div>
                                        <div class="alert alertGrayLight marginBottom20" role="alert">
                                            Depósito en garantía 15/12
                                        </div>
                                        <div class="alert alertGrayLight marginBottom20" role="alert">
                                            Promesa Bilateral 2/01
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Negociación desde 12/12/2012  Hasta : 12/01/2013
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <div class="alert alertGrayLight marginBottom20" role="alert">
                                            Propuesta de compra aprobada 12/12
                                        </div>
                                        <div class="alert alertGrayLight marginBottom20" role="alert">
                                            Depósito en garantía 15/12
                                        </div>
                                        <div class="alert alertGrayLight marginBottom20" role="alert">
                                            Promesa Bilateral 2/01
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Negociación desde 12/12/2012  Hasta : 12/01/2013
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <div class="alert alertGrayLight marginBottom20" role="alert">
                                            Propuesta de compra aprobada 12/12
                                        </div>
                                        <div class="alert alertGrayLight marginBottom20" role="alert">
                                            Depósito en garantía 15/12
                                        </div>
                                        <div class="alert alertGrayLight marginBottom20" role="alert">
                                            Promesa Bilateral 2/01
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>