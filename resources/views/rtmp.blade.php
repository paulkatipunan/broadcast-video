<html>
<head>
    <script src="http://releases.flowplayer.org/js/flowplayer-
      3.2.12.min.js"></script>
</head>

<body>
    <div id="player" style="width:644px;height:276px;margin:0 auto;text-align:center">
        <img src="/path/to/background.png" height="260" width="489" />
    </div>
    <script>
        $f("player", "http://releases.flowplayer.org/swf/flowplayer-
    3.2.16. swf ", {
        clip: {
            url: '<YOUR_FILE.flv>',
            scaling: 'fit',
            provider: 'hddn'
        },

        plugins: {
            hddn: {
                url: "flowplayer.rtmp-3.2.13.swf",

                netConnectionUrl: 'rtmp://<IP_OF_THE_SERVER>:1935/vod'
            }
        },
        canvas: {
            backgroundGradient: 'none'
        }
        });
    </script>
    <div class="fb-login-button" data-size="small" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
    <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v7.0&appId=235115033766468&autoLogAppEvents=1" nonce="f3nVGu97"></script>
</body>
</html>