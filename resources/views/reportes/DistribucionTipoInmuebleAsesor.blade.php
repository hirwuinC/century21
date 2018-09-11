@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-striped" id="registros">
		<thead>
		    <tr>
		      <th><center>Fecha de Emisión: {{date("d-m-Y")}}</center></th>
		      <th> Total Terreno : {{$cantidades['terreno']}}</th>
		      <th> Total Local Comercial : {{$cantidades['local']}}</th>
		      <th> Total Residencial : {{$cantidades['residencial']}}</th>
		      <th> Total Vacacional : {{$cantidades['vacacional']}}</th>
		      <th> Total Industrial : {{$cantidades['industrial']}}</th>
		    </tr>
			</thead>
		<tbody>
		@foreach($asesores as $asesor)
			@foreach($estatus as $key =>$value)
				@if($estatus[$key]['id'] == $asesor->id)
					<tr>
						<th class="asesor">{{$asesor->fullName}} <p class="codigo">Cod.#{{$asesor->codigo_id}}</p>
						</th>
						<th>Terreno: {{$estatus[$key]['terreno']}} </th>
						<th>Local Comercial: {{$estatus[$key]['local']}}</th>
						<th>Residencial: {{$estatus[$key]['residencial']}}</th>
						<th>Vacacional: {{$estatus[$key]['vacacional']}}</th>
						<th>Industrial: {{$estatus[$key]['industrial']}}</th>
					</tr>
				@endif
			@endforeach
		@endforeach
		</tbody>
	</table>
@endsection