$(document).ready(function(){

    $("#myBtnMdp").click(function(){
        $("#myModalMdp").modal();
    });
    $("#myBtnInfo").click(function(){
        $("#myModalInfo").modal();
    });

    $("#addSalon").click(function(e) {
        $("#addSalonModal").slideToggle(800);
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
        var userid = $("#chatInput").data("userid");

        $('.loading').show();
        $.ajax({
            type : 'POST',
            url : base_url + 'salon/userState',
            dataType : 'json',
            data: {userid: userid, room: room, state: 'new'},
            cache: false,
            complete: function() {
                setTimeout(function() {
                    $('.loading').hide();
                }, 500);
            }
        });

        div.scrollTop(height);

        socket.emit('newUser', {username: username, room: room, userid: userid} );

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
                    if(!$('li.user_'+response.userid)[0]) {
                        $('ul#participant').append('<li class="user_'+response.userid+'"><span>'+response.username+'</span><div><a>signaler</a> | <a>Contacter</a></div></li>');
                    }
                }
            });

            socket.on('leave', function(response) {
                if(response.room == room) {
                    $('.chat-ul').append('<div class="notif">'+response.username+' est deconnecté</div>');
                    var userDiv = ".user_"+response.userid;
                    $(userDiv).fadeOut(200);

                    div.scrollTop(height);

                    $.ajax({
                        type: 'POST',
                        url: base_url + 'salon/userState',
                        dataType: 'json',
                        data: {userid: response.userid, room: response.room, state: 'left'},
                        cache: false
                    });
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

        $('#admin-liste-salon').DataTable({
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

        $(".close").mouseup(function() {
            $(".modalFade").fadeOut(300);
        })

        $(document).mouseup(function(e) {
            var container = $(".modal-content");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $('.modalFade').fadeOut(300);
            }
        });


        $(".modalNote").click(function(e){
            var idBook  = $(".modalNote").attr('id');
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: base_url + "book_note/check",
                data: {id_book: idBook},
                success: function(data)
                {
                    if(data === "success") {
                        $.get( base_url + "salon/chatroomToSelect/"+idBook, function( data ) {
                            redirectToChat(data);
                        });
                    } else {
                        window.location.replace(base_url + "salon");
                    }
                }
            });

            // Récupération des infos du livre
            $.getJSON( base_url + "book/getJsonBook?id="+idBook, function( data ) {
                $('#title').html("Titre : "+data.title);
                $('#author').html("Auteur : "+data.author);
            });

            $(".modalFade").fadeIn(300);

            $("#gradeSubmit").click(function() {
                var grade = $('input[name=rating]:checked').val();

                if(grade > 0 && grade < 5) {
                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        url: base_url + "book_note/giveGrade",
                        data: {id_book: idBook, grade: grade},
                        success: function(data)
                        {
                            $.get( base_url + "salon/chatroomToSelect/"+idBook, function( data ) {
                                redirectToChat(data);
                            });
                        }
                    });
                }
            });
        });

        function redirectToChat(data)
        {
            var id = data.replace(/['"]+/g, '');
            id = id.replace(/\s/g, '');
            window.location.replace(base_url + "salon/view/" + id);
        }


    });
