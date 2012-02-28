<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

include 'dbparams.php';

$action = $_GET['action'];
$ptid = $_GET['id'];
$age = $_GET['age'];
$menage = $_GET['menage'];
$firstbirth = $_GET['fb'];
$firstrel = $_GET['fr'];
$biopsy = $_GET['biopsy'];
$numbiopsy = $_GET['numbiopsy'];
$hyperplasia = $_GET['h'];
$race = $_GET['race'];
$fiverisk = $_GET['five'];
$fiveavg = $_GET['fiveavg'];
$lifetimerisk = $_GET['life'];
$lifeavg = $_GET['lifeavg'];

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to MySQL server');

mysql_select_db($dbname);

if ($action == "exists")
{

	$query = "SELECT * FROM rat WHERE id = " . $ptid;
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}

	$num = mysql_num_rows($result);

	if ($num == 0)
	{
		//Patient not in database
		$json['exists'] = "0";

	}
	else
	{
		//Patient in database, return INFO
		$json['exists'] = "1";
		$json['age'] = mysql_result($result, 0, "age");
		$json['menage'] = mysql_result($result, 0, "menage");
		$json['birthage'] = mysql_result($result, 0, "birthage");
		$json['firstrels'] = mysql_result($result, 0, "firstrels");
		$json['biopsy'] = mysql_result($result, 0, "biopsy");
		$json['numbiopsy'] = mysql_result($result, 0, "numbiopsy");
		$json['hyperplasia'] = mysql_result($result, 0, "hyperplasia");
		$json['race'] = mysql_result($result, 0, "race");
		$json['fiverisk'] = mysql_result($result, 0, "fiverisk");
		$json['fiveavg'] = mysql_result($result, 0, "fiveavg");
		$json['lifetimerisk'] = mysql_result($result, 0, "lifetimerisk");
		$json['lifeavg'] = mysql_result($result, 0, "lifeavg");
	}

	echo json_encode($json);

}

elseif ($action == "addrisk")
{
	//Drop risk if already added
	$query = "SELECT id FROM rat WHERE id = " . $ptid;

	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}

	$num = mysql_num_rows($result);

	if ($num > 0)
	{
		$query2 = "DELETE FROM rat WHERE id = " . $ptid;

		$result2 = mysql_query($query2);
		if(!$result2)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query2);
		}
	}


	//Add patient to database
	$query = "INSERT INTO rat (id, age, menage, birthage, firstrels, biopsy, numbiopsy, hyperplasia, race, fiverisk, fiveavg, lifetimerisk, lifeavg) VALUES ('" . $ptid . "', '" . $age . "', '" . $menage . "', '" . $firstbirth . "', '" . $firstrel . "', '" . $biopsy . "', '" . $numbiopsy . "', '" . $hyperplasia . "', '" . $race . "', '" . $fiverisk . "', '" . $fiveavg . "', '" . $lifetimerisk . "', '" . $lifeavg . "')";

	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}

}

?>
