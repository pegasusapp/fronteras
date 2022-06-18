
function ajaxProcessEdit(data,route,destiny){
				
				var datos = new FormData();
				Object.keys(data).forEach(function(key,value){
					datos.append(key,value);
				});
			$.ajax({
					url:route,
					method: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					success: function(answer){
					if(answer){

						answer.forEach(function(key,value){
							alert(key+"-"+value);
						});

						//alert("Acción ejecutada exitosamente.");
					//	window.location = destiny;

						}
						else{
						//	alert("Problemas con el proceso.");
						}	 
							
							},
						// Error handling 
					error: function (error) {
					console.log(`Error ${error}`);
							}
					})

}














