<p style="font-family: verdana;font-size:medium;width: 100%;">Un cordial saludo Sra.&nbsp;<span style="font-weight: bold;">Iraida Caballero</span>,&nbsp;a continuacion se presenta una lista clasificada por asesor, donde se pueden apreciar reportes pendientes por enviar a nuestros clientes: <br><br><br>

@foreach($registros as $registro)
	@foreach($registro as $agente )

		<table style="width:100%;height: 5%;font-family: verdana;font-size:small;">
			<tr style="text-align: center;background-color: #F0E482">
				<td style="width: 20%;font-weight: bold;">Nombre del asesor </td>
				<td style="width: 20%;font-weight: bold;">Cedula </td>
				<td style="width: 20%;font-weight: bold;">Telefono fijo </td>
				<td style="width: 20%;font-weight: bold;">Telefono celular </td>
				<td style="width: 20%;font-weight: bold;">Correo </td>
				
			</tr>
			<tr style="text-align: center; ">
				<td style="width: 20%;">{{$agente['nombre']}} </td>
				<td style="width: 20%;">{{$agente['cedula']}}</td>
				<td style="width: 20%;">{{$agente['telefono']}}</td>
				<td style="width: 20%;">{{$agente['celular']}}</td>
				<td style="width: 20%;">{{$agente['correo']}}</td>
				
			</tr>

			
		</table>
		<br>
		<table style="width:100%;height: 10%">
				
				@if(count($agente['vencidos'])>0)
					<tr style="width:100%;color:#EF5350;background-color: #EDEBEB;font-weight: bold;text-align: center;font-family: verdana;font-size: small;"><td colspan="8">Posee, los siguientes informes vencidos{{' ('.count($agente['vencidos']).')'}}</td></tr>
					<tr  style="width:100%;color:#ffffff;background-color: #333333;text-align: center;font-weight: bold;font-family: verdana;font-size: small;">
						<td style="width:7%">Codigo</td>
						<td style="width:7%">MLS</td>
						<td style="width:10%">Estado</td>
						<td style="width:10%">Ciudad</td>
						<td style="width:23%">Urbanizacion</td>
						<td style="width:23%">Direccion</td>
						<td style="width:10%">Negocio</td>
						<td style="width:10%">Fecha</td>
					<tr>
					@foreach($agente['vencidos'] as $key =>$vencido)
							<tr style="font-family: verdana;font-size: small;background-color:{{$agente['coloresVencidos'][$key]}}">
									<td style="width:7%;text-align: center; ">{{$vencido->id}}</td>
									<td style="width:7%;text-align: center; ">{{$vencido->mls}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->estado}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->ciudad}}</td>
									<td style="width:23%;text-align: center;">{{$vencido->urbanizacion}}</td>
									<td style="width:23%;text-align: center;">{{$vencido->direccion}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->negocio}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->proximoInforme}}</td>
							<tr>	
					@endforeach
					<tr ><td colspan="8" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
					<tr ><td colspan="8" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
				@endif

				@if(count($agente['vencenHoy'])>0)

					<tr style="width:100%;color:#FF9800;background-color: #EDEBEB;font-weight: bold;text-align: center;font-family: verdana;font-size: small;"><td colspan="8">Posee, los siguientes informes que vencen hoy {{' ('.count($agente['vencenHoy']).')'}}</td></tr>
					<tr  style="width:100%;color:#ffffff;background-color: #333333;text-align: center;font-weight: bold;font-family: verdana;font-size: small;">
						<td style="width:7%">Codigo</td>
						<td style="width:7%">MLS</td>
						<td style="width:10%">Estado</td>
						<td style="width:10%">Ciudad</td>
						<td style="width:23%">Urbanizacion</td>
						<td style="width:23%">Direccion</td>
						<td style="width:10%">Negocio</td>
						<td style="width:10%">Fecha</td>
					<tr>
					@foreach($agente['vencenHoy'] as $key =>$vencido)
							<tr style="font-family: verdana;font-size: small;background-color:{{$agente['coloresVencenHoy'][$key]}}">
									<td style="width:7%;text-align: center; ">{{$vencido->id}}</td>
									<td style="width:7%;text-align: center; ">{{$vencido->mls}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->estado}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->ciudad}}</td>
									<td style="width:23%;text-align: center;">{{$vencido->urbanizacion}}</td>
									<td style="width:23%;text-align: center;">{{$vencido->direccion}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->negocio}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->proximoInforme}}</td>
							<tr>	
					@endforeach
					<tr ><td colspan="8" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
					<tr ><td colspan="8" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
				@endif

				@if(count($agente['porVencerse'])>0)
						
					<tr style="width:100%;color:#FF9800;background-color: #EDEBEB;font-weight: bold;text-align: center;font-family: verdana;font-size: small;"><td colspan="8">Posee, los siguientes informes que estan por vencerse {{'('.count($agente['porVencerse']).')'}}</td></tr>
					<tr  style="width:100%;color:#ffffff;background-color: #333333;text-align: center;font-weight: bold;font-family: verdana;font-size: small;">
						<td style="width:7%">Codigo</td>
						<td style="width:7%">MLS</td>
						<td style="width:10%">Estado</td>
						<td style="width:10%">Ciudad</td>
						<td style="width:23%">Urbanizacion</td>
						<td style="width:23%">Direccion</td>
						<td style="width:10%">Negocio</td>
						<td style="width:10%">Fecha</td>
					<tr>
					@foreach($agente['porVencerse'] as $key =>$vencido)
							<tr style="font-family: verdana;font-size: small;background-color:{{$agente['coloresPorVencerse'][$key]}}">
									<td style="width:7%;text-align: center; ">{{$vencido->id}}</td>
									<td style="width:7%;text-align: center; ">{{$vencido->mls}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->estado}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->ciudad}}</td>
									<td style="width:23%;text-align: center;">{{$vencido->urbanizacion}}</td>
									<td style="width:23%;text-align: center;">{{$vencido->direccion}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->negocio}}</td>
									<td style="width:10%;text-align: center;">{{$vencido->proximoInforme}}</td>
							<tr>	
					@endforeach
					<tr ><td colspan="8" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
					<tr ><td colspan="8" style="height:20%;color:#FFFFFF">&nbsp;</td></tr>
				@endif


		</table>
	@endforeach

<br><br><br><br>

@endforeach