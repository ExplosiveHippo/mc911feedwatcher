<html>
<head>
	
	<meta charset="utf-8">
	<style>

	body {
	  font: 10px sans-serif;
	}

	.axis path,
	.axis line {
	  fill: none;
	  stroke: #000;
	  shape-rendering: crispEdges;
	}

	.bar {
	  fill: steelblue;
	}

	.x.axis path {
	  display: none;
	}

	</style>

</head>
<body>

	<h2>Statistics on 911 Calls for Monroe County, NY - <?php echo date("D M d, Y"); ?></h2>

	<script src="http://d3js.org/d3.v3.min.js"></script>
	<script>

	var margin = {top: 20, right: 20, bottom: 30, left: 40},
		width = 960 - margin.left - margin.right,
		height = 500 - margin.top - margin.bottom;

	//var formatPercent = d3.format(".0%");

	var x = d3.scale.ordinal()
		.rangeRoundBands([0, width], .1);

	var y = d3.scale.linear()
		.range([height, 0]);

	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom");

	var yAxis = d3.svg.axis()
		.scale(y)
		.orient("left")
		//.tickFormat(formatPercent);

	var svg = d3.select("body").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
	  .append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	d3.tsv("statsapi.php", function(error, data) {

	  data.forEach(function(d) {
		d.frequency = +d.frequency;
	  });

	  x.domain(data.map(function(d) { return d.event; }));
	  y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

	  svg.append("g")
		  .attr("class", "x axis")
		  .attr("transform", "translate(0," + height + ")")
		  .call(xAxis);

	  svg.append("g")
		  .attr("class", "y axis")
		  .call(yAxis)
		.append("text")
		  .attr("transform", "rotate(-90)")
		  .attr("y", 6)
		  .attr("dy", ".71em")
		  .style("text-anchor", "end")
		  .text("Frequency");

	  svg.selectAll(".bar")
		  .data(data)
		.enter().append("rect")
		  .attr("class", "bar")
		  .attr("x", function(d) { return x(d.event); })
		  .attr("width", x.rangeBand())
		  .attr("y", function(d) { return y(d.frequency); })
		  .attr("height", function(d) { return height - y(d.frequency); });

	});

	</script>

	<h4>Stats are for Today, <?php echo date("Y-m-d"); ?></h4><br>

	<?php
	
		require_once("Database.class.php");
	
		$db = new Database();
		
		$eventtypes = $db->GetEventTypes();
	
		$letter = "A";
	
		echo '<br><font size="3">';
	
		foreach($eventtypes as $eventtype)
		{
			echo "<b>" . $letter . "</b>: " . $eventtype . "<br>";
			
			$letter++;
		}
	
		echo '</font>';
	
	?>

</body>
</html>