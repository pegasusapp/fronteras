/*=============================================
EDITAR AREA
=============================================*/

function editPerfil(valor)
{

    var idperfilEnergia = valor;
    
    var datos = new FormData();
    datos.append("idperfilEnergia", idperfilEnergia);

    $.ajax({
        url: "ajax/perfiles.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta){ 
            
            $("#idperfilEnergiaE").val(respuesta["idperfilEnergia"]);
            $("#nombreE").val(respuesta["nombre"]);
            $("#fuenteEnergia_idfuenteEnergiaE").val(respuesta["fuenteEnergia_idfuenteEnergia"]);
           
           
        }

    })
}




