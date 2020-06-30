<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>example.com</title>
    <script>
        if (top != self) {
            top.location.replace(self.location.href);
        }
    </script>
    <script src="//cdn.jsdelivr.net/clappr/latest/clappr.min.js"></script>
</head>
<body>
<div id="player" style="width:640px"></div>
<script>
    var player = new window.Clappr.Player({
        // this is an example url - for this to work you'll need to generate fresh token
        source: 'http://52.221.202.154/hls/test123.m3u8',
        parentId: '#player'
    });
</script>
</body>
</html>