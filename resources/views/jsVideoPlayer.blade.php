<html>
<head>
  <title> Stream Player </title>
  <link href="/js/video-js.min.css" rel="stylesheet" />
  <script src="/js/video.min.js"></script>
  <script>videojs.options.flash.swf = "video-js.swf";</script>
</head>
<body>
 <center>
   <video 
     id="livestream" 
     class="video-js vjs-default-skin vjs-big-play-centered"
     controls 
     autoplay
     preload="auto" 
     data-setup='{"techorder" : ["flash","html5] }'>
     <source src="rtmp://52.221.202.154:1935/live/test" type="rtmp/mp4">
   </video>
 </center>
</body>
</html>