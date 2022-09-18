
function saveMenu()
 {

       var lista_check = {"id" : [], "dataid" : [], "text" : []};
       $("#treeview").hummingbird("getChecked",{list:lista_check,onlyEndNodes:false});
       var servicio_activo = []; 
         for(j=0; j<lista_check.id.length;j++)
          {
          
            if(document.getElementById(lista_check.id[j]).className == "hummingbirdNoParent")
              { 
                
                servicio_activo.push(lista_check.id[j]);
              } 	
            
          } 	
       var servicios_activos_menu = servicio_activo.toString();
       var usuario_menu = document.getElementById("usuario_sesionado").value;
       var datos_servicio = new FormData();
       datos_servicio.append("servicios_activos_menu", servicios_activos_menu);
       $.ajax({
         url: "ajax/menu.ajax.php?userMenu="+usuario_menu,  
         method: "POST",
             data: datos_servicio, 
             cache: false,
            contentType: false,
            processData: false,
            dataType:"json",
            success: function(respuesta)
               { 
            
               if (respuesta=="ok")
                 {
                  swal("¡Los cambios han sido guardado correctamente!", {
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
                                window.location = "crearUsuario";
                      break;
                     
                        default:
                                window.location = "crearUsuario";
                    }
                    });
        
                 }
                 else
                 {
                  swal("¡Problemas con el cambio de datos!", {
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
                                window.location = "crearUsuario";
                      break;
                     
                        default:
                                window.location = "crearUsuario";
                    }
                    });
                 }
     
               }
             })

     
     }