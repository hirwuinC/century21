<div class="col-sm-4 hijo">
    <div class="thumbProperty">
        <div class="contentTop">
            {{$img}}
            <div class="caption">
                <div class="businessType">
                    <p>{{$type}}</p>
                </div>
                <div class="priceProject">
                    <p>{{$price}}</p>
                </div>
                <div class="editProperty">
                  {{$editar}}
                </div>
                <div class="deleteProperty" data-id="{{$code}}">
                  {{$eliminar}}
                </div>
            </div>
        </div>
        <div class="contentInfo">
            <div class="infoProperty">
                <h4>{{$residencia}}</h4>
                <p><span>Tipo de Inmueble: </span>{{$tipoInmueble}}</p>
                <p><span>Código MLS: </span>{{$codeMLS}}</p>
                <p><span>Código: </span>{{$code}}</p>
                <p><span>Asesor: </span>{{$asesor}}</p>
            </div>
            <div class="buttonsAction">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-6">
                            <input type="hidden" class="inmueble" value="{{$id}}">
                            {{$cambioEstatus}}
                        </div>
                        <div class="col-xs-6">
                            <input type="hidden" class="id" value="{{$id}}">
                            <button type="button" id="detalleAction" class="btnAcction detalleAction" data-toggle="modal" data-target="#detailInmueble">
                                Detalle
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
