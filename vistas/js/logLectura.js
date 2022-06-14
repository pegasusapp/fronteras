function deleteFile(idlectura,nameFile){

	if (confirm('Esta seguro de borrar el archivo?')) {
		var datos = new FormData();
		datos.append("id", idlectura);
		datos.append("nameFile", nameFile);
   	   $.ajax({
   			   url:"ajax/logLectura.ajax.php",
			   method: "POST",
			   data: datos,
			   cache: false,
			   contentType: false,
			   processData: false,
			   success: function(respuesta){
			   if(respuesta){

				 alert(respuesta);
					 window.location = "uploadConsumo";
					 }},
   			   // Error handling 
			   error: function (error) {
			   console.log(`Error ${error}`);
					   }
			 })
	  }
}














