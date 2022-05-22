 /*=============================================
EDITAR ALTERNO
=============================================*/

function editAlterno(valor)
{

    document.getElementById("vlr_activae").value="";
    document.getElementById("vlr_facturae").value="";
    document.getElementById("vlr_kvhe").value="";
    document.getElementById("m1e").value="";
    document.getElementById("m2e").value="";
    document.getElementById("m3e").value="";
    document.getElementById("m4e").value="";
    document.getElementById("m5e").value="";
    document.getElementById("m6e").value="";
    document.getElementById("m7e").value="";
    document.getElementById("m8e").value="";
    document.getElementById("m9e").value="";
    document.getElementById("m10e").value="";
    document.getElementById("m11e").value="";
    document.getElementById("m12e").value="";
    document.getElementById("prom_mese").value="";
    document.getElementById("mercadoe").value="";
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
        success: function(respuesta)
        { 
       
            document.getElementById("vlr_activae").value=respuesta["vlr_activa"];
            document.getElementById("vlr_facturae").value=respuesta["vlr_factura"];
            document.getElementById("vlr_kvhe").value=respuesta["vlr_kvh"];
            document.getElementById("m1e").value=respuesta["m1"];
            document.getElementById("m2e").value=respuesta["m2"];
            document.getElementById("m3e").value=respuesta["m3"];
            document.getElementById("m4e").value=respuesta["m4"];
            document.getElementById("m5e").value=respuesta["m5"];
            document.getElementById("m6e").value=respuesta["m6"];
            document.getElementById("m7e").value=respuesta["m7"];
            document.getElementById("m8e").value=respuesta["m8"];
            document.getElementById("m9e").value=respuesta["m9"];
            document.getElementById("m10e").value=respuesta["m10"];
            document.getElementById("m11e").value=respuesta["m11"];
            document.getElementById("m12e").value=respuesta["m12"];
            document.getElementById("prom_mese").value=respuesta["prom_mes"];
            document.getElementById("mercadoe").value=respuesta["mercado"];
            document.getElementById("alternaempresa_ide").value=respuesta["alternaempresa_id"];
           
        }

    })
}



