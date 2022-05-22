/*=============================================
EDITAR PRODUCCION
=============================================*/

function editProduccion(valor)
{

    var idproduccion = valor;
    
    var datos = new FormData();
    datos.append("idproduccion", idproduccion);

    $.ajax({
        url: "ajax/produccion.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta)
        { 
           
            $("#idproduccionE").val(respuesta["idproduccion"]);
            $("#anyoE").val(respuesta["anyo"]);
            $("#mesE").val(respuesta["mes"]);
            $("#toneladasE").val(respuesta["toneladas"]);
            $("#proyecto_idproyectoE").val(respuesta["proyecto_idproyecto"]);
           
        }

    })
}

function insertProduccion(valor,planta)
{

    
 document.getElementById("proyecto_idproyecto_produccion").value=valor;
 document.getElementById("nombrePlantaProduccion").innerHTML="Agregar produccion a la planta de "+planta;
}


   


