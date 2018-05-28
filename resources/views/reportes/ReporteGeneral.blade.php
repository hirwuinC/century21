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
			<tr style="width: 100%;text-align: center;font-weight: bold;font-style: italic;"  >
				 <td colspan="3" style="border:solid 2px;">## Totales </td>
			</tr>
			<tr style="width: 100%;text-align: center;">
				<td style="border:solid 2px;">Activos:&nbsp;&nbsp; {{$cantidades['Activos']}}</td>
				<td style="border:solid 2px;">Inactivos:&nbsp;&nbsp; {{$cantidades['Inactivos']}}</td>
				<td style="border:solid 2px;">Vendidos: &nbsp;&nbsp;{{$cantidades['Vendidos']}}</td>
			</tr>
			@if(count($asesores)>0)
			    <tr style="width: 100%;text-align: center;font-weight: bold;font-style: italic;">
			    	<td colspan="3" style="border:solid 2px;">## Totales por asesor </td>
			    </tr>
			    @foreach($asesores as $clave =>$valor)
			    	<tr><td colspan="3" style="border:solid 2px;font-weight: bold;">##&nbsp; {{$clave}}&nbsp;</td></tr>
			    	<tr style="width: 100%;text-align: center;">
			    		<td style="border:solid 2px;">Activos:&nbsp;&nbsp; {{$valor['Activos']}} </td>
			    		<td style="border:solid 2px;">Inactivos:&nbsp;&nbsp; {{$valor['Inactivos']}}</td>
			    		<td style="border:solid 2px;">Vendidos:&nbsp;&nbsp; {{$valor['Vendidos']}}</td>
			    	</tr>
			    @endforeach
			@endif
	</table>
	

    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/reporte.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
</html>