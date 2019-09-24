<body>
  <div id="root">
   

    <gmap-map :center="center" :zoom="17" ref="mmm" style="width: 100%; height: 500px">
      <gmap-marker :key="index" v-for="(m, index) in markers" :position="m.position" :clickable="true" :draggable="false" @click="center=m.position" v-if="index == markers.length - 1"></gmap-marker>
    </gmap-map>
    <br><br>
    <span v-for="(sn, index) in markers" v-if="index == markers.length - 1">@{{sn}}</span>
  </div>

  <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.0/vue.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
  <script src="{{url('js/vue-map.js')}}"></script>

  <script>
    Vue.use(VueGoogleMaps, {
      load: {
        key: 'AIzaSyCVv7Om1gEOD3UulCT3lVbwWl55nqGupoY'
      },
    });
    document.addEventListener('DOMContentLoaded', function() {
      new Vue({
        el: '#root',
        data: {
          lat1 : 14.609053699999997,
          lng1 : 121.02225650000001,
          center: {
            lat: 0,
            lng: 0
          },
          markers: [{
            position: {
              lat: 0,
              lng: 0
            }
          }]
        },
        mounted() {
           this.connectToPusher();
          // this.getLocation();
        },
         created() {
            this.getLocation();
          // setInterval(() => this.getLocation(),3000)
            //setInterval(() => this.panTo(),3000)
          },
        methods: {
          
           connectToPusher : function() {
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
                var mapPan = this.$refs.mmm;
                var markers = this.markers;
                var center = this.center;
                channel.bind('client-service-coordinates', function(data) {
                  var lat = data.coordinates.lat;
                  var lng = data.coordinates.long;

                  center = {
                    lat: lat,
                    lng: lng
                  };

                  mapPan.panTo({
                    lat: lat,
                    lng: lng
                  });

                  markers.push({
                    position: {
                      lat: lat,
                      lng: lng
                    }
                  })
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

                channel.bind('pusher:subscription_succeeded', function() {
                  var test = "paul adrian katipunan";
                  
                    var triggered = channel.trigger('client-service-coordinates', { coordinates });
                 
                  
                });

                // channel.trigger('client-service.coordinates', { message: 'Alarm!' });
                console.log('------');
                // axios.post("{{route('data.Pusher')}}", {
                //   coordinates : {'long' : long, 'lat' : lat},
                // }).then((response) => {                  

                // }).catch((error) => {

                // });
              },

              getLocation() {
                if (navigator.geolocation) {
                  //navigator.geolocation.getCurrentPosition(this.showPosition);

                  navigator.geolocation.watchPosition(this.showPosition);

                } else { 
                  x.innerHTML = "Geolocation is not supported by this browser.";
                }
              },  

        }
      });
    });
  </script>

</body>
