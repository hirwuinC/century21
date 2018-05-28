<!DOCTYPE html>
<html>
<head>
	<title>{{$titulo}}</title>
	
</head>
<body>
	<table style="width: 100%;border:solid 2px;font-family: verdana;font-style: italic;font-size: 20px;font-weight: bold;">
		    <tr style="width: 100%" >
		   		<td style="width: 70%;text-align: center;border:solid 2px">{{$titulo}}</td>
		   		<td style="width: 30%;text-align: left;border:solid 2px">
					<IMG SRC="/images/logo-header.png" WIDTH=250 HEIGHT=80 BORDER=0 ALT="Un beb&eacute;" ALIGN="RIGHT"> 
		   			  
		   	</tr>
	</table>
	 
	 <label style="margin-left: 65%;font-family: verdana;font-weight:bold;font-size: 15px;">Fecha:&nbsp;{{$fecha}}</label>
	<br>
	<table   style="width: 100%;border:solid 2px;font-family: verdana;font-size: medium;">
			@if($tipo==0)
					
					<tr style="width: 100%;text-align: center;font-style: italic;font-weight:bold"  >
				                <td colspan="2" style="width: 50%;border:solid 2px;">Precio promedio general de propiedades en venta </td>
				                <td colspan="2" style="width: 50%;border:solid 2px;">Precio promedio general de propiedades en alquiler</td>
					</tr>
					<tr style="width: 100%;text-align: center;font-style: italic;"  >
				                <td colspan="2" style="width: 50%;border:solid 2px;">{{$promedioV}}</td>
				                <td colspan="2" style="width: 50%;border:solid 2px;">{{$promedioA}}</td>
					</tr>
					<tr style="width: 100%;text-align: left;font-style: italic;font-weight: bold;"  >
				                <td style="border:solid 2px;text-align: left;width: 30%">Nombre Asesor</td>
				                <td style="border:solid 2px;text-align: center;width: 9%">Codigo</td>
				                <td style="border:solid 2px;text-align: center;width: 30%">Promedio Vent.</td>
				                <td style="border:solid 2px;text-align: center;width: 30%">Promedio Alq.</td>
						</tr>
					@foreach($cantidades as $key =>$value)
						@php
								$asesor = explode("/",$key);
								$promedio= explode("/",$value)
						@endphp
						<tr style="width: 100%;text-align: left;font-style: italic;"  >
				                <td style="border:solid 2px;text-align: left;width: 30%">{{$asesor[0]}}</td>
				                <td style="border:solid 2px;text-align: center;width: 9%">{{$asesor[1]}}</td>
				                <td style="border:solid 2px;text-align: center;width: 30%">{{$promedio[0]}}</td>
				                <td style="border:solid 2px;text-align: center;width: 30%">{{$promedio[1]}}</td>
						</tr>
					@endforeach

			@elseif($tipo==1 )
					<tr style="width: 100%;text-align: center;font-style: italic;font-weight:bold"  >
				                <td colspan="2" style="width: 50%;border:solid 2px;">Precio promedio general de propiedades en venta </td>
				                <td colspan="1" style="width: 50%;border:solid 2px;">Precio promedio general de propiedades en alquiler</td>
					</tr>
					<tr style="width: 100%;text-align: center;font-style: italic;"  >
				                <td colspan="2" style="width: 50%;border:solid 2px;">{{$promedioV}}</td>
				                <td colspan="1" style="width: 50%;border:solid 2px;">{{$promedioA}}</td>
					</tr>
					<tr style="width: 100%;text-align: left;font-style: italic;font-weight: bold;"  >
				                <td style="border:solid 2px;text-align: center;width: 22%">Tipo Inmueble</td>
				                <td style="border:solid 2px;text-align: center;width: 38%">Promedio Vent. (Inm. Css - General)</td>
				                <td style="border:solid 2px;text-align: center;width: 38%">Promedio Alq. (Inm. Css - General)</td>
				                
					 </tr>
					 @foreach($cantidades as $key => $value)
					 		@php
								$prom = explode("/",$value);
						    @endphp



						<tr style="width: 100%;text-align: left;font-style: italic;"  >
				                <td style="border:solid 2px;text-align: center;width: 22%">{{$key}} </td>
				                <td style="border:solid 2px;text-align: center;width: 38%">{{$prom[0]}}</td>
				                <td style="border:solid 2px;text-align: center;width: 38%">{{$prom[1]}}</td>
				                
					 </tr>
					 @endforeach

					

			@endif
							
	</table>
	

    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/reporte.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
