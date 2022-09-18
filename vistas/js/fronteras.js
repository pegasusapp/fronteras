/*=============================================
FRONTERAS
=============================================*/

let canvas; 
let ctx; 
let chartType; 
let myBarChart;
let ids;
let data;
let options;
let tipoEnergiaA="";
let tipoEnergiaR="";
let tipoEnergiaE="";
let tipoEnergiaP = "";
let tipoEnergiaC = "";
let tipoEnergia ="";
let cadenaFecha = "";
let EnergiaLabelA = "";
let EnergiaLabelR = "";
let EnergiaLabelP = "";
let EnergiaLabelE = "";
let EnergiaLabelC = "";
let tabla ="";
let Domingo ="";
let Lunes = "";
let Martes = "";
let Miercoles = "";
let Jueves = "";
let Viernes = "";
let Sabado = "";
const colorActiva = "75, 192, 192";
const colorReactiva = "0, 143, 57";
const colorExportada = "255, 173, 20";
const colorPenalizada = "255, 0, 00";
const colorCapacitiva = "128, 255, 51";
const mesv = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
const semana = {
  1: 'Dom',
  2: 'Lun',
  3: 'Mar',
  4: 'Mie',
  5: 'Jue',
  6: 'Vie',
  7: 'Sáb'
};


$(document).ready(function() {

  Chart.defaults.global.defaultFontColor = 'grey';
  Chart.defaults.global.defaultFontSize = 10;
  $('#example_table tbody').on('click', 'td.details-control', function () {
    let tr = $(this).closest('tr');
    let frt = $(this).attr('vlr');
    let row = table.row( tr );

    if ( row.child.isShown() ) 
      {
          row.child.hide();
          tr.removeClass('shown');
      }
      else{
        row.child( tabla ).show();
            tr.addClass('shown');
            startToBuildGraphic(frt,'hoy')
      }
  });
 
} );

