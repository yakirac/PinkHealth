<?php
//require("twitteroauth/twitteroauth.php");

include 'EpiCurl.php';
include 'EpiOAuth.php';
include 'EpiTwitter.php';
include 'secret.php';
//session_start();

$oauth_token = $_GET['otoken'];
$oauth_token_secret = $_GET['otokensecret'];

$name["sname"] = $oauth_token;
$name["tname"] = $oauth_token_secret;
echo json_encode($name);

/*$twitteroauth = new TwitterOAuth('FyHyViIKUNx3df24P9Zisw', 'lWGGJJYLOS9eg4Xcv9jPUXt7MNnh03XRXmnDJ1mi2w', $oauth_token, $oauth_token_secret);

$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);

$user_info = $twitteroauth->get('account/verify_credentials');
$sn = $user_info->screen_name;

$name["mname"] = "this is the name of the user: " .$sn;

echo json_encode($name);*/

$Twitter = new EpiTwitter($consumerKey, $consumerSecret);
$Twitter->setToken($oauth_token,$oauth_token_secret);
//$message Status update
$message = "still working with twitter";
$status=$Twitter->post_statusesUpdate(array('status' => $message));
$status->response;


?>
