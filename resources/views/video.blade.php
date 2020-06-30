<html>
    <head>
        <title>streaming client</title>
        <meta charset="utf-8"/>
        <link href="/js/video-js.min.css" rel="stylesheet" />
    </head>
    <body>
        <center>
        <h1>live streaming</h1>
        <video-js id="liveplayer" controls autoplay width=600 class="vjs-default-skin">
            <source src="http://52.221.202.154/hls/test123.m3u8" type="application/x-mpegURL">
        </video-js>

        <br><br>

        <video width=600 data-dashjs-player autoplay controls
            src=http://52.221.202.154/dash/test123.mpd></video>

        </center>

        <script src="/js/video.min.js"></script>
        <script src="/js/videojs-http-streaming.min.js"></script>
        <script src="/js/dash.all.min.js"></script>
        <script>
            var player = videojs("liveplayer");
            player.play();
        </script>
    </body>
</html>