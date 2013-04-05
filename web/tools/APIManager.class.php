<?php

	require_once("DatabaseManager2.class.php");

	//
	// API Manager Helper Objects
	//

	class Item
	{
		public $date;
		public $count;
	}
	
	class IncidentCount
	{
		public $incidentname;
		public $count;
		public $letter;
	}
	
	//
	// API Manager 
	//
	
	class APIManager
	{
	
		//
		// Dailing counts by incident API function
		//
		function GetCountsByDay($date)
		{
			dprint( "GetCountsByDay() Start." );
			
			try
			{
		
				$db = new DatabaseTool();
			
				// generate our query
				$query = 'select tmp.event as incidentname, count(tmp.zeecount) as count from (select DISTINCT itemid, event, count(incidentid) as zeecount from incidents where pubdate = ? group by itemid order by event) as tmp group by tmp.event';
			
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $date); // bind the varibale
				$results = $db->Execute($stmt);
				
				dprint( "Processing " . count($results) . " Results ..." );
				
				// create an array to put our results into
				$items = array();
				$letter = 'A';
				
				// iterate through the returned rows and decode them into a php class
				foreach( $results as $row )
				{
					$item = new IncidentCount();
			
					// pull the information from the row
					$item->incidentname = $row['incidentname'];
					$item->count = $row['count'];
					$item->letter = $letter;
					
					$letter++;
					
					$items[] = $item;
				}
				
				// close our DB connection
				$db->Close($mysqli, $stmt);
			
			}
			catch (Exception $e)
			{
				dprint( "Caught exception: " . $e->getMessage() );
			}
			
			dprint("GetCountsByDay() Done.");
			
			return $items;
		}
	
		//
		// Specific Incident Types API Functions
		//
	
		function GetMVACounts()
		{
			
			dprint( "GetMVACounts() Start." );
			
			try
			{
		
				$db = new DatabaseTool();
				
				// create the query
				$query = 'select tmp.pubdate as date, count(tmp.zeecount) as count from (select DISTINCT itemid, event, pubdate, count(incidentid) as zeecount from incidents where (lower(event) like "%mva%" or lower(event) like "%vehicle%" or lower(event) like "%hit and run%") group by itemid order by event) as tmp group by pubdate';
				
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
				
				dprint( "Processing " . count($results) . " Results ..." );

				// close our DB connection
				$db->Close($mysqli, $stmt);
			
			}
			catch (Exception $e)
			{
				dprint( "Caught exception: " . $e->getMessage() );
			}
			
			dprint("GetMVACounts() Done.");
			
			return $results;
		}
	
		function GetAllDogCounts()
		{
			dprint( "GetAllDogCounts() Start." );
			
			try
			{
		
				$db = new DatabaseTool();
				
				// create the query
				$query = 'select tmp.pubdate as date, count(tmp.zeecount) as count from (select DISTINCT itemid, pubdate, count(incidentid) as zeecount from incidents where lower(event) = "barking dogs" group by itemid order by pubdate) as tmp group by pubdate;';
				
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
				
				dprint( "Processing " . count($results) . " Results ..." );
				
				// close our DB connection
				$db->Close($mysqli, $stmt);
			
			}
			catch (Exception $e)
			{
				dprint( "Caught exception: " . $e->getMessage() );
			}
			
			dprint("GetAllDogCounts() Done.");
			
			return $results;
		}


		//
		// All-Time summations by day
		//

		function GetAllTimeSum()
		{
			dprint( "GetAllTimeSum() Start." );
			
			try
			{
		
				$db = new DatabaseTool();
				
				// create the query
				$query = 'select tmp.pubdate as date, count(tmp.zeecount) as count from (select DISTINCT itemid, pubdate, count(incidentid) as zeecount from incidents group by itemid order by pubdate) as tmp group by pubdate;';
			
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
				
				dprint( "Processing " . count($results) . " Results ..." );
				
				// close our DB connection
				$db->Close($mysqli, $stmt);
			
			}
			catch (Exception $e)
			{
				dprint( "Caught exception: " . $e->getMessage() );
			}
			
			dprint("GetAllTimeSum() Done.");
			
			return $results;
		}
		
	}

?>