function operationDayIn(word){
  let number = 0
  if(word == "ayer" || word == "atras")
     number = -1
  return number 
}
function startToBuildGraphic(frt,wordInit){

  let element = document.getElementById("td_"+frt);
  let tr = element.closest('tr');
  let datosIn = new FormData();
  datosIn.append("frontera", frt);
  datosIn.append("dia", wordInit);
  let row = table.row( tr );
  tipoEnergiaA = ""
  tipoEnergiaR = ""
  tipoEnergiaE = ""
  tipoEnergiaP = ""
  tipoEnergiaC = ""
  const d = new Date();
  let daysOperation = operationDayIn(wordInit)
  cadenaFecha = addDays(d, daysOperation,"day");

      $.ajax({ 
        url: "ajax/fronteras.ajax.php",
        method: "POST",
        data: datosIn,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json", 
        success: function(respuesta)
        { 
          tabla = "";
          fillArrayData(respuesta,frt)
          row.child( tabla ).show();
          addData(tipoEnergiaA,tipoEnergiaR,tipoEnergiaE,tipoEnergiaP,tipoEnergiaC,frt,cadenaFecha);
        }
    
    })
 


}
function addDays(fecha, dias,temp){
  
  
  if(temp == "day"){
    fecha.setDate(fecha.getDate() + dias);
  } 
  else if(temp=="month"){
    fecha.setMonth(fecha.getMonth() + dias);
  }
 
   
   let month = fecha.getMonth();
   let year = fecha.getFullYear();
   let day = fecha.getDate();
   console.log(year+"-"+month+"-"+day);
  return year+"-"+month+"-"+day;
}
function fillArrayData(respuesta,frt)
 {
    
      tabla=' <div class="row"> <div class="col-md-2"><table cellpadding="5" cellspacing="0" border="0" >';
      if(respuesta.length > 0)
      {
        for(const element of respuesta)
        {
            let EnergiaLabel = "";
            
            tabla+="<tr>";
            if(element['tipoEnergia']=="A")
            {
              tipoEnergiaA = element['datos'];
              EnergiaLabel ="Activa";
            }
            else if(element['tipoEnergia']=="R")
            {
              tipoEnergiaR = element['datos'];
              EnergiaLabel ="Reactiva";
            }
            else if(element['tipoEnergia']=="E")
            {
              tipoEnergiaE = element['datos'];
              EnergiaLabel ="Exportada";
            }
            else if(element['tipoEnergia']=="P")
            {
              tipoEnergiaP = element['datos'];
              EnergiaLabel ="Penalizada";
            }
            else if(element['tipoEnergia']=="C")
            {
              tipoEnergiaC = element['datos'];
              EnergiaLabel ="Capacitiva";
            }
            tabla+="<td>"+EnergiaLabel+": "+parseFloat(element['total_dia']).toFixed(2)+" kW h</td>";
            tabla+="</tr>";
        }  
      }
      else
      {
        
        tabla+="<tr>";
        tabla+="<td>No hay datos reportados</td>";
        tabla+="</tr>";
           }

     tablaInterna(frt)
}    
function tablaInterna(frt)
  {
    tabla+="<tr>";
    tabla+='<td><div class="btn-group"><a class="btn btn-app" onClick=startToBuildGraphic("'+frt+'","hoy")  ><i class="fas fa-play"></i>Hoy</a></div>&nbsp;<div class="btn-group"><a class="btn btn-app" onClick=startToBuildGraphic("'+frt+'","ayer")><i class="fas fa-play"></i>Ayer</a></div></td>';
    tabla+="</tr>";
    tabla+="<tr>";
    tabla+='<td><div class="btn-group"><a class="btn btn-app" onClick=verHistoricosMes("'+frt+'","actual","A") ><i class="fas fa-play"></i>Este mes</a></div>&nbsp;<div class="btn-group"><a class="btn btn-app" onClick=verHistoricosMes("'+frt+'","atras","A")><i class="fas fa-play"></i>Mes anterior</a></div></td>';
    tabla+="</tr>";
    tabla+="<tr>";
    tabla+='<td><div class="btn-group"><a class="btn btn-app" onClick=verHistoricosProm("'+frt+'","promedio","A") ><i class="fas fa-play"></i>Promedio A(6)</a></div>&nbsp;<div class="btn-group"><a class="btn btn-app" onClick=verHistoricosProm("'+frt+'","promedio","R")><i class="fas fa-play"></i>Promedio R(6)</a></div></td>';
    tabla+="</tr>";
    tabla+="<tr>";
    tabla+='<td><div class="btn-group"><a class="btn btn-app" onClick=verHistoricosProm("'+frt+'","promedio","E") ><i class="fas fa-play"></i>Promedio E(6)</a></div>&nbsp;<div class="btn-group"><a class="btn btn-app" onClick=verHistoricosProm("'+frt+'","promedio","P")><i class="fas fa-play"></i>Promedio P(6)</a></div></td>';
    tabla+="</tr>";
    tabla+="<tr>";
    tabla+='<td><div class="btn-group"><a class="btn btn-app" onClick=verHistoricosProm("'+frt+'","promedio","C") ><i class="fas fa-play"></i>Promedio C(6)</a></div>&nbsp;</div></td>';
    tabla+="</tr>";
    tabla+="</table></div>";
    tabla+="<div class='col-md-10'>";
    tabla+="<div class='card'>";
    tabla+="<div class='card-body'>";
    tabla+="<div class='chart' id='canvasMadre_"+frt+"'>";
    tabla+="</div>";
    tabla+="</div>";
    tabla+="</div>";
    tabla+="</div>";

}
function addData(valores,valores_re,valores_ex,valores_pe,valores_c,fronteraDraw,cadenaFechaDraw)
{

canvas = document.createElement('canvas');
canvas.id = 'areaChart_'+fronteraDraw;
let fechaImagen = cadenaFechaDraw.split("-");
document.body.appendChild(canvas); // adds the canvas to the body element
document.getElementById('canvasMadre_'+fronteraDraw).appendChild(canvas);


  data = {
         labels: ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24"],
         datasets: [
           
          {

                  label:"Energia activa",
                  fill:false,
                  borderColor:"rgb("+colorActiva+")",
                  borderWidth:1,
                  fill: false,
                  lineTension: 0.1,
                  borderCapStyle: 'square',
                  pointBorderColor: "white",
                  pointBackgroundColor: "rgb(75, 192, 192)",
                  pointBorderWidth: 0.5,
                  pointHoverRadius: 4,
                  pointHoverBackgroundColor: "yellow",
                  pointHoverBorderColor: "green",
                  pointHoverBorderWidth: 2,
                  pointRadius: 2,
                  pointHitRadius: 5,
                  data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                  spanGaps: true,
         },
         {
                  label:"Energia reactiva",
                  fill:false,
                  borderColor:"rgb("+colorReactiva+")",
                  borderWidth:1,
                  fill: false,
                  lineTension: 0.1,
                  borderCapStyle: 'square',
                  pointBorderColor: "white",
                  pointBackgroundColor: "rgb(0, 143, 57)",
                  pointBorderWidth: 0.5,
                  pointHoverRadius: 4,
                  pointHoverBackgroundColor: "yellow",
                  pointHoverBorderColor: "green",
                  pointHoverBorderWidth: 2,
                  pointRadius: 2,
                  pointHitRadius: 5,
                  data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                  spanGaps: true,
         },
         {
                  label:"Energia exportada",
                  fill:false,
                  borderColor:"rgb("+colorExportada+")",
                  borderWidth:1,
                  fill: false,
                  lineTension: 0.1,
                  borderCapStyle: 'square',
                  pointBorderColor: "white",
                  pointBackgroundColor: "rgb(255, 173, 20)",
                  pointBorderWidth: 0.5,
                  pointHoverRadius: 4,
                  pointHoverBackgroundColor: "yellow",
                  pointHoverBorderColor: "green",
                  pointHoverBorderWidth: 2,
                  pointRadius: 2,
                  pointHitRadius: 5,
                  data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                  spanGaps: true,
         },
         {
                  label:"Energia penalizada",
                  fill:false,
                  borderColor:"rgb("+colorPenalizada+")",
                  borderWidth:1,
                  fill: false,
                  lineTension: 0.1,
                  borderCapStyle: 'square',
                  pointBorderColor: "white",
                  pointBackgroundColor: "rgb(255, 0, 00)",
                  pointBorderWidth: 0.5,
                  pointHoverRadius: 4,
                  pointHoverBackgroundColor: "yellow",
                  pointHoverBorderColor: "green",
                  pointHoverBorderWidth: 2,
                  pointRadius: 2,
                  pointHitRadius: 5,
                  data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                  spanGaps: true,
         },
         {
                 label:"Energia capacitiva",
                 fill:false,
                 borderColor:"rgb("+colorCapacitiva+")",
                 borderWidth:1,
                 fill: false,
                 lineTension: 0.1,
                 borderCapStyle: 'square',
                 pointBorderColor: "white",
                 pointBackgroundColor: "rgb(128 255 51)",
                 pointBorderWidth: 0.5,
                 pointHoverRadius: 4,
                 pointHoverBackgroundColor: "yellow",
                 pointHoverBorderColor: "green",
                 pointHoverBorderWidth: 2,
                 pointRadius: 2,
                 pointHitRadius: 5,
                 data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                 spanGaps: true,
          }
        
        
        ]
};

          options = {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          },
          title: {
            fontSize: 10,
            display: true,
            text: 'Registro del día '+fechaImagen[2]+'  del mes ' +mesv[fechaImagen[1]]+' del año '+fechaImagen[0],
            position: 'bottom'
          }
          };
  canvas = document.getElementById("areaChart_"+fronteraDraw);
   ctx = canvas.getContext('2d');
  chartType = 'line';
  myBarChart = new Chart(ctx, {
    type: chartType,
    data: data,
    options: options
  });
  let res = valores.split(","); 
  let res_re = valores_re.split(","); 
  let res_ex = valores_ex.split(","); 
  let res_pe = valores_pe.split(",");
  let res_ca = valores_c.split(",");
  let j=0;
  console.log("-->"+res.length);
  if(res.length === 1){
    console.log("entro");
    myBarChart.data.datasets[0].data="";
  }
  else{
    for(let i=0;i<24;i++)
    {
      myBarChart.data.datasets[j].data[i] = res[i];
      myBarChart.data.datasets[j+1].data[i] = res_re[i];
      myBarChart.data.datasets[j+2].data[i] = res_ex[i];
      myBarChart.data.datasets[j+3].data[i] = res_pe[i];
      myBarChart.data.datasets[j+4].data[i] = res_ca[i];

    }
  }

    Chart.plugins.register({
      afterDraw: function (chart) {
        console.log(chart.data.datasets.length);
          if (chart.data.datasets[0].data.length === 0) {
              // No data is present
               ctx = chart.chart.ctx;
              let width = chart.chart.width;
              let height = chart.chart.height
              chart.clear();
              ctx.save();
              ctx.textAlign = 'center';
              ctx.textBaseline = 'middle';
              ctx.font = "20px 'Helvetica'";
              ctx.fillText('Aún no hay lecturas para el día de hoy', width / 2, height / 2);
              ctx.restore();
          }
      }
  });
 
  myBarChart.update();
}


