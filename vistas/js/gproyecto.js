/*=============================================
GESTION DE PROYECTOS
=============================================*/


/*=============================================
EDITAR PROYECTO 
=============================================*/

$(document).ready(function() {

    // Add event listener for opening and closing details
    $('#example_table_gproyecto tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var ids = $(this).attr('vlr');
      var datosIn = new FormData();
      datosIn.append("idgproyecto_extra", ids);
      var row = table.row( tr );
    
      if ( row.child.isShown() ) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
      }
      else {
          // Open this row
          
          $.ajax({ 
            url: "ajax/gproyecto.ajax.php",
            method: "POST",
            data: datosIn,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"json", 
            success: function(respuesta)
            { 
               
            var len = respuesta.length;
            var sumIng = 0;
            var sumEgr = 0;
            var formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'COP',
              });


               
              for( var i = 0; i<len; i++)
              {
                   
                if(i==0)
                {
                   var tablaing='<table cellspacing="0" id="tablegproyectoing_'+respuesta[i]["idgproyecto"]+'" class="floatedTable" border="0" style="padding-left:50px;">';
                    tablaing+='<thead>';
                    tablaing+='<th>CONCEPTO</th>';
                    tablaing+='<th>VALOR</th>';
                    tablaing+='<th>MOVIMIENTO</th>';
                    tablaing+='<th>BORRAR</th>';
                    tablaing+='</thead>';
                    tablaing+='<tbody>';
                   var tablaegr='<table cellspacing="0" id="tablegproyectoegr_'+respuesta[i]["idgproyecto"]+'" class="inlineTable" border="0" style="padding-left:50px;">';
                    tablaegr+='<thead>';
                    tablaegr+='<th>CONCEPTO</th>';
                    tablaegr+='<th>VALOR</th>';
                    tablaegr+='<th>MOVIMIENTO</th>';
                    tablaegr+='<th>BORRAR</th>';
                    tablaegr+='</thead>';
                    tablaegr+='<tbody>';    
                }
                
                
                
                
                if(respuesta[i]['naturaleza']=="+")
                    {
                        tablaing+="<tr style='background-color:#FFFFFF'>";
                        tablaing+="<td>"+respuesta[i]['nombreConcepto']+"</td>";
                        tablaing+="<td>("+respuesta[i]['naturaleza']+") $"+respuesta[i]['valor'].replace(/\d(?=(\d{3})+\.)/g, '$&,');+"</td>";
                        tablaing+="<td>"+respuesta[i]['nombreMovimiento']+"</td>";
                        tablaing+="<td><div style='cursor: pointer;' onClick=deleteConcepto('"+respuesta[i]['idconcepto']+"')><i class='fas fa-trash'></i></div></td>";
                        sumIng = sumIng + parseFloat(respuesta[i]['valor']);
                        /*
                        tabla+="<td><input type='button' name='fe_"+respuesta[i]['idfuenteEnergia']+"' id='fe_"+respuesta[i]['idfuenteEnergia']+"' value='ver consumos' onClick=verConsumos('"+respuesta[i]['idfuenteEnergia']+"','"+respuesta[i]['proyecto_idproyecto']+"') /></td>";
                        var plantaNombre = respuesta[i]['nombrePlanta'];
                        tabla+='<td><div class="btn-group"><button class="btn btn-warning btnInsertConsumos" onClick=reportConsumo('+respuesta[i]['proyecto_idproyecto']+','+respuesta[i]['idfuenteEnergia']+ ',"'+escape(plantaNombre)+'")    data-toggle="modal" data-target="#modalIngresarConsumo"><i class="fas fa-'+respuesta[i]['icon'] +'"></i></button></div></td>';
                        tabla+="<td>";
                        tabla+= "<div class='btn-group'>";
                        tabla+= "<button class='btn btn-success btnInsertProduccion' onclick=viewProduccion("+respuesta[i]['proyecto_idproyecto']+","+ respuesta[i]['fuenteEnergia_idfuenteEnergia']+")   data-toggle='modal' ><i class='fas fa-chart-line'></i></button>";
                        tabla+="</div>";  
                        tabla+="</td>";
                        */
                        tablaing+="</tr>";
                    }
                    else
                    {
                        tablaegr+="<tr style='background-color:#FFFFFF'>";
                        tablaegr+="<td>"+respuesta[i]['nombreConcepto']+"</td>";
                        tablaegr+="<td>("+respuesta[i]['naturaleza']+") $"+respuesta[i]['valor'].replace(/\d(?=(\d{3})+\.)/g, '$&,');+"</td>";
                        tablaegr+="<td>"+respuesta[i]['nombreMovimiento']+"</td>";
                        tablaegr+="<td><div style='cursor: pointer;' onClick=deleteConcepto('"+respuesta[i]['idconcepto']+"')><i class='fas fa-trash'></i></div></td>";
                        tablaegr+="</tr>";
                        sumEgr = sumEgr +  parseFloat(respuesta[i]['valor']);
                    }
                   
              }
                    tablaing+='</tbody>';
                    tablaing+='<tfoot>';
                    tablaing+='<tr>';
                    tablaing+='<th>Total</th>';
                    tablaing+='<th id="total_order">(+)$'+ sumIng.toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,'); +'</th>';
                    tablaing+='<th></th>';
                    tablaing+='<th></th>';
                    tablaing+='</tr>'; 
                    tablaing+='</tfoot>';
                    tablaing+="</table>";
                    tablaegr+='</tbody>';
                    tablaegr+='<tfoot>';
                    tablaegr+='<tr>';
                    tablaegr+='<th>Total</th>';
                    tablaegr+='<th id="total_order">(-)$'+sumEgr.toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,');+'</th>';
                    tablaegr+='<th></th>';
                    tablaegr+='<th></th>';
                    tablaegr+='</tr>'; 
                    tablaegr+='</tfoot>';
                    tablaegr+="</table>";
              row.child( tablaing + tablaegr ).show();
              tr.addClass('shown');
            
               
            }
        
        })
     
      }
    } );
      
    } )
