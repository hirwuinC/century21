
<div class="col-sm-3 thumbPropiety">
    <div class="thumbProperty">
        <div class="contentTop">
            <img class="imgInmueble" src="{{ asset('images')}}{{$img}}" alt="">
        </div>
        <div class="contentInfo">
            <div class="buttonsAction">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-6">
                            <button type="button" class="btnAcction btnCargar">
                                <input type="hidden" id="index-{{$contador}}" class="register" name="register" value="{{$contador}}">
                                <input type="file" name="image[]" accept="image/png, .jpeg, .jpg, image/gif" class="file-input">Cargar
                            </button>
                        </div>
                        <div class="col-xs-6">
                            <button type="button" class="btnAcction btnBorrar">
                                Borrar
                            </button>
                        </div>
                    </div>
                </div>
                <div class='row'>
                  <div class='col-xs-12'>
                    <div class='col-xs-6 col-xs-offset-4' >
                      <div class="styled-input-single">
                        {{$marcador}}
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
