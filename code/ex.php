<?php

require("twitteroauth/twitteroauth.php");
session_start();

$oauth_bridge_code = $_GET['code'];

// The TwitterOAuth instance  
$twitteroauth = new TwitterOAuth('FyHyViIKUNx3df24P9Zisw', 'lWGGJJYLOS9eg4Xcv9jPUXt7MNnh03XRXmnDJ1mi2w');
// Requesting authentication tokens, the parameter is the URL we will be redirected to  
$request_token = $twitteroauth->getRequestToken('https://api.twitter.com/oauth/request_token');
//$request = $twitteroauth->oAuthRequest('https://api.twitter.com/oauth/access_token', 'POST', array('oauth_bridge_code' => $oauth_bridge_code));

  
// Saving them into the session  
$_SESSION['oauth_token'] = $request_token['oauth_token'];  
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];  
  
// If everything goes well..  
if($twitteroauth->http_code==200){  
    // Let's generate the URL and redirect  
    //$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']); 
    //header('Location: '. $url);
  //$twitteroauth2 = new TwitterOAuth('FyHyViIKUNx3df24P9Zisw', 'lWGGJJYLOS9eg4Xcv9jPUXt7MNnh03XRXmnDJ1mi2w', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);  
  // Let's request the access token  
  //$access_token = $twitteroauth2->getAccessToken($_GET['oauth_verifier']);
  
  //$user_info = $twitteroauth2->get('account/verify_credentials'); 
  //$name = $user_info->screen_name;
  $message["success"] = "This was a success ok".$_SESSION['oauth_token'];
  $message["otoken"] = $_SESSION['oauth_token'];
  $message["otokens"] = $_SESSION['oauth_token_secret'];
  echo json_encode($message);

} else { 
    // It's a bad idea to kill the script, but we've got to know when there's an error.
    $message["success"] = "This was not a success";
    echo json_encode($message);
    die('Something wrong happened.');  
}

?>