function validateOk(ids)
{
 document.getElementById(ids).className="form-control";
}

function changeLbl(valor)
{
    if(valor == 1)
    document.getElementById("pogsis_lbl").innerHTML="Potencia del sistema (kWp)";
    else
    document.getElementById("pogsis_lbl").innerHTML="Potencia del sistema (kW)";
     
}


function listaClientes()
{
    var datos = new FormData();
    datos.append("listado_clientes", "listado_clientes");
    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta)
            { 
                
                for(i=0;i<respuesta.length;i++)
                {
                    var sel = document.getElementById('clienteProyecto_idclienteProyecto');
                    var opt = document.createElement('option');
                    opt.appendChild(document.createTextNode(respuesta[i]["nombreClienteProyecto"]));
                    opt.value = respuesta[i]["idclienteProyecto"]; 
                    sel.appendChild(opt); 
                } 

            
            }
          })

}
function listagProyectos()
{
    var datos = new FormData();
    datos.append("listado_gproyectos", "listado_gproyectos");
    $.ajax({
        url: "ajax/gproyecto.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta)
            { 
                
                var sel_o = document.getElementById('tipoproyecto_idtipoproyecto');
                var opt_o = document.createElement('option');
                opt_o.appendChild(document.createTextNode("Tipo proyecto..."));
                opt_o.value = ""; 
                sel_o.appendChild(opt_o); 


                for(i=0;i<respuesta.length;i++)
                {
                    var sel = document.getElementById('tipoproyecto_idtipoproyecto');
                    var opt = document.createElement('option');
                    opt.appendChild(document.createTextNode(respuesta[i]["nombretipoProyecto"]));
                    opt.value = respuesta[i]["idtipoproyecto"]; 
                    sel.appendChild(opt); 
                } 

            
            }
          })

}
function listagMovimientos()
{
    var datos = new FormData();
    datos.append("listado_gmovimientos", "listado_gmovimientos");
    $.ajax({
        url: "ajax/gproyecto.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta)
            { 
                
                var sel_m = document.getElementById('movimiento_idmovimiento');
                var opt_m = document.createElement('option');
                opt_m.appendChild(document.createTextNode("Tipo movimiento..."));
                opt_m.value = ""; 
                sel_m.appendChild(opt_m); 


                for(i=0;i<respuesta.length;i++)
                {
                    var sel = document.getElementById('movimiento_idmovimiento');
                    var opt = document.createElement('option');
                    opt.appendChild(document.createTextNode(respuesta[i]["nombreMovimiento"]));
                    opt.value = respuesta[i]["idmovimiento"]; 
                    sel.appendChild(opt); 
                } 

            
            }
          })

}

