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














