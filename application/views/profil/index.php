<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div id="profil" class="row row-offcanvas row-offcanvas-right">

    <div class="col-md-10">
        <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
        </p>
        <div class="col-md-11">
            <h1 class="titre-accueil text-center">Profil utilisateur</h1>
            <div class="col-md-5">
                <img class="featurette-image img-responsive center-block" data-src="holder.js/500x500/auto" alt="500x500" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDUwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzUwMHg1MDAvYXV0bwpDcmVhdGVkIHdpdGggSG9sZGVyLmpzIDIuNi4wLgpMZWFybiBtb3JlIGF0IGh0dHA6Ly9ob2xkZXJqcy5jb20KKGMpIDIwMTItMjAxNSBJdmFuIE1hbG9waW5za3kgLSBodHRwOi8vaW1za3kuY28KLS0+PGRlZnM+PHN0eWxlIHR5cGU9InRleHQvY3NzIj48IVtDREFUQVsjaG9sZGVyXzE1YzFjZjQ2MWQ2IHRleHQgeyBmaWxsOiNBQUFBQUE7Zm9udC13ZWlnaHQ6Ym9sZDtmb250LWZhbWlseTpBcmlhbCwgSGVsdmV0aWNhLCBPcGVuIFNhbnMsIHNhbnMtc2VyaWYsIG1vbm9zcGFjZTtmb250LXNpemU6MjVwdCB9IF1dPjwvc3R5bGU+PC9kZWZzPjxnIGlkPSJob2xkZXJfMTVjMWNmNDYxZDYiPjxyZWN0IHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIiBmaWxsPSIjRUVFRUVFIi8+PGc+PHRleHQgeD0iMTg1LjEyNSIgeT0iMjYxLjEiPjUwMHg1MDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
            </div>
            <div class="col-md-7">
                <h3><?php echo $_SESSION['last_name']." ".$_SESSION['first_name']?></h3>
                <h4><?php echo $_SESSION['email']?></h4>
                <!--<p>This is an example to show the potential of an offcanvas layout pattern in Bootstrap. Try some responsive-range viewport sizes to see it in action. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. Donec id elit non mi porta gravida at eget metus.</p>-->
                <button id="modal-book-api">Proposer un livre</button>
            </div>
        </div>

    </div>

    <div data-alerts="alerts" data-titles='{"warning": "<em>Warning!</em>", "error": "<em>Error!</em>"}' data-ids="myid" data-fade="3000"></div>
    <!-- a la une -->
    <div class="col-md-10" id="alaune">
        <div class="col-md-11">
            <h1 class="titre-accueil">Mes livres</h1>
            <div class="row bloc">
                <!--First column-->
                <article class="col-lg-3 col-md-4 col-sm-4 col-xs-6 min-height-bloc-img">
                    <div class="thumb-pad2 maxheight1"><div class="box_inner">
                            <div class="thumbnail thumbnail-vide">
                                <figure><a href="#"><a>
                                            <span class="glyphicon glyphicon-plus-sign" aria-hidden="true" id="myModalAddBook"></span>
                                        </a><img class="max-height-img" src="<?= base_url('assets/img/blank.png'); ?>" alt=""></a></figure>
                                <div class="caption">
                                    <a href="#" id="myModalAddBook">Ajouter un livre</a>
                                    <p class="title"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <!--
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <!--Collection card--
                    <div class="card collection-card">
                        <!--Card image--
                        <div class="view  hm-zoom">
                            <img src="<?= base_url('assets/img/blank.png'); ?>" class="img-fluid" alt="">
                            <div class="add-new-image">
                                <a>
                                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true" id="myModalAddBook"></span>
                                </a>
                            </div>
                        </div>
                        <!--/.Card image--
                    </div>
                    <!--/.Collection card--
                </div>
                <!--/First column-->
                <?php if(!empty($has_book)){
                    foreach ($has_book as $row){  ?>
                <!--Second column--
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <!--Collection card--
                    <div class="card collection-card">
                        <!--Card image--
                        <div class="view  hm-zoom">
                            <img src="<?php echo $row->cover; ?>" class="img-fluid" alt="">
                            <!--<img src="http://s2.lemde.fr/image/2016/01/21/534x0/4850777_6_a70a_premiere-de-couverture-du-livre-une-colere_3f1256ec4c3ff75e75caefd3cfc193d9.jpg" class="img-fluid" alt="">--
                            <div class="stripe dark">
                                <a>
                                    <p><?php echo $row->title; ?> <br> <strong><?php echo $row->author; ?></strong> <br> <i class="fa fa-chevron-right"></i></p>
                                </a>
                            </div>
                        </div>
                        <!--/.Card image--
                    </div>
                    <!--/.Collection card--
                </div>
                <!--/Second column-->

                <article class="col-lg-3 col-md-4 col-sm-4 col-xs-6 min-height-bloc-img">
                    <div class="thumb-pad2 maxheight1"><div class="box_inner">
                        <div class="thumbnail">
                            <figure><a href="#"><img class="max-height-img" src="<?php echo $row->cover; ?>" alt=""></a></figure>
                                <div class="caption">
                                    <a href="#"><?php echo $row->title; ?></a>
                                    <p class="title" title="<?php echo $row->author; ?>">de <?php echo $row->author; ?> <br></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <?php }
                    }else{ ?>
                    <p>Vous n'avez aucun livre.</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- fin a la une -->

    <?php if(!empty($non_validate_book)){ ?>
    <!-- a la une -->
    <div class="col-md-10" id="alaune">
        <div class="col-md-11">
            <h1 class="titre-accueil">Livres en cours de validation.</h1>
            <div class="row bloc">
                <?php foreach ($non_validate_book as $row){  ?>
                    <article class="col-lg-3 col-md-4 col-sm-4 col-xs-6 min-height-bloc-img">
                        <div class="thumb-pad2 maxheight1"><div class="box_inner">
                                <div class="thumbnail">
                                    <figure><a href="#"><img class="max-height-img" src="<?php echo $row->cover; ?>" alt=""></a></figure>
                                    <div class="caption">
                                        <a href="#"><?php echo $row->title; ?></a>
                                        <p class="title" title="<?php echo $row->author; ?>">de <?php echo $row->author; ?> <br></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- fin a la une -->
    <?php } ?>

    <!-- barre -->
    <div class="col-md-12 style-seven"><hr class="col-md-10 col-md-offset-1"></div>
    <!-- fin barre -->

    <!-- contact -->
    <div class="col-md-10">
        <div class="col-md-9">
            <h1 class="titre-accueil">Contactez %NOM / PRENOM%</h1>
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nom</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" placeholder="Nom">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Sujet</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputSubject" placeholder="Sujet">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="5" id="comment" placeholder="Message"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-default pull-right">Envoyer</input>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- fin contact -->

    <!-- menu flotant-->
    <div class="col-md-3 sidebar-offcanvas hidden-sm hidden-xs" id="sidebar">
        <div class="menu-flotant">
            <div class="col-md-12" id="inscription-flotant">
                <span id="insc-flotant">Mes informations:</span>
                <div class="form-group">
                    <a class="col-md-12" id="myBtnInfo" onclick="getInfoUser(<?php echo $_SESSION['user_id']; ?>)" href="#">Modifier mes informations</a>
                    <a class="col-md-12" id="myBtnMdp" href="#">Modifier mon mot de passe</a>
                    <a class="col-md-12" href="#">Gérer mes contacts</a>
                </div>
            </div>

            <div class="col-md-12 text-center" id="prochain-salon">
                <h4>Contactez nous:</h4>
                <button type="button" class="btn btn-info btn-lg">Contacter</button>
            </div>
        </div>
    </div><!--/.sidebar-offcanvas-->



    <!-- Modal mdp-->
    <div class="modal fade" id="myModalMdp" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modifier mot de passe</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form role="form" method="post" action=""  id="formUpdatePwd">
                                <div id="verifPass"></div>
                                <input type="hidden" class="form-control" id="idUser" value="<?php echo $_SESSION['user_id']; ?>" >
                                <div class="form-group">
                                    <label for="psw"> Ancien mot de passe</label>
                                    <input type="password" class="form-control" id="ancienmdp" name="ancienmdp" placeholder="Entrer l'ancien mot de passe" required>
                                </div>
                                <div class="form-group">
                                    <label for="psw"> Nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="nvmdp" name="nvmdp" placeholder="Entrer le nouveau mot de passe" required>
                                </div>
                                <div class="form-group">
                                    <label for="psw"> Confirmer mot de passe</label>
                                    <input type="password" class="form-control" id="nvmdp1" name="nvmdp1" placeholder="Entrer la connfirmer du mot de passe" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-floppy-disk"></span> Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal mes informations-->
    <div class="modal fade" id="myModalInfo" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modification informations</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form role="form">
                                <div class="form-group">
                                    <label for="usrname"> Nom</label>
                                    <input type="text" class="form-control" id="lastname" placeholder="Nom">
                                </div>
                                <div class="form-group">
                                    <label for="usrname"> Prenom</label>
                                    <input type="text" class="form-control" id="firstname" placeholder="Prénom">
                                </div>
                                <div class="form-group">
                                    <label for="usrname"> Email</label>
                                    <input type="text" class="form-control" id="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="usrname"> Téléphone</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Téléphone">
                                </div>
                                <button type="submit" id="submitInfo" onclick="updateInfoUser(<?php echo $_SESSION['user_id']; ?>)" class="btn btn-success btn-block"><span class="glyphicon glyphicon-floppy-disk"></span> Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add book-->
    <div class="modal fade" id="myModalAddBookView" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ajout d'un livre</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table-book" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Auteur</th>
                                        <th>ISBN</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add book with api-->
    <div class="modal fade" id="myModalAddBookAPI" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Proposer un livre.</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-inline" onsubmit="event.preventDefault(); searchBookApi(1);">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="title-book" placeholder="Titre">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="isbn-book" placeholder="ISBN">
                                </div>
                                <button type="submit"  class="btn btn-default">Submit</button>
                            </form>
                            <div id="results"></div>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div><!--/row-->