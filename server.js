var socket  = require( './node_modules/socket.io' );
var express = require('./node_modules/express'); //http support for NodeJS
var app     = express();
var server  = require('http').createServer(app); //Create an http server
var io      = require('socket.io').listen(server);

server.listen(3002);

server.listen(function () {
  console.log('Server listening');
});

io.on('connection', function (socket) {

    socket.on('newUser', function(username, room, userid) {
        socket.username = username;
        socket.room = room;
        socket.userid = userid;

        socket.broadcast.emit('newUser', username, room, userid);
    });

    socket.on('newMessage', function(msg, room, username) {
    	socket.broadcast.emit('push_message', msg, username, room);
    });

    socket.on('disconnect', function() {
        socket.broadcast.emit('leave', socket.username, socket.room, socket.userid);
    });

    socket.on('report', function() {
        socket.broadcast.emit('checkReport');
    });

});
