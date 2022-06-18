
function ajaxProcessEdit(data,route,destiny){
				
				var datos = new FormData();
				Object.entries(data).forEach(([key, value]) =>{
					alert(key+"-"+value);
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
					
						Object.keys(answer).forEach(function(key) {
							console.log(jsonData[key]);
						
						}		
			

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














