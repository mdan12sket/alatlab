<?php

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('323877569433-5dsebhqgmof2snk3pgccjaih1sd6c1h0.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://localhost/alatlab/login.php');

//
$google_client->addScope('email');

$google_client->addScope('profile');

//start session on web page
session_start();

?>