@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-striped" id="registros">
		<thead>
		    <tr>
		      <th><center>Fecha de Emisión: {{date("d-m-Y")}}</center></th>
		      <th>Activos Total: {{$cantidades['Activos']}}</th>
		      <th>Inactivos Total: {{$cantidades['Inactivos']}}</th>
		      <th>Vendidos Total: {{$cantidades['Vendidos']}}</th>
		    </tr>
			</thead>
		<tbody>
		@foreach($asesores as $asesor)
			@foreach($estatus as $key =>$value)
				@if($estatus[$key]['id'] == $asesor->id)
					<tr>
						<th class="asesor">{{$asesor->fullName}} <p class="codigo">Cod.#{{$asesor->codigo_id}}</p>
						</th>
						<th>Activos: {{$estatus[$key]['Activos']}} </th>
						<th>Inactivos: {{$estatus[$key]['Inactivos']}}</th>
						<th>Vendidos: {{$estatus[$key]['Vendidos']}}</th>
					</tr>
				@endif
			@endforeach
		@endforeach
		</tbody>
	</table>
@endsection
