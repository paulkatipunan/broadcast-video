var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var cors = require('cors');
var ss = require('socket.io-stream');

server.listen(4000, function() {
	console.log('server start');		
});
// WARNING: app.listen(80) will NOT work here!
app.use(cors());

app.get('/', function (req, res) {
  res.sendFile(__dirname + '/views/index.html');
});

app.get('/receiver', function (req, res) {
  res.sendFile(__dirname + '/views/receiver.html');
});

app.get('/webrtc', function (req, res) {
  res.sendFile(__dirname + '/views/webrtc.html');
});

app.get('/capture', function (req, res) {
  res.sendFile(__dirname + '/views/capture.html');
});

app.get('/rtc', function (req, res) {
  res.sendFile(__dirname + '/views/rtcc.html');
});

app.get('/rcvr', function (req, res) {
  res.sendFile(__dirname + '/views/rtcreceiver.html');
});

io.on('connection', function (socket) {
  //socket.emit('news', { hello: 'world' });
  socket.on('fire', function (data) {
    console.log(data);
    socket.emit('userSet', data);
  });

  socket.on('channel-1', function (data) {
    console.log(data);
    socket.emit('userSet', data);
  });

});