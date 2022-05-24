/*=============================================
 SOLICITUD
=============================================*/
//$(".btnVerItemSolicitud").click(function()
   
  function verSolicitud(valor)
   {
    //var idSolicitud = $(this).attr("idSolicitud");
   
    $("#solicitud_id").val(valor);

     $( "#target_view" ).submit(); 
   }
