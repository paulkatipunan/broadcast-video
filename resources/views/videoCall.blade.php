<!--
> Muaz Khan     - https://github.com/muaz-khan
> MIT License   - https://www.webrtc-experiment.com/licence/
> Documentation - https://github.com/muaz-khan/WebRTC-Experiment/tree/master/screen-sharing
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>WebRTC Screen Sharing</title>

        <script>
            if(!location.hash.replace('#', '').length) {
                location.href = location.href.split('#')[0] + '#' + (Math.random() * 100).toString().replace('.', '');
                location.reload();
            }
        </script>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="author" type="text/html" href="https://plus.google.com/+MuazKhan">
        <meta name="author" content="Muaz Khan">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <link rel="stylesheet" href="https://www.webrtc-experiment.com/style.css">

        <style>
            video {
                -moz-transition: all 1s ease;
                -ms-transition: all 1s ease;
                -o-transition: all 1s ease;
                -webkit-transition: all 1s ease;
                transition: all 1s ease;
                vertical-align: top;
                width: 100%;
            }
            input {
                border: 1px solid #d9d9d9;
                border-radius: 1px;
                font-size: 2em;
                margin: .2em;
                width: 30%;
            }
            select {
                border: 1px solid #d9d9d9;
                border-radius: 1px;
                height: 50px;
                margin-left: 1em;
                margin-right: -12px;
                padding: 1.1em;
                vertical-align: 6px;
                width: 18%;
            }
            .setup {
                border-bottom-left-radius: 0;
                border-top-left-radius: 0;
                font-size: 102%;
                height: 47px;
                margin-left: -9px;
                margin-top: 8px;
                position: absolute;
            }
            p { padding: 1em; }
            li {
                border-bottom: 1px solid rgb(189, 189, 189);
                border-left: 1px solid rgb(189, 189, 189);
                padding: .5em;
            }
        </style>
        <script>
            document.createElement('article');
            document.createElement('footer');
        </script>

        <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/ajhifddimkapgcifgcodmmfdlknahffk">

        <!-- scripts used for screen-sharing -->
        <script src="https://www.webrtc-experiment.com/socket.io.js"> </script>
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
        <script src="https://www.webrtc-experiment.com/IceServersHandler.js"></script>
        <script src="https://www.webrtc-experiment.com/getScreenId.js"> </script>
        <script src="https://www.webrtc-experiment.com/CodecsHandler.js"></script>
        <script src="https://www.webrtc-experiment.com/BandwidthHandler.js"></script>
        <script src="https://www.webrtc-experiment.com/screen.js"> </script>
    </head>

    <body>
        <article>
            <header style="text-align: center;">
           
                <p>
                   
                </p>
            </header>

            <div class="github-stargazers"></div>

            <h2 id="number-of-participants" style="display: block;text-align: center;border:0;margin-bottom:0;">Its a full-HD (1080p) screen sharing application using <a href="https://www.webrtc-experiment.com/">WebRTC</a>!</h2>

            <!-- just copy this <section> and next script -->
            <section class="experiment">
                <section class="hide-after-join">
                    <span>
                        Private ?? <a href="/screen-sharing/" target="_blank" title="Open this link for private screen sharing!"><code><strong id="unique-token">#123456789</strong></code></a>
                    </span>
                    <input type="text" id="user-name" placeholder="Your Name">
                    <button id="share-screen" class="setup">Share Your Screen</button>
                </section>

                <!-- list of all available broadcasting rooms -->
                <table style="width: 100%;" id="rooms-list" class="hide-after-join"></table>

                <!-- local/remote videos container -->
                <div id="videos-container"></div>
            </section>

            <script>
                // Muaz Khan     - https://github.com/muaz-khan
                // MIT License   - https://www.webrtc-experiment.com/licence/
                // Documentation - https://github.com/muaz-khan/WebRTC-Experiment/tree/master/screen-sharing
                var videosContainer = document.getElementById("videos-container") || document.body;
                var roomsList = document.getElementById('rooms-list');
                var screensharing = new Screen();
                var channel = location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
                var sender = Math.round(Math.random() * 999999999) + 999999999;
                // https://github.com/muaz-khan/WebRTC-Experiment/tree/master/socketio-over-nodejs
                var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';
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
                screensharing.onscreen = function(_screen) {
                    var alreadyExist = document.getElementById(_screen.userid);
                    if (alreadyExist) return;
                    if (typeof roomsList === 'undefined') roomsList = document.body;
                    var tr = document.createElement('tr');
                    tr.id = _screen.userid;
                    tr.innerHTML = '<td>' + _screen.userid + ' shared his screen.</td>' +
                            '<td><button class="join">View</button></td>';
                    roomsList.insertBefore(tr, roomsList.firstChild);
                    var button = tr.querySelector('.join');
                    button.setAttribute('data-userid', _screen.userid);
                    button.setAttribute('data-roomid', _screen.roomid);
                    button.onclick = function() {
                        var button = this;
                        button.disabled = true;
                        var _screen = {
                            userid: button.getAttribute('data-userid'),
                            roomid: button.getAttribute('data-roomid')
                        };
                        screensharing.view(_screen);
                    };
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
                // using firebase for signaling
                // screen.firebase = 'signaling';
                // if someone leaves; just remove his screen
                screensharing.onuserleft = function(userid) {
                    var video = document.getElementById(userid);
                    if (video && video.parentNode) video.parentNode.removeChild(video);
                    // location.reload();
                };
                // check pre-shared screens
                screensharing.check();
                document.getElementById('share-screen').onclick = function() {
                    var username = document.getElementById('user-name');
                    username.disabled = this.disabled = true;
                    screensharing.isModerator = true;
                    screensharing.userid = username.value;
                    screensharing.share();
                };
                function rotateVideo(video) {
                    video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
                    setTimeout(function() {
                        video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
                    }, 1000);
                }
                (function() {
                    var uniqueToken = document.getElementById('unique-token');
                    if (uniqueToken)
                        if (location.hash.length > 2) uniqueToken.parentNode.parentNode.parentNode.innerHTML = '<h2 style="text-align:center; display: block"><a href="' + location.href + '" target="_blank">Right click to copy & share this private link</a></h2>';
                        else uniqueToken.innerHTML = uniqueToken.parentNode.parentNode.href = '#' + (Math.random() * new Date().getTime()).toString(36).toUpperCase().replace( /\./g , '-');
                })();
                screensharing.onNumberOfParticipantsChnaged = function(numberOfParticipants) {
                    if(!screensharing.isModerator) return;
                    document.title = numberOfParticipants + ' users are viewing your screen!';
                    var element = document.getElementById('number-of-participants');
                    if (element) {
                        element.innerHTML = numberOfParticipants + ' users are viewing your screen!';
                    }
                };
            </script>

            <script>
                // todo: need to check exact chrome browser because opera also uses chromium framework
                var isChrome = !!navigator.webkitGetUserMedia;
                // DetectRTC.js - https://github.com/muaz-khan/WebRTC-Experiment/tree/master/DetectRTC
                // Below code is taken from RTCMultiConnection-v1.8.js (http://www.rtcmulticonnection.org/changes-log/#v1.8)
                var DetectRTC = {};
                (function () {
                    var screenCallback;
                    DetectRTC.screen = {
                        chromeMediaSource: 'screen',
                        getSourceId: function(callback) {
                            if(!callback) throw '"callback" parameter is mandatory.';
                            screenCallback = callback;
                            window.postMessage('get-sourceId', '*');
                        },
                        isChromeExtensionAvailable: function(callback) {
                            if(!callback) return;
                            if(DetectRTC.screen.chromeMediaSource == 'desktop') return callback(true);
                            // ask extension if it is available
                            window.postMessage('are-you-there', '*');
                            setTimeout(function() {
                                if(DetectRTC.screen.chromeMediaSource == 'screen') {
                                    callback(false);
                                }
                                else callback(true);
                            }, 2000);
                        },
                        onMessageCallback: function(data) {
                            if (!(typeof data == 'string' || !!data.sourceId)) return;
                            console.log('chrome message', data);
                            // "cancel" button is clicked
                            if(data == 'PermissionDeniedError') {
                                DetectRTC.screen.chromeMediaSource = 'PermissionDeniedError';
                                if(screenCallback) return screenCallback('PermissionDeniedError');
                                else throw new Error('PermissionDeniedError');
                            }
                            // extension notified his presence
                            if(data == 'rtcmulticonnection-extension-loaded') {
                                if(document.getElementById('install-button')) {
                                    document.getElementById('install-button').parentNode.innerHTML = '<strong>Great!</strong> <a href="https://chrome.google.com/webstore/detail/screen-capturing/ajhifddimkapgcifgcodmmfdlknahffk" target="_blank">Google chrome extension</a> is installed.';
                                }
                                DetectRTC.screen.chromeMediaSource = 'desktop';
                            }
                            // extension shared temp sourceId
                            if(data.sourceId) {
                                DetectRTC.screen.sourceId = data.sourceId;
                                if(screenCallback) screenCallback( DetectRTC.screen.sourceId );
                            }
                        },
                        getChromeExtensionStatus: function (callback) {
                            if (!!navigator.mozGetUserMedia) return callback('not-chrome');
                            var extensionid = 'ajhifddimkapgcifgcodmmfdlknahffk';
                            var image = document.createElement('img');
                            image.src = 'chrome-extension://' + extensionid + '/icon.png';
                            image.onload = function () {
                                DetectRTC.screen.chromeMediaSource = 'screen';
                                window.postMessage('are-you-there', '*');
                                setTimeout(function () {
                                    if (!DetectRTC.screen.notInstalled) {
                                        callback('installed-enabled');
                                    }
                                }, 2000);
                            };
                            image.onerror = function () {
                                DetectRTC.screen.notInstalled = true;
                                callback('not-installed');
                            };
                        }
                    };
                    // check if desktop-capture extension installed.
                    if(window.postMessage && isChrome) {
                        DetectRTC.screen.isChromeExtensionAvailable();
                    }
                })();
                DetectRTC.screen.getChromeExtensionStatus(function(status) {
                    if(status == 'installed-enabled') {
                        if(document.getElementById('install-button')) {
                            document.getElementById('install-button').parentNode.innerHTML = '<strong>Great!</strong> <a href="https://chrome.google.com/webstore/detail/screen-capturing/ajhifddimkapgcifgcodmmfdlknahffk" target="_blank">Google chrome extension</a> is installed.';
                        }
                        DetectRTC.screen.chromeMediaSource = 'desktop';
                    }
                });
                window.addEventListener('message', function (event) {
                    if (event.origin != window.location.origin) {
                        return;
                    }
                    DetectRTC.screen.onMessageCallback(event.data);
                });
                console.log('current chromeMediaSource', DetectRTC.screen.chromeMediaSource);
            </script>

            <section class="experiment">
                <h2>Prerequisites</h2>
                <ol>
                    <li>
                        Chrome?
                        <a href="https://chrome.google.com/webstore/detail/screen-capturing/ajhifddimkapgcifgcodmmfdlknahffk" target="_blank">Store</a>
                        / <a href="https://github.com/muaz-khan/Chrome-Extensions/tree/master/desktopCapture">Source Code</a>
                        /
                        <button onclick="!!navigator.webkitGetUserMedia && !!window.chrome && !!chrome.webstore && !!chrome.webstore.install && chrome.webstore.install('https://chrome.google.com/webstore/detail/ajhifddimkapgcifgcodmmfdlknahffk', function() {location.reload();})" id="install-button" style="font-size:inherit; padding-bottom:0;">Click to Install</button>
                    </li>

                    <li>
                        Firefox? Please use version 52 or higher. Also use HTTPs.
                    </li>

                    <li>
                        Edge? Please use version 17 or higher. Also use HTTPs.
                    </li>

                    <li>
                        Safari? Please use version 11 (on Mac or iphone/ipad). However Safari can merely view screens. Safari can not share its own screen.
                    </li>
                </ol>
            </section>

            <section class="experiment"><small id="send-message"></small></section>

            <section class="experiment">
                <h2>Advantages</h2>
                <ol>
                    <li>Share full screen with one or more users in <strong>HD</strong> format!</li>
                    <li>Share screen from chrome and view over all WebRTC compatible browsers/plugins.</li>
                    <li>
                        You can open private rooms and it will be really "totally" private!<br /><br />
                        <ol>
                            <li>Use hashes to open private rooms: <strong>#private-room</strong></li>
                            <li>Use URL parameters to open private rooms: <strong>?private=room</strong></li>
                        </ol>
                    </li>
                </ol>
            </section>

            <section class="experiment">
                <h2>Common issues & queries</h2>
                <ol>
                    <li>Recursive cascade images or blurred screen experiences occur only when you try to share screen between two tabs on the same system. This NEVER happens when sharing between unique systems or devices.</li>
                    <li>Opera/IE/Safari has no support of screen-capturing yet. However, you can view shared screens on Opera/IE/Safari!</li>
                    <li>Remember, it is not desktop sharing! It is just a state-less screen sharing. Desktop sharing is possible only through native (C++) applications.</li>
                </ol>
            </section>

            <section class="experiment">
                <h2 class="header">Why Screen Sharing Fails?</h2>
                <ol>
                    <li>
                        You've not used '<strong>chromeMediaSource</strong>' or '<strong>mediaSource</strong>' constraint:
                        <pre>
// for chrome
mandatory: {chromeMediaSource: 'screen'}
// or desktop-Capturing
mandatory: {chromeMediaSource: 'desktop'}

// for Firefox (https-only)
video: {
    mediaSource: 'window' || 'screen'
}

// for Edge &gt;= 17 (https-only)
navigator.getDisplayMedia({
    video: true
}).then(successCallback, errorCallback);
</pre>
                    </li>
                    <li>On chrome, you requested audio-stream alongwith '<strong>chromeMediaSource</strong>' – it is not permitted on chrome. Remember, Firefox is supporting audio+screen from single getUserMedia request.</li>
                    <li>On chrome, you're not testing it on SSL origin (HTTPS domain) otherwise you didn't enable <code><a href="http://peter.sh/experiments/chromium-command-line-switches/#allow-http-screen-capture" target="_blank">--allow-http-screen-capture</a></code> command-line flag on canary. Firefox is supporting screen capturing from both HTTP and HTTPs domains.</li>
                    <li>You may used media constraints like min/max frameRate; bandwidth or min/max width/height like 2000*2000 that is "currently" not allowed.</li>
                </ol>
            </section>

            <section class="experiment">
                <h2 class="header">How to use <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/screen-sharing">screen.js</a>?</h2>
                <pre>
&lt;script src="//www.webrtc-experiment.com/screen.js"&gt;&lt;/script&gt;
</pre>
        <pre>
var screen = new Screen('screen-unique-id');

// get shared screens
screen.onaddstream = function(e) {
    document.body.appendChild(e.video);
};

// custom signaling channel
// you can use each and every signaling channel
// any websocket, socket.io, or XHR implementation
// any SIP server
// anything! etc.
screen.openSignalingChannel = function(callback) {
    return io.connect().on('message', callback);
};

// check pre-shared screens
// it is useful to auto-view
// or search pre-shared screens
screen.check();

document.getElementById('share-screen').onclick = function() {
    screen.share('screen name');
};

// to stop sharing screen
// screen.leave();
</pre>
            </section>

            <section class="experiment">
                <h2 class="header">Suggestions</h2>
                <ol>
                    <li>
                        <a href="https://github.com/muaz-khan/RTCMultiConnection" target="_blank">RTCMultiConnection.js</a> can be used for HD screen sharing; HD audio/video streaming; fastest file sharing; and writing entire skype-like app in the browser!
                    </li>
                </ol>
            </section>

        </article>

        <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/screen-sharing" class="fork-left"></a>

        <footer>
            <p>
                <a href="https://www.webrtc-experiment.com/">WebRTC Experiments</a>
                © <a href="https://plus.google.com/+MuazKhan" rel="author" target="_blank">Muaz Khan</a>
                <a href="mailto:muazkh@gmail.com" target="_blank">muazkh@gmail.com</a>
            </p>
        </footer>

        <!-- commits.js is useless for you! -->
        <script src="https://www.webrtc-experiment.com/commits.js" async> </script>
    </body>
</html>