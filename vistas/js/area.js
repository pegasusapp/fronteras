/*=============================================
EDITAR AREA
=============================================*/

function editArea(valor)
{

    var idarea = valor;
    
    var datos = new FormData();
    datos.append("idarea", idarea);

    $.ajax({
        url: "ajax/area.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta){ 
            
            $("#idareaE").val(respuesta["idarea"]);
            $("#nombreAreaE").val(respuesta["nombreArea"]);
            $("#proyecto_idproyectoE").val(respuesta["proyecto_idproyecto"]);
           
           
        }

    })
}




