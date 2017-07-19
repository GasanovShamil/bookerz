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
                $('#status-message').css('background-color', 'rgba(63, 191, 63, .80)');
                $('#status-message').flash_message({
                    text: 'Vos informations de profil ont été modifiées!',
                    how: 'append'
                });
            }else{
                $('#status-message').css('background-color', 'rgba(237, 2, 2, .80)');
                $('#status-message').flash_message({
                    text: 'Une erreur s\'est produite. Veillez ressayer!',
                    how: 'append'
                });
            }
        }, error: function (ts) {
            console.log("error");
            console.log(ts.responseText);
        }
    });
}
function addPropositionBook(id){
    var monelementauthor = document.getElementById('author'+id);
    var monelementlinkimg = document.getElementById('linkImg'+id);
    var monelementtitle = document.getElementById('title'+id);
    var monelementisbn13 = document.getElementById('isbn13'+id);
    var monelementisbn10 = document.getElementById('isbn10'+id);
    var monelementdescription = document.getElementById('description'+id);
    var monelementpublished = document.getElementById('published'+id);
    var monelementeditor = document.getElementById('editor'+id);
    var url = base_url + 'book/addPropositionUser';
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {author: monelementauthor.dataset.author, linkimg: monelementlinkimg.dataset.link, title: monelementtitle.dataset.title, isbn13: monelementisbn13.dataset.isbn13, isbn10: monelementisbn10.dataset.isbn10, description: monelementdescription.dataset.description, published: monelementpublished.dataset.published, editor: monelementeditor.dataset.editor},
        cache: false,
        success: function (data) {
            if (data === Object(data)){
                var noBook = document.getElementById("no-book-suggest");
                if (noBook != null) {
                    noBook.remove();
                }
                $("#suggest-book").append("<article class='col-lg-3 col-md-4 col-sm-4 col-xs-6 min-height-bloc-img'>"
                    + "<div class='thumb-pad2 maxheight1'><div class='box_inner'>"
                    + "<div class='thumbnail'>"
                    + "<figure><a href='#'><img class='max-height-img' src='"+data.cover+"' alt='''></a></figure>"
                    + "<div class='caption'>"
                    + "<a href='#'>"+data.title+"</a>"
                    +" <p class='title' title='"+data.author+"'>de "+data.author+"<br></p>"
                    +" </div>"
                    + "</div>"
                    + "</div>"
                    + "</article>");
                $("#myModalAddBookAPI").modal("hide");
                $('#status-message').css('background-color', 'rgba(63, 191, 63, .80)');
                $('#status-message').flash_message({
                    text: 'Le livre a bien été ajouté!',
                    how: 'append'
                });
            }else if (data == "existe"){
                $('#status-message').css('background-color', 'rgba(237, 2, 2, .80)');
                $('#status-message').flash_message({
                    text: 'Ce livre existe déjà!',
                    how: 'append'
                });
            }else{
                $('#status-message').css('background-color', 'rgba(237, 2, 2, .80)');
                $('#status-message').flash_message({
                    text: 'Une erreur s\'est produite. Veillez ressayer!',
                    how: 'append'
                });
            }
        }, error: function (ts) {
            console.log("error");
            console.log(ts.responseText);
        }
    });
}
function addBookUser(idBook) {
    var urladd = base_url + 'book/addBookToUser';
    $.ajax({
        type: 'POST',
        url: urladd,
        dataType: 'json',
        data: {id: idBook},
        cache: false,
        success: function (data) {
            if(data === Object(data)){
                var noBook = document.getElementById("no-book");
                if (noBook != null) {
                    noBook.remove();
                }
                $("#book-user").after("<article class='col-lg-3 col-md-4 col-sm-4 col-xs-6 min-height-bloc-img'>"
                    + "<div class='thumb-pad2 maxheight1'><div class='box_inner'>"
                    + "<div class='thumbnail'>"
                    + "<figure><a href='#'><img class='max-height-img' src='" + data.cover + "' alt='''></a></figure>"
                    + "<div class='caption'>"
                    + "<a href='#'>" + data.title + "</a>"
                    + " <p class='title' title='" + data.author + "'>de " + data.author + "<br></p>"
                    + " </div>"
                    + "</div>"
                    + "</div>"
                    + "</article>");
                $("#myModalAddBookView").modal("hide");
                $('#status-message').css('background-color', 'rgba(63, 191, 63, .80)');
                $('#status-message').flash_message({
                    text: 'Le livre a bien été ajouté!',
                    how: 'append'
                });
            }
            if(data == "bookexiste"){
                $('#status-message').css('background-color', 'rgba(63, 191, 63, .80)');
                $('#status-message').flash_message({
                    text: 'Vous disposez déjà ce livre!',
                    how: 'append'
                });
            }
            if(data == "erroraddbook"){
                $('#status-message').css('background-color', 'rgba(237, 2, 2, .80)');
                $('#status-message').flash_message({
                    text: 'Une erreur s\'est produite. Veillez ressayer!',
                    how: 'append'
                });
            }
        }, error: function (ts) {
            console.log("error");
            console.log(ts.responseText);
        }
    });
}

