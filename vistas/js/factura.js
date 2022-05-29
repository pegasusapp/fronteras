function borrarFactura(anyo,mes,frontera,filename){

	if (confirm('Esta seguro de borrar el archivo?')) {
		var datos = new FormData();
		datos.append("anyo", anyo);
		datos.append("mes", mes);
	    datos.append("frontera", frontera);
	    datos.append("filename", filename);
   	   $.ajax({
   			   url:"ajax/factura.ajax.php",
			   method: "POST",
			   data: datos,
			   cache: false,
			   contentType: false,
			   processData: false,
			   success: function(respuesta){
			   if(respuesta){
					 window.location = "uploadFile";
					 }},
   			   // Error handling 
			   error: function (error) {
			   console.log(`Error ${error}`);
					   }
			 })
	  }
}

function searchFactura(anyo,mes,frontera){

		var datos = new FormData();
		datos.append("anyoSearch", anyo);
		datos.append("mesSearch", mes);
	    datos.append("fronteraSearch", frontera);
   	   $.ajax({
   			   url:"ajax/factura.ajax.php",
			   method: "POST",
			   data: datos,
			   cache: false,
			   contentType: false,
			   processData: false,
			   success: function(respuesta){
			   if(respuesta){
				alert("Ya existe un registro para esta frontera el año y el mes");	 
				window.location = "uploadFile";
					 }
					 
					
					},
   			   // Error handling 
			   error: function (error) {
			   console.log(`Error ${error}`);
					   }
			 })
	  
}













