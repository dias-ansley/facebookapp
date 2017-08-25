<?php
error_reporting(0);
if(!session_id()){
	session_start();
}

if(!userAuth($_SESSION['userData'])){
  
    destroySession();
    
}


// Include the autoloader provided in the SDK
require_once __DIR__ . '/facebook-php-sdk/autoload.php';

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/*
 * Configuration and setup Facebook SDK
 */
$appId 			= '113170559354149'; //Facebook App ID
$appSecret 		= 'fb6427abaa63dfbaa8122741d8438132'; //Facebook App Secret
$redirectURL 	= 'http://localhost/fbphpapp/index.php'; //Callback URL
$fbPermissions 	= array('email');  //Optional permissions

$fb = new Facebook(array(
	'app_id' => $appId,
	'app_secret' => $appSecret,
	'default_graph_version' => 'v2.2',
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

// Try to get access token
try {
	if(isset($_SESSION['facebook_access_token'])){
		$accessToken = $_SESSION['facebook_access_token'];
	}else{
  		$accessToken = $helper->getAccessToken();
	}
} catch(FacebookResponseException $e) {
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
}



?>