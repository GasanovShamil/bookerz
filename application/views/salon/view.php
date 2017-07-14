<style media="screen">
    footer {
        display: none;
    }
</style>
</div> <!-- /container -->
<div class="loading">
    <p>Connexion au salon</p>
    <div class="lds-spinner" style="100%;height:100%">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<div class="chatroom" data-username="<?php echo $_SESSION['email']; ?>" data-room="<?php echo $id_salon; ?>">
    <div class="sidebar">
        <div class="invite">
            Inviter un ami <span class="fa fa-plus"></span>
        </div>

        <div class="userList">
            <?php if (isset($usersIn) && !empty($usersIn)): ?>
                <?php foreach ($usersIn as $user): ?>

                    <div class="user_<?php echo $user[0]->getId(); ?>">
                        <div class="userL">
                            <?php echo $user[1] . " " . $user[2]; ?>
                            <span class="fa fa-chevron-right"></span><span class="fa fa-chevron-right"></span>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="nbViewer">
            <span id="nbUsers"> <!-- A faire en JS --> </span>connectés
        </div>

    </div>

    <div class="msg-bloc">

        <?php
        if(isset($messages)){ ?>

            <?php foreach ($messages as $message) { ?>

                <div class="msg-container">
                    <div class="author-msg">
                        <?php echo $message['first_name']; ?>
                        <div class="message">
                            <?php echo htmlspecialchars($message['message']); ?>
                        </div>
                    </div>
                </div>

            <?php } ?>

        <?php } ?>

    </div>
    <form method="post" id="sendMessage">
        <input type="text" class="chatInput" id="chatInput" placeholder="Envoyer un message..." data-room="<?php echo $id_salon; ?>" data-username="<?php echo $_SESSION['email']; ?>" data-userid="<?php echo $_SESSION['user_id']; ?>">
    </form>

</div>
