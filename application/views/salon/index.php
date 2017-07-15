<div class="contain">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-md-12">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <div class="col-md-12">
                <h1 class="titre-accueil text-center">Salon</h1>
            </div>
        </div>
            <table id="liste-salon" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Salon</th>
                        <th>Livre</th>
                        <th>Date d'ouverture</th>
                        <th>Date de fin</th>
                        <th>Rejoindre</th>
                    </tr>
                </thead>

                <?php if (empty($rooms)): ?>
                    Aucun salon de chat n'est disponible pour le moment
                <?php else: ?>
                    <tbody>
                    <?php foreach ($rooms as $room): ?>
                        <?php
                        $infoRoom = $room[0];
                        $book = $room[1];
                        ?>
                            <tr>
                                <td><?php echo $infoRoom->getName(); ?></td>
                                <td><?php echo $book->getTitle(); ?></td>
                                <td><?php echo $infoRoom->getStart_date(); ?></td>
                                <td><?php echo $infoRoom->getEnd_date(); ?></td>
                                <td><a id="<?php echo $book->getId(); ?>" class="modalNote">Rejoindre</a></td>
                            </tr>
                    <?php endforeach; ?>

                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div><!--/row-->
    <?php if (isset($nextRooms) && !empty($nextRooms)): ?>
        <h1>Prochain salons :</h1>
        <?php foreach ($nextRooms as $room): ?>
            <hr>
            <?php echo $room[1]->getTitle(); ?>
            <br>
            le <?php echo $room[0]->getStart_date(); ?>
        <?php endforeach; ?>
    <?php else: ?>
        <h1>Pas de prochains salons pour le moment</h1>
    <?php endif; ?>
</div>

<!-- Own modal -->
<div class="modalFade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Vous devez donner une note au livre avant d'accéder au salon</h4>
            </div>
            <div id="modal-salon" class="modal-body">
                <div>
                    <div class="col-md-12 bookInfo">
                        <span class="col-md-12 text-center" id="title">Titre : </span>
                        <span class="col-md-12 text-center" id="author">Auteur : </span>
                    </div>
                        <span class="star-rating star-4">
                            <input type="radio" name="rating" value="1"><i></i>
                            <input type="radio" name="rating" value="2"><i></i>
                            <input type="radio" name="rating" value="3"><i></i>
                            <input type="radio" name="rating" value="4"><i></i>
                        </span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="gradeSubmit">Rejoindre le salon</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">

    </div>
</div>

<div class="modal fade" id="alert-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               <p></p>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
