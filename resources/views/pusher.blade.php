<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/4.4/pusher.min.js"></script>

</head>
<body>
  <div class="content" id="content">
    <h1>Pusher Test</h1>
    <div >
      <div id="googleMap" style="width:100%;height:400px;"></div>
    </div>
  </div>
</body>
    <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVv7Om1gEOD3UulCT3lVbwWl55nqGupoY&libraries=places">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="{{url('js/vue-map.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
    <script type="text/javascript">
    //vue code for calling api
        var app = new Vue({

          el: '.content',

          data: {
            testData : [],
            testd : [],
          },

          mounted() {
              this.connectToPusher();
              this.googleMap();
              

          },

          created() {
            //setInterval(() => this.getLocation(),3000)
          },

          methods:{
            connectToPusher : function() {
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('03d3093b75ff51ae76bc', {
                  cluster: 'ap1',
                  forceTLS: true
                });
                var listOfBroadcastData = [];
                var channel = pusher.subscribe('my-channel');

                var mapProp= {
                  center:new google.maps.LatLng(14.609053699999997,121.02225650000001),
                  zoom:5,
                };

                var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

                channel.bind('my-event', function(data) {
                  console.log(data.message.lat);
                  map.panTo({lat: data.message.lat,lng:data.message.long});
                  //listOfBroadcastData.push(data.message);
                   
                   // content.value = listOfBroadcastData;
                });
            },
            googleMap(lat, long) {
                // var mapProp= {
                //   center:new google.maps.LatLng(51.508742,-0.120850),
                //   zoom:5,
                // };
                // var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
            },

            showPosition(position) {
                var long = position.coords.longitude;
                var lat = position.coords.latitude;

                axios.post("{{route('data.Pusher')}}", {
                  coordinates : {'long' : long, 'lat' : lat},
                }).then((response) => {                  

                }).catch((error) => {

                });
              },

              getLocation() {
                if (navigator.geolocation) {
                  navigator.geolocation.getCurrentPosition(this.showPosition);
                } else { 
                  x.innerHTML = "Geolocation is not supported by this browser.";
                }
              },  
              
           
          }
        })

  </script>

