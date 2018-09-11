@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered  table-condensed" id="registros">
		<thead>
		    <tr class="totales">
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
		@foreach($listaAsesores as $i=>$value)
			<tr class="active">
				<th class="asesores" colspan="6">{{$listaAsesores[$i]['nombre']}} <p class="codigo">Cod.#{{$listaAsesores[$i]['codigo']}}</p></th>
      			<th>Cantidad de propiedades:{{$listaAsesores[$i]['cantidadPropiedades']}} </th>
      			<th>PVP Promedio Captación:{{ number_format($listaAsesores[$i]['precioCAPromedio'], 2, ',', '.') }}</th>
      			<th>PVP Promedio Cierre:{{ number_format($listaAsesores[$i]['precioCIPromedio'], 2, ',', '.') }}</th>
      			<th>Promedio Comisión Captación:{{ number_format($listaAsesores[$i]['comisionCAPromedio'], 2, ',', '.')}} </th>
      			<th>Promedio Comisión Captación:{{ number_format($listaAsesores[$i]['comisionCIPromedio'], 2, ',', '.')}} </th>
      			<th>Ganancia Neta: {{ number_format($listaAsesores[$i]['ganancia'], 2, ',', '.') }}</th>
			</tr>
			<tr class="titulo">
				<th>MLS </th>
				<th>ID </th>
      			<th>Tipo Inmueble </th>
      			<th>Tipo Negocio </th>
      			<th>Ciudad </th>
      			<th>Asesor Cerrador </th>
      			<th>Fecha de Venta </th>
      			<th>PVP Captación </th>
      			<th>PVP Cierre </th>
      			<th>Comisión Captación (%)</th>
      			<th>Comisión Cierre (%)</th>
      			<th>Ganancia Neta</th>
			</tr>
			@foreach($propiedadesT as $b=>$value )
				@if($listaAsesores[$i]['id']==$propiedadesT[$b]['agente'])
					<tr class="propiedades">
						<th><p class="codigo">{{$propiedadesT[$b]['mls']}}</p></th>
						<th>{{$propiedadesT[$b]['id']}}</th>
		      			<th>{{$propiedadesT[$b]['tipoInmueble']}} </th>
		      			<th>{{$propiedadesT[$b]['tipoNegocio']}} </th>
		      			<th>{{$propiedadesT[$b]['ciudad']}}</th>
		      			<th>{{$propiedadesT[$b]['cerrador']}}</th>
		      			<th>{{date("d/m/Y", strtotime($propiedadesT[$b]['fechaVenta']))}}</th>
		      			<th>{{ number_format($propiedadesT[$b]['precioCA'], 2, ',', '.') }} </th>
		      			<th>{{ number_format($propiedadesT[$b]['precioCI'], 2, ',', '.') }} </th>
		      			<th>{{ number_format($propiedadesT[$b]['comisionCA'], 2, ',', '.') }} </th>
		      			<th>{{ number_format($propiedadesT[$b]['comisionCI'], 2, ',', '.') }} </th>
		      			<th>{{ number_format($propiedadesT[$b]['ganancia'], 2, ',', '.') }} </th>
					</tr>
				@endif
			@endforeach
		@endforeach
		</tbody>
	</table>
@endsection
