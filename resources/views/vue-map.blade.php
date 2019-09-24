<body>
  <div id="root">
    <button @click="panTo">
      Pan To
    </button>

    <button @click="panToBounds">
      Pan To Bounds
    </button>

    <button @click="fitBounds">
      Fit Bounds
    </button>

    <gmap-map :center="center" :zoom="17" ref="mmm" style="width: 100%; height: 500px">
      <gmap-marker :key="index" v-for="(m, index) in markers" :position="m.position" :clickable="true" :draggable="false" @click="center=m.position"></gmap-marker>
    </gmap-map>
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
          lat : '',
          lng : null,
          center: {
            lat: null,
            lng: null
          },
          markers: [{
            position: {
              lat: null,
              lng: null
            }
          }]
        },
        mounted() {
           this.connectToPusher();
        },
         created() {
   
          setInterval(() => this.getLocation(),3000)
            //setInterval(() => this.panTo(),3000)
          },
        methods: {
          fitBounds() {
            var b = new google.maps.LatLngBounds();
            b.extend({
              lat: 14.609053699999997,
              lng: 121.02225650000001
            });
            b.extend({
              lat: 33.7606,
              lng: 35.64592
            });
            this.$refs.mmm.fitBounds(b);
          },
          panToBounds() {
            var b = new google.maps.LatLngBounds();
            b.extend({
              lat: 14.609053699999997,
              lng: 121.02225650000001
            });
            b.extend({
              lat: 33.7606,
              lng: 35.64592
            });
            this.$refs.mmm.panToBounds(b);
          },
          panTo() {
           
            lng = this.lng + 0.001;
            lat = this.lat + 0.001;
            
            this.$refs.mmm.panTo({
              lat: lat,
              lng: lng
            });

            this.markers.push({
              position: {
                lat: lat,
                lng: lng
              }
            })
            this.lng =lng;
            this.lat = lat;
          },
          connectToPusher : function() {
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('03d3093b75ff51ae76bc', {
                  cluster: 'ap1',
                  forceTLS: true
                });
                var listOfBroadcastData = [];
                var channel = pusher.subscribe('my-channel');

                // var mapProp= {
                //   center:new google.maps.LatLng(14.609053699999997,121.02225650000001),
                //   zoom:5,
                // };

                // var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
                var mapPan = this.$refs.mmm;
                var markers = this.markers;
                var center = this.center;
                channel.bind('my-event', function(data) {
                  var lat = data.message.lat;
                  var lng = data.message.long;
                  
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
      });
    });
  </script>

</body>
