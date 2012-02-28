<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

include 'dbparams.php';

$action = $_GET['action'];
$ptid = $_GET['id'];
$height = $_GET['height'];
$weight = $_GET['weight'];
$bmi = $_GET['bmi'];
$calories = $_GET['calories'];
$drinks = $_GET['drinks'];
$minutes = $_GET['minutes'];
$intensity = $_GET['intensity'];
$strenuous = $_GET['stren'];
$moderate = $_GET['mod'];
$mild = $_GET['mild'];
$godin = $_GET['godin'];
$sevenday = $_GET['seven'];


$thepill = $_GET['thepill'];
$alcohol1 = $_GET['alc1'];
$alcohol2 = $_GET['alc2'];
$alcohol3 = $_GET['alc3'];
$smoke = $_GET['smoke'];


$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to MySQL server');

mysql_select_db($dbname);

if ($action == "start")
{
	$query = "SELECT height, weight, bmi FROM plan WHERE id = " . $ptid;
	
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
		$json['height'] = mysql_result($result, 0, "height");
		$json['weight'] = mysql_result($result, 0, "weight");
		$json['bmi'] = mysql_result($result, 0, "bmi");
	}
	
	echo json_encode($json);
}
elseif ($action == "addweight")
{
	$date = date("Y\-m\-d");

	$query = "SELECT progressweight.index FROM progressweight WHERE id = " . $ptid . " AND progressweight.date = '" . $date . "'";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//Today is not in the database, add it!
		
		$query = "INSERT INTO progressweight ( id, weight, bmi, progressweight.date) VALUES ('" . $ptid . "', '" . $weight . "', '" . $bmi . "', '" . $date . "')";
		
		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
		
	}
	else
	{
		//Today is in the database, update it!
		
		$query = "UPDATE progressweight SET weight = '" . $weight . "', bmi = '" . $bmi . "' WHERE id = " . $ptid . " AND progressweight.date = '" . $date . "'";
	
		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
	}
}
elseif ($action == "getweight")
{
	$query = "SELECT weight, progressweight.date FROM progressweight WHERE id = " . $ptid . " ORDER BY progressweight.date ASC";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		for ($i = 0; $i < $num; $i++)
		{
			$json2['weight'] = mysql_result($result, $i, "weight");
			//$json2['bmi'] = mysql_result($result, $i, "bmi");
			$json2['date'] = mysql_result($result, $i, "progressweight.date");
			
			$details[] = $json2;
		}
		
		$json['details'] = $details;
	}
	
	$query = "SELECT height FROM plan WHERE id = " .$ptid;
		
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
		
	if ($num > 0)
	{
		$json['height'] = mysql_result($result, 0, "height");
	}
	
	echo json_encode($json);
} //getweight

elseif ($action == "getbmi")
{
	$query = "SELECT bmi, progressweight.date FROM progressweight WHERE id = " . $ptid . " ORDER BY progressweight.date ASC";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		for ($i = 0; $i < $num; $i++)
		{
			$json2['bmi'] = mysql_result($result, $i, "bmi");
			$json2['date'] = mysql_result($result, $i, "progressweight.date");
			
			$details[] = $json2;
		}
		
		$json['details'] = $details;
	}
	
	echo json_encode($json);
} //getbmi

elseif ($action == "getweighttoday")
{
	$date = date("Y\-m\-d");
	
	$query = "SELECT weight, bmi, progressweight.date FROM progressweight WHERE id = " . $ptid . " AND progressweight.date = '" . $date . "'";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		$json2['weight'] = mysql_result($result, 0, "weight");
		$json2['bmi'] = mysql_result($result, 0, "bmi");
		$json2['date'] = mysql_result($result, 0, "progressweight.date");
		
		$details[] = $json2;
		
		
		$json['details'] = $details;
	}
	
	$query = "SELECT height FROM plan WHERE id = " .$ptid;
		
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
		
	if ($num > 0)
	{
		$json['height'] = mysql_result($result, 0, "height");
	}
	
	
	echo json_encode($json);
} //getweighttoday
elseif ($action == "addcalconsumed")
{
	$date = date("Y\-m\-d");

	$query = "SELECT progresscalconsumed.index FROM progresscalconsumed WHERE id = " . $ptid . " AND progresscalconsumed.date = '" . $date . "'";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//Today is not in the database, add it!
		
		$query = "INSERT INTO progresscalconsumed ( id, calories, progresscalconsumed.date) VALUES ('" . $ptid . "', '" . $calories . "', '" . $date . "')";
		
		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
		
	}
	else
	{
		//Today is in the database, update it!
		
		$query = "UPDATE progresscalconsumed SET calories = '" . $calories . "' WHERE id = " . $ptid . " AND progresscalconsumed.date = '" . $date . "'";
	
		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
	}
}
elseif ($action == "getcalconsumed")
{
	$query = "SELECT calories, progresscalconsumed.date FROM progresscalconsumed WHERE id = " . $ptid . " ORDER BY progresscalconsumed.date ASC";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		for ($i = 0; $i < $num; $i++)
		{
			$json2['calories'] = mysql_result($result, $i, "calories");
			$json2['date'] = mysql_result($result, $i, "progresscalconsumed.date");
			
			$details[] = $json2;
		}
		
		$json['details'] = $details;
	}
	
	echo json_encode($json);
} //getcalconsumed

