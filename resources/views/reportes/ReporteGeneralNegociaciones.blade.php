@extends('admin/base_reportes')
@section('content')
	@include('admin/common/encabezadoReportes')
	<table class="table table-bordered table-condensed" id="registros">
		<thead>
		    
		</thead>
		
			@foreach($aux1 as $a=>$value)
				<tr class="totales success">
					<th class="asesores" colspan="5">{{$aux1[$a]['nombre']}} <p class="codigo">Cod.#{{$aux1[$a]['codigo']}}</p></th>
				</tr>
				<tr class="totales active">
					<th colspan="5">Negociaciones por estatus</th>
				</tr>
				<tr class="totales active">
					<th>Activas</th>
					<th>Canceladas</th>
					<th colspan="3">Finalizadas</th>
				</tr>
				<tr class="totales">
					<th>{{$aux1[$a]['activas']}}</th>
					<th>{{$aux1[$a]['canceladas']}}</th>
					<th colspan="3">{{$aux1[$a]['finalizadas']}}</th>
				</tr>
				<tr class="totales active">
					<th colspan="5">Negociaciones Activas  por proceso</th>
				</tr>
				<tr class="totales active">
					<th>Propuesta de Compra</th>
					<th>Deposito en Garantia</th>
					<th>Promesa Bilateral</th>
					<th colspan="2">Firma en registro</th>
				</tr>
				<tr class="totales">
					<th>{{$aux1[$a]['propuesta']}}</th>
					<th>{{$aux1[$a]['deposito']}}</th>
					<th>{{$aux1[$a]['promesa']}}</th>
					<th colspan="2">{{$aux1[$a]['firma']}}</th>
				</tr>
				<tr class="totales active">
					<th colspan="5">Negociaciones Concretadas por tipo de  intervención</th>
				</tr>
				<tr class="totales active">
					<th>Captador</th>
					<th>Cerrador</th>
					<th colspan="3">Captador - Cerrador</th>
				</tr>
				<tr class="totales">
					<th>{{$aux1[$a]['captador']}}</th>
					<th>{{$aux1[$a]['cerrador']}}</th>
					<th colspan="3">{{$aux1[$a]['ambos']}}</th>
				</tr>
				<tr class="totales warning">
					<th colspan="5">Lista de Propiedades</th>
				</tr>
				<tr class="totales warning">
					<th>MLS</th>
					<th>Asesor Cerrador</th>
					<th>Estatus</th>
					<th>Precio Final</th>
					<th>Ingreso Neto</th>
				<tr>
				@foreach($aux2 as $b=>$value)
					@foreach($aux2[$b] as $c=>$value)
						@if($aux2[$b][$c]->agente==$aux1[$a]['id'])
							<tr class="totales">
								<th>{{$aux2[$b][$c]->mls}}</th>
								<th>{{$aux2[$b][$c]->asesorCerrador}}</th>
								<th>{{$aux2[$b][$c]->nombreEstatus}}</th>
								<th>{{ number_format($aux2[$b][$c]->precioFinal, 2, ',', '.') }}</th>
								<th>{{ number_format($aux2[$b][$c]->ingresoNeto, 2, ',', '.') }}</th>
							<tr>
						@endif
					@endforeach
				@endforeach
			@endforeach
		</tbody>
	</table>
@endsection