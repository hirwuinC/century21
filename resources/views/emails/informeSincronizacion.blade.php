	@if($descarga==1)
	               <table style="width: 99%;height: 3%;">
	               			<tr style="font-weight: bold;text-align: center;color:#000000;background-color: #DFFDAB;font-family: verdana;font-size:small;">
							<td style="width: 49%">Inicio sincronizacion:&nbsp;&nbsp; {{' '.$tiempoIn}}
							</td>
							<td style="width: 50%">
								Fin sincronizacion :&nbsp;&nbsp;{{$tiempoFin}}
							</td>
							
						</tr>
	               </table>

			@if($cambios>0)

					<table style="width:100%;height: 5%;font-family: verdana;font-size:small;">
						<tr style="text-align: center;font-weight: bold;background-color: #333333;color:#FFFFFF"><td colspan="3" style="width: 100%; ">Reporte de datos cargados al sistema</td></tr>
						<tr  style="text-align: center;font-weight: bold;background-color: #FCF5D1;color:#000000;">
							<td style="width: 33%;">Cantidad de estados </td>
							<td td style="width: 33%;">Cantidad de ciudades </td>
							<td td style="width: 33%;">Cantidad de urbanizaciones </td>
						</tr>

						<tr  style="text-align: center;background-color: #FFFFFF;">
							<td style="width: 33%;">{{$longitud['estados']}} </td>
							<td td style="width: 33%;">{{$longitud['ciudades']}} </td>
							<td td style="width: 33%;">{{$longitud['urbanizaciones']}} </td>
						</tr>
						<tr  style="text-align: center;font-weight: bold;background-color: #FCF5D1;color:#000000;">
							<td td style="width: 33%;">Imagenes enlazadas: </td>
							<td td style="width: 33%;">Cantidad de agentes: </td>
							<td td style="width: 33%;">Cantidad de propiedades: </td>
						</tr>
						<tr  style="text-align: center;background-color: #FFFFFF;">
							<td style="width: 33%;">{{$longitud['imagenes']}} </td>
							<td td style="width: 33%;">{{$longitud['agentes']}} </td>
							<td td style="width: 33%;">{{$longitud['propiedades']}} </td>
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
										<td  style="width: 38%;">Codigo Interno</td>
										<td  style="width: 39%;" >Nombre</td>
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
				@elseif($cambios==0 && count($modificaciones)==0)
					<table style="width:99%;height: 5%;font-family: verdana;font-size:medium;">
						
						
						<tr style="text-align: center;background-color: #F5F3F3;height: 40%">
							<td colspan="2" >
							</br></br>						La conexion al servidor se realizo correctamente, no se realizaron cambios en la base de datos de nuestro sistema de gestion de inmuebles, ni se detectaron diferencias de nuestros registros con los de casa matriz.</br></br></br>
							</td>
						</tr>

					</table>

				@endif
				@if(count($modificaciones)>0)
			          </br></br></br>
			          <table table style="width:99%;height: 5%;font-family: verdana;font-size:small;font-family: verdana;font-size:small;">
			          	 <tr><td colspan="4" style="background-color: #830808;color:#FFFFFF;font-weight: bold;text-align: center;">Cantidad de propiedades que presentan diferencias con los datos de casa matriz:&nbsp;&nbsp;{{count($modificaciones)}}</td></tr>
			          	 <tr style="font-weight: bold;text-align: center;background-color: #333333;color:#FFFFFF">
			          	 	<td>Eliminaciones:&nbsp;&nbsp;{{$cantidades['Eliminados']}}</td>
			          	 	<td>Cambios de agente:&nbsp;&nbsp;{{$cantidades['Agente']}}</td>
			          	 	<td>Cambios de precio:&nbsp;&nbsp;{{$cantidades['Precio']}}</td>
			          	 	<td>Cambios de T. negocio:&nbsp;&nbsp;{{$cantidades['Negocio']}}</td>
			          	 </tr>
			          	 @foreach($modificaciones as $key => $act )
			          	 		<tr style="background-color: #FCF5D1;color:#000000;text-align: left;font-weight: bold;">
			          	 			<td colspan="4">Codigo MlS de la propiedad &nbsp;{{$key}}:&nbsp;({{count($act)}})</td>
			          	 		<tr>
								@foreach($act as $llave =>$actualizado)
									<tr style="text-align: center;background-color: #F5F3F3">
										<td colspan="4">{{$llave.' : '.$actualizado}}</td>
									</tr>
								@endforeach
			          	 @endforeach
			          </table>
				@endif
	@elseif($descarga!=1)
		<table style="width:80%;height: 5%;font-family: verdana;font-size:medium;margin-left: 10%;">
						
						<tr style="font-weight: bold;text-align: center;background-color: #830808;color:#FFFFFF;">
							<td >Inicio sincronizacion:&nbsp;&nbsp; {{' '.$tiempoIn}}
							</td>
							<td>
								Fin sincronizacion :&nbsp;&nbsp;{{$tiempoFin}}
							</td>
							
						</tr>
						<tr style="text-align: center;background-color: #F5F3F3;height: 40%">
							<td colspan="2" >
							</br></br>	
							@if	($descarga==2)	
										{{'Falla al conectar con el servidor,es posible que el servidor se encuentre caido .'}}
							@elseif($descarga==3)	
										{{'Falla al loguear, es posible que la clave de acceso utilizada sea incorrecta.'}}
							@elseif($descarga==4)
							          {{'Falla al descargar el archivo de sicronizacion, puede que el archivo solicitado no exista en el servidor o existan problemas con la conexion a internet'}}
							@endif

							</br></br></br>
							</td>
						</tr>

					</table>
	@endif