let consumoSeisMeses = "";
 function procesoDataProm(respuesta,idsFrt)
 {
      let len = respuesta.length;
      tabla=' <div class="row"> <div class="col-md-2"><table cellpadding="5" cellspacing="0" border="0" >';
      if(len > 0)
      {
        let totalPromedioA = 0;
        let totalPromedioR = 0;
        let totalPromedioP = 0;
        let totalPromedioE = 0;
        let totalPromedioC = 0;
      
        var sumA = 0;
        var sumR = 0;
        var sumE = 0;
        var sumP = 0;
        var sumC = 0;
        var tA = 0;
        for( var i = 0; i<len; i++)
            {
                var mesActualj = parseInt(respuesta[i]['mesLectura']) - 1;
            
                tabla+="<tr>";
              if(tA == 0)
                {   
                tipoEnergia =
                    [
                      {
                            "mes"     : mesv[mesActualj],
                            "valor"   : respuesta[i]['datos'],
                            "energia" : respuesta[i]['tipoEnergia'],
                            "anyo"    : respuesta[i]['anyoLectura'],
                            "mesNum"  : respuesta[i]['mesLectura']
                      }

                    ]
                }
                else
                {
                    
                tipoEnergia.push(
                    {
                          "mes"     : mesv[mesActualj],
                          "valor"   : respuesta[i]['datos'],
                          "energia" : respuesta[i]['tipoEnergia'],
                          "anyo"    : respuesta[i]['anyoLectura'],
                          "mesNum"  : respuesta[i]['mesLectura']
                    });  
                  
                }    
    
              tA +=1;
            }
 
                const groupedPeople = groupBy(tipoEnergia, 'energia');
                console.log(groupedPeople);

               
              
                for(let key in groupedPeople["A"])
                 {
                  sumA += parseFloat(groupedPeople["A"][key]["valor"]);
                  EnergiaLabelA ="Activa";
                 }
                 for(let key in groupedPeople["R"])
                 {
                  sumR += parseFloat(groupedPeople["R"][key]["valor"]);
                  EnergiaLabelR ="Reactiva";
                 }
                 for(let key in groupedPeople["E"])
                 {
                  sumE += parseFloat(groupedPeople["E"][key]["valor"]);
                  EnergiaLabelE ="Exportada";
                 }
                 for(let key in groupedPeople["P"])
                 {
                  sumP += parseFloat(groupedPeople["P"][key]["valor"]);
                  EnergiaLabelP ="Penalizada";
                 }
                 for(let key in groupedPeople["C"])
                  {
                      sumC += parseFloat(groupedPeople["C"][key]["valor"]);
                      EnergiaLabelP ="Capacitiva";
                  }

                 if (typeof groupedPeople["A"] != 'undefined'){ totalPromedioA = sumA/groupedPeople["A"].length;} else{ totalPromedioA=0;}
                 if (typeof groupedPeople["R"] != 'undefined'){ totalPromedioR = sumR/groupedPeople["R"].length;} else {totalPromedioR=0;}
                 if (typeof groupedPeople["E"] != 'undefined'){ totalPromedioE = sumE/groupedPeople["E"].length;} else {totalPromedioE=0;}
                 if (typeof groupedPeople["P"] != 'undefined'){ totalPromedioP = sumP/groupedPeople["P"].length;} else {totalPromedioP=0;}
                 if (typeof groupedPeople["C"] != 'undefined'){ totalPromedioC = sumC/groupedPeople["C"].length;} else {totalPromedioC=0;}

                tabla+="<td>Prom(6) A. "+(totalPromedioA).toFixed(4)+" kW h</td>";
                tabla+="</tr>";
                tabla+="<tr>";
                tabla+="<td>Prom(6) R. "+(totalPromedioR).toFixed(4)+" kW h</td>";
                tabla+="</tr>";
                tabla+="<tr>";
                tabla+="<td>Prom(6) E. "+(totalPromedioE).toFixed(4)+" kW h</td>";
                tabla+="</tr>";
                tabla+="<tr>";
                tabla+="<td>Prom(6) P. "+(totalPromedioP).toFixed(4)+" kW h</td>"; 
                tabla+="</tr>";
                tabla+="<tr>";
                tabla+="<td>Prom(6) C. "+(totalPromedioC).toFixed(4)+" kW h</td>";
                tabla+="</tr>";
        
      }
      else
      {
        tabla+="<tr>";
        tabla+="<td>No hay datos reportados</td>";
        tabla+="</tr>";
      }

tablaInterna(idsFrt)

 } 
 function groupBy(objectArray, property) {
  return objectArray.reduce((acc, obj) => {
     const key = obj[property];
     if (!acc[key]) {
        acc[key] = [];
     }
     // Add object to list for given key's value
     acc[key].push(obj);
     return acc;
  }, {});
}

 function verHistoricosProm(idsIn,word,energia)
{
      let element = document.getElementById("td_"+idsIn);
      let tr = element.closest('tr');
      let datosIn = new FormData();
      datosIn.append("frontera_prom", idsIn);
      datosIn.append("energia", energia);
      let row = table.row( tr );
      tipoEnergia = "";
      $.ajax({ 
        url: "ajax/fronteras.ajax.php",
        method: "POST",
        data: datosIn,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json", 
        success: function(respuestaHistorica)
        { 
           
          tabla = "";
          procesoDataProm(respuestaHistorica,idsIn)
          row.child( tabla ).show();
          addDataProm(tipoEnergia,energia,idsIn,cadenaFecha);

           
        }
    
    })
}

