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
function addPropositionBook(id){
    var monelementauthor = document.getElementById('author'+id);
    var monelementlinkimg = document.getElementById('linkImg'+id);
    var monelementtitle = document.getElementById('title'+id);
    var monelementisbn13 = document.getElementById('isbn13'+id);
    var monelementisbn10 = document.getElementById('isbn10'+id);
    var monelementdescription = document.getElementById('description'+id);
    var monelementpublished = document.getElementById('published'+id);
    var monelementeditor = document.getElementById('editor'+id);
    console.log(monelementauthor.dataset.author);
    console.log(monelementlinkimg.dataset.link);
    console.log(monelementtitle.dataset.title);
    console.log(monelementisbn10.dataset.isbn10);
    console.log(monelementdescription.dataset.description);
    console.log(monelementpublished.dataset.published);
    console.log(monelementeditor.dataset.editor);
    var url = base_url + 'book/addPropositionUser';
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {author: monelementauthor.dataset.author, linkimg: monelementlinkimg.dataset.link, title: monelementtitle.dataset.title, isbn13: monelementisbn13.dataset.isbn13, isbn10: monelementisbn10.dataset.isbn10, description: monelementdescription.dataset.description, published: monelementpublished.dataset.published, editor: monelementeditor.dataset.editor},
        cache: false,
        success: function (data) {
            console.log(data);
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
}
function addBookUser(idBook) {
    var urladd = base_url + 'book/addBookToUser';
    console.log("iduser :"+idBook);
    $.ajax({
        type: 'POST',
        url: urladd,
        dataType: 'json',
        data: {id: idBook},
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
        //url: "https://www.googleapis.com/books/v1/volumes?q="+q+"&maxResults=1&startIndex="+searchID,
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
                                //+ "<p>"+resum+"</p></div>"
                                + ""
                                + "</div>";

                           /* <p>Renovations</p>
                            <p></p>
                            </div><!--/panel-->
                            </div>" +
                            "" +
                            "<h2>" + "Titre: " + title + "</h2>"
                            + "<h3>" + author + "</h3>"
                            + "<img src =\"" + linkImg + "\">"
                            + "<p>"  + resum + "</p>"
                            // + "<p>"  + data.items[i].volumeInfo.industryIdentifiers + "</p>"
                            + "</br></br>"*/
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
                        //startPage: pagec,
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
                            'render': function (data, id, value){
                                return "<a onclick='addBookUser("+value.id+")'><span class='glyphicon glyphicon-plus'></span></a>";
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
