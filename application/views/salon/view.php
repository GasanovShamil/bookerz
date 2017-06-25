<style type="text/css">
    #salon {
        margin-bottom: 100px;
    }
    .emojionearea .emojionearea-picker {
        height: 200px;
    }
    .emojionearea .emojionearea-picker .emojionearea-wrapper {
        height: 200px;
    }
    .emojionearea .emojionearea-picker .emojionearea-scroll-area {
        120px;
    }
    .chat-ul {
        padding: 0;
    }
</style>


<h2>Salon de chat</h2> <?php if(isset($book[0])) {echo $book[0]['title'];} ?>

<div class="contain">
    <div class="row row-offcanvas row-offcanvas-right" id="salon">
        <div class="col-md-12">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <div class="col-md-12">
                <h1 class="titre-accueil text-center">Salon: <?php if(isset($book[0])) {echo $book[0]['title'];} ?></h1>
            </div>

        </div>
        <div class="col-md-7 ">
            <div class="col-md-12 bloc-message" data-username="<?php echo $_SESSION['email']; ?>" data-room="<?php echo $id_salon; ?>">
                <p>Message</p>
                <div class="col-md-12 scrollspy-example" data-spy="scroll" data-target="#navbar-example2" data-offset="0">
                    <div class="clearfix">
                        <div class="chat">
                            <div class="chat-history">
                                <?php
                                if(isset($messages)){ ?>
                                    <ul class="chat-ul">
                                        <?php foreach ($messages as $message) { ?>
                                            <li>
                                                <div class="message-data">
                                                    <span class="message-data-name"><i class="fa fa-circle you"></i><?php echo $message['first_name']; ?></span>
                                                </div>
                                                <div class="message you-message">
                                                    <?php echo htmlspecialchars($message['message']); ?>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div> <!-- end chat-history -->

                        </div> <!-- end chat -->
                    </div>
                </div>
            </div>

            <div class="col-md-12" id="chat-box">
                <form method="post" id="sendMessage">
                    <input type="text" id="chatInput" placeholder="Envoyer un message" data-room="<?php echo $id_salon; ?>" data-username="<?php echo $_SESSION['email']; ?>" data-userid="<?php echo $_SESSION['user_id']; ?>">

                    <input type="submit" class="btn btn-info pull-right" value="Envoyer">
                </form>
            </div>
        </div>

        <div class="col-md-5" id="liste-participant">
            <!-- menu flotant-->
            <div class="col-md-12 bloc-message">
                <p>Liste des participants</p>
                <div class="col-md-12 scrollspy-example" data-spy="scroll" data-target="#navbar-example2" data-offset="0">
                    <ul id="participant">
                        <!-- participant added in JS -->
                    </ul>
                </div>
            </div><!--/.sidebar-offcanvas-->
            <div class="pull-right">
                <p id="bt-list-participant">Inviter un contact<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                </p>
            </div>
        </div>
    </div><!--/row-->
</div>


<div class="error">

</div>