function addDataProm(tipoEnergia,energia,ids,cadenaFecha) 
 {
 var colorSesion = "";
  if(energia == "A")
    {
        EnergiaLabel = "Activa";
        colorSesion= colorActiva;
    }
  else if (energia=="R")
  {
      EnergiaLabel="Reactiva";
      colorSesion=colorReactiva;
  }
  else if(energia=="E")
  {
      EnergiaLabel="Exportada";
      colorSesion=colorExportada;
  }
  else if(energia=="C")
  {
      EnergiaLabel="Capacitiva";
      colorSesion=colorCapacitiva;
  }
  else
  {
      EnergiaLabel="Penalizada";
      colorSesion=colorPenalizada;
  }
  canvas = document.createElement('canvas');
  canvas.id = 'areaChart_'+ids;
  var fechaImagen = cadenaFecha.split("-");
  document.body.appendChild(canvas); // adds the canvas to the body element
  document.getElementById('canvasMadre_'+ids).appendChild(canvas);
  console.log(colorSesion);

data = {
        labels: [],
        datasets:[
                  {
                  "label":"Consumo energia " +EnergiaLabel,
                  "data":[0,0,0,0,0,0,0],
                  "fill":false,
                  "backgroundColor":["rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)"],
                  "borderColor":["rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")"],
                  "borderWidth":1
                  }
                 ]
       };
options = {
  'onClick' : (evt, item) => 
             { 
                 
                 e = item[0]; 
                 console.log(e._index)
                 var month = item[0]['_model'].label;
                 console.log(this.data.labels[e._index]); 
                 console.log(this.data.datasets[0].data[e._index]);
                 console.log(this.data.datasets[0].label);
                 var etiquetaEnvio=this.data.datasets[0].label;
                           // this.selectedDay = month;
                 this.renderHourlyBarChart(month,ids,etiquetaEnvio); 
              },
        scales: {
          xAxes: [{
              gridLines:
                 {
                  offsetGridLines: true
                 },
                 stacked: false
                 }]
               },
        title: 
              {
                fontSize: 10,
                display: true,
                text: 'Consumo de los últimos 6 meses energia '+EnergiaLabel+' y su promedio',
                position: 'bottom'
              }
          };
   canvas = document.getElementById("areaChart_"+ids);
    ctx = canvas.getContext('2d');
    chartType = 'bar';

     myBarChart = new Chart(ctx, {
      type: 'bar',
      data: data,
      options: options
    })
   
    const groupedPeople = groupBy(tipoEnergia, 'energia');
    var sumaPromedioEner = 0;
    for(let key in groupedPeople[energia])
    {
     myBarChart.data.labels.push(groupedPeople[energia][key]["mes"]+" - "+groupedPeople[energia][key]["anyo"]);
     myBarChart.data.datasets[0].data[key] = parseFloat(groupedPeople[energia][key]["valor"]).toFixed(4);
     sumaPromedioEner += parseFloat(groupedPeople[energia][key]["valor"]);
    }
    if (typeof groupedPeople[energia] != 'undefined')
    {
     
      console.log(groupedPeople[energia].length);
      totalPromedioEnergia = sumaPromedioEner/groupedPeople[energia].length;
      myBarChart.data.labels.push("promedio");
      myBarChart.data.datasets[0].data[groupedPeople[energia].length] = parseFloat(totalPromedioEnergia).toFixed(4);
      myBarChart.update();
    }
    else
    {
      totalPromedioEnergia = 0;
      myBarChart.data.labels.push("No existe este tipo de energia");
      myBarChart.data.datasets[0].data[6] = parseFloat(totalPromedioEnergia).toFixed(4);
      myBarChart.update();
    }
    


}


