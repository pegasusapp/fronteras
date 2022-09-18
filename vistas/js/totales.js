/*=============================================
EDITAR TOTALES 
=============================================*/

function editTotales(valor)
{

    var idtotalesConsumo = valor;
    
    var datos = new FormData();
    datos.append("idtotalesConsumo", idtotalesConsumo);

    $.ajax({
        url: "ajax/totales.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta)
        { 
        

            $("#idtotalesConsumoE").val(respuesta["idtotalesConsumo"]);
            $("#consumoE").val(respuesta["consumo"]);
            $("#costoE").val(respuesta["costo"]);
            $("#indicadorE").val(respuesta["indicador"]);

            
           
        }

    })
}

function saveChangesEdit() 

{

    var idtotalesConsumoE = document.getElementById("idtotalesConsumoE").value;
    var costoE = document.getElementById("costoE").value;
    var consumoE = document.getElementById("consumoE").value;
    var indicadorE = document.getElementById("indicadorE").value;
    var datos = new FormData();
    datos.append("idtotalesConsumoE", idtotalesConsumoE);
    datos.append("costoE", costoE);
    datos.append("consumoE", consumoE);
    datos.append("indicadorE", indicadorE);
    $.ajax({
        url: "ajax/totales.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta)
        { 
        

          // swal("Exito!", "Cambios realizados!", "success");
          alert("Cambios hechos!");
           document.getElementById("sub_rta").submit(); 
           
        }

    })
}


   


