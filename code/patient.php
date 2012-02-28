<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'dbparams.php';

$action = $_GET['action'];
$ptname = $_GET['name'];
$ptid = $_GET['id'];

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to MySQL server');

mysql_select_db($dbname);

if ($action == "start")
{

	$query = "SELECT * FROM patient WHERE id = " . $ptid;
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}

	$num = mysql_num_rows($result);

	if ($num == 0)
	{
		//Patient not in database, add him/her
		$query = "INSERT INTO patient (id, ptname) VALUES ('" . $ptid . "', '" . $ptname . "')";

		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}

		$json['start'] = "1";

	}
	else
	{
		//Patient in database, return OK
		$json['start'] = "0";
	}

	echo json_encode($json);

	/*for($i=0; $i<$num; $i++)
	{
		$json["id"] = mysql_result($result, $i, "id");
		$json["creator"] = mysql_result($result, $i, "creator");
		$json["creatorname"] = mysql_result($result, $i, "creatorname");
		$json["timestamp"] = mysql_result($result, $i, "timestamp");
		$json["location"] = mysql_result($result, $i, "location");
		$json["latitude"] = mysql_result($result, $i, "latitude");
		$json["longitude"] = mysql_result($result, $i, "longitude");
		$json["details"] = mysql_result($result, $i, "details");

		$buzzes[] = $json;

	}

	$json2['buzzes'] = $buzzes;

	//echo $json;
	echo json_encode($json2);*/

}


?>