function editgProyecto(id,nombre)
{
    var datos = new FormData();
    document.location.href = "#ancla";
    document.getElementById("tipoproyecto_idtipoproyecto").value = "";
    document.getElementById("nombregProyecto").value = "";
    document.getElementById("clienteProyecto_idclienteProyecto").value ="";
    document.getElementById("potenciagSistema").value = "";
    document.getElementById("generacionaProyecto").value ="";
    document.getElementById("energiaAutoconsumo").value = "";
    document.getElementById("energiaExcedentes").value = "";
    document.getElementById("tarifaAplicada").value = "";
    document.getElementById("tarifaGenerada").value = "";
    document.getElementById("trmDolar").value = "";
    document.getElementById("impuestoRenta").value = "";
    document.getElementById("depreciacion").value = "";
    document.getElementById("ipc").value = "";
    document.getElementById("dtf").value = "";
    document.getElementById("interesBancario").value = "";
    document.getElementById("descripcionProyecto").value = "";
    document.getElementById("idgproyecto").value = "";
    datos.append("idgproyecto", id);
    $.ajax({
        url: "ajax/gproyecto.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta)
            { 
                for(i=0;i<respuesta.length;i++)
                {
                 document.getElementById("tipoproyecto_idtipoproyecto").value = respuesta[i]["tipoproyecto_idtipoproyecto"];
                 document.getElementById("nombregProyecto").value = respuesta[i]["nombregProyecto"];
                 document.getElementById("clienteProyecto_idclienteProyecto").value = respuesta[i]["clienteProyecto_idclienteProyecto"];
                 document.getElementById("potenciagSistema").value = respuesta[i]["potenciagSistema"];
                 document.getElementById("generacionaProyecto").value = respuesta[i]["generacionaProyecto"];
                 document.getElementById("energiaAutoconsumo").value = respuesta[i]["energiaAutoconsumo"];
                 document.getElementById("energiaExcedentes").value = respuesta[i]["energiaExcedentes"];
                 document.getElementById("tarifaAplicada").value = respuesta[i]["tarifaAplicada"];
                 document.getElementById("tarifaGenerada").value = respuesta[i]["tarifaGenerada"];
                 document.getElementById("trmDolar").value = respuesta[i]["trmDolar"];
                 document.getElementById("impuestoRenta").value = respuesta[i]["impuestoRenta"];
                 document.getElementById("depreciacion").value = respuesta[i]["depreciacion"];
                 document.getElementById("ipc").value = respuesta[i]["ipc"];
                 document.getElementById("dtf").value = respuesta[i]["dtf"];
                 document.getElementById("interesBancario").value = respuesta[i]["interesBancario"];
                 document.getElementById("descripcionProyecto").value = respuesta[i]["descripcionProyecto"];
                 document.getElementById("idgproyecto").value = respuesta[i]["idgproyecto"];
                }
            
            }
          })

}

function saveCliente() 
{

   var nClientP = document.getElementById("nombreClienteProyecto");
   var eClientP = document.getElementById("emailCliente");
   var tClientP = document.getElementById("telefonoCliente");
   var iClientP = document.getElementById("identificacionCliente");
   var formElement = document.forms['createClient'];

  if(!nClientP.checkValidity() || !eClientP.checkValidity() || !tClientP.checkValidity() || !iClientP.checkValidity())
   {
        
        for(i=0;i<formElement.length;i++)
        {
            formElement[i].className="form-control is-invalid"; 
        } 

   }
   else
   {
        var datos = new FormData();
        datos.append("nombreClienteProyecto", document.getElementById("nombreClienteProyecto").value);
        datos.append("emailCliente", document.getElementById("emailCliente").value);
        datos.append("telefonoCliente", document.getElementById("telefonoCliente").value);
        datos.append("identificacionCliente", document.getElementById("identificacionCliente").value);
        $.ajax({
                url: "ajax/clientes.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType:"json",
                success: function(respuesta)
                { 
                        
                        if (respuesta == "ok")
                        {
                            Swal.fire(
                                        'Excelente!',
                                        'El cliente ha sido creado!',
                                        'success'
                                    )
                            for(i=0;i<formElement.length;i++)
                                {
                                    formElement[i].value=""; 
                                }
                            document.getElementById("clienteProyecto_idclienteProyecto").options.length = 0;
                            listaClientes();
                            document.getElementById("closeW").click();   
                        }
                        else
                        {
                                Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...algo salió mal',
                                            text: ''+respuesta,
                                            footer: '<a href="errores">Por favor reportar este error haciendo click aqui</a>'
                                        })
                                        
                        }
                }

            })
   }


}


function deleteConcepto(valor)
{
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })
      
      swalWithBootstrapButtons.fire({
        title: '¿Está seguro?',
        text: "Esta operación no tiene reverso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, soy valiente!',
        cancelButtonText: 'No, me arrepiento!',
        reverseButtons: true
      }).then((result) => {
        if (result.value) 
        {
            var datos = new FormData();
            datos.append("idconcepto", valor);
           
            $.ajax({
                    url: "ajax/gproyecto.ajax.php",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType:"json",
                    success: function(respuesta)
                    { 
                            
                            if (respuesta == "ok")
                            {
                                swal("¡El concepto ha sido borrado!", {
                                    buttons: 
                                    {
                                     catch: 
                                       {
                                       text: "Cerrar",
                                       value: "ok",
                                       }
                                    },
                                  })
                                  .then((value) => {
                                    switch (value)
                                    {
                                        case "ok":
                                                window.location = "gproyectos";
                                        break;
                                   
                                        default:
                                                window.location = "gproyectos";
                                    }
                                  });
                               
                                

                            }
                            else
                            {
                                    Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...algo salió mal',
                                                text: ''+respuesta,
                                                footer: '<a href="errores">Por favor reportar este error haciendo click aqui</a>'
                                            })
                                            
                            }
                    }
    
                })

        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) 
        {
          swalWithBootstrapButtons.fire(
            'Cancelado',
            'El concepto sigue su curso :)',
            'error'
          )
        }
      })
}


if(document.getElementById('clienteProyecto_idclienteProyecto'))
{
    listaClientes();
}
if(document.getElementById('tipoproyecto_idtipoproyecto'))
{
    listagProyectos();
}
if(document.getElementById('movimiento_idmovimiento'))
{
    listagMovimientos();
}