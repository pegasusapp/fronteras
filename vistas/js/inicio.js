/*=============================================
RECARGAR GRAFICA
=============================================*/
var salesChartCanvas = $('#salesChart_indice').get(0).getContext('2d');

var salesChartData = {
  labels  : ['Ene.', 'Feb.', 'Mar.', 'Abr.', 'May.', 'Jun.', 'Jul.', 'Ago.', 'Sep.', 'Oct.', 'Nov.', 'Dic.'],
  datasets: [ ]
}
var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines : {
          display : false,
        }
      }],
      yAxes: [{
        gridLines : {
          display : false,
        }
      }]
    }
  }
  var salesChart = new Chart(salesChartCanvas, { 
    type: 'line', 
    data: salesChartData, 
    options: salesChartOptions
  }
)
function reloadGraph_uno(valor)
{

    var idplanta = valor;
    
    var datos = new FormData();
    datos.append("idplanta", idplanta);

    $.ajax({
            url: "ajax/inicio.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"JSON",
            success: function(respuesta)
            { 
                var textodata ="";
               
                if (salesChart)
                {
                   alert("entro a impiar");
                   salesChart.clear();
                  
                }
              
               
                var R = 60;
                var G = 141;
                var B = 188;
                var A = 0.9;
              
              
                for(i = 0 ; i < respuesta.length; i++) 
                 {
                 
                  daticos = respuesta[i].elementos.split(",");
                    datosFinales ='';
                     for(j=0;j<daticos.length;j++)
                     {
                        operacion = daticos[j].split("-");
                        operacionFinal = operacion[0] / operacion[1];
                        datosFinales += operacionFinal.toFixed(2)+",";
                     }       
                      textodata = '[' + datosFinales.substring(0, datosFinales.length - 1) + ']'; 
                     console.log(textodata); 
                     
                          salesChart.data.datasets.push({
                            label: 'Año ' + respuesta[i].anyo + ' KwH/Ton',
                            backgroundColor     : 'rgba('+R+','+G+','+B+','+A+')',
                            borderColor         : 'rgba('+R+','+G+','+B+','+(A-0.1)+')',
                            pointRadius         : true,
                            pointColor          : 'rgba('+R+','+G+','+B+','+A+')',
                            pointStrokeColor    : 'rgba('+R+','+G+','+B+','+(A + 0.1)+')',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba('+R+','+G+','+B+','+(A + 0.1)+')',
                            data:  eval(textodata)
                        });
                        salesChart.update();
                          R = R + 150;
                          G = G + 70;
                          B = B + 30;

                       


                  }
            }

        })
    }

  