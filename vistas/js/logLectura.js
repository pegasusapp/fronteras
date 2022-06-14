function deleteFile(idlectura){

	if (confirm('Esta seguro de borrar el archivo?')) {
		var datos = new FormData();
		datos.append("id", idlectura);
   	   $.ajax({
   			   url:"ajax/lectura.ajax.php",
			   method: "POST",
			   data: datos,
			   cache: false,
			   contentType: false,
			   processData: false,
			   success: function(respuesta){
			   if(respuesta){
					 window.location = "uploadConsumo";
					 }},
   			   // Error handling 
			   error: function (error) {
			   console.log(`Error ${error}`);
					   }
			 })
	  }
}














