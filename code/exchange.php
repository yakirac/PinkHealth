<?php
require_once('twitteroauth/twitteroauth.php');
echo "This is exchange.php";

$oauth_bridge_code = $_GET['bridge_code'];
echo $oauth_bridge_code;

$connection = new TwitterOAuth('FyHyViIKUNx3df24P9Zisw', 'lWGGJJYLOS9eg4Xcv9jPUXt7MNnh03XRXmnDJ1mi2w');

$url = 'https://api.twitter.com/oauth/access_token';
$request = $connection->oAuthRequest($url, 'POST', array('oauth_bridge_code' => $oauth_bridge_code));

if ($connection->http_code == 200){
  //echo json_encode(array('token' => OAuthUtil::parse_parameters($request)));
  $message["success"] = $oauth_bridge_code;
  echo json_encode($message);
  
}
else {
  $message["success"] = "It was not a success";
  echo json_encode($message);
}
?>