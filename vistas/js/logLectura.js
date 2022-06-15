function deleteFile(idlectura,nameFile){

	if (confirm('Esta seguro de borrar el archivo?')) {
		ajaxLecturas(idlectura,nameFile,"ajax/logLectura.ajax.php");
	  }
}

function insertData(idlectura,nameFile){

			ajaxLecturas(idlectura,nameFile,"ajax/insertLectura.ajax.php");
	 
}


function ajaxLecturas(idlectura,nameFile,route){
				
				var datos = new FormData();
				datos.append("id", idlectura);
				datos.append("nameFile", nameFile);
				$.ajax({
					url:route,
					method: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					success: function(respuesta){
					if(respuesta){
							alert("Acción ejecutada exitosamente.");
							window.location = "uploadConsumo";
							
							}
						else{
							alert("Problemas con el archivo.");
						}	 
							
							},
						// Error handling 
					error: function (error) {
					console.log(`Error ${error}`);
							}
					})

}














