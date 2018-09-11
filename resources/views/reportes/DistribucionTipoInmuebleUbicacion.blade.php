@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-condensed" id="registros">
		<thead>
		    <tr class="totales">
		      <th><center>Fecha de Emisión: {{date("d-m-Y")}}</center></th>
		      <th> Total Terrenos : {{$cantidades['terreno']}}</th>
		      <th> Total Locales Comerciales : {{$cantidades['local']}}</th>
		      <th> Total Residencial : {{$cantidades['residencial']}}</th>
		      <th> Total Vacacional : {{$cantidades['vacacional']}}</th>
		      <th> Total Industrial : {{$cantidades['industrial']}}</th>
		    </tr>
			</thead>
		<tbody>
		@foreach($estateSelect as $a=>$value)
			<tr class="active">
				<th class="estados">{{$estateSelect[$a]['nombre']}}</p>
				</th>
				<th>Terreno: {{$estateSelect[$a]['terreno']}} </th>
				<th>Local Comercial: {{$estateSelect[$a]['local']}}</th>
				<th>Residencial: {{$estateSelect[$a]['residencial']}}</th>
				<th>Vacacional: {{$estateSelect[$a]['vacacional']}}</th>
				<th>Industrial: {{$estateSelect[$a]['industrial']}}</th>
			</tr>
			@foreach ($citySelect as $b => $value)
				@if($estateSelect[$a]['id']==$citySelect[$b]['padre'])
					<tr class="success">
						<th class="ciudades">{{$citySelect[$b]['nombre']}}</p>
						</th>
						<th>Terreno: {{$citySelect[$b]['terreno']}} </th>
						<th>Local Comercial: {{$citySelect[$b]['local']}}</th>
						<th>Residencial: {{$citySelect[$b]['residencial']}}</th>
						<th>Vacacional: {{$citySelect[$b]['vacacional']}}</th>
						<th>Industrial: {{$citySelect[$b]['industrial']}}</th>
					</tr>
					@foreach ($urbSelect as $c => $value)
						@if($citySelect[$b]['id']==$urbSelect[$c]['padre'])
							<tr>
								<th class="urbanizaciones">{{$urbSelect[$c]['nombre']}}</p>
								</th>
								<th>Terrreno: {{$urbSelect[$c]['terreno']}} </th>
								<th>Local Comercial: {{$urbSelect[$c]['local']}}</th>
								<th>Residencial: {{$urbSelect[$c]['residencial']}}</th>
								<th>Vacacional: {{$urbSelect[$c]['vacacional']}}</th>
								<th>Industrial: {{$urbSelect[$c]['industrial']}}</th>
							</tr>
						@endif
					@endforeach
				@endif
				
			@endforeach
		@endforeach
		</tbody>
	</table>
@endsection
