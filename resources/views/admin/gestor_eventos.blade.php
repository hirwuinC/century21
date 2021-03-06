@extends('admin/base_admin')

@section('content')
<div class="padreCalendario">
  @if (Session::has('status'))
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1" id="error">
        <div class="alert alert-danger" role="alert">Usted no tiene acceso a la ruta solicitada!!</div>
        </div>
      </div>
    </div>
  @endif
  <div class="row ">
    <div class="col-xs-10 col-xs-offset-1 cabeceraGestor">
      <div class="col-xs-1 flechaIzquierda">
        <a class="arrow arrow-left" title="Mes Anterior" href=""></a>
      </div>
      <div class="col-xs-10 mes">
        <span>{{$mes}}-{{$year}}</span>
        <input type="hidden" id="fechaCompleta" value="{{date('Y-m-d')}}">
      </div>
      <div class="col-xs-1 flechaDerecha">
        <a class="arrow arrow-right" title="Próximo Mes" href=""></a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1 contDias">
      <table>
        <thead class="dias">
          <tr>
          @for($a=1;$a<=count($dias);$a++)
            <th class="celdaDia" id="columna{{$a}}">
                <span>{{$dias[$a]}}</span>
            </th>
          @endfor
          </tr>
        </thead>
        <tbody>
          <tr class="rowDia">
                @php($last_cell=$primerDia+$ultimoDiaMes)
                <!-- hacemos un bucle hasta 42, que es el máximo de valores que puede
                // haber... 6 columnas de 7 dias-->
                @for($i=1;$i<=42;$i++)
                  @if($i==$primerDia)
                    <!--determinamos en que dia empieza-->
                    @php($day=1)
                  @endif
                  @if($i<$primerDia || $i>=$last_cell)
                    <!-- celda vacia -->
                    <td class="celda"></td>
                  @else
                      <!-- mostramos el dia -->
                      <td class="celda celdallena" data-fecha="{{$day}}">
                        {{$day}}
                        @if(array_key_exists($day, $arreglo))
                          <span class="notification-counter" id="counter{{$day}}">{{$arreglo[$day]}}</span>
                        @endif
                      </td>
                    @php($day++)
                  @endif
                  <!-- cuando llega al final de la semana, iniciamos una columna nueva -->
                  @if($i%7==0)
                    </tr ><tr class='rowDia'>
                  @endif
                @endfor
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@include('admin/modals/nuevo_evento')
@include('admin/modals/historial_evento')
@endsection('content')
@section('js')
    <script type="text/javascript" src="{{ asset('js/admin/gestorEventos/gestorEventos.js') }}"></script>
@endSection
