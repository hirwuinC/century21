	@if($cambios>0)

			<table style="width:100%;height: 5%;font-family: verdana;font-size:small;">
				
				<tr style="text-align: center;font-weight: bold;background-color: #333333;color:#FFFFFF"><td colspan="3" style="width: 100%; ">Reporte de datos cargados al sistema</td></tr>
				<tr  style="text-align: center;font-weight: bold;background-color: #FCF5D1;color:#000000;">
					<td style="width: 30%;">Cantidad de estados </td>
					<td td style="width: 30%;">Cantidad de ciudades </td>
					<td td style="width: 30%;">Cantidad de urbanizaciones </td>
				</tr>

				<tr  style="text-align: center;background-color: #FFFFFF;">
					<td style="width: 30%;">{{$longitud['estados']}} </td>
					<td td style="width: 30%;">{{$longitud['ciudades']}} </td>
					<td td style="width: 30%;">{{$longitud['urbanizaciones']}} </td>
				</tr>
				<tr  style="text-align: center;font-weight: bold;background-color: #FCF5D1;color:#000000;">
					<td td style="width: 30%;">Imagenes enlazadas: </td>
					<td td style="width: 30%;">Cantidad de agentes: </td>
					<td td style="width: 30%;">Cantidad de propiedades: </td>
				</tr>
				<tr  style="text-align: center;background-color: #FFFFFF;">
					<td style="width: 30%;">{{$longitud['imagenes']}} </td>
					<td td style="width: 30%;">{{$longitud['agentes']}} </td>
					<td td style="width: 30%;">{{$longitud['propiedades']}} </td>
				</tr>
				<tr style="background-color: #FFFFFF;width: 100%;height: 10%;">
					<td colspan="3">&nbsp;</td>
					<td colspan="3">&nbsp;</td>
					<td colspan="3">&nbsp;</td>
				</tr>
					@if($longitud['agentes']>0)

						<tr style="text-align: center;font-weight: bold;background-color: #333333;color:#FFFFFF">
							<td colspan="3" >Lista de agentes</td>
						</tr>
						<tr style="text-align: center;font-weight: bold;background-color: #FCF5D1;color:#000000;">
								<td style="width: 20%;" >Codigo Agente</td>
								<td  style="width: 35%;">Codigo Interno</td>
								<td  style="width: 35%;" >Nombre</td>
						</tr>
							@foreach($agentes as $agente)
								
								<tr style="text-align: center;background-color: {{$agente['colorFondo']}}">
									<td style="width: 20%;" >{{$agente['codigoId']}}</td>
									<td  style="width: 35%;">{{$agente['id']}}</td>
									<td  style="width: 35%;" >{{$agente['nombre']}}</td>
								</tr>
								
							@endforeach
					<tr style="background-color: #FFFFFF;width: 100%;height: 10%;">
						<td colspan="3">&nbsp;</td>
						<td colspan="3">&nbsp;</td>
						<td colspan="3">&nbsp;</td>
					</tr>
					@endif

				
					@if($longitud['propiedades']>0)

						<tr style="text-align: center;font-weight: bold;background-color: #333333;color:#FFFFFF">
							<td colspan="3" >Lista de propiedades</td>
						</tr>
						<tr style="text-align: center;font-weight: bold;background-color: #FCF5D1;color:#000000;">
							<td style="width: 20%;" >Codigo MLS</td>
							<td  style="width: 35%;">Codigo Interno</td>
							<td  style="width: 35%;" >Agente</td>
						</tr>
							@foreach($propiedades as $propiedad)
								<tr style="text-align: center;background-color: {{$propiedad['colorFondo']}};color:{{$propiedad['colorTexto']}}">
									<td style="width: 20%;" >{{$propiedad['mls']}}</td>
									<td  style="width: 35%;">{{$propiedad['id']}}</td>
									<td  style="width: 35%;" >{{$propiedad['agente']}}</td>
								</tr>
							@endforeach
					@endif
			</table>
		@endif