function verHistoricos(idsHs,day)
{
      let element = document.getElementById("td_"+idsHs);
      let tr = element.closest('tr');
      let datosIn = new FormData();
      datosIn.append("frontera_dia", idsHs);
      datosIn.append("dia", day);
      let row = table.row( tr );
    
      $.ajax({ 
        url: "ajax/fronteras.ajax.php",
        method: "POST",
        data: datosIn,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json", 
        success: function(respuestaHs)
        { 

          tabla = "";
          tipoEnergiaA=0;
          tipoEnergiaR=0;
          tipoEnergiaE=0;
          tipoEnergiaP=0;
          tipoEnergiaC=0;
          procesoData(respuestaHs,idsHs)
          row.child( tabla ).show();
          addData(tipoEnergiaA,tipoEnergiaR,tipoEnergiaE,tipoEnergiaP,tipoEnergiaC,idsHs,cadenaFecha);

           
        }
    
    })
}




  function verHistoricosMes(fronteraHistoricos,wordInit,energia)
  {
    let element = document.getElementById("td_"+fronteraHistoricos);
    let tr = element.closest('tr');

    let datosIn = new FormData();
    datosIn.append("frontera_mes", fronteraHistoricos);
    datosIn.append("mes", wordInit);
    datosIn.append("energia", energia);
    const d = new Date();
    let daysOperation = operationDayIn(wordInit)
    cadenaFecha = addDays(d, daysOperation,"month");
    let row = table.row( tr );
   
         $.ajax({ 
          url: "ajax/fronteras.ajax.php",
          method: "POST",
          data: datosIn,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json", 
          success: function(respuesta)
          { 
             
            tabla="";
            procesoDataMes(respuesta,fronteraHistoricos)
            row.child( tabla ).show();
            addDataM(tipoEnergia,Domingo,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado,fronteraHistoricos,cadenaFecha);
  
             
          }
      
      })
  
  }

  function procesoDataMes(respuesta,frto)
  {
    tabla=' <div class="row"> <div class="col-md-2"><table cellpadding="5" cellspacing="0" border="0" >';
    Lunes  = "";
    Martes = "";
    Miercoles = "";
    Jueves = "";
    Viernes = "";
    Sabado = "";
    Domingo = "";

    if(respuesta.length > 0)
    {
     
      for(const element of respuesta)
      {
        

          tabla+="<tr>";
          tipoEnergia = element['tipoEnergia'];
          if(element['dia'] == 1)
          {
            Domingo = element['datos'];
          }
          if(element['dia'] == 2)
          {
            Lunes = element['datos'];
          }
          if(element['dia'] == 3)
          {
            Martes = element['datos'];                     
          }
          if(element['dia'] == 4)
          {
            Miercoles = element['datos'];                     
          }
          if(element['dia'] == 5)
          {
            Jueves = element['datos'];                     
          }
          if(element['dia'] == 6)
          {
            Viernes = element['datos'];                     
          }
          if(element['dia'] == 7)
          {
            Sabado = element['datos'];                     

          }
          tabla+="<td>Prom. "+element['tipoEnergia']+" "+semana[element['dia']]+" : "+parseFloat(element['total_dia']).toFixed(2)+" kW h</td>";
          tabla+="</tr>";
      }

    }
    else
    {
      tabla+="<tr>";
      tabla+="<td>No hay datos reportados</td>";
      tabla+="</tr>";
    }
    tablaInterna(frto)
  }


  function addDataM(energia,Dom,Lun,Mar,Mier,Jue,Vie,Sab,FronteraMes,cadenaFechaMes) {
   
    canvas = document.createElement('canvas');
    canvas.id = 'areaChart_'+FronteraMes;
    let fechaImagen = cadenaFechaMes.split("-");
    document.body.appendChild(canvas); // adds the canvas to the body element
    document.getElementById('canvasMadre_'+FronteraMes).appendChild(canvas);

    data = {
           labels: ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24"],
           datasets: [{

                    label:"Lunes",
                    fill:false,
                    borderColor:"rgb(246, 202, 25)",
                    borderWidth:1,
                    fill: false,
                    lineTension: 0.1,
                    borderCapStyle: 'square',
                    pointBorderColor: "white",
                    pointBackgroundColor: "rgb(75, 192, 192)",
                    pointBorderWidth: 0.5,
                    pointHoverRadius: 4,
                    pointHoverBackgroundColor: "yellow",
                    pointHoverBorderColor: "green",
                    pointHoverBorderWidth: 2,
                    pointRadius: 2,
                    pointHitRadius: 5,
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    spanGaps: true,
                     },
                     {

                      label:"Martes",
                      fill:false,
                      borderColor:"rgb(219, 117, 0)",
                      borderWidth:1,
                      fill: false,
                      lineTension: 0.1,
                      borderCapStyle: 'square',
                      pointBorderColor: "white",
                      pointBackgroundColor: "rgb(75, 192, 192)",
                      pointBorderWidth: 0.5,
                      pointHoverRadius: 4,
                      pointHoverBackgroundColor: "yellow",
                      pointHoverBorderColor: "green",
                      pointHoverBorderWidth: 2,
                      pointRadius: 2,
                      pointHitRadius: 5,
                      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                      spanGaps: true,
                       },
                       {

                        label:"Miercoles",
                        fill:false,
                        borderColor:"rgb(0, 0, 0)",
                        borderWidth:1,
                        fill: false,
                        lineTension: 0.1,
                        borderCapStyle: 'square',
                        pointBorderColor: "white",
                        pointBackgroundColor: "rgb(75, 192, 192)",
                        pointBorderWidth: 0.5,
                        pointHoverRadius: 4,
                        pointHoverBackgroundColor: "yellow",
                        pointHoverBorderColor: "green",
                        pointHoverBorderWidth: 2,
                        pointRadius: 2,
                        pointHitRadius: 5,
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        spanGaps: true,
                         },
                         {

                          label:"Jueves",
                          fill:false,
                          borderColor:"rgb(172, 3, 255)",
                          borderWidth:1,
                          fill: false,
                          lineTension: 0.1,
                          borderCapStyle: 'square',
                          pointBorderColor: "white",
                          pointBackgroundColor: "rgb(75, 192, 192)",
                          pointBorderWidth: 0.5,
                          pointHoverRadius: 4,
                          pointHoverBackgroundColor: "yellow",
                          pointHoverBorderColor: "green",
                          pointHoverBorderWidth: 2,
                          pointRadius: 2,
                          pointHitRadius: 5,
                          data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                          spanGaps: true,
                           },
                           {

                            label:"Viernes",
                            fill:false,
                            borderColor:"rgb(0, 26, 255)",
                            borderWidth:1,
                            fill: false,
                            lineTension: 0.1,
                            borderCapStyle: 'square',
                            pointBorderColor: "white",
                            pointBackgroundColor: "rgb(75, 192, 192)",
                            pointBorderWidth: 0.5,
                            pointHoverRadius: 4,
                            pointHoverBackgroundColor: "yellow",
                            pointHoverBorderColor: "green",
                            pointHoverBorderWidth: 2,
                            pointRadius: 2,
                            pointHitRadius: 5,
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                            spanGaps: true,
                             },
                             {

                              label:"Sabado",
                              fill:false,
                              borderColor:"rgb(26, 255, 0)",
                              borderWidth:1,
                              fill: false,
                              lineTension: 0.1,
                              borderCapStyle: 'square',
                              pointBorderColor: "white",
                              pointBackgroundColor: "rgb(75, 192, 192)",
                              pointBorderWidth: 0.5,
                              pointHoverRadius: 4,
                              pointHoverBackgroundColor: "yellow",
                              pointHoverBorderColor: "green",
                              pointHoverBorderWidth: 2,
                              pointRadius: 2,
                              pointHitRadius: 5,
                              data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                              spanGaps: true,
                               },
                               {

                                label:"Domingo",
                                fill:false,
                                borderColor:"rgb(0, 205, 255)",
                                borderWidth:1,
                                fill: false,
                                lineTension: 0.1,
                                borderCapStyle: 'square',
                                pointBorderColor: "white",
                                pointBackgroundColor: "rgb(75, 192, 192)",
                                pointBorderWidth: 0.5,
                                pointHoverRadius: 4,
                                pointHoverBackgroundColor: "yellow",
                                pointHoverBorderColor: "green",
                                pointHoverBorderWidth: 2,
                                pointRadius: 2,
                                pointHitRadius: 5,
                                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                                spanGaps: true,
                                 }      
          
          ]
};

            options = {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            },
            title: {
              fontSize: 10,
              display: true,
              text: 'Registro  energia ' + energia + ' mes de '+mesv[fechaImagen[1]]+ ' de '+fechaImagen[0],
              position: 'bottom'
            }
            };
    canvas = document.getElementById("areaChart_"+FronteraMes);
    ctx = canvas.getContext('2d');
    chartType = 'line';
    myBarChart = new Chart(ctx, {
      type: chartType,
      data: data,
      options: options
    });
    let lun = Lun.split(","); 
    let mar = Mar.split(","); 
    let mier = Mier.split(","); 
    let jue = Jue.split(","); 
    let vie = Vie.split(","); 
    let sab = Sab.split(","); 
    let dom = Dom.split(","); 
    let j=0;
      for(let i=0;i<24;i++)
      {
        myBarChart.data.datasets[j].data[i] = lun[i];
        myBarChart.data.datasets[j+1].data[i] = mar[i];
        myBarChart.data.datasets[j+2].data[i] = mier[i];
        myBarChart.data.datasets[j+3].data[i] = jue[i];
        myBarChart.data.datasets[j+4].data[i] = vie[i];
        myBarChart.data.datasets[j+5].data[i] = sab[i];
        myBarChart.data.datasets[j+6].data[i] = dom[i];
      }
    

    myBarChart.update();
  }




