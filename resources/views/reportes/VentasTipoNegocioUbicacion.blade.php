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
		      	<th>Total Operaciones </th>
				<th>Total Promedio Precio Final</th>
				<th>Total Ventas</th>
				<th>Total IngresoBruto</th>
				<th>Total Pago Casa Matriz</th>
				<th>Total Ingreso Neto</th>
		    </tr>
		    <tr class="totales">
		    	<th>{{$totales['operaciones']}}</th>
					<th>{{ number_format($totales['promedioPrecio'], 2, ',', '.') }}</th>
					<th>{{ number_format($totales['totalVentas'], 2, ',', '.') }}</th>
					<th>{{ number_format($totales['ingresoBruto'], 2, ',', '.') }}</th>
					<th>{{ number_format($totales['pagoMatriz'], 2, ',', '.') }}</th>
					<th>{{ number_format($totales['ingresoNeto'], 2, ',', '.') }}</th>
		    </tr>
		</thead>
		<tbody>
		@foreach($estateSelect as $a=>$value)
			<tr class="danger totales">
				<th class="asesor" colspan="6">{{$estateSelect[$a]['nombre']}}</p>
				</th>
			</tr>
			<tr class="danger totales">
				<th> Total Operaciones </th>
				<th>Total Promedio Precio Final</th>
				<th>Total Ventas</th>
				<th>Total IngresoBruto</th>
				<th>Total Pago Casa Matriz</th>
				<th>Total Ingreso Neto</th>
			</tr>
			<tr class="totales">
				<th>{{$estateSelect[$a]['operaciones']}}</th>
				<th>{{ number_format($estateSelect[$a]['promedioPrecio'], 2, ',', '.') }}</th>
				<th>{{ number_format($estateSelect[$a]['totalVentas'], 2, ',', '.') }}</th>
				<th>{{ number_format($estateSelect[$a]['ingresoBruto'], 2, ',', '.') }}</th>
				<th>{{ number_format($estateSelect[$a]['pagoMatriz'], 2, ',', '.') }}</th>
				<th>{{ number_format($estateSelect[$a]['ingresoNeto'], 2, ',', '.') }}</th>
			</tr>
			@foreach ($citySelect as $b => $value)
				@if($estateSelect[$a]['id']==$citySelect[$b]['padre'])
					<tr class="warning totales">
						<th class="asesor" colspan="6">{{$citySelect[$b]['nombre']}}</p>
						</th>
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
						<th>{{$citySelect[$b]['operaciones']}}</th>
						<th>{{ number_format($citySelect[$b]['promedioPrecio'], 2, ',', '.') }}</th>
						<th>{{ number_format($citySelect[$b]['totalVentas'], 2, ',', '.') }}</th>
						<th>{{ number_format($citySelect[$b]['ingresoBruto'], 2, ',', '.') }}</th>
						<th>{{ number_format($citySelect[$b]['pagoMatriz'], 2, ',', '.') }}</th>
						<th>{{ number_format($citySelect[$b]['ingresoNeto'], 2, ',', '.') }}</th>
					</tr>
					@foreach ($urbSelect as $c => $value)
						@if($citySelect[$b]['id']==$urbSelect[$c]['padre'])
							<tr class="success totales">
								<th class="asesor" colspan="6">{{$urbSelect[$c]['nombre']}}</p>
								</th>
							</tr>
							<tr class="success totales">
								<th> Total Operaciones </th>
								<th>Total Promedio Precio Final</th>
								<th>Total Ventas</th>
								<th>Total IngresoBruto</th>
								<th>Total Pago Casa Matriz</th>
								<th>Total Ingreso Neto</th>
							</tr>
							<tr class="totales">
								<th>{{$citySelect[$b]['operaciones']}}</th>
								<th>{{ number_format($urbSelect[$c]['promedioPrecio'], 2, ',', '.') }}</th>
								<th>{{ number_format($urbSelect[$c]['totalVentas'], 2, ',', '.') }}</th>
								<th>{{ number_format($urbSelect[$c]['ingresoBruto'], 2, ',', '.') }}</th>
								<th>{{ number_format($urbSelect[$c]['pagoMatriz'], 2, ',', '.') }}</th>
								<th>{{ number_format($urbSelect[$c]['ingresoNeto'], 2, ',', '.') }}</th>
							</tr>
							@foreach($aux20 as $e=>$value)
								@if($urbSelect[$c]['id']==$aux20[$e]['padre'])
									<tr class="active">
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
										<th>{{$aux20[$e]['operacionesVenta']}}</th>
										<th>{{ number_format($aux20[$e]['promedioPrecioVenta'], 2, ',', '.') }}</th>
										<th>{{ number_format($aux20[$e]['totalVentasVenta'], 2, ',', '.') }}</th>
										<th>{{ number_format($aux20[$e]['ingresoBrutoVenta'], 2, ',', '.') }}</th>
										<th>{{ number_format($aux20[$e]['pagoMatrizVenta'], 2, ',', '.') }}</th>
										<th>{{ number_format($aux20[$e]['ingresoNetoVenta'], 2, ',', '.') }}</th>
									</tr>
									<tr class="active">
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
										<th>{{$aux20[$e]['operacionesAlquiler']}}</th>
										<th>{{ number_format($aux20[$e]['promedioPrecioAlquiler'], 2, ',', '.') }}</th>
										<th>{{ number_format($aux20[$e]['totalVentasAlquiler'], 2, ',', '.') }}</th>
										<th>{{ number_format($aux20[$e]['ingresoBrutoAlquiler'], 2, ',', '.') }}</th>
										<th>{{ number_format($aux20[$e]['pagoMatrizAlquiler'], 2, ',', '.') }}</th>
										<th>{{ number_format($aux20[$e]['ingresoNetoAlquiler'], 2, ',', '.') }}</th>
									</tr>
								@endif
							@endforeach
						@endif
					@endforeach
				@endif
			@endforeach
		@endforeach
		</tbody>
	</table>
@endsection