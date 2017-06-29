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

    // $("#chatInput").emojioneArea({
    //     pickerPosition: "bottom",
    //     tonesStyle: "radio",
    //     autoHideFilters: true
    // });

    function escapeHtml(text) {
        return text
          .replace(/&/g, "&amp;")
          .replace(/</g, "&lt;")
          .replace(/>/g, "&gt;")
          .replace(/"/g, "&quot;")
          .replace(/'/g, "&#039;");
    }

    $("#sendMessage").submit(function(event) {
        event.preventDefault();
    });

    if($(".bloc-message").length) {
        var socket = io.connect( 'http://localhost:3002' );
        var room = $(".bloc-message").data("room");
        var div = $(".scrollspy-example");
        var height = div[0].scrollHeight;
        var username = $("#chatInput").data("username");
        var data = {username: username, room: room};

        div.scrollTop(height);

        socket.emit('newUser', data );

        socket.on('push_message', function(response) {
            if(response.room == room) {
              var message = escapeHtml(response.msg);
                $('.chat-ul').append(
                    '<li><div class="message-data"><span class="message-data-name"><i class="fa fa-circle you"></i>'
                    +response.username+
                    '</span></div><div class="message you-message">'
                    +message+
                    '</div></li>');
                div.scrollTop(height);
            }
        });

        socket.on('newUser', function(response) {
            if(response.room == room) {
                $('.chat-ul').append('<div class="notif">'+response.username+' rejoint le salon</div>');
                div.scrollTop(height);

                $('ul#participant').append('<li class="col-md-12"><img src="http://bootsnipp.com/img/avatars/bcf1c0d13e5500875fdd5a7e8ad9752ee16e7462.jpg" /><span>'+response.username+'</span><div class="pull-right"><a>signaler</a> | <a>Contacter</a></div></li>');
            }
        });

        socket.on('leave', function(response) {
            if(response.room == room) {
                $('.chat-ul').append('<div class="notif">'+response.username+' est deconnecté</div>');
                div.scrollTop(height);
            }
        });
    }

    $('#chatInput').keydown(function(e) {
        if(e.which === 13) {

            var message = $("#chatInput").val();
            var room = $("#chatInput").data("room");
            var username = $("#chatInput").data("username");
            var userid = $("#chatInput").data("userid");

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

            $('#chatInput').val('');
        }
    });




    /***********************************/
    /*         LISTE SALONS            */
    /***********************************/

    $('#liste-salon').DataTable({
        "language": {
            "sProcessing":     "Traitement en cours...",
            "sSearch":         "Rechercher&nbsp;:",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments par page",
            "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
        }
    });
    $('#rejoindre-salon').click(function(){
        $('#modal-note-livre').mod
    });
});
