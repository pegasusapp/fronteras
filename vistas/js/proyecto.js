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

  if(document.getElementById("pais"))
  {
    selectPais('pais');
    
  }
  
  } );

function selectPais(ide)
{
  //llenamos el select de pais
  var datosp = new FormData();
  datosp.append("listado_pais", "listado_pais");
  $.ajax
        ({
          url: "ajax/pais.ajax.php",
          method: "POST",
          data: datosp,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json",
          success: function(respuestap)
          { 
            
            for (i = 0 ; i<respuestap.length; i++)
              {
                var sel = document.getElementById(ide);
                var opt = document.createElement('option');
                opt.appendChild(document.createTextNode(respuestap[i]["nombre"]));
                opt.value = respuestap[i]["idpais"]; 
                sel.appendChild(opt); 
              }
          }
        });
}


function selectDpto(valor,ide)
{
  //llenamos el select de pais
 

  document.getElementById(ide).options.length = 0;
  var datosd = new FormData();
  datosd.append("valorDpto", valor);
  $.ajax
        ({
          url: "ajax/pais.ajax.php",
          method: "POST",
          data: datosd,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json",
          success: function(respuestad)
          { 
            
            for (i = 0 ; i<respuestad.length; i++)
              {
                var sel = document.getElementById(ide);
                var opt = document.createElement('option');
                opt.appendChild(document.createTextNode(respuestad[i]["departamento"]));
                opt.value = respuestad[i]["iddepartamento"]; 
                sel.appendChild(opt); 
              }
              
          }
        });

        
} 

function selectMunicipio(valor,ide)
{
  //llenamos el select de pais
  document.getElementById(ide).options.length = 0;
  var datosm = new FormData();
  datosm.append("valorMunicipio", valor);
  $.ajax
        ({
          url: "ajax/pais.ajax.php",
          method: "POST",
          data: datosm,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json",
          success: function(respuestam)
          { 
            
            for (i = 0 ; i<respuestam.length; i++)
              {
                var sel = document.getElementById(ide);
                var opt = document.createElement('option');
                opt.appendChild(document.createTextNode(respuestam[i]["nombreMunicipio"]));
                opt.value = respuestam[i]["idmunicipio"]; 
                sel.appendChild(opt); 
              }
             
              
          }
        });
}

function selectDptoE(valor,ide,callback,envio)
{
  //llenamos el select de pais
 

  document.getElementById(ide).options.length = 0;
  var datosd = new FormData();
  datosd.append("valorDpto", valor);
  $.ajax
        ({
          url: "ajax/pais.ajax.php",
          method: "POST",
          data: datosd,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json",
          success: function(respuestad)
          { 
            
            for (i = 0 ; i<respuestad.length; i++)
              {
                var sel = document.getElementById(ide);
                var opt = document.createElement('option');
                opt.appendChild(document.createTextNode(respuestad[i]["departamento"]));
                opt.value = respuestad[i]["iddepartamento"]; 
                sel.appendChild(opt); 
              }
             
                callback(envio)
             
          }
        });

        
} 

function selectMunicipioE(valor,ide,callback,envio)
{
  //llenamos el select de pais
  document.getElementById(ide).options.length = 0;
  var datosm = new FormData();
  datosm.append("valorMunicipio", valor);
  $.ajax
        ({
          url: "ajax/pais.ajax.php",
          method: "POST",
          data: datosm,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json",
          success: function(respuestam)
          { 
            
            for (i = 0 ; i<respuestam.length; i++)
              {
                var sel = document.getElementById(ide);
                var opt = document.createElement('option');
                opt.appendChild(document.createTextNode(respuestam[i]["nombreMunicipio"]));
                opt.value = respuestam[i]["idmunicipio"]; 
                sel.appendChild(opt); 
              }
             
              callback(envio)
             
              
          }
        });
}

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
    document.getElementById('paisE').options.length = 0;
    var datos = new FormData();
    datos.append("idproyecto", idproyecto);
    selectPais('paisE');
    var idDpto = "";
    var idMnpo = "";
   
    $.ajax({
        url: "ajax/proyecto.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta){ 
       
          selectDptoE(respuesta[0]["pais_idpais"],'nombreDepartamentoE',asignationdpto,respuesta[0]["departamento_iddepartamento"])
          selectMunicipioE(respuesta[0]["departamento_iddepartamento"],'nombreMunicipioE',asignationmnpo,respuesta[0]["municipio_idmunicipio"])
            $("#idproyectoE").val(respuesta[0]["idproyecto"]);
            $("#nombrePlantaE").val(respuesta[0]["nombrePlanta"]);
            $("#ubicacionProyectoE").val(respuesta[0]["ubicacionProyecto"]);
            $("#fechaRegistroE").val(respuesta[0]["fechaRegistro"]);
            $("#tipoInstalacionE").val(respuesta[0]["tipoInstalacion"]);
            $("#actividadComercialE").val(respuesta[0]["actividadComercial"]);
            $("#gerentePlantaE").val(respuesta[0]["gerentePlanta"]);
            $("#nroContactoE").val(respuesta[0]["nroContacto"]);
            $("#correoContactoE").val(respuesta[0]["correoContacto"]);
            $("#jefeMantenimientoE").val(respuesta[0]["jefeMantenimiento"]);
            $("#contactoJefeE").val(respuesta[0]["contactoJefe"]);
            $("#correoContactojefeE").val(respuesta[0]["correoContactojefe"]);
            var fuentesM=respuesta[0]["fuentes"];
            var fenergia = document.getElementsByName("fenergia[]");
            var tete = fuentesM.split(",");
            for(k=0;k<tete.length;k++)
            {
              for (i = 0; i < fenergia.length; i++) 
                {
                
                  if (fenergia[i].value==tete[k]) {
                     
                    fenergia[i].checked="true";
                    fenergia[i].disabled="true";
                  }
                }
          
            }
                     
        
        }

    })
  
}

function asignationdpto(dpto)
{
 
  document.getElementById("nombreDepartamentoE").value = dpto

}

function asignationmnpo(mnpo)
{
 
  document.getElementById("nombreMunicipioE").value = mnpo;
}



