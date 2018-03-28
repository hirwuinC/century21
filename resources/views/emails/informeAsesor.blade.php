<p style="font-family: verdana;font-size:medium;width: 100%;">Un cordial saludo Sr(a).&nbsp;<span style="font-weight: bold;">{{$asesor[$agente]['nombre']}}</span>,&nbsp;al dia de hoy usted posee informes de gestion de propiedades pendientes por enviar, a continuacion le ofrezco una lista con los detalles: <br><br><br></p>
<table style="width:100%;height: 10%">
		
		@if(count($asesor[$agente]['vencidos'])>0)
			<tr style="width:100%;color:#EF5350;background-color: #EDEBEB;font-weight: bold;text-align: center;font-family: verdana;font-size: small;"><td colspan="8">Usted tiene, los siguientes informes vencidos{{' ('.count($asesor[$agente]['vencidos']).')'}}</td></tr>
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
			@foreach($asesor[$agente]['vencidos'] as $key =>$vencido)
					<tr style="font-family: verdana;font-size: small;background-color:{{$asesor[$agente]['coloresVencidos'][$key]}}">
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
		@endif

		@if(count($asesor[$agente]['vencenHoy'])>0)
				<tr ><td colspan="7" style="height:20%;color:#FFFFFF">a</td></tr>
				<tr ><td colspan="7" style="height:20%;color:#FFFFFF">a</td></tr>
			<tr style="width:100%;color:#FF9800;background-color: #EDEBEB;font-weight: bold;text-align: center;font-family: verdana;font-size: small;"><td colspan="8">Usted tiene, los siguientes informes que vencen hoy {{' ('.count($asesor[$agente]['vencenHoy']).')'}}</td></tr>
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
			@foreach($asesor[$agente]['vencenHoy'] as $key =>$vencido)
					<tr style="font-family: verdana;font-size: small;background-color:{{$asesor[$agente]['coloresVencenHoy'][$key]}}">
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
		@endif

		@if(count($asesor[$agente]['porVencerse'])>0)
				<tr ><td colspan="7" style="height:20%;color:#FFFFFF">a</td></tr>
				<tr ><td colspan="7" style="height:20%;color:#FFFFFF">a</td></tr>
			<tr style="width:100%;color:#FF9800;background-color: #EDEBEB;font-weight: bold;text-align: center;font-family: verdana;font-size: small;"><td colspan="8">Usted tiene, los siguientes informes que estan por vencerse {{'('.count($asesor[$agente]['porVencerse']).')'}}</td></tr>
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
			@foreach($asesor[$agente]['porVencerse'] as $key =>$vencido)
					<tr style="font-family: verdana;font-size: small;background-color:{{$asesor[$agente]['coloresPorVencerse'][$key]}}">
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
		@endif


</table>
<br><br><br>
<p style="font-family: verdana;font-size:medium;width: 100%;">Le recomendamos, enviar los informes pendientes los mas pronto posible, para mantener informado a nuestros clientes sobre el proceso de gestion de sus inmuebles, sin mas que agregar me despido no sin antes desearle un muy buen dia,<br><br></p>
<span style="font-family: verdana;font-size: medium;font-weight: bold;text-align: center;width: 90%;">Administrador del sistema: XXX-XXX-XXX-XXX</span>