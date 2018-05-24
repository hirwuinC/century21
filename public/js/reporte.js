function imprimirReporteDiario() 
{
	 if (window.print) 
	 {
        window.print();
     } 
     else 
     {
        swal("Error de compatibilidad", "Su navegador no soporta la funcion de impresion de reportes ", "error");
     }
}


$(document).ready(function()
	{
			
				imprimirReporteDiario();


			
			
	
	});