var app = require('http').createServer();
var io = require('socket.io')(app);
var port = 9001;
app.listen(port);

io.on('connection', function (socket) {

  socket.on('server_receive', function (data) {
    io.emit('client_receive', data);
  });

  socket.on('server_time', function (data) {  	
	var current_time = parseInt(new Date().getTime()/1000);
	//console.log(current_time);
    io.emit('client_time', current_time);
    //console.log('hello');
  });
  
});

//console.log("Server is started on http://104.236.111.34:" + port);