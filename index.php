<?php
require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google\Client();
$client->setAuthConfig('client_secrets.json');
$client->addScope(Google\Service\Fitness::FITNESS_ACTIVITY_READ);
//$client->setRedirectUri('http://' . $_SERVER['localhost/demofit'] . '/oauth2callback.php');
//$client->setAccessType('offline');        // offline access
//$client->setIncludeGrantedScopes(true);   // incremental auth
//echo "hello";
//it;

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
/*
    if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.

                $redirect_uri = "http://localhost/demofit/oauth2callback.php";
                 header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL)); 
            //    $authUrl = $client->createAuthUrl();
             ///   printf("Open the following link in your browser:\n%s\n", $authUrl);
              //  print 'Enter verification code: ';
             //   $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
               // $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
           
        }

        */

       $client->setAccessToken($_SESSION['access_token']);
      $service = new Google\Service\Fitness($client);

      echo "GOT IT";
      echo "<pre>";

        // Same code as yours
      $dataSources = $service->users_dataSources;
      $dataSets = $service->users_dataSources_datasets;

      $listDataSources = $dataSources->listUsersDataSources("me");

      $timezone = "GMT+0530";
      $today = date("Y-m-d");

      $endTime = strtotime("now");
      $startTime = strtotime($today.' 00:00:00 '.$timezone);

      //$endTime = strtotime($today.' 00:00:00 '.$timezone);
      //$startTime = strtotime('-1 day', $endTime);

      while($listDataSources->valid()) {
            $dataSourceItem = $listDataSources->next();
            if ($dataSourceItem['dataType']['name'] == "com.google.step_count.delta") {
                $dataStreamId = $dataSourceItem['dataStreamId'];
                $listDatasets = $dataSets->get("me", $dataStreamId, $startTime.'000000000'.'-'.$endTime.'000000000');

                $step_count = 0;
                while($listDatasets->valid()) {
                    $dataSet = $listDatasets->next();
                    $dataSetValues = $dataSet['value'];

                    if ($dataSetValues && is_array($dataSetValues)) {
                        foreach($dataSetValues as $dataSetValue) {
                            $step_count += $dataSetValue['intVal'];
                        }
                    }
                }
                print("STEP: ".$step_count."<br />");
            };
        }

        echo "</pre>";

        //$_SESSION['logout'];
       // if (isset($_REQUEST['logout'])) {
         // unset($_SESSION['access_token']);

      //add api access for google fit.

      //$files = $drive->files->listFiles(array())->getItems();
     // echo json_encode($files);
} else {
  echo "i am else";
  //it;
  //$redirect_uri = 'http://' . $_SERVER['localhost/demofit'] . '/oauth2callback.php';
  $redirect_uri = "http://localhost/demofit/oauth2callback.php";
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

