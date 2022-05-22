/*=============================================
EDITAR EQUIPO
=============================================*/

function editPotencia(valor)
{

    var idtipoPotencia = valor;
    
    var datos = new FormData();
    datos.append("idtipoPotencia", idtipoPotencia);

    $.ajax({
        url: "ajax/equipo.ajax.php",
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

function habilitarText(valor)
{

  
    var fequipo = document.getElementsByName("tipoPotencia_idtipoPotencia[]");
   
    if (fequipo[valor-1].checked)
    {
     
     
      document.getElementById("cantidad_"+valor).disabled=false;    
     
   }
   else
   {
   
    document.getElementById("cantidad_"+valor).disabled=true;  
    document.getElementById("cantidad_"+valor).value=0;    
   }
    
      
    


}



