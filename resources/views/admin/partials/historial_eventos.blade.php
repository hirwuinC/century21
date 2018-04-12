@foreach($asesores as $asesor)
  @if(array_key_exists($asesor->fullName, $arreglo))
    <div class="Asesor">
      <div class="col-xs-8 col-sm-offset-2">
        <h1 class="titleSection">{{$asesor->fullName}}</h1>
      </div>
      <div class="eventosAsesor">
          @for($i=0;$i<count($arreglo[$asesor->fullName]);$i++)
            @if($agente==$arreglo[$asesor->fullName][$i]->creador)
              <div class="row">
                  <div class="col-xs-8 col-sm-offset-2">
                      <div class="form-group">
                          <button type="button" class="close close-event" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <textarea class="form-control limpiar modificarCampo" maxlength="150" name="evento" id="evento">{{$arreglo[$asesor->fullName][$i]->descripcion}}</textarea>
                          <input type="hidden" class="registro" value="{{$arreglo[$asesor->fullName][$i]->id}}">
                      </div>
                  </div>
              </div>
            @else
              <div class="row">
                  <div class="col-xs-8 col-sm-offset-2">
                      <div class="form-group">
                          <textarea class="form-control limpiar modificarCampo" maxlength="150" disabled name="evento" id="evento">{{$arreglo[$asesor->fullName][$i]->descripcion}}</textarea>
                          <input type="hidden" id="contador" value="">
                      </div>
                  </div>
              </div>
            @endif
          @endfor
      </div>
    </div>

  @endif
@endforeach
