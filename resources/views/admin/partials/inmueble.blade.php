<div class="col-sm-4">
    <div class="thumbProperty">
        <div class="contentTop">
            <img src="{{ asset('images')}}/{{$img}}" alt="">
            <div class="caption">
                <div class="businessType">
                    <p>{{$type}}</p>
                </div>
                <div class="priceProject">
                    <p><span>Bsf.:</span> {{$price}}</p>
                </div>
                <div class="editProperty">
                    <a href="">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="contentInfo">
            <div class="infoProperty">
                <h4><a href="{{$url}}">{{$residencia}}</a></h4>
                <p><span>Código MLS: </span>{{$code}}</p>
            </div>
            <div class="buttonsAction">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-6">
                            <button type="button" class="btnAcction" data-toggle="modal" data-target="#cambioStatus">
                                Cambiar Estatus
                            </button>
                        </div>
                        <div class="col-xs-6">
                            <button type="button" class="btnAcction" data-toggle="modal" data-target="#detailInmueble">
                                Detalle
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>