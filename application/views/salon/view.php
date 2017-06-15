<style media="screen">
    .chatArea {
        width: 100%;
        height: 600px;
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

    .content {
        padding: 6px 0 5px 7px;
        background-color: rgba(128, 128, 128, 0.42);
        margin: 5px 0 0 0;
        min-width: 100px;
        max-width: 700px;
        border-radius: 20px;
    }

    .author {
        font-size: 12px;
        font-style: italic;
    }
</style>
<h2>Salon de chat</h2> <?php if(isset($book[0])) {echo $book[0]['title'];} ?>


<br><br><br>
<div class="chatArea" data-username="<?php echo $_SESSION['email']; ?>" data-room="<?php echo $id_salon; ?>">
    <?php
    if(isset($messages)){
        foreach ($messages as $message) {
            ?>
            <div class="content">
                <?php echo $message['message']; ?>
                <div class="author">
                    <?php echo $message['first_name'] ?>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
<form method="post" id="sendMessage">
    <?php
    if(isset($_SESSION['email'])) {
        ?>
            <input type="text" id="message" class="message" data-room="<?php echo $id_salon; ?>" data-username="<?php echo $_SESSION['email']; ?>" data-userid="<?php echo $_SESSION['user_id']; ?>">
        <?php
    }
    ?>
    <button type="submit">Envoyer</button>
</form>
<div class="error">

</div>
