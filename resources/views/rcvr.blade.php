<script src="https://rtcmulticonnection.herokuapp.com/dist/RTCMultiConnection.min.js"></script>
<script src="https://rtcmulticonnection.herokuapp.com/socket.io/socket.io.js"></script>

<div id="local-videos-container">
    
</div>

<!-- <video id="remote-videos-container" playsinline autoplay muted> -->
     <video id="gum" playsinline autoplay></video>
    
</video>
<script>
var connection = new RTCMultiConnection();

// this line is VERY_important
connection.socketURL = 'https://rtcmulticonnection.herokuapp.com:443/';

// if you want audio-only session
// connection.session = {
//     audio: true
// };

// connection.mediaConstraints = {
//     video: false,
//     audio: true
// };

// connection.sdpConstraints.mandatory = {
//     OfferToReceiveAudio: true,
//     OfferToReceiveVideo: true
// };

// ask RTCMultiConnection to
    // DO NOT capture any camera
    // because we already have one
connection.dontCaptureUserMedia = false;

//check roo every 3 second in active the connet
(function checkRoom() {
    connection.checkPresence('xxxxxx', function(isRoomExist, roomid, error) {
        if (isRoomExist === true) {
            connection.join('xxxxxx');
            return;
        }

        setTimeout(checkRoom, 3000); // recheck after every 3 seconds
    });
})();

var localVideoContainer = document.getElementById('local-videos-container');
// var remoteVideoContainer = document.getElementById('remote-videos-container');
const gumVideo = document.getElementById('gum');
connection.onstream = function(event) {
    if (event.type === 'remote') {
        gumVideo.srcObject = event.stream;
    }
    // var video = event.stream;
    console.log(gumVideo)
    // remoteVideoContainer.srcObject = video;
    
    // if (event.type === 'local') {   
    // console.log(event.type) 
    //     localVideoContainer.appendChild(video);
    // }
    // if (event.type === 'remote') {    
    //     remoteVideoContainer.appendChild(video)
    // }
}

// this.disabled = true;
// connection.mediaConstraints.video = true;
// connection.addStream({
//     video: true,
//     oneway: true
// });

</script>