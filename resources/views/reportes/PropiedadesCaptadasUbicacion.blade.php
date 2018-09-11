@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-condensed" id="registros">
		<thead>
		    <tr class="titulo">
				<th colspan="5">Fecha de Emisión: {{date("d-m-Y")}}</th>
		      	<th>Total Propiedades: {{$totales['totalPropiedades']}}</th>
		      	<th>Total Visitas: {{$totales['visitas']}}</th>
		      	<th>Total Comisión Captación Promedio: {{number_format($totales['comisionPromedio'], 2, ',', '.')}}</th>
		      	<th>Total Precio de Venta Promedio: {{number_format($totales['precioPromedio'], 2, ',', '.')}}</th>
		    </tr>
			</thead>
		<tbody>
		@foreach($estateSelect as $a=>$value)
			<tr class="danger">
				<th class="estados" colspan="5">{{$estateSelect[$a]['nombre']}}</p></th>
      			<th>Propiedades:{{$estateSelect[$a]['cantidadPropiedades']}} </th>
      			<th>Visitas:{{$estateSelect[$a]['visitas']}} </th>
      			<th>Promedio Comisión de captación:{{ number_format($estateSelect[$a]['comisionPromedio'], 2, ',', '.')}} </th>
      			<th>Promedio Precio de Venta : {{ number_format($estateSelect[$a]['precioPromedio'], 2, ',', '.') }}</th>
			</tr>
			@foreach ($citySelect as $b => $value)
				@if($estateSelect[$a]['id']==$citySelect[$b]['padre'])
					<tr class="warning">
						<th class="ciudades" colspan="5">{{$citySelect[$b]['nombre']}}</p></th>
						<th>Propiedades:{{$citySelect[$b]['cantidadPropiedades']}} </th>
      					<th>Visitas:{{$citySelect[$b]['visitas']}} </th>
      					<th>Promedio Comisión de captación:{{ number_format($citySelect[$b]['comisionPromedio'], 2, ',', '.')}} </th>
      					<th>Promedio Precio de Venta : {{ number_format($citySelect[$b]['precioPromedio'], 2, ',', '.') }}</th>
					</tr>
					@foreach ($urbSelect as $c => $value)
						@if($citySelect[$b]['id']==$urbSelect[$c]['padre'])
							<tr class="success">
								<th class="urbanizaciones" colspan="5">{{$urbSelect[$c]['nombre']}}</p></th>
								<th>Propiedades:{{$urbSelect[$c]['cantidadPropiedades']}} </th>
  								<th>Visitas:{{$urbSelect[$c]['visitas']}} </th>
      							<th>Promedio Comisión de captación:{{ number_format($urbSelect[$c]['comisionPromedio'], 2, ',', '.')}} </th>
      							<th>Promedio Precio de Venta : {{ number_format($urbSelect[$c]['precioPromedio'], 2, ',', '.') }}</th>
							</tr>
							<tr class="titulo active">
								<th>MLS</th>
								<th>ID</th>
				      			<th>Tipo Inmueble</th>
				      			<th>Tipo Negocio</th>
				      			<th>Asesor</th>
				      			<th>Fecha de Captación</th>
				      			<th>Cantidad de Visitas</th>
				      			<th>Comisión de Captación (%)</th>
				      			<th>Precio de Venta</th>
							</tr>
							@foreach($propiedadesT as $d=>$value)
								@if($urbSelect[$c]['id']==$propiedadesT[$d]['padre'])
									<tr class="propiedades">
										<th><p class="codigo">{{$propiedadesT[$d]['mls']}}</p></th>
										<th>{{$propiedadesT[$d]['id']}}</th>
						      			<th>{{$propiedadesT[$d]['tipoInmueble']}} </th>
						      			<th>{{$propiedadesT[$d]['tipoNegocio']}} </th>
						      			<th>{{$propiedadesT[$d]['fullName']}}</th>
						      			<th>{{date("d/m/Y", strtotime($propiedadesT[$d]['fecha']))}}</th>
						      			<th>{{$propiedadesT[$d]['visitas']}} </th>
						      			<th>{{ number_format($propiedadesT[$d]['comisionCaptacion'], 2, ',', '.') }} </th>
						      			<th>{{ number_format($propiedadesT[$d]['precio'], 2, ',', '.') }} </th>
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