elseif ($action == "getcalconsumedtoday")
{
	$date = date("Y\-m\-d");

	$query = "SELECT calories, progresscalconsumed.date FROM progresscalconsumed WHERE id = " . $ptid . " AND progresscalconsumed.date = '" . $date . "'";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		$json2['calories'] = mysql_result($result, 0, "calories");
		$json2['date'] = mysql_result($result, 0, "progresscalconsumed.date");
		
		$details[] = $json2;
		
		$json['details'] = $details;
	}
	
	echo json_encode($json);
} //getcalconsumedtoday

elseif ($action == "addalcohol")
{
	$date = date("Y\-m\-d");

	$query = "SELECT progressalcohol.index FROM progressalcohol WHERE id = " . $ptid . " AND progressalcohol.date = '" . $date . "'";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//Today is not in the database, add it!
		
		$query = "INSERT INTO progressalcohol ( id, drinks, progressalcohol.date) VALUES ('" . $ptid . "', '" . $drinks . "', '" . $date . "')";
		
		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
		
	}
	else
	{
		//Today is in the database, update it!
		
		$query = "UPDATE progressalcohol SET drinks = '" . $drinks . "' WHERE id = " . $ptid . " AND progressalcohol.date = '" . $date . "'";
	
		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
	}
}// addalcohol

elseif ($action == "getalcohol")
{
	$query = "SELECT drinks, progressalcohol.date FROM progressalcohol WHERE id = " . $ptid . " ORDER BY progressalcohol.date ASC";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		for ($i = 0; $i < $num; $i++)
		{
			$json2['drinks'] = mysql_result($result, $i, "drinks");
			$json2['date'] = mysql_result($result, $i, "progressalcohol.date");
			
			$details[] = $json2;
		}
		
		$json['details'] = $details;
	}
	
	echo json_encode($json);
} //getalcohol

elseif ($action == "getalcoholtoday")
{
	$date = date("Y\-m\-d");
	
	$query = "SELECT drinks, progressalcohol.date FROM progressalcohol WHERE id = " . $ptid . " AND progressalcohol.date = '" . $date . "'";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		for ($i = 0; $i < $num; $i++)
		{
			$json2['drinks'] = mysql_result($result, $i, "drinks");
			$json2['date'] = mysql_result($result, $i, "progressalcohol.date");
			
			$details[] = $json2;
		}
		
		$json['details'] = $details;
	}
	
	echo json_encode($json);
}

elseif ($action == "addexmin")
{
	$date = date("Y\-m\-d");

	$query = "SELECT progressexminutes.index FROM progressexminutes WHERE id = " . $ptid . " AND progressexminutes.date = '" . $date . "'";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//Today is not in the database, add it!
		
		$query = "INSERT INTO progressexminutes ( id, minutes, intensity, progressexminutes.date) VALUES ('" . $ptid . "', '" . $minutes . "', '" . $intensity . "', '" . $date . "')";
		
		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
		
	}
	else
	{
		//Today is in the database, update it!
		
		$query = "UPDATE progressexminutes SET minutes = '" . $minutes . "', intensity = '" . $intensity . "' WHERE id = " . $ptid . " AND progressexminutes.date = '" . $date . "'";
	
		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
	}
}// addexmin

elseif ($action == "getexmin")
{
	$query = "SELECT minutes, intensity, progressexminutes.date FROM progressexminutes WHERE id = " . $ptid . " ORDER BY progressexminutes.date ASC";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		for ($i = 0; $i < $num; $i++)
		{
			$json2['minutes'] = mysql_result($result, $i, "minutes");
			$json2['intensity'] = mysql_result($result, $i, "intensity");
			$json2['date'] = mysql_result($result, $i, "progressexminutes.date");
			
			$details[] = $json2;
		}
		
		$json['details'] = $details;
	}
	
	echo json_encode($json);
} //getexmin