function renderHourlyBarChart(month,ids,etiquetaEnvio)
{
  
var cortarEtiqueta = month.split(" - ");
var  anyoConsulta = cortarEtiqueta[1].trim();
var mesConsulta = cortarEtiqueta[0].trim();
  

  if(mesConsulta == "Enero")
    mesConsulta=1;
  else if(mesConsulta == "Febrero")
    mesConsulta=2;
  else if(mesConsulta == "Marzo")
    mesConsulta=3;
  else if(mesConsulta == "Abril")
    mesConsulta=4;
  else if(mesConsulta == "Mayo")
    mesConsulta=5;
  else if(mesConsulta == "Junio")
    mesConsulta=6;
  else if(mesConsulta == "Julio")
    mesConsulta=7;
  else if(mesConsulta == "Agosto")
    mesConsulta=8;
  else if(mesConsulta == "Septiembre")
    mesConsulta=9;
  else if(mesConsulta == "Octubre")
    mesConsulta=10;
  else if(mesConsulta == "Noviembre")
    mesConsulta=11;
  else
    mesConsulta=12;
   
    var etiquetaq = etiquetaEnvio.split(" ");
    var primeraLetra = etiquetaq[2].charAt(0);
    

    var element = document.getElementById("td_"+ids);
    var tr = element.closest('tr');
    var datosIn = new FormData();
    datosIn.append("fronteraDetalle", ids);
    datosIn.append("energiaDetalle", primeraLetra);
    datosIn.append("mesConsultaDetalle", mesConsulta);
    datosIn.append("anyoDetalle", anyoConsulta)
    var row = table.row( tr );
    tipoEnergia = "";
    $.ajax({ 
      url: "ajax/fronteras.ajax.php",
      method: "POST",
      data: datosIn,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json", 
      success: function(respuesta)
      { 
         
        tabla = "";
        procesoDataDetalle(respuesta,ids)
        row.child( tabla ).show();
        addDataDetalle(tipoEnergia,primeraLetra,ids,cadenaFecha);

         
      }
  
  })


}  

