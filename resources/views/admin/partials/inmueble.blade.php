<div class="col-sm-4">
    <div class="thumbProperty">
        <div class="contentTop">
            <img src="{{ asset('images')}}/{{$img}}" alt="">
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
            </div>
        </div>
        <div class="contentInfo">
            <div class="infoProperty">
                <h4>{{$residencia}}</h4>
                <p><span>Código MLS: </span>{{$code}}</p>
            </div>
            <div class="buttonsAction">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-6">
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
