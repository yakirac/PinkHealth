<?php

include 'dbparams.php';

$ptid = $_GET['id'];

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to MySQL server');

mysql_select_db($dbname);


        $date = date("Y\-m\-d");

	$query = "SELECT calories, date FROM progresscalburned WHERE id='$ptid' AND date='2011-05-29'";
	
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
		$bcalories = 0;
		for ($i = 0; $i < $num; $i++)
		{
			$calories = mysql_result($result, $i, "calories");
			//echo "calories: ".$calories;
			if($calories > $bcalories){
			  $bcalories = $calories;
			  //echo "bcalories: ".$bcalories;
			}
			
		}
		//echo "out bcalories: ".$bcalories;
		if($bcalories >= 100 && $bcalories < 200){
		  $bquery = "SELECT * FROM badges WHERE badge_name='100calories'";
		  $bresult = mysql_query($bquery);
		  if(!$result)
		  {
		    die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		  }
		  $brow = mysql_fetch_array($bresult);
		   $cal = $brow['badge_text'];
		   $url = $brow['badge_image_url'];
		  $json['badge'] = $cal;
		  $json['burl'] = $url;
		}
		if($bcalories >= 200 && $bcalories <300){
		  $bquery = "SELECT badge_text, badge_image_url FROM badges WHERE badge_name='200calories'";
		  $bresult = mysql_query($bquery);
		  if(!$result)
		  {
		    die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		  }
		    $brow = mysql_fetch_array($bresult);
		   $cal = $brow['badge_text'];
		   $url = $brow['badge_image_url'];
		  $json['badge'] = $cal;
		  $json['burl'] = $url;
		}
		if($bcalories >= 300 && $bcalories < 400){
		  $bquery = "SELECT badge_text, badge_image_url FROM badges WHERE badge_name='300calories'";
		  $bresult = mysql_query($bquery);
		  if(!$result)
		  {
		    die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		  }
		    $brow = mysql_fetch_array($bresult);
		   $cal = $brow['badge_text'];
		   $url = $brow['badge_image_url'];
		  $json['badge'] = $cal;
		  $json['burl'] = $url;
		}
		if($bcalories >= 400 && $bcalories < 500){
		  //echo "It's 400 and up";
		  $bquery = "SELECT badge_text, badge_image_url FROM badges WHERE badge_name='400calories'";
		  $bresult = mysql_query($bquery);
		  if(!$result)
		  {
		    die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		  }
		   $brow = mysql_fetch_array($bresult);
		   $cal = $brow['badge_text'];
		   $url = $brow['badge_image_url'];
		  $json['badge'] = $cal;
		  $json['burl'] = $url;
		}
		if($bcalories >= 500){
		  $bquery = "SELECT badge_text, badge_image_url FROM badges WHERE badge_name='500calories'";
		  $bresult = mysql_query($bquery);
		  if(!$result)
		  {
		    die("Invalid query: " . mysql_error() . "<br/>Query: " . $query);
		  }
		    $brow = mysql_fetch_array($bresult);
		   $cal = $brow['badge_text'];
		   $url = $brow['badge_image_url'];
		  $json['badge'] = $cal;
		  $json['burl'] = $url;
		}
		
	}
			
        echo json_encode($json);

?>