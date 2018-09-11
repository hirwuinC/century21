@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered  table-condensed" id="registros">
		<thead>
		    <tr class="totales">
		      <th colspan="5">Fecha de Emisión: {{date("d-m-Y")}}</th>
		      <th>Total Propiedades: {{$totales['totalPropiedades']}}</th>
		      <th>Total Visitas: {{$totales['visitas']}}</th>
		      <th>Total Comisión Captación Promedio: {{number_format($totales['comisionPromedio'], 2, ',', '.')}}</th>
		      <th>Total Precio de Venta Promedio: {{number_format($totales['precioPromedio'], 2, ',', '.')}}</th>
		    </tr>
		</thead>
		<tbody>
		@foreach($listaAsesores as $i=>$value)
			<tr class="active">
				<th class="asesores" colspan="5">{{$listaAsesores[$i]['nombre']}} <p class="codigo">Cod.#{{$listaAsesores[$i]['codigo']}}</p>
				</th>
      			<th>Cantidad de propiedades:{{$listaAsesores[$i]['cantidadPropiedades']}} </th>
      			<th>Visitas:{{$listaAsesores[$i]['visitas']}} </th>
      			<th>Promedio Comisión de captación:{{ number_format($listaAsesores[$i]['comisionPromedio'], 2, ',', '.')}} </th>
      			<th>Promedio Precio de Venta : {{ number_format($listaAsesores[$i]['precioPromedio'], 2, ',', '.') }}</th>
			</tr>
			<tr class="titulo">
				<th>MLS</th>
				<th>ID</th>
      			<th>Tipo Inmueble</th>
      			<th>Tipo Negocio</th>
      			<th>Ciudad</th>
      			<th>Fecha de Captación</th>
      			<th>Cantidad de Visitas</th>
      			<th>Comisión de Captación (%)</th>
      			<th>Precio de Venta</th>
			</tr>
			@foreach($propiedadesT as $b=>$value )
				@if($listaAsesores[$i]['id']==$propiedadesT[$b]['agente'])
					<tr class="propiedades">
						<th><p class="codigo">{{$propiedadesT[$b]['mls']}}</p></th>
						<th>{{$propiedadesT[$b]['id']}}</th>
		      			<th>{{$propiedadesT[$b]['tipoInmueble']}} </th>
		      			<th>{{$propiedadesT[$b]['tipoNegocio']}} </th>
		      			<th>{{$propiedadesT[$b]['ciudad']}}</th>
		      			<th>{{date("d/m/Y", strtotime($propiedadesT[$b]['fecha']))}}</th>
		      			<th>{{$propiedadesT[$b]['visitas']}} </th>
		      			<th>{{ number_format($propiedadesT[$b]['comisionCaptacion'], 2, ',', '.') }} </th>
		      			<th>{{ number_format($propiedadesT[$b]['precio'], 2, ',', '.') }} </th>
					</tr>
				@endif
			@endforeach
		@endforeach
		</tbody>
	</table>
@endsection
