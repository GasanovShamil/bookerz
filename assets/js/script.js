function getInfoUser(idUser){
    var url = base_url + 'user/getInfoUser';
    $.ajax({
        type  : 'POST',
        url   : url,
        dataType : 'json',
        data : {id:idUser},
        cache: false,
        success: function(data) {
            $("#lastname").val(data[0].last_name);
            $("#firstname").val(data[0].first_name);
            $("#email").val(data[0].email);
            $("#phone").val(data[0].phone);
        }, error: function(ts) {
            console.log("error");
            console.log(ts.responseText);
        }
    });
}
function updateInfoUser(idUser) {
    var url = base_url + 'user/updateInfoUser';
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {id: idUser, lastname: $("#lastname").val(), firstname: $("#firstname").val(), phone: $("#phone").val()},
        cache: false,
        success: function (data) {
            if(data == "success"){
                $("#myModalInfo").modal("hide");
                $.alert("Cette fenêtre se fermera dans : ", {withTime: true,type: 'success',title:'Informations modifier avec succès',icon:'glyphicon',minTop: 200});
            }else{
                console.log("no ok");
            }
        }, error: function (ts) {
            console.log("error");
            console.log(ts.responseText);
        }
    });
}

$(document).ready(function(){

    $("#formUpdatePwd").submit(function (e) {
        e.preventDefault();
        if($("#nvmdp").val().length < 8 || $("#nvmdp1").val().length < 8){
            $("#verifPass").html("<p class='bg-danger'>Les mots de passe doivent avoir 8 caractères minimum.</p>");
        }else{
            if($("#nvmdp").val() != $("#nvmdp1").val()){
                $("#verifPass").html("<p class='bg-danger'>Les nouveaux mot de passe se correspondent pas.</p>");
            }else{
                var url = base_url + 'user/updatePwd';
                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    data: {id: $("#idUser").val(), ancienmdp: $("#ancienmdp").val(), nvmdp: $("#nvmdp").val(), nvmdp1: $("#nvmdp1").val()},
                    cache: false,
                    success: function (data) {
                        if(data == "success"){
                            $("#myModalMdp").modal("hide");
                            $.alert("Cette fenêtre se fermera dans : ", {withTime: true,type: 'success',title:'Mot de passe modifier avec succès',icon:'glyphicon',minTop: 200});
                        }
                        if(data == "erreurr"){
                            $("#verifPass").html("<p class='bg-danger'>Mot de passe incorrect.</p>");
                        }
                    }, error: function (ts) {
                        console.log("error");
                        console.log(ts.responseText);
                    }
                });
            }
        }
    });

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

    $("#sendMessage").submit(function(e) {
        e.preventDefault();
    });

    function escapeHtml(text) {
        return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }

    if($(".chatroom").length) {
        var socket = io.connect( 'http://localhost:3002' );
        var room = $(".chatroom").data("room");
        var div = $(".msg-bloc");
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
                var username = escapeHtml(response.username);
                var message = escapeHtml(response.msg);
                $('.msg-bloc').append(
                    '<div class="msg-container"><div class="author-msg">'
                    +username+
                    '<div class="message">'
                    +message+
                    '</div></div></div>');

                    div.scrollTop(height);
                }
            });

            socket.on('newUser', function(response) {
                var username = escapeHtml(response.username);
                if(response.room == room) {
                    $('.msg-bloc').append(
                        '<div class="notif">'
                        +response.username+
                        ' rejoint le salon</div>'
                    );

                    div.scrollTop(height);

                    if(!$('.user_'+response.userid)[0]) {
                        $('.userList').append(
                            '<div class="user_'
                            +response.userid+
                            '"><div class="userL">'
                            +username+
                            '<span class="fa fa-chevron-right"></span><span class="fa fa-chevron-right"></span></div></div>'
                        );
                    }
                }
            });

            socket.on('leave', function(response) {
                var username = escapeHtml(response.username);
                if(response.room == room) {
                    $('.msg-bloc').append(
                        '<div class="notif">'
                        +username+
                        ' est deconnecté</div>'
                    );

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


    var ch = false;
    $("#myModalAddBook").click(function () {
       $("#myModalAddBookView").modal("show");
        var url = base_url + 'book/getAllBook';
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            cache: false,
            success: function (data) {
                if(ch == false){
                    ch = true;
                    var table = $('#table-book').DataTable({
                        "ajax": {
                            "url": url,
                            "dataSrc": "data"
                        },
                        "columns": [
                            { "data": "title" },
                            { "data": "author" },
                            { "data": "ISBN13" }
                        ],
                        'columnDefs': [{
                            'targets': 3,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-body-center',
                            'render': function (data, id){
                                console.log(data);
                                console.log(id);
                                return "<button>Ajouter</button>";
                            }
                        }],
                        autoFill: true,
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

                    $('#table-book tbody').on( 'click', 'button', function () {
                        var data = table.row( $(this).parents('tr') ).data();
                        var urladd = base_url + 'book/addBookToUser';
                        console.log("iduser :"+data.id);
                        $.ajax({
                            type: 'POST',
                            url: urladd,
                            dataType: 'json',
                            data: {id: data.id},
                            cache: false,
                            success: function (data) {
                                /*if(data == "success"){
                                    $("#myModalInfo").modal("hide");
                                    $.alert("Cette fenêtre se fermera dans : ", {withTime: true,type: 'success',title:'Informations modifier avec succès',icon:'glyphicon',minTop: 200});
                                }else{
                                    console.log("no ok");
                                }*/
                            }, error: function (ts) {
                                console.log("error");
                                console.log(ts.responseText);
                            }
                        });
                    } );
                }
                /*if(data == "success"){
                    $("#myModalInfo").modal("hide");
                    $.alert("Cette fenêtre se fermera dans : ", {withTime: true,type: 'success',title:'Informations modifier avec succès',icon:'glyphicon',minTop: 200});
                }else{
                    console.log("no ok");
                }*/
            }, error: function (ts) {
                console.log("error");
                console.log(ts.responseText);
            }
        });
    });

});