elseif ($action == "getexmintoday")
{
	$date = date("Y\-m\-d");

	$query = "SELECT minutes, intensity, progressexminutes.date FROM progressexminutes WHERE id = " . $ptid . " AND progressexminutes.date = '" . $date . "'";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		$json2['minutes'] = mysql_result($result, 0, "minutes");
		$json2['intensity'] = mysql_result($result, 0, "intensity");
		$json2['date'] = mysql_result($result, 0, "progressexminutes.date");
		
		$details[] = $json2;
		
		$json['details'] = $details;
	}
	
	echo json_encode($json);
} //getexmintoday

elseif ($action == "addcalburned")
{
	$date = date("Y\-m\-d");

	$query = "SELECT progresscalburned.index FROM progresscalburned WHERE id = " . $ptid . " AND progresscalburned.date = '" . $date . "'";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//Today is not in the database, add it!
		
		$query = "INSERT INTO progresscalburned ( id, calories, progresscalburned.date) VALUES ('" . $ptid . "', '" . $calories . "', '" . $date . "')";
		
		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
		
	}
	else
	{
		//Today is in the database, update it!
		
		$query = "UPDATE progresscalburned SET calories = '" . $calories . "' WHERE id = " . $ptid . " AND progresscalburned.date = '" . $date . "'";
	
		$result = mysql_query($query);
		if(!$result)
		{
			die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		}
	}
}// addcalburned

elseif ($action == "getcalburned")
{
	$query = "SELECT calories, progresscalburned.date FROM progresscalburned WHERE id = " . $ptid . " ORDER BY progresscalburned.date ASC";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		for ($i = 0; $i < $num; $i++)
		{
			$json2['calories'] = mysql_result($result, $i, "calories");
			$json2['date'] = mysql_result($result, $i, "progresscalburned.date");
			
			$details[] = $json2;
		}
		
		$json['details'] = $details;
	}
	
	echo json_encode($json);
} //getcalburned

elseif ($action == "getcalburnedtoday")
{
	$date = date("Y\-m\-d");

	$query = "SELECT calories, progresscalburned.date FROM progresscalburned WHERE id = " . $ptid . " AND progresscalburned.date = '" . $date . "'";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		$json2['calories'] = mysql_result($result, 0, "calories");
		$json2['date'] = mysql_result($result, 0, "progresscalburned.date");
		
		$details[] = $json2;
		
		$json['details'] = $details;
	}
	
	echo json_encode($json);
} //getcalburnedtoday

elseif ($action == "getgodin")
{
	$query = "SELECT strenuous, moderate, mild, godin, sevenday FROM plan WHERE id = " . $ptid;
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;

		$json2['strenuous'] = mysql_result($result, 0, "strenuous");
		$json2['moderate'] = mysql_result($result, 0, "moderate");
		$json2['mild'] = mysql_result($result, 0, "mild");
		$json2['godin'] = mysql_result($result, 0, "godin");
		$json2['sevenday'] = mysql_result($result, 0, "sevenday");
			
	}
	
	$query = "SELECT intensity, progressexminutes.date FROM progressexminutes WHERE id = " . $ptid . " ORDER BY progressexminutes.date DESC LIMIT 0, 7";

	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num > 6)
	{
		$json['current'] = 1;
		
		for ($i = 0; $i < 7; $i++)
		{
			$json3['intensity'] = mysql_result($result, $i, "intensity");
			
					
			$json4[] = $json3;
		}
		
	}
	else
	{
		//Not 7 results in table yet
		$json['current'] = 0;
	}
	
	$details[] = $json2;

	$json['details'] = $details;
	$json['intensity'] = $json4;
	
	echo json_encode($json);
} //getgodin

elseif ($action == "getalc")
{
	$query = "SELECT alcohol1, alcohol2, alcohol3 FROM plan WHERE id = " . $ptid;
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['exists'] = 0;
	}
	else
	{
		$json['exists'] = 1;
		
		$json2['alc1'] = mysql_result($result, 0, "alcohol1");
		$json2['alc2'] = mysql_result($result, 0, "alcohol2");
		$json2['alc3'] = mysql_result($result, 0, "alcohol3");
		
		$details[] = $json2;
		
		$json['details'] = $details;
	}
	
	$query = "SELECT SUM(drinks) FROM progressalcohol WHERE YEAR( date ) = YEAR( CURDATE( ) ) AND MONTH( date ) = MONTH( CURDATE( ) )";
	
	$result = mysql_query($query);
	if(!$result)
	{
		die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
	}
	
	$num = mysql_num_rows($result);
	
	if ($num == 0)
	{
		//No results in table yet
		$json['current'] = 0;
	}
	/*else
	{
		$json['current'] = 1;
		
		$alc1 = mysql_result($result, 0, "alcohol1");
		$alc2 = mysql_result($result, 0
		
		
		$cur_details[] = $json3;
		
		$json['cur_details'] = $cur_details;
	}*/
	
	
	echo json_encode($json);
}

?>