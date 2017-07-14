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
    /*         FIN CHAT ROOM           */
    /***********************************/


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
