@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-striped" id="registros">
		<thead>
		    <tr class="titulo">
		      <th><center>Fecha de Emisión: {{date("d-m-Y")}}</center></th>
		      <th> Total Propiedades Venta : {{$cantidades['propiedadVenta']}}</th>
		      <th> Total Promedio Precio Venta : {{number_format($cantidades['precioPromedioVenta'], 2, ',', '.')}}</th>
		      <th> Total Propiedades Alquiler : {{$cantidades['propiedadAlquiler']}}</th>
		      <th> Total Promedio Precio Alquiler : {{number_format($cantidades['precioPromedioAlquiler'], 2, ',', '.')}} </th>
		    </tr>
			</thead>
		<tbody>
		@foreach($asesores as $asesor)
			@foreach($resultado as $key =>$value)
				@if($resultado[$key]['id'] == $asesor->id)
					<tr>
						<th class="asesor">{{$asesor->fullName}} <p class="codigo">Cod.#{{$asesor->codigo_id}}</p>
						</th>
						<th>Propiedades Venta: {{$resultado[$key]['propiedadVenta']}} </th>
						<th>Precio Promedio Venta: {{number_format($resultado[$key]['precioPromedioVenta'], 2, ',', '.')}}</th>
						<th>Propiedades Alquiler: {{$resultado[$key]['propiedadAlquiler']}}</th>
						<th>Precio Promedio Alquiler:{{number_format($resultado[$key]['precioPromedioAlquiler'], 2, ',', '.')}}</th>
					</tr>
				@endif
			@endforeach
		@endforeach
		</tbody>
	</table>
@endsection