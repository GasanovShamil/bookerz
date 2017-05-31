<style media="screen">
    .chatArea {
        width: 100%;
        min-height: 600px;
        padding: 10px 10px;
        border: 1px solid grey;
        border-radius: 4px;
        background-color: #FCFAFA;
        overflow-y: scroll;
    }

    .message {
        width: 90%;
        border-radius: 4px;
        padding: 5px 5px;
    }

    #sendMessgae {
        width: 10%;
    }
</style>
<h2>Salon de chat</h2> <?php echo $book['title']; ?>


<br><br><br>

<div class="chatArea">

</div>
<input type="text" id="message" class="message">
<button type="button" id="sendMessage">Envoyer</button>
