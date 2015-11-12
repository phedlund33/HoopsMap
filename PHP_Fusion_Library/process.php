<?php
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';
require_once 'src/contrib/Google_FusiontablesService.php';
session_start();
$client = new Google_Client();
$client->setApplicationName("EV Fusion Table Map");
// Visit https://code.google.com/apis/console?api=plus to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
 $client->setClientId('23261132086-u9usua8sbbda3c93dv560a895ik9mtkp.apps.googleusercontent.com');
 $client->setClientSecret('zNLyYRB6SfMSDow_R49h9QNF');
 $client->setRedirectUri('http://web3.encyclopediavirginia.org/vfh_map/google-api-php-client/');
 $client->setDeveloperKey('AIzaSyAHmvVu_aQhPJvFJVfP7siInlAblO4lTus');
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
