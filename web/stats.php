<html>
<head>
	
	<title>Monroe County, NY 911 Feed API</title>
	
	<meta name="description" content="Monroe County, NY 911 Feed API">
	<meta name="keywords" content="Monroe, Monroe County, 911, Public Safty, Rochester, Feed, API, Application Programming Interface, Application, Programming, Interface, FOSS, Open Source, Open Data, Open, Source, Data">
	
	<link rel="shortcut icon" href="media/favicon.png" type="image/x-icon" />
	
	<link href="css/main.css" rel="stylesheet" type="text/css">

</head>
<body>

	<div class="top">
	
		<div class="topwrapper">

			<div class="header">

				<h2>Today's Statistics for  911 Calls for Monroe County, NY - <?php echo date("D M d, Y"); ?></h2>

			</div>

			<div class="graph1" id="graph1">

				<script src="http://d3js.org/d3.v3.min.js"></script>
				<script>

				var margin = {top: 20, right: 20, bottom: 30, left: 40},
					width = 800 - margin.left - margin.right,
					height = 450 - margin.top - margin.bottom;

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

				var svg = d3.select("#graph1").append("svg")
					.attr("width", width + margin.left + margin.right)
					.attr("height", height + margin.top + margin.bottom)
				  .append("g")
					.attr("transform", "translate(" + margin.left + "," + margin.top + ")")
					.attr("class", "chart");

				var today = new Date();
				var apiurl = "api/statsapi.php?startdate=" + today.getFullYear() + "-" + (today.getMonth()+1) + "-" + today.getDate();

				//alert(apiurl);

				d3.tsv(apiurl, function(error, data) {

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

			</div>

			<div class="decoder">

				<div class="tab">

					<?php
					
						require_once("./tools/Database.class.php");
					
						$db = new Database();
						
						$eventtypes = $db->GetEventTypes();
					
						$letter = "A";
					
						echo '<br><font size="2">';
					
						foreach($eventtypes as $eventtype)
						{
							echo "<b>" . $letter . "</b>: " . $eventtype->eventtype;
							echo ' (<a href="http://monroe911.mycodespace.net/visdata.php?eventtypeid=' . $eventtype->eventtypeid . '&period=today">hourly</a>)<br>';
							
							$letter++;
						}
					
						echo '</font>';
					
					?>
				
					<br>
				
				</div>
			
			</div>

		</div>

	</div>

</body>
</html>