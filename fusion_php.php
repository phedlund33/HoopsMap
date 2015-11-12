<?php
 /*
 *copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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
 $client->setRedirectUri('http://www.hoopsmap.com/fusion_php.php');
 $client->setDeveloperKey('AIzaSyCveDZZx4UNQukYyH_l1ORyx2vXSkZRq4w');
 $service = new Google_FusiontablesService($client);

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
  return;
}
echo "Session is: ".$_SESSION['token'];
if (isset($_SESSION['token'])) {
 echo "token is set";
 $client->setAccessToken($_SESSION['token']);
	
}

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
  $client->revokeToken();
}

if ($client->getAccessToken()) {
  echo "session is set";
// The access token may have been updated lazily.
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
 
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
 <style type="text/css">
      #map_canvas {
        height: 800px;
        width: 100%;
      }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
	var display_data;
	var map;
	var zoom = 8;
	var center = new google.maps.LatLng(38.00, -79.27);
	var num_rows = 10;
	var counter = 0;
	var t;
		
	var geocoder;
	function initialize() {
			geocoder = new google.maps.Geocoder();
			var mapOptions = {
			  zoom: zoom,
			  center: center,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
			
			var query = "SELECT Address, Program, 'Last Name', ROWID FROM 1bdMjQB2XjsdX75bDgPgBeF-PxPYLytfD4Z0CXm0 WHERE Coordinates = ''";
			var encodedQuery = encodeURIComponent(query);

			// Construct the URL
			var url = ['https://www.googleapis.com/fusiontables/v1/query'];
			url.push('?sql=' + encodedQuery);
			url.push('&key=AIzaSyAHmvVu_aQhPJvFJVfP7siInlAblO4lTus');
			url.push('&callback=?');

			// Send the JSONP request using jQuery
			$.ajax({
			  url: url.join(''),
			  dataType: 'jsonp',
			  success: function (data) {
				var rows = data['rows'];
				num_rows = rows.length;
				//for (var i in rows) {
				//for (var i = 0; i < 10; i++) {
				  
					//if(i > 0){ //don't process the first row
				  
						var address = rows[counter][0];
						//var Program = rows[i][1];
						//var Name = rows[i][2];
						
						//var coordinates = geoCode(address);
						//var coordinates = codeAddress(address, Program, Name);
						//var delay = function() { codeAddress(rows[counter][0]); counter++};
						var delay = function() { 
							if(counter < 20){
								codeAddress(rows[counter][0],rows[counter][3]);
								counter++
							}
							else{
								clearInterval(t);
							}
							
						};
						t = setInterval(delay, 2000);
					
					//}
				//}
			  }
			});
      	}
	function codeAddress(address, rowid) {
       		var ftData = document.getElementById('ft-data');
        	geocoder.geocode( { 'address': address}, function(results, status) {
		
          	if (status == google.maps.GeocoderStatus.OK) {
			ftData.innerHTML += String(results[0].geometry.location)+'<br />';
            		map.setCenter(results[0].geometry.location);
            		var marker = new google.maps.Marker({
                		map: map,
                		position: results[0].geometry.location,
				title: String(results[0].geometry.location) + " " + rowid
            		});
	
			updateTable(results[0].geometry.location, rowid);
        
	  	} else {
            		ftData.innerHTML += 'Geocode was not successful for the following reason: ' + status;
          	}
        	});
		//counter ++;
      	}
	function updateTable(coordinates, rowid) {
		  
		//alert(coordinates+", "+ rowid);
		var url = ['process.php'];
		url.push('?rowid=' +rowid);
		url.push('&coordinates=' +coordinates);
		url.push('&callback=?');
		  $.ajax({
                          url: url.join(''),
                          dataType: 'jsonp',
                          success: function (data) {

				alert('success');
			}
		});
		

	}
</script>
</head>
<body onload="initialize()">
<header><h1>Geocode Fusion Table Addresses</h1></header>
<?php
  if(isset($authUrl)) {
    print "<a class='login' href='$authUrl'>Connect Me!</a>";
  } else {
   print "<a href='process.php'>Process</a><br />";
   print "<a class='logout' href='?logout'>Logout</a>";
   print "<br /><a id='myLink' href='javascript:void(0);'>Do it</a>";
  }
?>
	<div id="map_canvas"></div>
	<div id="ft-data"></div>
</body></html>
