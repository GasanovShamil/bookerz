<div class="contain">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-md-12">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <div class="col-md-12">
                <h1 class="titre-accueil text-center">Salons</h1>
            </div>

        </div>

        <br><br><br>
        <div class="error">
            <?php echo validation_errors(); ?>
        </div>
        <a id="addSalon" class="buttonHover">Créer un salon <span class="glyphicon glyphicon-plus"></span></a>
        <br>
        <div id="addSalonModal" class="hiddenDiv">
            <?php echo form_open_multipart('createsalontempo/create'); ?>
            <label>Nom du salon</label>
            <input type="text" name="name" placeholder="Nom du salon">
            <br>
            <label>Date et heure d'ouverture du salon</label>
            <input type="date" name="start_date_day" value="<?php echo date('Y-m-d'); ?>">
            <input type="time" name="start_date_hour" value="<?php echo date('H:i:s'); ?>">
            <br>
            <label>Date et heure de fin</label>
            <input type="date" name="end_date_day">
            <input type="time" name="end_date_hour">
            <br>
            <label>livre</label>
            <input type="text" name="id_livre">
            <br>
            <label>Nombre d'utilisateurs maximum </label>
            <input type="number" class="number" name="nb_max_user" placeholder="20">
            <br>
            <label>Nombre de signalement requis à partir duquel un utilisateur sera expulsé du salon</label>
            <input type="number" class="number" name="nb_max_report_needed" placeholder="3">
            <br><br>
            <button type="submit" class="btn btn-default">Enregistrer le salon</button>
            </form>
        </div>
        <br>
            <table id="admin-liste-salon" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Dates</th>
                        <th>Nom du salon</th>
                        <th>Action</th>
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
                                <td><?php echo $book->getTitle(); ?></td>
                                <td><?php echo $infoRoom->getStart_date()." / ".$infoRoom->getEnd_date(); ?></td>
                                <td><?php echo $infoRoom->getName(); ?></td>
                                <td>
                                    <a id="<?php echo $infoRoom->getId(); ?>" data-toggle="modal" data-target="#myModal">Rejoindre</a>
                                    <?php echo form_open('/createsalontempo/delete/'.$infoRoom->getId()) ?>
                                        <input type="submit" value="Delete" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                    <?php endforeach; ?>

                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div><!--/row-->

    <hr>
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

    <hr>
    <?php if (isset($closedRooms) && !empty($closedRooms)): ?>
        <h1>Anciens salons :</h1>
        <?php foreach ($closedRooms as $room): ?>
            <?php echo $room[1]->getTitle(); ?>
            <br>
            le <?php echo $room[0]->getStart_date(); ?>
        <?php endforeach; ?>
    <?php else: ?>
        <h1>Aucun ancien salon trouvé</h1>
    <?php endif; ?>
</div>
