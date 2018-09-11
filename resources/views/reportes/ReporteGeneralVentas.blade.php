@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-condensed" id="registros">
		<thead>
		    <tr class="totales">
		      	<th>Fecha de Emisión: {{date("d-m-Y")}} </th>
		      	<th>Operaciones Cerradas: {{$cantidades['operaciones']}}</th>
		      	<th>Operaciones Reportadas: {{$cantidades['reportadas']}}</th>
		      	<th>Total Ventas: {{ number_format($cantidades['totalVentas'], 2, ',', '.') }}</th>
		      	<th>Ingreso Bruto: {{ number_format($cantidades['ingresoBruto'], 2, ',', '.') }}</th>
				<th>Pago Casa Matriz: {{ number_format($cantidades['pagoMatriz'], 2, ',', '.') }}</th>
				<th>Ingreso Neto: {{ number_format($cantidades['ingresoNeto'], 2, ',', '.') }}</th>
		    </tr>
			</thead>
		<tbody>
			<tr class="totales danger">
				<th  class="asesor" colspan="7">Tipo de Intermediación</th>
			</tr>
			<tr class="totales active">
				<th colspan="2">Captador</th>
				<th colspan="2">Cerrador </th>
				<th colspan="3">Captador-Cerrador</th>
			</tr>
			<tr class="totales">
				<th colspan="2">{{$cantidades['captadas']}}</th>
				<th colspan="2">{{$cantidades['cerradas']}}</th>
				<th colspan="3">{{$cantidades['CACI']}}</th>

			</tr>
			<tr class="totales danger">
				<th  class="asesor" colspan="7">Tipo de Negocio</th>
			</tr>
			<tr class="totales warning">
				<th class="asesor" colspan="7">Venta</th>
			</tr>
			<tr class="totales active">
				<th>Operaciones Cerradas</th>
				<th>Ingreso Bruto</th>
				<th>Pago Casa Matriz</th>
				<th>Ingreso Neto</th>
				<th colspan="3">Total Ventas</th>		
			</tr>
			<tr class="totales">
				<th>{{$cantidades['operacionesVenta']}}</th>
				<th>{{ number_format($cantidades['ingresoBrutoVenta'], 2, ',', '.') }}</th>
				<th>{{ number_format($cantidades['pagoMatrizVenta'], 2, ',', '.') }}</th>
				<th>{{ number_format($cantidades['ingresoNetoVenta'], 2, ',', '.') }}</th>
				<th colspan="3">{{ number_format($cantidades['totalVentasVenta'], 2, ',', '.') }}</th>
			</tr>
			<tr class="totales warning">
				<th class="asesor" colspan="7">Alquiler</th>
			</tr>
			<tr class="totales active">
				<th>Operaciones Cerradas</th>
				<th>Ingreso Bruto</th>
				<th>Pago Casa Matriz</th>
				<th>Ingreso Neto</th>
				<th colspan="3">Total Alquileres</th>		
			</tr>
			<tr class="totales">
				<th>{{$cantidades['operacionesAlquiler']}}</th>
				<th>{{ number_format($cantidades['ingresoBrutoAlquiler'], 2, ',', '.') }}</th>
				<th>{{ number_format($cantidades['pagoMatrizAlquiler'], 2, ',', '.') }}</th>
				<th>{{ number_format($cantidades['ingresoNetoAlquiler'], 2, ',', '.') }}</th>
				<th colspan="3">{{ number_format($cantidades['totalVentasAlquiler'], 2, ',', '.') }}</th>
			</tr>
			<tr class="totales success">
				<th  class="asesor" colspan="7">Tipo de Inmueble</th>
			</tr>
			<tr class="totales warning">
				<th class="asesor" colspan="7">Terreno</th>
			</tr>
			<tr class="totales active">
				<th>Operaciones Cerradas</th>
				<th>Precio de Venta Promedio</th>
				<th>Ingreso Neto</th>
				<th colspan="4">Total Ventas</th>		
			</tr>
			<tr class="totales">
				<th>{{$cantidades['operacionesTerreno']}}</th>
				<th>{{ number_format($cantidades['promedioPrecioTerreno'], 2, ',', '.') }}</th>
				<th>{{ number_format($cantidades['ingresoNetoTerreno'], 2, ',', '.') }}</th>
				<th colspan="4">{{ number_format($cantidades['totalVentasTerreno'], 2, ',', '.') }}</th>
			</tr>
			<tr class="totales warning">
				<th class="asesor" colspan="7">Local Comercial</th>
			</tr>
			<tr class="totales active">
				<th>Operaciones Cerradas</th>
				<th>Precio de Venta Promedio</th>
				<th>Ingreso Neto</th>
				<th colspan="4">Total Ventas</th>		
			</tr>
			<tr class="totales">
				<th>{{$cantidades['operacionesComercial']}}</th>
				<th>{{ number_format($cantidades['promedioPrecioComercial'], 2, ',', '.') }}</th>
				<th>{{ number_format($cantidades['ingresoNetoComercial'], 2, ',', '.') }}</th>
				<th colspan="4">{{ number_format($cantidades['totalVentasComercial'], 2, ',', '.') }}</th>
			</tr>
			<tr class="totales warning">
				<th class="asesor" colspan="7">Residencial</th>
			</tr>
			<tr class="totales active">
				<th>Operaciones Cerradas</th>
				<th>Precio de Venta Promedio</th>
				<th>Ingreso Neto</th>
				<th colspan="4">Total Ventas</th>		
			</tr>
			<tr class="totales">
				<th>{{$cantidades['operacionesResidencial']}}</th>
				<th>{{ number_format($cantidades['promedioPrecioResidencial'], 2, ',', '.') }}</th>
				<th>{{ number_format($cantidades['ingresoNetoResidencial'], 2, ',', '.') }}</th>
				<th colspan="4">{{ number_format($cantidades['totalVentasResidencial'], 2, ',', '.') }}</th>
			</tr>
			<tr class="totales warning">
				<th class="asesor" colspan="7">Vacacional</th>
			</tr>
			<tr class="totales active">
				<th>Operaciones Cerradas</th>
				<th>Precio de Venta Promedio</th>
				<th>Ingreso Neto</th>
				<th colspan="4">Total Ventas</th>		
			</tr>
			<tr class="totales">
				<th>{{$cantidades['operacionesVacacional']}}</th>
				<th>{{ number_format($cantidades['promedioPrecioVacacional'], 2, ',', '.') }}</th>
				<th>{{ number_format($cantidades['ingresoNetoVacacional'], 2, ',', '.') }}</th>
				<th colspan="4">{{ number_format($cantidades['totalVentasVacacional'], 2, ',', '.') }}</th>
			</tr>
			<tr class="totales warning">
				<th class="asesor" colspan="7">Industrial</th>
			</tr>
			<tr class="totales active">
				<th>Operaciones Cerradas</th>
				<th>Precio de Venta Promedio</th>
				<th>Ingreso Neto</th>
				<th colspan="4">Total Ventas</th>		
			</tr>
			<tr class="totales">
				<th>{{$cantidades['operacionesIndustrial']}}</th>
				<th>{{ number_format($cantidades['promedioPrecioIndustrial'], 2, ',', '.') }}</th>
				<th>{{ number_format($cantidades['ingresoNetoIndustrial'], 2, ',', '.') }}</th>
				<th colspan="4">{{ number_format($cantidades['totalVentasIndustrial'], 2, ',', '.') }}</th>
			</tr>
			
		</tbody>
	</table>
@endsection
