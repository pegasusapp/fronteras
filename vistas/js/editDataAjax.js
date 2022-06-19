
function ajaxProcessEdit(data,route){
				
				var datos = new FormData();
				Object.entries(data).forEach(([key, value]) =>{
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
					
						const obj = JSON.parse(answer);
						for (const [key, value] of Object.entries(obj)) {
							$("#"+key).val(value);
						  }
						}
						else{
								alert("Problemas con el proceso.");
						}	 
							
							},
						// Error handling 
					error: function (error) {
					console.log(`Error ${error}`);
							}
					})

}














