	google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Jobs'],
          ['Germany', 200],
          ['UAE', 300],
          ['India', 700],
          ['Egypt', 700],
          ['Russia', 700],
          ['Pakistan', 300],
        ]);

        var options = {
        displayMode: 'visualization',
        colorAxis: {colors: ['FF9AA4', 'FB100C']},
		legend: 'none',
		datalessRegionColor: 'F3F3F3',	
      };

        var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    };