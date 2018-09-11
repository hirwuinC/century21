@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-condensed" id="registros">
		<thead>
		    <tr class="totales">
		      	<th colspan="3">Fecha de Emisión: {{date("d-m-Y")}} </th>
		      	<th>Operaciones Oficina: {{$cantidades['operaciones']}}</th>
		      	<th>Ingreso Bruto Oficina: {{ number_format($cantidades['ingresoBruto'], 2, ',', '.') }}</th>
				<th>Pago Casa Matriz Oficina: {{ number_format($cantidades['pagoMatriz'], 2, ',', '.') }}</th>
				<th>Ingreso Neto Oficina: {{ number_format($cantidades['ingresoNeto'], 2, ',', '.') }}</th>
		    </tr>
			</thead>
		<tbody>

			@foreach($aux1 as $e=>$value)
				<tr class="active">
					<th class="asesor" colspan="3">{{$aux1[$e]['nombre']}}<p class="codigo">Código:# {{$aux1[$e]['codigo']}}</p></th>
					<th>Operaciones Realizadas: {{$aux1[$e]['operaciones']}}</th>
					<th>Ingreso Bruto: {{ number_format($aux1[$e]['ingresoBruto'], 2, ',', '.') }}</th>
					<th>Pago Casa Matriz: {{ number_format($aux1[$e]['pagoMatriz'], 2, ',', '.') }}</th>
					<th>Ingreso Neto: {{ number_format($aux1[$e]['ingresoNeto'], 2, ',', '.') }}</th>
				</tr>
				@foreach($resultado as $i=>$value)
					@if($aux1[$e]['id']==$resultado[$i]['padre'])
						<tr class="totales danger">
							<th class="asesor" colspan="7">Captador</th>
						</tr>
						<tr class="totales active">
							<th>Promedio Captación (%)</th>
							<th>Promedio Cierre (%)</th>
							<th>Promedio Comisión Compartida (%)</th>
							<th>Operaciones Realizadas</th>
							<th>Ingreso Bruto</th>
							<th>Pago Casa Matriz</th>
							<th>Ingreso Neto</th>
						</tr>
						<tr class="totales">
							<th>{{ number_format($resultado[$i]['promedioCaptacionCA'], 2, ',', '.') }}</th>
							<th>{{ number_format($resultado[$i]['promedioCierreCA'], 2, ',', '.') }}</th>
							<th>{{ number_format($resultado[$i]['promedioCompartidoCA'], 2, ',', '.') }}</th>
							<th>{{$resultado[$i]['operacionesCA']}}</th>
							<th>{{ number_format($resultado[$i]['ingresoBrutoCA'], 2, ',', '.') }}</th>
							<th>{{ number_format($resultado[$i]['pagoMatrizCA'], 2, ',', '.') }}</th>
							<th>{{ number_format($resultado[$i]['ingresoNetoCA'], 2, ',', '.') }}</th>
						</tr>
						<tr class="totales warning">
							<th  class="asesor" colspan="7">Cerrador</th>
						</tr>
						<tr class="totales active">
							<th>Promedio Captación (%)</th>
							<th>Promedio Cierre (%)</th>
							<th>Promedio Comisión Compartida (%)</th>
							<th>Operaciones Realizadas</th>
							<th>Ingreso Bruto</th>
							<th>Pago Casa Matriz</th>
							<th>Ingreso Neto</th>
						</tr>
						<tr class="totales">
							<th>{{ number_format($resultado[$i]['promedioCaptacionCI'], 2, ',', '.') }}</th>
							<th>{{ number_format($resultado[$i]['promedioCierreCI'], 2, ',', '.') }}</th>
							<th>{{ number_format($resultado[$i]['promedioCompartidoCI'], 2, ',', '.') }}</th>
							<th>{{$resultado[$i]['operacionesCI']}}</th>
							<th>{{ number_format($resultado[$i]['ingresoBrutoCI'], 2, ',', '.') }}</th>
							<th>{{ number_format($resultado[$i]['pagoMatrizCI'], 2, ',', '.') }}</th>
							<th>{{ number_format($resultado[$i]['ingresoNetoCI'], 2, ',', '.') }}</th>
						</tr>
						<tr class="totales success">
							<th class="asesor" colspan="7">Captador - Cerrador</th>
						</tr>
						<tr class="totales active">
							<th>Promedio Captación (%)</th>
							<th colspan="2">Promedio Cierre (%)</th>
							<th>Operaciones Realizadas</th>
							<th>Ingreso Bruto</th>
							<th>Pago Casa Matriz</th>
							<th>Ingreso Neto</th>
						</tr>
						<tr class="totales">
							<th>{{ number_format($resultado[$i]['promedioCaptacionCACI'], 2, ',', '.') }}</th>
							<th colspan="2">{{ number_format($resultado[$i]['promedioCierreCACI'], 2, ',', '.') }}</th>
							<th>{{$resultado[$i]['operacionesCACI']}}</th>
							<th>{{ number_format($resultado[$i]['ingresoBrutoCACI'], 2, ',', '.') }}</th>
							<th>{{ number_format($resultado[$i]['pagoMatrizCACI'], 2, ',', '.') }}</th>
							<th>{{ number_format($resultado[$i]['ingresoNetoCACI'], 2, ',', '.') }}</th>
						</tr>
					@endif
				@endforeach
			@endforeach
		</tbody>
	</table>
@endsection