function procesoDataDetalle(respuesta,ids)
{
 var len = respuesta.length;
 var tmpbandera = 0;
     tabla=' <div class="row"> <div class="col-md-2"><table cellpadding="5" cellspacing="0" border="0" >';
     if(len > 0)
     {
       for( var i = 0; i<len; i++)
       {
              var mesActualj = parseInt(respuesta[i]['mesLectura']) - 1;
              cadenaFecha =  respuesta[i]['anyoLectura']+"-"+mesv[mesActualj]+"-"+respuesta[i]['diaLectura']; 
    
              tabla+="<tr>";
            if(tmpbandera == 0)
              {   
              tipoEnergia =
                  [
                    {
                          "mes"     : mesv[mesActualj],
                          "valor"   : respuesta[i]['max_value'],
                          "H"       : respuesta[i]['column_max_value'],
                          "energia" : respuesta[i]['tipoEnergia'],
                          "anyo"    : respuesta[i]['anyoLectura'],
                          "mesNum"  : respuesta[i]['mesLectura'],
                          "dia"  : respuesta[i]['diaLectura']
                    }

                  ]
              }
              else
              {
                  
              tipoEnergia.push(
                  {
                        "mes"     : mesv[mesActualj],
                        "valor"   : respuesta[i]['max_value'],
                        "H"       : respuesta[i]['column_max_value'],
                        "energia" : respuesta[i]['tipoEnergia'],
                        "anyo"    : respuesta[i]['anyoLectura'],
                        "mesNum"  : respuesta[i]['mesLectura'],
                        "dia"  : respuesta[i]['diaLectura']
                  });  
                
              }    

              tmpbandera +=1;
       }

       
     }
     else
     {
       tabla+="<tr>";
       tabla+="<td>No hay datos reportados</td>";
       tabla+="</tr>";
     }

    tablaInterna(ids)
} 

