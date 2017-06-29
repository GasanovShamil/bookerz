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
        <div class="col-md-8 col-md-offset-2">
            <!-- section filtre -->
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-3">
                    <select class="form-control">
                        <option>Catégorie</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <select class="form-control">
                        <option>Titre</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control">
                        <option>Auteur</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
            </div><br /><br /><br />
            <table id="liste-salon" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Dates</th>
                        <th>Numéro de salon</th>
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
                                <td>inutile</td>
                                <td><a id="<?php echo $infoRoom->getId(); ?>" data-toggle="modal" data-target="#myModal">Rejoindre</a></td>
                            </tr>
                    <?php endforeach; ?>

                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div><!--/row-->
</div>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Vous devez donner une note pour rejoindre le salon!!!</h4>
            </div>
            <div id="modal-salon" class="modal-body">
                <div>
                    <div  class="col-md-12">
                        <span class="col-md-8 col-md-offset-2">Titre</span>
                        <span class="col-md-8 col-md-offset-2">Auteur</span>
                    </div>
                    <div class="rating" style="text-align: center;">
                        <a href="#4" title="Donner 4 étoiles">★</a>
                        <a href="#3" title="Donner 3 étoiles">★</a>
                        <a href="#2" title="Donner 2 étoiles">★</a>
                        <a href="#1" title="Donner 1 étoile">★</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Rejoindre le salon</button>
            </div>
        </div>
    </div>
</div>
