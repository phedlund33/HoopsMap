<?php
/**
 * Instagram PHP API example usage.
 * This is the entry point of your application, it will detect whether
 * the user is already authenticated and will present her the login
 * window in case she is not.
 * 
 * If the authentication token is already stored (as a cookie in this case),
 * the user will be redirected to callback.php which is basically the same
 * URI callback that you must set up with Instagram as the return address
 * for your application on their developers section:
 * http://instagr.am/developer/
 * 
 * 
 * If you have any question, check http://mauriciocuenca.com/ for the
 * latest updates
**/
require_once 'Instagram.php';

/**
 * Configuration params, make sure to write exactly the ones
 * instagram provide you at http://instagr.am/developer/
 */
$config = array(
        'client_id' => 'e1d602f8517645749de38593dbf9ad25', // Your client id
        'client_secret' => '63dbfae2a6444956802e269384fc05cc', // Your client secret
        'grant_type' => 'authorization_code',
        'redirect_uri' => 'http://www.HoopsMap.com/instagram/', // The redirect URI you provided when signed up for the service
     );

/**
 * This is how a wrong response looks like
 * array(1) { ["InstagramOAuthToken"]=> string(89) "{"code": 400, "error_type": "OAuthException", "error_message": "No matching code found."}" }
 */
session_start();
/**
if (isset($_SESSION['InstagramAccessToken']) && !empty($_SESSION['InstagramAccessToken'])) {
    header('Location: index.php');
    die();
}
**/
// Instantiate the API handler object
$instagram = new Instagram($config);
$instagram->openAuthorizationUrl();
?>

