<?php
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';
require_once 'src/contrib/Google_FusiontablesService.php';
session_start();
$client = new Google_Client();
$client->setApplicationName("HoopsMap");
// Visit https://code.google.com/apis/console?api=plus to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
 $client->setClientId('353095432463.apps.googleusercontent.com');
 $client->setClientSecret('rr7bRMVYg_kso5-hloK9ptZs');
 $client->setRedirectUri('http://www.hoopsmap.com/oauth2callback');
 $client->setDeveloperKey('AIzaSyCveDZZx4UNQukYyH_l1ORyx2vXSkZRq4w');
 $service = new Google_FusiontablesService($client);

if (isset($_SESSION['token'])) {

 //echo "token is set";
 $client->setAccessToken($_SESSION['token']);

}else{
 //echo "token is not set";
}

$coordinates = $_GET['coordinates'];
$rowid = $_GET['rowid'];
if ($client->getAccessToken()) {

	$updateQuery = "UPDATE 1bdMjQB2XjsdX75bDgPgBeF-PxPYLytfD4Z0CXm0 SET Coordinates ='".$coordinates."' WHERE ROWID ='".$rowid."'";
	//$updateQuery = "UPDATE 15AJLOfA4RXs1-TQhDx3RR5ENBUEAdEE220mMEXM SET Coordinates = '3333,2222' WHERE ROWID ='801'";
        try{
                $service->query->sql($updateQuery);
        }catch(Exception $e){
                echo print_r($e);
        }

}

?>
