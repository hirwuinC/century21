@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-condensed" id="registros">
		<thead>
		    <tr class="totales">
		      	<th>Fecha de Emisión: {{date("d-m-Y")}} </th>
		      	<th>Operaciones Cerradas: {{$cantidades['operaciones']}}</th>
		      	<th>Total Ventas: {{ number_format($cantidades['totalVentas'], 2, ',', '.') }}</th>
		      	<th >Ingreso Bruto: {{ number_format($cantidades['ingresoBruto'], 2, ',', '.') }}</th>
				<th colspan="3">Pago Casa Matriz: {{ number_format($cantidades['pagoMatriz'], 2, ',', '.') }}</th>
				<th colspan="3">Ingreso Neto: {{ number_format($cantidades['ingresoNeto'], 2, ',', '.') }}</th>
		    </tr>
		</thead>
		
			@foreach($aux1 as $a=>$value)
				<tr class="totales success">
					<th class="asesores" colspan="10">{{$aux1[$a]['nombre']}} <p class="codigo">Cod.#{{$aux1[$a]['codigo']}}</p></th>
				</tr>
				<tr class="totales active">
					<th></th>
					<th colspan="3">Cierre de operaciones por tipo de intermediación</th>
					<th colspan="2">Captación segun exclusividad de venta Century 21</th>
					<th colspan="4">Efectividad</th>
				</tr>
				<tr class="totales active">
					<th>Antiguedad (Meses)</th>
					<th>Captador</th>
					<th>Cerrador </th>
					<th>Captador-Cerrador</th>
					<th>Exclusiva</th>
					<th>Sin Exclusiva</th>
					<th colspan="2">Propiedades Captadas</th>
					<th colspan="2">Propiedades Vendidas</th>
				</tr>
				<tr class="totales">
					<th>{{$aux1[$a]['antiguedad']}}</th>
					<th>{{$aux1[$a]['captador']}}</th>
					<th>{{$aux1[$a]['cerrador']}}</th>
					<th>{{$aux1[$a]['ambos']}}</th>
					<th>{{$aux1[$a]['propiedadExclusiva']}}</th>
					<th>{{$aux1[$a]['propiedadSinExclusiva']}}</th>
					<th colspan="2">{{$aux1[$a]['propiedadesCaptadas']}}</th>
					<th colspan="2">{{$aux1[$a]['propiedadesVendidas']}}</th>
				</tr>
				@foreach($aux2 as $b=>$value)
					@foreach($aux2[$b] as $c=>$value)
						@if($aux2[$b][$c]['padre']==$aux1[$a]['id'])
							<tr class="totales active">
								<th class="asesor" colspan="10">{{$aux2[$b][$c]['nombreTipo']}}</th>
							</tr>
							<tr class="totales active">
								<th colspan="5">Operaciones por Venta</th>
								<th colspan="5">Operaciones por Alquiler</th>
							</tr>
							<tr class="totales active">
								<th>Operaciones</th>
								<th>Total Ventas</th>
								<th>Ingreso Bruto</th>
								<th>Pago Matriz</th>
								<th>Ingreso Neto</th>
								<th>Operaciones</th>
								<th>Total Ventas</th>
								<th>Ingreso Bruto</th>
								<th>Pago Matriz</th>
								<th>Ingreso Neto</th>
							</tr>
							<tr class="totales">
								<th>{{$aux2[$b][$c]['propiedadVenta']}}</th>
								<th>{{ number_format($aux2[$b][$c]['totalVenta'], 2, ',', '.') }}</th>
		      					<th>{{ number_format($aux2[$b][$c]['comisionBrutaVenta'], 2, ',', '.') }}</th>
								<th>{{ number_format($aux2[$b][$c]['pagoMatrizVenta'], 2, ',', '.') }}</th>
								<th>{{ number_format($aux2[$b][$c]['ingresoNetoVenta'], 2, ',', '.') }}</th>
								<th>{{$aux2[$b][$c]['propiedadAlquiler']}}</th>
								<th>{{ number_format($aux2[$b][$c]['totalAlquiler'], 2, ',', '.') }}</th>
		      					<th>{{ number_format($aux2[$b][$c]['comisionBrutaAlquiler'], 2, ',', '.') }}</th>
								<th>{{ number_format($aux2[$b][$c]['pagoMatrizAlquiler'], 2, ',', '.') }}</th>
								<th>{{ number_format($aux2[$b][$c]['ingresoNetoAlquiler'], 2, ',', '.') }}</th>
							</tr>
						@endif
					@endforeach
				@endforeach
			@endforeach
		</tbody>
	</table>
@endsection
