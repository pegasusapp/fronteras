
function editDataDesviacion(idlectura){

	let myData = {"id": idlectura};
	alert(idlectura);


			ajaxProcessEdit(myData,"ajax/desviacion.ajax.php","desviacion");
	 
}