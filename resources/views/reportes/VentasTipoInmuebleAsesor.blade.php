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
					<th class="asesor" colspan="6">Terreno</th>
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
					<th>{{$aux1[$e]['operacionesTerreno']}}</th>
					<th>{{ number_format($aux1[$e]['promedioPrecioTerreno'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['totalVentasTerreno'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoBrutoTerreno'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['pagoMatrizTerreno'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoNetoTerreno'], 2, ',', '.') }}</th>
				</tr>
				<tr class="success">
					<th class="asesor" colspan="6">Local Comercial</th>
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
					<th>{{$aux1[$e]['operacionesComercial']}}</th>
					<th>{{ number_format($aux1[$e]['promedioPrecioComercial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['totalVentasComercial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoBrutoComercial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['pagoMatrizComercial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoNetoComercial'], 2, ',', '.') }}</th>
				</tr>
				<tr class="success">
					<th class="asesor" colspan="6">Residencial</th>
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
					<th>{{$aux1[$e]['operacionesResidencial']}}</th>
					<th>{{ number_format($aux1[$e]['promedioPrecioResidencial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['totalVentasResidencial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoBrutoResidencial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['pagoMatrizResidencial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoNetoResidencial'], 2, ',', '.') }}</th>
				</tr>
				<tr class="success">
					<th class="asesor" colspan="6">Vacacional</th>
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
					<th>{{$aux1[$e]['operacionesVacacional']}}</th>
					<th>{{ number_format($aux1[$e]['promedioPrecioVacacional'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['totalVentasVacacional'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoBrutoVacacional'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['pagoMatrizVacacional'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoNetoVacacional'], 2, ',', '.') }}</th>
				</tr>
				<tr class="success">
					<th class="asesor" colspan="6">Industrial</th>
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
					<th>{{$aux1[$e]['operacionesIndustrial']}}</th>
					<th>{{ number_format($aux1[$e]['promedioPrecioIndustrial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['totalVentasIndustrial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoBrutoIndustrial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['pagoMatrizIndustrial'], 2, ',', '.') }}</th>
					<th>{{ number_format($aux1[$e]['ingresoNetoIndustrial'], 2, ',', '.') }}</th>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection
