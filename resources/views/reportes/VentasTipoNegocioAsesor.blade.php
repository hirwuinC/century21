@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')

	<table class="table table-bordered table-condensed" id="registros">
		<thead>
			<tr class="totales">
				<th colspan="5"></th>
				<th>Fecha de Emisión: {{date("d-m-Y")}}</th>
			</tr>
		    <tr class="totales active">
		      	<th> Total Operaciones </th>
				<th>Total Promedio Precio Final</th>
				<th>Total Ventas</th>
				<th>Total IngresoBruto</th>
				<th>Total Pago Casa Matriz</th>
				<th>Total Ingreso Neto</th>
		    </tr>
		    <tr class="totales">
		    	<th>{{$cantidades['operaciones']}}</th>
					<th>{{ number_format($cantidades['promedioPrecio'], 2, ',', '.') }}</th>
					<th>{{ number_format($cantidades['totalVentas'], 2, ',', '.') }}</th>
					<th>{{ number_format($cantidades['ingresoBruto'], 2, ',', '.') }}</th>
					<th>{{ number_format($cantidades['pagoMatriz'], 2, ',', '.') }}</th>
					<th>{{ number_format($cantidades['ingresoNeto'], 2, ',', '.') }}</th>
		    </tr>
			</thead>
		<tbody>
			@foreach($aux1 as $e=>$value)
				<tr class="danger">
					<th  colspan="6">{{$aux1[$e]['nombre']}}<p class="codigo">Código:# {{$aux1[$e]['codigo']}}</p></th>
				</tr>
				<tr class="warning totales">
					<th> Total Operaciones </th>
					<th>Total Promedio Precio Final</th>
					<th>Total Ventas</th>
					<th>Total IngresoBruto</th>
					<th>Total Pago Casa Matriz</th>
					<th>Total Ingreso Neto</th>
				</tr>
				<tr class="totales">
					<th>{{$aux1[$e]['operacionesTotal']}}</th>
					<th>{{ number_format($aux1[$e]['promedioPrecioTotal'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['totalVentasTotal'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoBrutoTotal'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['pagoMatrizTotal'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoNetoTotal'], 2, ',', '.') }}</th>
				</tr>
				<tr class="success">
					<th class="asesor" colspan="6">Ventas</th>
				</tr>
				<tr class="active totales">
					<th>Operaciones Realizadas</th>
					<th>Promedio Precio Final</th>
					<th>Total Ventas</th>
					<th>IngresoBruto</th>
					<th>Pago Casa Matriz</th>
					<th>Ingreso Neto</th>
				</tr>
				<tr class="totales">
					<th>{{$aux1[$e]['operacionesVentas']}}</th>
					<th>{{ number_format($aux1[$e]['promedioPrecioVentas'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['totalVentasVentas'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoBrutoVentas'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['pagoMatrizVentas'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoNetoVentas'], 2, ',', '.') }}</th>
				</tr>
				<tr class="success">
					<th class="asesor" colspan="6">Alquiler</th>
				</tr>
				<tr class="active totales">
					<th>Operaciones Realizadas</th>
					<th>Promedio Precio Final</th>
					<th>Total Ventas</th>
					<th>IngresoBruto</th>
					<th>Pago Casa Matriz</th>
					<th>Ingreso Neto</th>
				</tr>
				<tr class="totales">
					<th>{{$aux1[$e]['operacionesAlquiler']}}</th>
					<th>{{ number_format($aux1[$e]['promedioPrecioAlquiler'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['totalVentasAlquiler'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoBrutoAlquiler'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['pagoMatrizAlquiler'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoNetoAlquiler'], 2, ',', '.') }}</th>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection
