<!DOCTYPE html>
<html>
<head>
	<title>Pusher of data</title>
</head>
<body>
	<div class="content">
		<input type="text" v-model="data" name="">
		<button @click="broadcast">Broadcast</button>

    <br><br>
    <canvas></canvas>
	</div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>
	   <script type="text/javascript">

const canvas = window.canvas = document.querySelector('canvas');
canvas.width = 480;
canvas.height = 360;


      const socket = io.connect('http://localhost:4000');
    console.log('test---');
  socket.on('userSet', function(video) {
    console.log();
     canvas.className = filterSelect.value;
     canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
});

 
     </script>
   <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
      var OneSignal = window.OneSignal || [];
      OneSignal.push(function() {
        OneSignal.init({
          appId: "2c23c2f0-8d83-4f9c-9c08-d3aa7a6c2e3b",
        });
      });
    </script>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
	  <script type="text/javascript">
		//vue code for calling api
        var app = new Vue({

          el: '.content',

          data: {
			data : '',
          },

          mounted() {
          	
          },

          methods:{

            broadcast : function() {
           	    axios.post("{{route('data.Pusher')}}", {
           	    	data : this.data
           	    }).then((response) => {

           	    	

           	    }).catch((error) => {

           	    });
	 		}
          }
        })

	</script>
</body>
</html>