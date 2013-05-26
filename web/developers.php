<?php
	require_once("_header.php");
?>

			
				<br>
				<br>
				<h3>Developer Access and Tools</h3>
				<br>
				<br>
				
				All code for the site as well as the scrapers can be found in the GitHub repo <a href="https://github.com/thequbit/mc911feedwatcher">here</a>.<br>
				<br>
				
				For information on how to use the JSON API's, check out the GitHub WiKi <a href="https://github.com/thequbit/mc911feedwatcher/wiki">here</a>.  It includes definitions of the API calls that return JSON objects, as well as example Python code that uses PyGal to render SVG images with the data the API's return.<br>
				<br>
				
				<h4>Example API JSON Objects</h4>
				
				<div class="tab">
					<a href="http://mycodespace.net/projects/mcsafetyfeed/api/counts.php?type=mva">Daily Counts of Motor Vehicle Accodents</a><br>
					<a href="http://mycodespace.net/projects/mcsafetyfeed/api/counts.php?type=barkingdogs">Daily Counts of Backing Dog Complaints</a><br>
					<a href="http://mycodespace.net/projects/mcsafetyfeed/api/counts.php?type=dailycounts">Today's Counts for all Incident Types</a><br>
					<a href="http://mycodespace.net/projects/mcsafetyfeed/api/counts.php?type=alltimesum">All-Time Summation by Incident Type</a><br>
				</div>
				<br>
				
				If you would like additional API's added, please use the contact information found on the <a href="about.php">about</a> page.<br>
				<br>
				
				Note: API access is not currently restricted since the demand is not high.  If the demand increases, there may be API limitations put in place.  If you would like a data drop of the data just contact me and I will be happy to shoot it over to you :D.
				<br>
				<br>
				<br>
				
				<h3>Quick and Dirty example of PyGal Outputs</h3>
				<br>
				<br>
				
				<center>
				
					<iframe src="api/getsvg.php?type=mva" width="800" height="600"></iframe><br>
					<br>
					
					<iframe src="api/getsvg.php?type=barkingdogs" width="800" height="600"></iframe><br>
					<br>
					
					<iframe src="api/getsvg.php?type=alltimesum" width="800" height="600"></iframe><br>
					<br>

				</center>
		
<?php
	require_once("_footer.php");
?>