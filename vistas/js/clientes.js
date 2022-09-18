/*=============================================
EDITAR USUARIO
=============================================*/
function editarCliente(usuarioIn)
{

	var identificador = usuarioIn;
	var datos = new FormData();
	datos.append("nitCliente", identificador);

	$.ajax({
		url: "ajax/clientes.ajax.php",  
		method: "POST",
      	data: datos, 
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta)
		 { 
     		
			var len = respuesta.length;
    				  if(len > 0)
	      				{
							for( var i = 0; i<len; i++)
							{
								
								document.getElementById("editaremailCliente").value = respuesta[i]["emailCliente"];
								document.getElementById("editarcontactoCliente").value = respuesta[i]["contactoCliente"];
								document.getElementById("editaractivo").value = respuesta[i]["activo"];
								document.getElementById("editarnitCliente").value = respuesta[i]["nitCliente"];
							}	
						}
		}

	});


}

/*=============================================
EDITAR MENU
=============================================*/
function editarMenu(usuarioIn)
{

	
	$("#identificadorMenu").val(usuarioIn);
	document.getElementById('form_editMenu').submit();
}

function starCreateUser()
{
	document.getElementById('perfil_planta_div').style.display = 'none';
}


/*=============================================
ACTIVAR USUARIO
=============================================*/
$(".btnActivar").click(function(){

	var idUsuario = $(this).attr("idUsuario");
	var estadoUsuario = $(this).attr("estadoUsuario");

	var datos = new FormData();
 	datos.append("activarId", idUsuario);
  	datos.append("activarUsuario", estadoUsuario);

  	$.ajax({

	  url:"ajax/usuarios.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      }

  	})

  	if(estadoUsuario == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoUsuario',1);

  	}else{

  		$(this).addClass('btn-success');
  		$(this).removeClass('btn-danger');
  		$(this).html('Activado');
  		$(this).attr('estadoUsuario',0);

  	}

})

/*=============================================
REVISAR SI EL USUARIO YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoUsuario").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarUsuario", usuario);

	 $.ajax({
	    url:"ajax/usuarios.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoUsuario").parent().after('<div class="alert alert-warning">Este usuario ya existe en la base de datos</div>');

	    		$("#nuevoUsuario").val("");

	    	}

	    }

	})
})

/*=============================================
ELIMINAR USUARIO
=============================================*/
$(".btnEliminarUsuario").click(function(){

  var idUsuario = $(this).attr("idUsuario");
  var fotoUsuario = $(this).attr("fotoUsuario");
  var usuario = $(this).attr("usuario");

  swal({
    title: '¿Está seguro de borrar el usuario?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar usuario!'
  }).then((result)=>{

    if(result.value){

      window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario;

    }

  })



})






