<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
		<script src="https://rtcmulticonnection.herokuapp.com/socket.io/socket.io.js"></script>
		<script src="https://www.webrtc-experiment.com/socket.io/PeerConnection.js"></script>

		<script type="text/javascript">
	
			var channel = location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
			var sender = Math.round(Math.random() * 999999999) + 999999999;

			// var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';
			var SIGNALING_SERVER = 'https://rtcmulticonnection.herokuapp.com:443/';
			io.connect(SIGNALING_SERVER).emit('new-channel', {
			    channel: channel,
			    sender: sender
			});

			var socket = io.connect(SIGNALING_SERVER + channel);
			socket.send = function (message) {
			    socket.emit('message', {
			        sender: sender,
			        data: message
			    });
			};
				console.log(socket)
			// pass "socket" object over the constructor instead of URL
			var peer = new PeerConnection(socket);


			function getUserMedia(callback) {
			    var hints = {
			        audio: true,
			        video: {
			            optional: [],

			            // capture super-hd stream!
			            mandatory: {
			                minWidth: 1280,
			                minHeight: 720,
			                maxWidth: 1920,
			                maxHeight: 1080,
			                minAspectRatio: 1.77
			            }
			        }
			    };

			    navigator.getUserMedia(hints, function (stream) {
			        //    you can use "peer.addStream" to attach stream
			        //    peer.addStream(stream);
			        // or peer.MediaStream = stream;

			        callback(stream);

			        // preview local video
			        var video = document.createElement('video');
			        video.srcObject = stream;
			        video.controls = true;
			        video.muted = true;

			        peer.onStreamAdded({
			            mediaElement: video,
			            userid: 'self',
			            stream: stream
			        });
			    });
			}

			</script>
</body>
</html>


