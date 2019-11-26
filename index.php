<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Highcharts Example</title>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
 var chart;
 $(document).ready(function() {
  $.getJSON("./src/DataService.php", function(json) {

   chart = new Highcharts.Chart({
    chart: {
     renderTo: 'container',
     type: 'line',
     marginRight: 130,
     marginBottom: 25
    },
    title: {
     text: 'Users vs. Onboarding Progress',
     x: 0 //center
    },
    subtitle: {
     text: '',
     x: 0
    },
    xAxis: {
     categories: ['0%', '20%', '40%', '50%', '70%', '90%', '99%', '100%']
    },
    yAxis: {
     title: {
      text: 'Percentage of Users'
     },
     plotLines: [{
      value: 0,
      width: 1,
      color: '#808080'
     }]
    },
    tooltip: {
     formatter: function() {
      return '<b>' + this.series.name + '</b><br/>' +
       this.x + ' completed: ' + this.y + '%';
     }
    },
    legend: {
     layout: 'vertical',
     align: 'right',
     verticalAlign: 'top',
     x: 0,
     y: 100,
     borderWidth: 0
    },
    series: json
   });
  });

 });

});
</script>
</head>
<body>
<script src="./js/highcharts.js"></script>
<script src="./js/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

</body>
</html>
