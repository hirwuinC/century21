@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-condensed" id="registros">
		<thead>
		    <tr>
		      <th><center>Fecha de Emisión: {{date("d-m-Y")}}</center></th>
		      <th>Activos Total: {{$cantidades['Activos']}}</th>
		      <th>Inactivos Total: {{$cantidades['Inactivos']}}</th>
		      <th>Vendidos Total: {{$cantidades['Vendidos']}}</th>
		    </tr>
			</thead>
		<tbody>
		@foreach($estateSelect as $a=>$value)
			<tr class="active">
				<th class="estados">{{$estateSelect[$a]['nombre']}}</p>
				</th>
				<th>Activos: {{$estateSelect[$a]['activos']}} </th>
				<th>Inactivos: {{$estateSelect[$a]['inactivos']}}</th>
				<th>Vendidos: {{$estateSelect[$a]['vendidos']}}</th>
			</tr>
			@foreach ($citySelect as $b => $value)
				@if($estateSelect[$a]['id']==$citySelect[$b]['padre'])
					<tr class="success">
						<th class="ciudades">{{$citySelect[$b]['nombre']}}</p>
						</th>
						<th>Activos: {{$citySelect[$b]['activos']}} </th>
						<th>Inactivos: {{$citySelect[$b]['inactivos']}}</th>
						<th>Vendidos: {{$citySelect[$b]['vendidos']}}</th>
					</tr>
					@foreach ($urbSelect as $c => $value)
						@if($citySelect[$b]['id']==$urbSelect[$c]['padre'])
							<tr>
								<th class="urbanizaciones">{{$urbSelect[$c]['nombre']}}</p>
								</th>
								<th>Activos: {{$urbSelect[$c]['activos']}} </th>
								<th>Inactivos: {{$urbSelect[$c]['inactivos']}}</th>
								<th>Vendidos: {{$urbSelect[$c]['vendidos']}}</th>
							</tr>
						@endif
					@endforeach
				@endif
				
			@endforeach
		@endforeach
		</tbody>
	</table>
@endsection
