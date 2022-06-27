<!DOCTYPE html>  
<html>  
    <head>  
        <title>Export Google Chart to PDF using PHP with DomPDF</title>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
        <script type="text/javascript">
               google.charts.load('current', {'packages':['corechart']});

               google.charts.setOnLoadCallback(drawChart);

               function drawChart()
               {
                var data = google.visualization.arrayToDataTable([
                 ['Gender', 'Number'],['Masculino', 80],['FEmenino', 20]]);

                var options = {
                 title : 'Percentage of Male and Female Employee',
                 pieHole : 0.4,
                 chartArea:{left:100,top:70,width:'100%',height:'80%'}
                };
                var chart_area = document.getElementById('piechart');
                var chart = new google.visualization.PieChart(chart_area);

                google.visualization.events.addListener(chart, 'ready', function(){
                 chart_area.innerHTML = '<img src="' + chart.getImageURI() + '" class="img-responsive">';
                });
                chart.draw(data, options);
               }

        </script>  
    </head>  
    <body>  
        <br /><br />  
        <div class="container" id="testing">  
            <h3 align="center">Export Google Chart to PDF using PHP with DomPDF</h3>  
            <br />
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Export Google Chart to PDF using PHP with DomPDF</h3>
    </div>
    <div class="panel-body" align="center">
     <div id="piechart" style="width: 100%; max-width:900px; height: 500px; "></div>
    </div>
   </div>
        </div>
  <br />
  <div align="center">
   <form method="post" id="make_pdf" action="create_pdf.php">
    <input type="hidden" name="hidden_html" id="hidden_html" />
    <button type="button" name="create_pdf" id="create_pdf" class="btn btn-danger btn-xs">Make PDF</button>
   </form>
  </div>
  <br />
  <br />
  <br />
    </body>  
</html>

<script>
$(document).ready(function(){

  $('#hidden_html').val($('#testing').html());
  alert($('#testing').html());
  $('#make_pdf').submit();

});
</script>