function addDataDetalle(tipoEnergia,energia,ids,cadenaFecha) 
 {
 var colorSesion = "";
  if(energia == "A")
     {
         EnergiaLabel = "Activa"; colorSesion= colorActiva;
     }
  else if (energia=="R")
     {
         EnergiaLabel="Reactiva"; colorSesion=colorReactiva;
     }
  else if(energia=="E")
     {
         EnergiaLabel="Exportada"; colorSesion=colorExportada;
     }
  else if(energia=="C")
  {
      EnergiaLabel="Capacitiva"; colorSesion=colorCapacitiva;
  }
  else
     {
         EnergiaLabel="Penalizada"; colorSesion=colorPenalizada;
     }
  canvas = document.createElement('canvas');
  canvas.id = 'areaChart_'+ids;
  var fechaImagen = cadenaFecha.split("-");
  document.body.appendChild(canvas); // adds the canvas to the body element
  document.getElementById('canvasMadre_'+ids).appendChild(canvas);

data = {
        labels: [],
        datasets:[
                  {
                  "label":"Energia " +EnergiaLabel,
                  "data":[],
                  "fill":false,
                  "backgroundColor":["rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)","rgb("+colorSesion+",0.2)"],
                  "borderColor":["rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")","rgb("+colorSesion+")"],
                  "borderWidth":1
                  }
                 ]
       };
options = {
 
        scales: {
          xAxes: [{
              gridLines:
                 {
                  offsetGridLines: true
                 },
                 stacked: false
                 }]
               },
        title: 
              {
                fontSize: 10,
                display: true,
                text: 'Maximas horas de consumo en el mes de '+fechaImagen[1]+'  de la energia ' + EnergiaLabel,
                position: 'bottom'
              }
          };
   canvas = document.getElementById("areaChart_"+ids);
    ctx = canvas.getContext('2d');
    chartType = 'line';

     myBarChart = new Chart(ctx, {
      type: 'line',
      data: data,
      options: options
    })
   
    const groupedPeople = groupBy(tipoEnergia, 'energia');
   // var sumaPromedioEner = 0;
    for(let key in groupedPeople[energia])
    {
     myBarChart.data.labels.push(groupedPeople[energia][key]["dia"]);
     myBarChart.data.datasets[0].data[key] = parseFloat(groupedPeople[energia][key]["valor"]).toFixed(4);
     //sumaPromedioEner += parseFloat(groupedPeople[energia][key]["valor"]);
    }
   // totalPromedioEnergia = sumaPromedioEner/groupedPeople[energia].length;
    //myBarChart.data.labels.push("promedio");
   // myBarChart.data.datasets[0].data[groupedPeople[energia].length] = parseFloat(totalPromedioEnergia).toFixed(4);
    myBarChart.update();

}

function editarFrontera(frontera)
{
  var datosIn = new FormData();
  datosIn.append("fronteraConsulta", frontera);
  $.ajax({ 
    url: "ajax/fronteras.ajax.php",
    method: "POST",
    data: datosIn,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json", 
    success: function(respuesta)
    { 
      for( var i = 0; i<respuesta.length; i++)
      {
        document.getElementById("editaridentificador").value=respuesta[i]["fronteraCliente"]; 
        document.getElementById("seguimientoeditar").value = respuesta[i]["seguimiento"];
        document.getElementById("editarminimoKv").value = respuesta[i]["minimoKv"]; 
 
      }

       
    }

})
}