function searchBookApi(pagec){
    console.log("page courant: "+pagec);
    var q = null;
    var startIndex = 0;
    var valide = true;

    var searchByTitle = $("#title-book").val();
    document.getElementById('results').innerHTML = "";

    var searchByISBN = $("#isbn-book").val();

    if (searchByTitle != ""){
        q = searchByTitle;
    }else if (searchByISBN != ""){
        q = "isbn:" + searchByISBN;
    }

    $.ajax({
        url: "https://www.googleapis.com/books/v1/volumes?q="+q+"&maxResults=10&startIndex="+pagec,
        dataType: "json",

        success: function(data){
            console.log(data.totalItems);
            if (data.totalItems == 0){
                results.innerHTML += "<h2 class='text-center'>Pas de résultat</h2>"
            }else if (data.totalItems == 1){
                results.innerHTML += "<h2>" + "Titre: " + data.volumeInfo.title + "</h2>"
                    + "<h3>" + data.volumeInfo.authors + "</h3>"
                    + "<img src =\"" + data.volumeInfo.imageLinks.thumbnail + "\">"
                    + "<p>"  + data.volumeInfo.description + "</p>"
                    // + "<p>"  + data.items[i].volumeInfo.industryIdentifiers + "</p>"
                    + "</br></br>"
            }else{
                results.innerHTML += "<div class='row'>";
                for(i = 0; i < data.items.length; i++){
                    if (data.items[i].volumeInfo.imageLinks && data.items[i].volumeInfo.imageLinks.thumbnail != undefined &&
                        $.isArray(data.items[i].volumeInfo.industryIdentifiers) && data.items[i].volumeInfo.industryIdentifiers.length > 0 &&
                        data.items[i].volumeInfo.title && data.items[i].volumeInfo.title != undefined && data.items[i].volumeInfo.authors && data.items[i].volumeInfo.authors
                        != undefined && data.items[i].volumeInfo.industryIdentifiers[0] && data.items[i].volumeInfo.industryIdentifiers[0].identifier != undefined &&
                        data.items[i].volumeInfo.industryIdentifiers[1] && data.items[i].volumeInfo.industryIdentifiers[1].identifier !=
                        undefined && data.items[i].volumeInfo.description && data.items[i].volumeInfo.description != undefined && data.items[i].volumeInfo.publishedDate &&
                        data.items[i].volumeInfo.publishedDate != undefined && data.items[i].volumeInfo.publisher && data.items[i].volumeInfo.publisher != undefined) {

                        results.innerHTML += "<div class='col-md-12 list-book'>"
                                + "<div class='col-md-3'><a>"
                                + "<img id='linkImg"+i+"' data-link='"+data.items[i].volumeInfo.imageLinks.thumbnail+"' src='"+ data.items[i].volumeInfo.imageLinks.thumbnail +"' class='img-responsive'></a></div>"
                                + "<div class='col-md-7'><h3 id='title"+i+"' data-title='"+data.items[i].volumeInfo.title+"'>Titre : "+data.items[i].volumeInfo.title+"</h3>"
                                + "<h5 id='author"+i+"' data-author='"+data.items[i].volumeInfo.authors+"'>Auteur : "+data.items[i].volumeInfo.authors+"</h5>"
                                + "<h5 id='isbn13"+i+"' data-isbn13='"+data.items[i].volumeInfo.industryIdentifiers[0].identifier+"'>ISBN13 : "+data.items[i].volumeInfo.industryIdentifiers[0].identifier+"</h5>"
                                + "<h5 id='isbn10"+i+"' data-isbn10='"+data.items[i].volumeInfo.industryIdentifiers[1].identifier+"'>ISBN10 : "+data.items[i].volumeInfo.industryIdentifiers[1].identifier+"</h5>"
                                + "<div style='display: none' id='description"+i+"' data-description='"+data.items[i].volumeInfo.description+"'></div>"
                                + "<div style='display: none' id='published"+i+"' data-published='"+data.items[i].volumeInfo.publishedDate+"'></div>"
                                + "<div style='display: none' id='editor"+i+"' data-editor='"+data.items[i].volumeInfo.publisher+"'></div>"
                                + "<a onclick='addPropositionBook("+i+")' class='btn btnajoutlivre'>Ajouter</a>"
                                + "</div>";
                    }
                }
                results.innerHTML += "</div>";
                console.log("nombre de pagination totale "+Math.ceil(data.totalItems/10));
                console.log("page courante "+pagec);
                if (pagec == Math.ceil(data.totalItems/10)){
                    pagec = (Math.ceil(data.totalItems/10)) - 1;
                }
                if (document.getElementById("pagination-demo") == null){
                    results.innerHTML += "<ul id='pagination-demo' class='pagination-sm'></ul>";
                    $('#pagination-demo').twbsPagination({
                        totalPages: Math.ceil(data.totalItems/10),
                        visiblePages: 7,
                        startPage: pagec,
                        first: "Premier",
                        prev: "Précedent",
                        next: "Suivant",
                        last: "Dernier",
                    }).on('page', function (evt, page) {
                        searchBookApi(page);
                    });
                }
            }
        }
        //type: 'GET'
    });
}

