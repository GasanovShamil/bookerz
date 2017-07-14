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
                        <div class="userL" data-user="<?php echo $user[0]->getId(); ?>">
                            <?php echo ucfirst($user[1]); ?> <span class="fa fa-chevron-right"></span><span class="fa fa-chevron-right"></span>
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
        <input type="text" class="chatInput" id="chatInput" placeholder="Envoyer un message..." data-room="<?php echo $id_salon; ?>" data-username="<?php echo $_SESSION['first_name']; ?>" data-userid="<?php echo $_SESSION['user_id']; ?>">
    </form>

    <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Signaler
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <p></p>
                </div>
                <div class="modal-body">
                    Pour quelle(s) raison(s) voulez-vous signaler cet utilisateur ?
                    <textarea id="reason" rows="2" cols="50"></textarea>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger" id="confirmReport">Envoyer</a>
                </div>
            </div>
        </div>
    </div>
</div>
