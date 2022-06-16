function deleteFile(idlectura,nameFile){

	if (confirm('Esta seguro de borrar el archivo?')) {
		ajaxLecturas(idlectura,nameFile,"ajax/logLectura.ajax.php",false);
	  }
}

function insertData(idlectura,nameFile){

			ajaxLecturas(idlectura,nameFile,"ajax/insertLectura.ajax.php",true);
	 
}


function ajaxLecturas(idlectura,nameFile,route,flag){
				
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
						   if(flag){

							var data = new FormData();
							data.append("id", idlectura);
							$.ajax({
								url:"ajax/changeLogLectura.ajax.php",
								method: "POST",
								data: data,
								cache: false,
								contentType: false,
								processData: false,
								success: function(rta){
											if(rta){
												alert("Acción ejecutada exitosamente.");
												window.location = "uploadConsumo";

											}
													},
								error: function (error) {
								console.log(`Error ${error}`);
										}
								})
							
						   }
						   else{
							alert("Acción ejecutada exitosamente.");
							window.location = "uploadConsumo";
						   }
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














