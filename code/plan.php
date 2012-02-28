<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

include 'dbparams.php';

$action = $_GET['action'];
$ptid = $_GET['id'];
$height = $_GET['height'];
$weight = $_GET['weight'];
$bmi = $_GET['bmi'];
$thepill = $_GET['thepill'];
$strenuous = $_GET['stren'];
$moderate = $_GET['mod'];
$mild = $_GET['mild'];
$godin = $_GET['godin'];
$sevenday = $_GET['seven'];
$alcohol1 = $_GET['alc1'];
$alcohol2 = $_GET['alc2'];
$alcohol3 = $_GET['alc3'];
$smoke = $_GET['smoke'];


$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to MySQL server');

mysql_select_db($dbname);

if ($action == "exists")
{

	$query = "SELECT * FROM plan WHERE id = " . $ptid;
	
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

		//Add row
		$query = "INSERT INTO plan (id, height, weight, bmi, thepill, strenuous, moderate, mild, godin, sevenday, alcohol1, alcohol2, alcohol3, smoke) VALUES ('" . $ptid . "', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL')";

		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
	}
	else
	{
		//Patient in database, return INFO
		$json['exists'] = "1";
		$json['height'] = mysql_result($result, 0, "height");
		$json['weight'] = mysql_result($result, 0, "weight");
		$json['bmi'] = mysql_result($result, 0, "bmi");
		$json['thepill'] = mysql_result($result, 0, "thepill");
		$json['strenuous'] = mysql_result($result, 0, "strenuous");
		$json['moderate'] = mysql_result($result, 0, "moderate");
		$json['mild'] = mysql_result($result, 0, "mild");
		$json['godin'] = mysql_result($result, 0, "godin");
		$json['sevenday'] = mysql_result($result, 0, "sevenday");
		$json['alc1'] = mysql_result($result, 0, "alcohol1");
		$json['alc2'] = mysql_result($result, 0, "alcohol2");
		$json['alc3'] = mysql_result($result, 0, "alcohol3");
		$json['smoke'] = mysql_result($result, 0, "smoke");
	}

	echo json_encode($json);

}

elseif ($action == "addbmi")
{
	$query = "UPDATE plan SET weight = '" . $weight . "', height = '" . $height . "', bmi = '" . $bmi . "'  WHERE id = " . $ptid;

	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
}

elseif ($action == "addthepill")
{
	$query = "UPDATE plan SET thepill = '" . $thepill . "' WHERE id = " . $ptid;

	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
}

elseif ($action == "addgodin")
{
	$query = "UPDATE plan SET strenuous = '" . $strenuous . "', moderate = '" . $moderate . "', mild = '" . $mild . "', godin = '" . $godin . "', sevenday = '" . $sevenday . "' WHERE id = " . $ptid;

	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
}

elseif ($action == "addalcohol")
{
	echo $alcohol1;

	if ($alcohol1 != NULL)
	{
		$query = "UPDATE plan SET alcohol1 = '" . $alcohol1 . "' WHERE id = " . $ptid;
	}
	elseif ($alcohol2 != NULL)
	{
		$query = "UPDATE plan SET alcohol2 = '" . $alcohol2 . "' WHERE id = " . $ptid;
	}
	elseif ($alcohol3 != NULL)
	{
		$query = "UPDATE plan SET alcohol3 = '" . $alcohol3 . "' WHERE id = " . $ptid;
	}

	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
}

elseif ($action == "addtobacco")
{
	$query = "UPDATE plan SET smoke = '" . $smoke . "' WHERE id = " . $ptid;

	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
}

?>
