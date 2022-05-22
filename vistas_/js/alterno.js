 /*=============================================
EDITAR ALTERNO
=============================================*/

function editAlterno(valor)
{

    var idalterno = valor;
    
    var datos = new FormData();
    datos.append("alternaempresa_id", idalterno);

    $.ajax({
        url: "ajax/alterno.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta){ 
            
            $("#alternaempresa_idE").val(respuesta["alternaempresa_id"]);
            $("#empresaE").val(respuesta["empresa"]);
            $("#sedeE").val(respuesta["sede"]);
            $("#fechaaE").val(respuesta["fecha"]);
            $("#departamentoE").val(respuesta["departamento"]);
            $("#nrocontactoE").val(respuesta["nrocontacto"]);
            $("#activoE").val(respuesta["activo"]);
            $("#orE").val(respuesta["or"]);
            $("#vlr_activaE").val(respuesta["vlr_activa"]);
            $("#vlr_facturaE").val(respuesta["vlr_factura"]);
            $("#vlr_kvhE").val(respuesta["vlr_kvh"]);
            $("#m1E").val(respuesta["m1"]);
            $("#m2E").val(respuesta["m2"]);
            $("#m3E").val(respuesta["m3"]);
            $("#m4E").val(respuesta["m4"]);
            $("#m5E").val(respuesta["m5"]);
            $("#m6E").val(respuesta["m6"]);
            $("#prom_mesE").val(respuesta["prom_mes"]);
            $("#mercadoE").val(respuesta["mercado"]);
            $("#niveltensionE").val(respuesta["niveltension"]);
           
           
        }

    })
}



