 <style type="text/css">
   html,
body {
  height: 100%;
}

#map {
  height: 100%;
  width: 100%;
}

 </style>
 <body>

    <div id="map"></div>


 <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVv7Om1gEOD3UulCT3lVbwWl55nqGupoY&libraries=places">
  </script>
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
  <script type="text/javascript">
initMap();
// connectToPusher();
// getLocation();

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 17,
    center: new google.maps.LatLng(14.427583, 121.022489),
    
  });
  marker = new google.maps.Marker({
    map: map,
  });

  var triangleCoords = [
          {
           lng : 121.022489,
           lat : 14.427583
          },
          {
           lng : 121.0224927,
           lat : 14.4273513
          },
          {
           lng : 121.0226773,
          lat : 14.4251722
          },
          {
           lng : 121.0227185,
           lat : 14.4242252
          },
          {
           lng : 121.0226157,
           lat : 14.4235279
          },
          {
           lng : 121.0226451,
           lat : 14.4234734
          },
          {
           lng : 121.0238684,
           lat : 14.4235981
          },
          {
           lng : 121.0240751,
           lat : 14.4235514
          },
          {
           lng : 121.0241639,
           lat : 14.4234619
          },
          {
           lng : 121.0247269,
           lat : 14.4233173
          },
          {
           lng : 121.0255457,
           lat : 14.4231173
          },
          {
           lng : 121.0259136,
           lat : 14.4240521
          },
          {
           lng : 121.0263464,
           lat : 14.4251518
          },
          {
           lng : 121.0264748,
           lat :14.4254782
          },
          {
           lng : 121.0269102,
           lat : 14.4264187
          },
          {
           lng : 121.0262548,
           lat : 14.4266755
          },
          {
           lng : 121.025757,
           lat : 14.4268399
          },
          {
           lng : 121.0239508,
           lat : 14.4273619
          },
          {
           lng : 121.0227915,
           lat : 14.4276747
          },
          {
           lng : 121.0225161,
           lat : 14.4276984
          },
          {
           lng : 121.022489,
           lat : 14.427583
          }
      
  ];

  // Construct the polygon.
  var bermudaTriangle = new google.maps.Polygon({
    paths: triangleCoords,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35
  });
  bermudaTriangle.setMap(map);

  marker.setPosition(map.getCenter());

  map.addListener('click', function(e) {
    console.log(e.latLng)
    animatedMove(marker, .5, marker.position, e.latLng);
  });
}

google.maps.event.addDomListener(window, 'load');


function connectToPusher() {
  // Enable pusher logging - don't include this in production
   Pusher.logToConsole = true;

   var token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjdlMzY0YjExMTY3NTMxY2E5YzFjYTJiYTNkNTAyOTZkMGI0MDI5YmU1Yzk0ZGMwMWE5ZGI4NmM4MDM2NmUzNDg4NjgxZTliZGUyZjNjNmEwIn0.eyJhdWQiOiIxIiwianRpIjoiN2UzNjRiMTExNjc1MzFjYTljMWNhMmJhM2Q1MDI5NmQwYjQwMjliZTVjOTRkYzAxYTlkYjg2YzgwMzY2ZTM0ODg2ODFlOWJkZTJmM2M2YTAiLCJpYXQiOjE1NjU1Nzc4MjYsIm5iZiI6MTU2NTU3NzgyNiwiZXhwIjoxNTk3MjAwMjI2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.DuBTRcrVgSCell9N23EVzoG0X7jMg7dRrvY1bWV3AvPdbuWL3bpb6X0HPtlV4VvRC4V4pFrfh-_SAYlKdX1ASyM4rGmy97ZObI6m43XlxVXitasqsXm7wUCXxLRZrlr4HNccxxu4VlK0-VFVfe7OpFJ-Uv5AlTsJz5OLVJ1PHW3xFST5s0SrAbjoUf3v8L9ICj_RC-xqDMsFX1HGVmLMFhmvCvsw34_4uME05o2vxJlJo-ybazPcDZN3tiC7qVDHzVve3O_bSUkTNJ6bysT8SZJUQ5QqBSfRp_9Vp99BwhrZijvjsU59bgyoEtrLOvkgpL3GkTVKYULo2MvMlFibzdD_YvaepA9QFbjufy6CxL3z2BOpr1rAIozZIKdZmKGFowMNKPIZHUJEcaHiZpO1G-6rm7cCfnOqO18vCH432XlET4xbvAnoYZvjWd5UVbsIKY7NVw062CQJFR9v4b9IEEmvZvrfRlWpSGh5swf7jOfrzxZtg75EVVBsyDemNRAJ2Zqsiv0NY0WgfXiP-QpXvvaCRGvaEr7b-fsdfgpIJlUY8jjTG7Jkt0qEoVmZrkcsO8KFg4rB_vv4-8N5uUbp-dCUUr5D8YW4jJEsmA6dhj-JTTxuBnlSijpVB1oTz6V5L68XTnOyvA7569gUZHVAW1Gx1ABGbwYBojVJNvRk3Wg"

  let pusher = new Pusher('03d3093b75ff51ae76bc', {
      authEndpoint: 'api/broadcasting/auth',
      cluster: 'ap1',
      encrypted: true,
      auth: {
          headers: {
              'Accept': 'application/json',
              'Authorization': 'Bearer ' + token
          }
      }
  });

    var listOfBroadcastData = [];
    var channel = pusher.subscribe('private-channel-coordinates');
    // var mapProp= {
    //   center:new google.maps.LatLng(14.609053699999997,121.02225650000001),
    //   zoom:5,
    // };
    // var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: new google.maps.LatLng(14.428444, 121.021450)
    });
    marker = new google.maps.Marker({
      map: map,
    });

    marker.setPosition(map.getCenter());

    channel.bind('client-service-coordinates', function(data) {
     
      var lat = data.coordinates.lat;
      var lng = data.coordinates.long;
      
      animatedMove(marker, .5, marker.position, lat, lng);
       // content.value = listOfBroadcastData;
    });
}
// move marker from position current to moveto in t seconds
function animatedMove(marker, t, current, moveToLat, moveToLng) {
  console.log(moveToLat)
  var lat = current.lat();
  var lng = current.lng();

  var deltalat = (moveToLat - current.lat()) / 100;
  var deltalng = (moveToLng - current.lng()) / 100;
  

  var delay = 30 * t;
  for (var i = 0; i < 100; i++) {
    (function(ind) {
      setTimeout(
        function() {
          var lat = marker.position.lat();
          var lng = marker.position.lng();
          lat += deltalat;
          lng += deltalng;
          latlng = new google.maps.LatLng(lat, lng);
          marker.setPosition(latlng);
          map.setCenter(latlng)
        }, delay * ind
      );
    })(i)
  }
}

