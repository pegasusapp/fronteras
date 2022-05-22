/*=============================================
EDITAR PROYECTO 
=============================================*/

$(document).ready(function() {

  // Add event listener for opening and closing details
  $('#example_table tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var ids = $(this).attr('vlr');
    var datosIn = new FormData();
    datosIn.append("idproyecto_extra", ids);
    var row = table.row( tr );
  
    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
    
        $.ajax({
          url: "ajax/proyecto.ajax.php",
          method: "POST",
          data: datosIn,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json", 
          success: function(respuesta)
          { 
             
            var len = respuesta.length;
            var tabla='<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
            for( var i = 0; i<len; i++)
            {
            
              tabla+="<tr>";
              tabla+="<td>Fuente:</td>";
              tabla+="<td>"+respuesta[i]['nombreFuente']+"</td>";
              tabla+="<td><input type='button' name='fe_"+respuesta[i]['idfuenteEnergia']+"' id='fe_"+respuesta[i]['idfuenteEnergia']+"' value='ver consumos' onClick=verConsumos('"+respuesta[i]['idfuenteEnergia']+"','"+respuesta[i]['proyecto_idproyecto']+"') /></td>";
              var plantaNombre = respuesta[i]['nombrePlanta'];
              tabla+='<td><div class="btn-group"><button class="btn btn-warning btnInsertConsumos" onClick=reportConsumo('+respuesta[i]['proyecto_idproyecto']+','+respuesta[i]['idfuenteEnergia']+ ',"'+escape(plantaNombre)+'")    data-toggle="modal" data-target="#modalIngresarConsumo"><i class="fas fa-'+respuesta[i]['icon'] +'"></i></button></div></td>';
              tabla+="<td>";
              tabla+= "<div class='btn-group'>";
              tabla+= "<button class='btn btn-success btnInsertProduccion' onclick=viewProduccion("+respuesta[i]['proyecto_idproyecto']+","+ respuesta[i]['fuenteEnergia_idfuenteEnergia']+")   data-toggle='modal' ><i class='fas fa-chart-line'></i></button>";
              tabla+="</div>";  
              tabla+="</td>";
              tabla+="</tr>";
            }
            tabla+="</table>";
             
            row.child( tabla ).show();
            tr.addClass('shown');
             
          }
      
      })
   
    }
  } );

  //llenamos el select de pais
  $.ajax
        ({
          url: 'ajax/getcountry.php',
          //data: 'action=showAll',
          method: "POST",
          cache: false,
          contentType: false,
          processData: false,
          //dataType:"json",
          success: function(r)
          {
            $("#pais").html(r);
          }
        });   


  } );

function reportConsumo(proyecto,fuente,planta)
{
 document.getElementById("proyecto_idproyecto_consumo").value = "";
 document.getElementById("fuenteEnergia_idfuenteEnergia_consumo").value="";
 document.getElementById("proyecto_idproyecto_consumo").value = proyecto;
 document.getElementById("fuenteEnergia_idfuenteEnergia_consumo").value = fuente;
 document.getElementById("nombrePlantaProduccionConsumo").innerHTML="Agregar consumo a la planta de "+unescape(planta);

}

function verConsumos(fuente,proyecto)
{
 $("#proyecto_id").val(proyecto);
 $("#fuente_energia_id").val(fuente);
 $("#target_view").submit(); 
}
function viewProduccion(proyecto,fuente)
{
 $("#proyecto_id_grafica").val(proyecto);
 $("#fuenteEnergia_id_grafica").val(fuente);
 $("#target_view_graficas").submit(); 
}
function editProyecto(valor,planta)
{

    var idproyecto = valor;
    $("#lbl_proyecto_anuncio").html("Editar "+ planta);
    
    var datos = new FormData();
    datos.append("idproyecto", idproyecto);

    $.ajax({
        url: "ajax/proyecto.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta){ 
           
            $("#idproyectoE").val(respuesta["idproyecto"]);
            $("#nombrePlantaE").val(respuesta["nombrePlanta"]);
            $("#ubicacionProyectoE").val(respuesta["ubicacionProyecto"]);
            $("#fechaRegistroE").val(respuesta["fechaRegistro"]);
            $("#tipoInstalacionE").val(respuesta["tipoInstalacion"]);
          

            $("#nombreMunicipioE").val(respuesta["nombreMunicipio"]);
            $("#nombreDepartamentoE").val(respuesta["nombreDepartamento"]);
            $("#actividadComercialE").val(respuesta["actividadComercial"]);
         
            $("#gerentePlantaE").val(respuesta["gerentePlanta"]);
            $("#nroContactoE").val(respuesta["nroContacto"]);
            $("#correoContactoE").val(respuesta["correoContacto"]);

            $("#jefeMantenimientoE").val(respuesta["jefeMantenimiento"]);
            $("#contactoJefeE").val(respuesta["contactoJefe"]);
            $("#correoContactojefeE").val(respuesta["correoContactojefe"]);
            var fuentesM=respuesta["fuentes"];
            var fenergia = document.getElementsByName("fenergia[]");
            var tete = fuentesM.split(",");
            for(k=0;k<tete.length;k++)
            {
              for (i = 0; i < fenergia.length; i++) 
                {
                  //alert(fenergia[i].value+" y "+tete[k]);
                  if (fenergia[i].value==tete[k]) {
                     
                    fenergia[i].checked="true";
                    fenergia[i].disabled="true";
                  }
                }
          
            }
           
        }

    })
}




