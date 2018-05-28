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

		    @foreach($cantidades as $key =>$value)
		    	<tr style="width: 100%;text-align: left;font-style: italic;font-weight: bold;"  >
				                <td colspan="4" style="width: 50%;border:solid 2px;">{{' '.$key}}</td>        
				</tr>
				<tr style="width: 100%;text-align: left;font-style: italic;font-weight: bold;"  >
				                <td style="border:solid 2px;text-align: center;width: 20%">MLS</td>
				                <td style="border:solid 2px;text-align: center;width: 30%">Tipo de inmueble</td>
				                <td style="border:solid 2px;text-align: center;width: 30%">Tipo de negocio</td>
				                <td style="border:solid 2px;text-align: center;width: 20%">Fecha</td>
				</tr>

				@foreach($value as $registro)
						
						<tr style="width: 100%;text-align: left;font-style: italic;"  >
				                <td style="border:solid 2px;text-align: center;width: 20%">{{$registro->mls}}</td>
				                <td style="border:solid 2px;text-align: center;width: 30%">{{$registro->tipo_inmueble}}</td>
				                 <td style="border:solid 2px;text-align: center;width: 30%">{{$registro->tipo_negocio}}</td>
				                <td style="border:solid 2px;text-align: center;width: 20%">{{$registro->fecha}}</td>
						</tr>
				@endforeach


		    @endforeach
			
							
	</table>
	

    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/reporte.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
