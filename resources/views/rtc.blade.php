<script src="https://cdn.webrtc-experiment.com/getScreenId.js"></script>
<script src="https://cdn.webrtc-experiment.com/screen.js"></script>
<script src="https://rtcmulticonnection.herokuapp.com/dist/RTCMultiConnection.min.js"></script>
<script src="https://rtcmulticonnection.herokuapp.com/socket.io/socket.io.js"></script>
<style type="text/css">
    video {
        width: 150px;
        height: 150px;
    }
</style>
<button id="btn-open-room">Open Room</button>
<button id="share-screen">Open screeen</button>
<!-- <button id="btn-join-room">Join Room</button><hr> -->


<div id="local-videos-container">
    
</div>

<div id="remote-videos-container">
    
</div>
<script>
var screen = new Screen(213); // argument is optional
console.log(screen)
// on getting local or remote streams
screen.onstream = function(e) {
    document.body.appendChild(e.video);
};

// check pre-shared screens
// it is useful to auto-view
// or search pre-shared screens
screen.check();

document.getElementById('share-screen').onclick = function() {
    alert();
    screen.share();
};

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


connection.onstream = function(event) {
    document.body.appendChild( event.mediaElement );
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


</script>