function getLocation() {
  if (navigator.geolocation) {
    //navigator.geolocation.getCurrentPosition(this.showPosition);

    navigator.geolocation.watchPosition(showPosition);

  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  var long = position.coords.longitude;
  var lat = position.coords.latitude;

  var token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjdlMzY0YjExMTY3NTMxY2E5YzFjYTJiYTNkNTAyOTZkMGI0MDI5YmU1Yzk0ZGMwMWE5ZGI4NmM4MDM2NmUzNDg4NjgxZTliZGUyZjNjNmEwIn0.eyJhdWQiOiIxIiwianRpIjoiN2UzNjRiMTExNjc1MzFjYTljMWNhMmJhM2Q1MDI5NmQwYjQwMjliZTVjOTRkYzAxYTlkYjg2YzgwMzY2ZTM0ODg2ODFlOWJkZTJmM2M2YTAiLCJpYXQiOjE1NjU1Nzc4MjYsIm5iZiI6MTU2NTU3NzgyNiwiZXhwIjoxNTk3MjAwMjI2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.DuBTRcrVgSCell9N23EVzoG0X7jMg7dRrvY1bWV3AvPdbuWL3bpb6X0HPtlV4VvRC4V4pFrfh-_SAYlKdX1ASyM4rGmy97ZObI6m43XlxVXitasqsXm7wUCXxLRZrlr4HNccxxu4VlK0-VFVfe7OpFJ-Uv5AlTsJz5OLVJ1PHW3xFST5s0SrAbjoUf3v8L9ICj_RC-xqDMsFX1HGVmLMFhmvCvsw34_4uME05o2vxJlJo-ybazPcDZN3tiC7qVDHzVve3O_bSUkTNJ6bysT8SZJUQ5QqBSfRp_9Vp99BwhrZijvjsU59bgyoEtrLOvkgpL3GkTVKYULo2MvMlFibzdD_YvaepA9QFbjufy6CxL3z2BOpr1rAIozZIKdZmKGFowMNKPIZHUJEcaHiZpO1G-6rm7cCfnOqO18vCH432XlET4xbvAnoYZvjWd5UVbsIKY7NVw062CQJFR9v4b9IEEmvZvrfRlWpSGh5swf7jOfrzxZtg75EVVBsyDemNRAJ2Zqsiv0NY0WgfXiP-QpXvvaCRGvaEr7b-fsdfgpIJlUY8jjTG7Jkt0qEoVmZrkcsO8KFg4rB_vv4-8N5uUbp-dCUUr5D8YW4jJEsmA6dhj-JTTxuBnlSijpVB1oTz6V5L68XTnOyvA7569gUZHVAW1Gx1ABGbwYBojVJNvRk3Wg"

  let pusher = new Pusher('03d3093b75ff51ae76bc', {
      authEndpoint: 'api/broadcasting/auth',
      cluster: 'ap1',
      encrypted: true,
      auth: {
          headers: {
              'Accept': 'application/json',
              'Authorization': 'Bearer ' + token
          }
      }
  });
   
  let channel = pusher.subscribe('private-channel-coordinates');

  coordinates = {'long' : long, 'lat' : lat};

  // channel.bind('pusher:subscription_succeeded', function() {
  //     var triggered = channel.trigger('client-service-coordinates', { coordinates });
  // });
}


  </script>
</body>

<!-- coords: {
    latitude - Geographical latitude in decimal degrees.
    longitude - Geographical longitude in decimal degrees. 
    altitude - Height in meters relative to sea level.
    accuracy - Possible error margin for the coordinates in meters. 
    altitudeAccuracy - Possible error margin for the altitude in meters. 
    heading - The direction of the device in degrees relative to north. 
    speed - The velocity of the device in meters per second.
}
timestamp - The time at which the location was retrieved
 -->



