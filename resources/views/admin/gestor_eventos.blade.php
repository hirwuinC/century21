@extends('admin/base_admin')

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="col-xs-2 col-xs-offset-5 cabeceraGestor">
        <span>{{$mes}}</span>
        <span></span>
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
            <?php
              $last_cell=$primerDia+$ultimoDiaMes;
              // hacemos un bucle hasta 42, que es el máximo de valores que puede
              // haber... 6 columnas de 7 dias
              for($i=1;$i<=42;$i++)
              {
                if($i==$primerDia)
                {
                  // determinamos en que dia empieza
                  $day=1;
                }
                if($i<$primerDia || $i>=$last_cell)
                {
                  // celca vacia
                  echo "<td>&nbsp;</td>";
                }else{
                  // mostramos el dia
                    echo "<td>$day</td>";
                  $day++;
                }
                // cuando llega al final de la semana, iniciamos una columna nueva
                if($i%7==0)
                {
                  echo "</tr ><tr class='rowDia'>\n";
                }
              }
            ?>
        </tr>
      </tbody>
    </table>
  </div>
</div>

@endsection('content')
@section('js')
    <script type="text/javascript" src="{{ asset('js/admin/gestorEventos/gestorEventos.js') }}"></script>
@endSection
