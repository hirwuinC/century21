
@foreach ($negociaciones as $negociacion)
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading{{$negociacion->id}}">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapse{{$negociacion->id}}" aria-expanded="false" aria-controls="collapse{{$negociacion->id}}">
                Fecha de Inicio de Negociacion: {{$negociacion->fechaCreacion}} Estatus de Negociación:{{$negociacion->descripcionEstatus}}
            </a>
        </h4>
    </div>
        <div id="collapse{{$negociacion->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$negociacion->id}}">
            <div class="panel-body">
              @foreach($pasosNegociaciones as $paso)
                @if($paso->negociacion_id == $negociacion->id)
                <div class="alert alertGrayLight marginBottom20" role="alert">
                    {{$paso->descripcionEstatus}} - {{$paso->fechaEstatus}}
                </div>
                @endif
              @endforeach
            </div>
        </div>
    </div>
@endforeach
