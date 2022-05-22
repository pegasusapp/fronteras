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

/*
$(".btnDescItemSolicitud").click(function(){

    var idSolicitud = $(this).attr("idSolicitud");
    var datos = new FormData();
    datos.append("idSolicitud", idSolicitud);

    $.ajax({
        url: "ajax/transformador.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta){

            $("#capacidad_nominalE").val(respuesta["capacidad_nominal"]);
            $("#codigo_transformadorE").val(respuesta["codigo_transformador"]);
            $("#longitudE").val(respuesta["longitud"]);
            $("#laltitudE").val(respuesta["laltitud"]);
            $("#altitudE").val(respuesta["altitud"]);
            $("#voltaje_nominalE").val(respuesta["voltaje_nominal"]);
            $("#dispo_potenciaE").val(respuesta["dispo_potencia"]);
            $("#dispo_energiaE").val(respuesta["dispo_energia"]);
        }

    })


}) */