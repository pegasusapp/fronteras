/*=============================================
EDITAR FUENTE
=============================================*/

function editFuente(valor)
{

    var idfuente = valor;
    
    var datos = new FormData();
    datos.append("idfuenteEnergia", idfuente);

    $.ajax({
        url: "ajax/fuentes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta){ 
            
            $("#idfuenteEnergiaE").val(respuesta["idfuenteEnergia"]);
            $("#nombreFuenteE").val(respuesta["nombreFuente"]);
            $("#unidadMedidaFuenteE").val(respuesta["unidadMedidaFuente"]);
           
        }

    })
}




