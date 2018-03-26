		
@foreach($registros as $registro)
	@foreach($registro as $agente )

		<table style="width:45%;height: 10%;font-family: verdana;font-size:small;">
			<tr><td style="width: 25%;font-weight: bold;">Nombre del asesor: </td><td style="text-align: left;">{{$agente['nombre']}}</td></tr>

			<tr><td style="width: 25%;font-weight: bold;">C.I.: </td><td style="text-align: left;">{{$agente['cedula']}}</td></tr>
			<tr><td style="width: 25%;font-weight: bold;">Telefono fijo: </td><td style="text-align: left;">{{$agente['telefono']}}</td></tr>
			<tr><td style="width: 25%;font-weight: bold;">Telefono celular: </td><td style="text-align: left;">{{$agente['celular']}}</td></tr>
			<tr><td style="width: 25%;font-weight: bold;">Correo electronico: </td><td style="text-align: left;">{{$agente['correo']}}</td></tr>
		</table>
		<br>
		<table style="width:90%;height: 10%">
				
				@if(count($agente['vencidos'])>0)
					<tr style="width:100%;color:#EF5350;background-color: #DCDBDB;font-weight: bold;text-align: center;font-family: verdana;font-size: small;"><td colspan="7">Posee, los siguientes informes vencidos{{' ('.count($agente['vencidos']).')'}}</td></tr>
					<tr  style="width:100%;color:#ffffff;background-color: #333333;text-align: center;font-weight: bold;font-family: verdana;font-size: small;">
						<td style="width:10%">Codigo</td>
						<td style="width:10%">Estado</td>
						<td style="width:10%">Ciudad</td>
						<td style="width:25%">Urbanizacion</td>
						<td style="width:25%">Direccion</td>
						<td style="width:10%">Negocio</td>
						<td style="width:10%">Fecha</td>
					<tr>
					@foreach($agente['vencidos'] as $key =>$vencido)
							<tr style="font-family: verdana;font-size: small;background-color:{{$agente['coloresVencidos'][$key]}}">
									<td style="width:10%;text-align: center; ">XXX-XXX-XXX</td>
									<td style="width:10%;text-align: center;">{{$vencido->estado}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->ciudad}}</td>
									<td style="width:25%;text-align: center;">{{$vencido->urbanizacion}}</td>
									<td style="width:25%;text-align: center;">{{$vencido->direccion}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->negocio}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->proximoInforme}}</td>
							<tr>	
					@endforeach
					<tr ><td colspan="7" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
					<tr ><td colspan="7" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
				@endif

				@if(count($agente['vencenHoy'])>0)

					<tr style="width:100%;color:#FF9800;background-color: #DCDBDB;font-weight: bold;text-align: center;font-family: verdana;font-size: small;"><td colspan="7">Posee, los siguientes informes que vencen hoy {{' ('.count($agente['vencenHoy']).')'}}</td></tr>
					<tr  style="width:100%;color:#ffffff;background-color: #333333;text-align: center;font-weight: bold;font-family: verdana;font-size: small;">
						<td style="width:10%">Codigo</td>
						<td style="width:10%">Estado</td>
						<td style="width:10%">Ciudad</td>
						<td style="width:25%">Urbanizacion</td>
						<td style="width:25%">Direccion</td>
						<td style="width:10%">Negocio</td>
						<td style="width:10%">Fecha</td>
					<tr>
					@foreach($agente['vencenHoy'] as $key =>$vencido)
							<tr style="font-family: verdana;font-size: small;background-color:{{$agente['coloresVencenHoy'][$key]}}">
									<td style="width:10%;text-align: center; ">XXX-XXX-XXX</td>
									<td style="width:10%;text-align: center;">{{$vencido->estado}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->ciudad}}</td>
									<td style="width:25%;text-align: center;">{{$vencido->urbanizacion}}</td>
									<td style="width:25%;text-align: center;">{{$vencido->direccion}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->negocio}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->proximoInforme}}</td>
							<tr>	
					@endforeach
					<tr ><td colspan="7" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
					<tr ><td colspan="7" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
				@endif

				@if(count($agente['porVencerse'])>0)
						
					<tr style="width:100%;color:#FF9800;background-color: #DCDBDB;font-weight: bold;text-align: center;font-family: verdana;font-size: small;"><td colspan="7">Posee, los siguientes informes que estan por vencerse {{'('.count($agente['porVencerse']).')'}}</td></tr>
					<tr  style="width:100%;color:#ffffff;background-color: #333333;text-align: center;font-weight: bold;font-family: verdana;font-size: small;">
						<td style="width:10%">Codigo</td>
						<td style="width:10%">Estado</td>
						<td style="width:10%">Ciudad</td>
						<td style="width:25%">Urbanizacion</td>
						<td style="width:25%">Direccion</td>
						<td style="width:10%">Negocio</td>
						<td style="width:10%">Fecha</td>
					<tr>
					@foreach($agente['porVencerse'] as $key =>$vencido)
							<tr style="font-family: verdana;font-size: small;background-color:{{$agente['coloresPorVencerse'][$key]}}">
									<td style="width:10%;text-align: center; ">0</td>
									<td style="width:10%;text-align: center;">{{$vencido->estado}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->ciudad}}</td>
									<td style="width:25%;text-align: center;">{{$vencido->urbanizacion}}</td>
									<td style="width:25%;text-align: center;">{{$vencido->direccion}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->negocio}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->proximoInforme}}</td>
							<tr>	
					@endforeach
					<tr ><td colspan="7" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
					<tr ><td colspan="7" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
				@endif


		</table>
	@endforeach

<br><br><br>

@endforeach