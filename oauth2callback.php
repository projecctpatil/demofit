<?php
require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google\Client();
$client->setAuthConfigFile('client_secrets.json');
//$client->setRedirectUri('http://' . $_SERVER['localhost/demofit'] . '/oauth2callback.php');
$client->setRedirectUri('http://localhost/demofit/oauth2callback.php');
$client->addScope(Google\Service\Fitness::FITNESS_ACTIVITY_READ);
$client->setAccessType('offline');
$client->setPrompt('consent');

//echo " I am ini oauth2callback";
//exit;

if (! isset($_GET['code'])) {
 // echo " I am in if statement";
  $auth_url = $client->createAuthUrl();
  echo $auth_url;
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  echo "i am in else";
 // exit;
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
 // $_SESSION['refresh_token'] - $client->getRefresh
  $redirect_uri= 'http://localhost/demofit';
  //$redirect_uri = 'http://' . $_SERVER['localhost/demofit'] . '/';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}