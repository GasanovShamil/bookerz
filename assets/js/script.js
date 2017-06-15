$(document).ready(function(){

    $("#myBtnMdp").click(function(){
        $("#myModalMdp").modal();
    });
    $("#myBtnInfo").click(function(){
        $("#myModalInfo").modal();
    });

    /***********************************/
    /*         CHAT ROOM               */
    /***********************************/

    $('#sendMessage').submit(function(event) {
        event.preventDefault();
    });

    if($(".chatArea").length) {
        var socket = io.connect( 'http://localhost:3002' );
        var room = $(".chatArea").data("room");
        var div = $(".chatArea");
        var height = div[0].scrollHeight;
        var username = $("#message").data("username");
        var data = {username: username, room: room};

        socket.emit('newUser', data );

        socket.on('push_message', function(response) {
            if(response.room == actualRoom) {
                $('.chatArea').append('<div class="content">'+response.msg+'<div class="author">'+response.username+'</div></div>');
                div.scrollTop(height);
            }
        });

        socket.on('newUser', function(response) {
            if(response.room == room) {
                $('.chatArea').append('<div class="notif">'+response.username+' rejoint le salon</div>');
                div.scrollTop(height);
            }
        });

        socket.on('leave', function(response) {
            if(response.room == room) {
                $('.chatArea').append('<div class="notif">'+response.username+' est deconnecté</div>');
                div.scrollTop(height);
            }
        });
    }

    $('#message').keyup(function(e) {
        if(e.which === 13) {

            var message = $("#message").val();
            var room = $("#message").data("room");
            var username = $("#message").data("username");
            var userid = $("#message").data("userid");

            var url = base_url + 'salon/insertMessage';

            var newMessageVar = {msg: message, room: room, username: username};

            $.ajax({
                type  : 'POST',
                url   : url,
                dataType : 'json',
                data : {message:message, userid:userid, room:room},
                cache: false,
                success: function(data) {
                    console.log(data);
                    socket.emit('newMessage', newMessageVar);
                }, error: function(ts) {
                    console.log("error");
                    console.log(ts.responseText);
                }
            });

            $('#message').val('');
        }
    });


    /***********************************/
    /*         FIN CHAT ROOM           */
    /***********************************/
});
