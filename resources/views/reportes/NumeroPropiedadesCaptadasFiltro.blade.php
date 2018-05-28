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
			@if($tipo==0 || $tipo==1)
					
					<tr style="width: 100%;text-align: center;font-style: italic;font-weight:bold"  >
				                <td colspan="3" style="border:solid 2px;">Total captado: {{array_sum($cantidades)}}</td>
					</tr>
					<tr style="width: 100%;text-align:center;font-weight: bold;font-style: italic;"  >
				                <td style="border:solid 2px;">Nombre</td>
				                <td style="border:solid 2px;">Codigo</td>
				                @if($tipo==1)
				                	<td style="border:solid 2px;">Cantidad (Imuebles caracas - General)</td>
				                @else
				                	<td style="border:solid 2px;">Cantidad</td>
				                @endif

						</tr>
					@foreach($cantidades as $key =>$value)
						@php
								$asesor = explode("/",$key)
						@endphp
						<tr style="width: 100%;text-align: left;font-style: italic;"  >
				                <td style="border:solid 2px;text-align: left;">{{$asesor[0]}}</td>
				                <td style="border:solid 2px;text-align: center;">{{$asesor[1]}}</td>
				                <td style="border:solid 2px;text-align: center;">{{$value}}</td>
						</tr>
					@endforeach
			@else
					<tr style="width: 100%;text-align: center;font-style: italic;font-weight:bold"  >
				                <td colspan="3" style="border:solid 2px;">Total captado:&nbsp;&nbsp;&nbsp;&nbsp; {{$cantidades}}</td>
					</tr>
					

			@endif
							
	</table>
	

    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/reporte.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
