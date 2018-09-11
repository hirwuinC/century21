@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-condensed" id="registros">
		<thead>
		    <tr class="titulo">
				<th colspan="6">Fecha de Emisión: {{date("d-m-Y")}}</th>
				<th>Total Propiedades: {{$totales['totalPropiedades']}}</th>
				<th>Total PVP Promedio Captación: {{ number_format($totales['precioCAPromedio'], 2, ',', '.') }}</th>
				<th>Total PVP Promedio Cierre: {{ number_format($totales['precioCIPromedio'], 2, ',', '.') }}</th>
				<th>Total Promedio Comisión Captación: {{number_format($totales['comisionCAPromedio'], 2, ',', '.')}}</th>
				<th>Total Promedio Comisión Cierre: {{number_format($totales['comisionCIPromedio'], 2, ',', '.')}}</th>
				<th>Total Ganancia Neta: {{number_format($totales['ganancia'], 2, ',', '.')}}</th>
		    </tr>
			</thead>
		<tbody>
		@foreach($estateSelect as $a=>$value)
			<tr class="danger">
				<th class="estados" colspan="6">{{$estateSelect[$a]['nombre']}}</p></th>
      			<th>Propiedades:{{$estateSelect[$a]['cantidadPropiedades']}} </th>
      			<th>PVP Promedio Captación:{{ number_format($estateSelect[$a]['precioCAPromedio'], 2, ',', '.') }}</th>
      			<th>PVP Promedio Cierre:{{ number_format($estateSelect[$a]['precioCIPromedio'], 2, ',', '.') }}</th>
      			<th>Promedio Comisión Captación:{{ number_format($estateSelect[$a]['comisionCAPromedio'], 2, ',', '.')}} </th>
      			<th>Promedio Comisión Captación:{{ number_format($estateSelect[$a]['comisionCIPromedio'], 2, ',', '.')}} </th>
      			<th>Ganancia Neta: {{ number_format($estateSelect[$a]['ganancia'], 2, ',', '.') }}</th>
			</tr>
			@foreach ($citySelect as $b => $value)
				@if($estateSelect[$a]['id']==$citySelect[$b]['padre'])
					<tr class="warning">
						<th class="ciudades" colspan="6">{{$citySelect[$b]['nombre']}}</p></th>
						<th>Propiedades:{{$citySelect[$b]['cantidadPropiedades']}} </th>
			      		<th>PVP Promedio Captación:{{ number_format($citySelect[$b]['precioCAPromedio'], 2, ',', '.') }}</th>
			      		<th>PVP Promedio Cierre:{{ number_format($citySelect[$b]['precioCIPromedio'], 2, ',', '.') }}</th>
			      		<th>Promedio Comisión Captación:{{ number_format($citySelect[$b]['comisionCAPromedio'], 2, ',', '.')}} </th>
			      		<th>Promedio Comisión Captación:{{ number_format($citySelect[$b]['comisionCIPromedio'], 2, ',', '.')}} </th>
			      		<th>Ganancia Neta: {{ number_format($citySelect[$b]['ganancia'], 2, ',', '.') }}</th>
					</tr>
					@foreach ($urbSelect as $c => $value)
						@if($citySelect[$b]['id']==$urbSelect[$c]['padre'])
							<tr class="success">
								<th class="urbanizaciones" colspan="6">{{$urbSelect[$c]['nombre']}}</p></th>
								<th>Propiedades:{{$urbSelect[$c]['cantidadPropiedades']}} </th>
					      		<th>PVP Promedio Captación:{{ number_format($urbSelect[$c]['precioCAPromedio'], 2, ',', '.') }}</th>
					      		<th>PVP Promedio Cierre:{{ number_format($urbSelect[$c]['precioCIPromedio'], 2, ',', '.') }}</th>
					      		<th>Promedio Comisión Captación:{{ number_format($urbSelect[$c]['comisionCAPromedio'], 2, ',', '.')}} </th>
					      		<th>Promedio Comisión Captación:{{ number_format($urbSelect[$c]['comisionCIPromedio'], 2, ',', '.')}} </th>
					      		<th>Ganancia Neta: {{ number_format($urbSelect[$c]['ganancia'], 2, ',', '.') }}</th>
							</tr>
							<tr class="titulo active">
								<th>MLS </th>
								<th>ID </th>
								<th>Tipo Inmueble </th>
								<th>Tipo Negocio </th>
								<th>Asesor Captador </th>
								<th>Asesor Cerrador </th>
								<th>Fecha de Venta </th>
								<th>PVP Captación </th>
								<th>PVP Cierre </th>
								<th>Comisión Captación (%)</th>
								<th>Comisión Cierre (%)</th>
								<th>Ganancia Neta</th>
							</tr>
							@foreach($propiedadesT as $d=>$value)
								@if($urbSelect[$c]['id']==$propiedadesT[$d]['padre'])
									<tr class="propiedades">
										<th><p class="codigo">{{$propiedadesT[$d]['mls']}}</p></th>
										<th>{{$propiedadesT[$d]['id']}}</th>
										<th>{{$propiedadesT[$d]['tipoInmueble']}} </th>
										<th>{{$propiedadesT[$d]['tipoNegocio']}} </th>
										<th>{{$propiedadesT[$d]['captador']}}</th>
										<th>{{$propiedadesT[$d]['cerrador']}}</th>
										<th>{{date("d/m/Y", strtotime($propiedadesT[$d]['fechaVenta']))}}</th>
										<th>{{ number_format($propiedadesT[$d]['precioCA'], 2, ',', '.') }} </th>
										<th>{{ number_format($propiedadesT[$d]['precioCI'], 2, ',', '.') }} </th>
										<th>{{ number_format($propiedadesT[$d]['comisionCA'], 2, ',', '.') }} </th>
										<th>{{ number_format($propiedadesT[$d]['comisionCI'], 2, ',', '.') }} </th>
										<th>{{ number_format($propiedadesT[$d]['ganancia'], 2, ',', '.') }} </th>
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