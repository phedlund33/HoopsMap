	function getUrlVars()
		{
			var vars = [], hash;
			var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			for(var i = 0; i < hashes.length; i++)
			{
				hash = hashes[i].split('=');
				vars.push(hash[0]);
				vars[hash[0]] = hash[1];
			}
			return vars;
		}
	function getLatLng(coord)
	{
		var coordinates = coord.split(",");
        var lat = parseFloat(coordinates[0]);
        var lon = parseFloat(coordinates[1]);
        var myLatLng = new google.maps.LatLng(lat,lon);
		
		return myLatLng;
		
	  }
	  function getLatLng2(lat, lon)
	{
		
        var lat = parseFloat(lat);
        var lon = parseFloat(lon);
        var myLatLng = new google.maps.LatLng(lat,lon);
		
		return myLatLng;
		
	  }
	    function loadFTdata(query, function_name)
	   {
			
	        var encodedQuery = encodeURIComponent(query);
			 //var encodedQuery = query;
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
          	
          	function_name(data);
       
          }
        });
	   }
	  
	  //hooops maps style stuff:
	  	
	    var style = [
        {
          featureType: 'all',
          elementType: 'all',
          stylers: [
            { saturation: -50 }
          ]
        },
		{
			featureType: "landscape",
   			 elementType: "geometry.fill",
			stylers: [
			  { hue: "#ff9900" },
			  { saturation: -47 }
			]
		  },
        {
          featureType: 'poi',
          elementType: 'all',
          stylers: [
            { visibility: 'off' }
          ]
        },
        {
          featureType: 'transit',
          elementType: 'all',
          stylers: [
            { visibility: 'off' }
          ]
        }
      ];
      