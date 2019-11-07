<script src="https://rtcmulticonnection.herokuapp.com/dist/RTCMultiConnection.min.js"></script>
<script src="https://rtcmulticonnection.herokuapp.com/socket.io/socket.io.js"></script>
<script src="https://www.webrtc-experiment.com/socket.io.js"> </script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://www.webrtc-experiment.com/IceServersHandler.js"></script>
<script src="https://www.webrtc-experiment.com/getScreenId.js"> </script>
<script src="https://www.webrtc-experiment.com/CodecsHandler.js"></script>
<script src="https://www.webrtc-experiment.com/BandwidthHandler.js"></script>
<script src="https://www.webrtc-experiment.com/screen.js"> </script>
<style type="text/css">
    video {
        width: 150px;
        height: 150px;
    }
</style>
<button id="btn-open-room">Open Room</button>
<button id="btn-join-room">Join Room</button><hr>

 <!-- just copy this <section> and next script -->
            <section class="experiment">
                <section class="hide-after-join">
                    <input type="text" id="user-name" placeholder="Your Name">
                    <button id="share-screen" class="setup">Share Your Screen</button>
                </section>

                <!-- list of all available broadcasting rooms -->
                <table style="width: 100%;" id="rooms-list" class="hide-after-join"></table>

                <!-- local/remote videos container -->
                <div id="videos-container"></div>
            </section>

<div id="local-videos-container">
    
</div>

<div id="remote-videos-container">
    
</div>
<script>
var connection = new RTCMultiConnection();

// this line is VERY_important
connection.socketURL = 'https://rtcmulticonnection.herokuapp.com:443/';

// all below lines are optional; however recommended.

connection.session = {
    audio: true,
    video: true,
    oneway: true,
};

connection.bandwidth = {
    audio: 50,  // 50 kbps
    video: 256 // 256 kbps
};

connection.sdpConstraints.mandatory = {
    OfferToReceiveAudio: true,
    OfferToReceiveVideo: true
};
var localVideoContainer =  document.getElementById('local-videos-container');
connection.onstream = function(event) {
    localVideoContainer.appendChild(event.mediaElement);
};

// connection.addStream({
//     audio: true,
//     video: true,
//     oneway: true
// });

var predefinedRoomId = 'xxxxxx';

document.getElementById('btn-open-room').onclick = function() {
    this.disabled = true;
    connection.open( predefinedRoomId );
};

document.getElementById('btn-join-room').onclick = function() {
    this.disabled = true;
    connection.join( predefinedRoomId );
};




var videosContainer = document.getElementById("videos-container") || document.body;
var roomsList = document.getElementById('rooms-list');
var screensharing = new Screen();
var channel = location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
var sender = Math.round(Math.random() * 999999999) + 999999999;
// https://github.com/muaz-khan/WebRTC-Experiment/tree/master/socketio-over-nodejs
var SIGNALING_SERVER = 'https://rtcmulticonnection.herokuapp.com:443/';
io.connect(SIGNALING_SERVER).emit('new-channel', {
channel: channel,
sender: sender
});
var socket = io.connect(SIGNALING_SERVER + channel);
socket.on('connect', function () {
// setup peer connection & pass socket object over the constructor!
});
socket.send = function (message) {
socket.emit('message', {
    sender: sender,
    data: message
});
};
screensharing.openSignalingChannel = function(callback) {
return socket.on('message', callback);
};

screensharing.onstream = function(e) {
    document.body.appendChild(e.video);
};

// on getting each new screen
screensharing.onaddstream = function(media) {
    media.video.id = media.userid;
    var video = media.video;
    videosContainer.insertBefore(video, videosContainer.firstChild);
    rotateVideo(video);
    var hideAfterJoin = document.querySelectorAll('.hide-after-join');
    for(var i = 0; i < hideAfterJoin.length; i++) {
        hideAfterJoin[i].style.display = 'none';
    }
    if(media.type === 'local') {
        addStreamStopListener(media.stream, function() {
            location.reload();
        });
    }
};


screensharing.onNumberOfParticipantsChnaged = function(numberOfParticipants) {
    if(!screensharing.isModerator) return;
    document.title = numberOfParticipants + ' users are viewing your screen!';
    var element = document.getElementById('number-of-participants');
    if (element) {
        element.innerHTML = numberOfParticipants + ' users are viewing your screen!';
    }
};

document.getElementById('share-screen').onclick = function() {
var username = document.getElementById('user-name');
username.disabled = this.disabled = true;
screensharing.isModerator = true;
screensharing.userid = username.value;
screensharing.share();
};
            
</script>