$(document).ready(function(){


    $(".details-book").click(function () {
        var id = $(this).data("idbook");
        var url = base_url + 'book/getDetailsBook';
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {id: id},
            cache: false,
            success: function (data) {
                if (data === Object(data)){
                    console.log(data[0]);
                    var title = document.getElementById('title-details');
                    var author = document.getElementById('author-details');
                    var resum = document.getElementById('resum-details');
                    var status = document.getElementById('status-details');
                    title.innerHTML = data[0].title;
                    author.innerHTML = data[0].author;
                    resum.innerHTML = data[0].description;
                    status.innerHTML = data[0].libelle;
                    $("#modal-details-book img").attr("src", data[0].cover)
                    $("#modal-details-book").modal("show");

                    $( ".select-status" ).change(function () {
                        var idstatus = $(this).val();
                        var url = base_url + 'book/updateStatus';
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {idStatus: idstatus, idBook:id},
                            cache: false,
                            success: function (data) {
                                console.log(data);
                                if(data){
                                    $('#status-message').css('background-color', 'rgba(63, 191, 63, .80)');
                                    $('#status-message').flash_message({
                                        text: 'Statut changé!',
                                        how: 'append'
                                    });
                                    $("#modal-details-book").modal("hide");
                                }else{
                                    $('#status-message').css('background-color', 'rgba(237, 2, 2, .80)');
                                    $('#status-message').flash_message({
                                        text: 'Une erreur s\'est produite. Veillez ressayer!',
                                        how: 'append'
                                    });
                                }
                            }, error: function (ts) {
                                console.log("error");
                                console.log(ts.responseText);
                            }
                        });
                    });
                }else{
                    $('#status-message').css('background-color', 'rgba(237, 2, 2, .80)');
                    $('#status-message').flash_message({
                        text: 'Une erreur s\'est produite. Veillez ressayer!',
                        how: 'append'
                    });
                }
            }, error: function (ts) {
                console.log("error");
                console.log(ts.responseText);
            }
        });
    });

    
    
    $(".details-book-content").click(function () {
        var id = $(this).data("idbook");
        var url = base_url + 'book/getDetailsBook2';
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {id: id},
            cache: false,
            success: function (data) {
                if (data === Object(data)){
                    console.log(data[0]);
                    var title = document.getElementById('title-details');
                    var author = document.getElementById('author-details');
                    var resum = document.getElementById('resum-details');
                   
                    title.innerHTML = data[0].title;
                    author.innerHTML = data[0].author;
                    resum.innerHTML = data[0].description;
                  
                    $("#modal-details-book img").attr("src", data[0].cover)
                    $("#modal-details-book").modal("show");

                  
                }else{
                    $('#status-message').css('background-color', 'rgba(237, 2, 2, .80)');
                    $('#status-message').flash_message({
                        text: 'Une erreur s\'est produite. Veillez ressayer!',
                        how: 'append'
                    });
                }
            }, error: function (ts) {
                console.log("error");
                console.log(ts.responseText);
            }
        });
    });
    
    /*message flash*/
    (function($) {
        $.fn.flash_message = function(options) {

            options = $.extend({
                text: 'Done',
                time: 2000,
                how: 'before',
                class_name: ''
            }, options);

            return $(this).each(function() {
                if( $(this).parent().find('.flash_message').get(0) )
                    return;

                var message = $('<span />', {
                    'class': 'flash_message ' + options.class_name,
                    text: options.text
                }).hide().fadeIn('fast');

                $(this)[options.how](message);

                message.delay(options.time).fadeOut('2000', function() {
                    $(this).remove();
                });

            });
        };
    })(jQuery);


    $("#myModalContactAdminBt").click(function () {
        $("#myModalContactAdmin").modal("show");
    });

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

    function jsUcfirst(string)
    {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function redirectToChat(data)
    {
        var id = data.replace(/['"]+/g, '');
        id = id.replace(/\s/g, '');
        window.location.replace(base_url + "salon/view/" + id);
    }

    function countUser(count)
    {
        var divCountVal = $(".cc").length;
        var divCount = $("#nbUsers");
        divCount.html(divCountVal);
        console.log(divCountVal);
    }

    if($(".chatroom").length) {
        var socket = io.connect( 'http://localhost:3002' );
        var room = $(".chatroom").data("room");
        var div = $(".msg-bloc");
        var height = div[0].scrollHeight;
        var username = $("#chatInput").data("username");
        var userid = $("#chatInput").data("userid");
        var id_salon_parent = $(".chatroom").data("idsalonparent");

        $('.loading').show();
        countUser();

        if(!$('.user_'+userid)[0]) {
            $('.userList').append(
                '<div class="user_'
                +userid+
                '"><div class="userL" data-user="'+userid+'">'
                +jsUcfirst(username)+
                '<span class="fa fa-chevron-right"></span><span class="fa fa-chevron-right"></span></div></div>'
            );
        }

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
                        +jsUcfirst(response.username)+
                        ' rejoint le salon</div>'
                    );

                    div.scrollTop(height);

                    if(!$('.user_'+response.userid)[0]) {
                        $('.userList').append(
                            '<div class="user_'
                            +response.userid+
                            '"><div class="userL" data-user="'+response.userid+'">'
                            +jsUcfirst(username)+
                            '<span class="fa fa-chevron-right"></span><span class="fa fa-chevron-right"></span></div></div>'
                        );
                    }
                    countUser();
                }
            });

            socket.on('leave', function(response) {
                var username = escapeHtml(response.username);
                if(response.room == room) {
                    $('.msg-bloc').append(
                        '<div class="notif">'
                        +jsUcfirst(username)+
                        ' est deconnecté</div>'
                    );

                    var userDiv = ".user_"+response.userid;
                    $(userDiv).remove();

                    div.scrollTop(height);

                    $.ajax({
                        type: 'POST',
                        url: base_url + 'salon/userState',
                        dataType: 'json',
                        data: {userid: response.userid, room: response.room, state: 'left'},
                        cache: false
                    });
                }
                countUser(0);
            });

            socket.on('checkReport', function() {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'salon/checkBan',
                    dataType: 'json',
                    data: {id_salon_parent: id_salon_parent},
                    cache: false,
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'success') {
                            $('#alert-modal .modal-header p').html('Exclus du salon');
                            $('#alert-modal .modal-body').html('Vous avez été exclus du salon suite à votre comportement. Vous allez être redirigé');
                            $('#alert-modal').modal('show');
                            setTimeout( function(){
                                window.location.replace(base_url + "salon/");
                            }  , 3000 );
                        }
                    }
                });
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
                $('.msg-bloc').append(
                    '<div class="msg-container"><div class="author-msg">'
                    +username+
                    '<div class="message">'
                    +message+
                    '</div></div></div>');


                div.scrollTop(height);
            }
        });

        $('.userL').click(function() {
            var userHit = $(this).data('user');
            if(userid != userHit) {
                $.ajax({
                    type : 'POST',
                    url : base_url + 'salon/checkReport',
                    dataType : 'json',
                    data : {id_user_reported: userHit, id_salon: room},
                    cache : false,
                    success: function(data){
                        if( data.status == 'error' ) {
                            // error handling, show data.message or what you want.
                            $('#confirm-modal').modal('show');
                        } else {
                            // same as above but with success
                            $('#alert-modal .modal-header p').html('Signaler');
                            $('#alert-modal .modal-body').html('Vous avez déjà signalé cet utilisateur dans ce salon.');
                            $('#alert-modal').modal('show');
                        }
                    }
                });

                $('#confirmReport').click(function() {
                    var reason = $('#reason').val();
                    if($.trim(reason)) {
                        $.ajax({
                            type : 'POST',
                            url : base_url + 'salon/addReport',
                            dataType : 'json',
                            data : {id_user_reported: userHit, id_salon: room, reason: reason},
                            cache: false,
                            success: function(data) {
                                socket.emit('report');
                                $('#confirm-modal').modal('hide');
                                $('#alert-modal .modal-header p').html('Signaler');
                                $('#alert-modal .modal-body').html('Nous avons bien reçu votre signalement.');
                                $('#alert-modal').modal('show');
                            }, error: function() {
                                $('#confirm-modal').modal('hide');
                                $('#alert-modal .modal-header p').html('Signaler');
                                $('#alert-modal .modal-body').html('Vous avez déjà signalé cet utilisateur');
                                $('#alert-modal').modal('show');
                            }
                        });
                    } else {

                    }
                });
            }
        });

        $('.invite').click(function() {
            $('#invit-modal').modal('show');
        });

        $('#confirmInvit').click(function() {
            var email = $('#guest').val();
            var url = Math.floor((Math.random() * 100000000000) + 1);
            $.ajax({
                type: 'POST',
                url: base_url+"salon/newInvitation",
                dataType:'json',
                data: {email: email, url: url, room: room},
                success: function(data) {
                    if(data.status == 'success') {
                        $('#invite-modal').modal('hide');
                        $('#alert-modal .modal-header p').html('Invitation envoyé');
                        $('#alert-modal .modal-body').html('L\'invitation a bien été envoyé');
                        $('#alert-modal').modal('show');
                    } else {
                        $('#invite-modal').modal('hide');
                        $('#alert-modal .modal-header p').html('Erreur');
                        $('#alert-modal .modal-body').html('Une erreur a eu lieu, merci de réessayer ultérieurement.');
                        $('#alert-modal').modal('show');
                    }
                }
            })

        })

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
                        var id_salon_to_send = $('.modalNote').attr('id');
                        $.ajax({
                            type: 'POST',
                            url: base_url + 'salon/checkBan',
                            dataType: 'json',
                            data: {id_salon_parent: id_salon_to_send},
                            cache: false,
                            success: function(data) {
                                console.log(data);
                                if(data.status == 'success') {
                                    $('#alert-modal .modal-header p').html('Exclus du salon');
                                    $('#alert-modal .modal-body').html('Vous avez été exclus du salon suite à votre comportement. Vous ne pouvez pas y retourner');
                                    $('#alert-modal').modal('show');
                                } else {
                                    $.get( base_url + "salon/chatroomToSelect/"+idBook, function( data ) {
                                        redirectToChat(data);
                                    });
                                }
                            }
                        });
                    } else { 
                        $(".modalFade").fadeIn(300);
                    }
                }
            });

            // Récupération des infos du livre
            $.getJSON( base_url + "book/getJsonBook?id="+idBook, function( data ) {
                $('#title').html("Titre : "+data.title);
                $('#author').html("Auteur : "+data.author);
            });

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
                            {"data": "title"},
                            {"data": "author"},
                            {"data": "ISBN13"}
                        ],
                        'columnDefs': [{
                            'targets': 3,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-body-center',
                            'render': function (data, id, value) {
                                return "<a onclick='addBookUser(" + value.id + ")'><span class='glyphicon glyphicon-plus'></span></a>";
                            }
                        }],
                        autoFill: true,
                        "language": {
                            "sProcessing": "Traitement en cours...",
                            "sSearch": "Rechercher&nbsp;:",
                            "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments par page",
                            "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                            "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                            "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                            "sInfoPostFix": "",
                            "sLoadingRecords": "Chargement en cours...",
                            "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                            "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                            "oPaginate": {
                                "sFirst": "Premier",
                                "sPrevious": "Pr&eacute;c&eacute;dent",
                                "sNext": "Suivant",
                                "sLast": "Dernier"
                            },
                            "columns": [
                                {"data": "title"},
                                {"data": "author"},
                                {"data": "ISBN13"}
                            ],
                            'columnDefs': [{
                                'targets': 3,
                                'searchable': false,
                                'orderable': false,
                                'className': 'dt-body-center',
                                'render': function (data, id) {
                                    console.log(data);
                                    console.log(id);
                                    return "<button>Ajouter</button>";
                                }
                            }]
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


    $("#modal-book-api").click(function () {
        $("#myModalAddBookAPI").modal("show");
    });



});
