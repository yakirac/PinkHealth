<?php

include 'dbparams.php'; 

require("twitteroauth.php");
session_start();

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to MySQL server');
mysql_select_db($dbname);

if(!empty($_SESSION['username'])){ 
     // User is logged in, redirect   
     //echo "Session is still alive";
  echo "Hello, " . '@' . $_SESSION['username'];


  //$twitteroauth = new TwitterOAuth('FyHyViIKUNx3df24P9Zisw', 'lWGGJJYLOS9eg4Xcv9jPUXt7MNnh03XRXmnDJ1mi2w', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);


}

$twitteroauth = new TwitterOAuth('FyHyViIKUNx3df24P9Zisw', 'lWGGJJYLOS9eg4Xcv9jPUXt7MNnh03XRXmnDJ1mi2w', $_SESSION['oauth_token'], $_SESSION['oauth_secret']);

$home_timeline = $twitteroauth->get('statuses/home_timeline');  
echo $home_timeline;

//$twitteroauth->post('statuses/update', array('status' => 'Hello Nettuts+'));

//echo "This is twitter_update.php";
?>