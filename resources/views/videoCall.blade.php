<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="description" content="WebRTC code samples">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1, maximum-scale=1">
    <meta itemprop="description" content="Client-side WebRTC code samples">
    <meta itemprop="image" content="../../../images/webrtc-icon-192x192.png">
    <meta itemprop="name" content="WebRTC code samples">
    <meta name="mobile-web-app-capable" content="yes">
    <meta id="theme-color" name="theme-color" content="#ffffff">

    <base target="_blank">

    <title>getUserMedia + CSS filters</title>

    <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
    <style>
        .none {
            -webkit-filter: none;
            filter: none;
        }

        .blur {
            -webkit-filter: blur(3px);
            filter: blur(3px);
        }

        .grayscale {
            -webkit-filter: grayscale(1);
            filter: grayscale(1);
        }

        .invert {
            -webkit-filter: invert(1);
            filter: invert(1);
        }

        .sepia {
            -webkit-filter: sepia(1);
            filter: sepia(1);
        }

        button#snapshot {
            margin: 0 10px 25px 0;
            width: 110px;
        }

        video {
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div id="container">

      <h1><a href="//webrtc.github.io/samples/" title="WebRTC samples homepage">WebRTC samples</a> <span>getUserMedia + CSS filters</span>
      </h1>

      <video playsinline autoplay></video>

      <label for="filter">Filter: </label>
      <select id="filter">
          <option value="none">None</option>
          <option value="blur">Blur</option>
          <option value="grayscale">Grayscale</option>
          <option value="invert">Invert</option>
          <option value="sepia">Sepia</option>
      </select>

      <img src="" id="play">

      <button id="snapshot">Take snapshot</button>
        <button onclick="triggerEvent2()">button</button>
      <canvas style="display: none;"></canvas>

      <p>Draw a frame from the getUserMedia video stream onto the canvas element, then apply CSS filters.</p>

      <p>The variables <code>canvas</code>, <code>video</code> and <code>stream</code> are in global scope, so you can
          inspect them from the console.</p>

      <a href="https://github.com/webrtc/samples/tree/gh-pages/src/content/getusermedia/filter"
         title="View source for this page on GitHub" id="viewSource">View source on GitHub</a>
  </div>

  <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
  <script src="js/main.js" async></script>

  <script src="../../../js/lib/ga.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>
       
	<script type="text/javascript">
		/*
 *  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a BSD-style license
 *  that can be found in the LICENSE file in the root of the source
 *  tree.
 */

'use strict';
 

const snapshotButton = document.querySelector('button#snapshot');
const filterSelect = document.querySelector('select#filter');

// Put variables in global scope to make them available to the browser console.
const video = window.video = document.querySelector('video');
const canvas = window.canvas = document.querySelector('canvas');
canvas.width = 480;
canvas.height = 360;

snapshotButton.onclick = function() {
  canvas.className = filterSelect.value;
  canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
  var f=canvas.toDataURL();
  console.log(f);
};

filterSelect.onchange = function() {
  video.className = filterSelect.value;
};

const constraints = {
  audio: false,
  video: true
};

function handleSuccess(stream) {
  window.stream = stream; // make stream available to browser console
  video.srcObject = stream;
}

function handleError(error) {
  console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
}

navigator.mediaDevices.getUserMedia(constraints).then(handleSuccess).catch(handleError);


function triggerEvent() {
      socket.emit('fire', {mydata : 'test only'});

}

function triggerEvent2() {
    setInterval(function(){
      canvas.className = filterSelect.value;
      canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
      var f = canvas.toDataURL('image/webp');
        socket.emit('channel-1', f);
    }, 70);
}

const socket = io.connect('http://localhost:4000');
    console.log('test---');
  socket.on('userSet', function(data) {
    var img = document.getElementById('play');
    img.src = data;
    console.log('-----');
     console.log(data);
     canvas.className = filterSelect.value;
     canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
  });

	</script>
</body>
</html>
