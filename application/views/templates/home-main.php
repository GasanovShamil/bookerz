<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row row-offcanvas row-offcanvas-right">

    <div class="col-md-10">
        <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
        </p>
        <div class="col-md-11">
            <h1 class="titre-accueil"><?php echo $page->title?></h1>
            <p><?php echo $page->text?></p>

        </div>

    </div>

    <!-- barre -->
    <div class="col-md-12 style-seven"><hr class="col-md-10 col-md-offset-1"></div>
    <!-- fin barre -->

    <!-- a la une -->
    <div class="col-md-10" id="alaune">
        <div class="col-md-12" id="alaune">
            <div class="col-md-10 col-md-offset-1">

                <div class="row bloc">
            <?php 
            if(! empty($on_top)){
            	foreach ($on_top as $book){?>
                   
                    <article id="<?php echo $book->getId(); ?>" class="col-lg-3 col-md-4 col-sm-4 col-xs-6 min-height-bloc-img">
                            <div class="thumb-pad2 maxheight1"><div class="box_inner">
                                <div class="thumbnail details-book-content" data-idbook="<?php echo $book->getId(); ?>">
                                    <figure><a><img class="max-height-img" src="<?php echo $book->getCover(); ?>" alt=""></a></figure>
                                        <div class="caption">
                                            <a><?php if(iconv_strlen($book->getTitle()) > 30){ echo substr($book->getTitle(), 0, 30)."..."; }else{ echo $book->getTitle(); } ?></a>
                                            <p class="title" title="<?php echo $book->getAuthor(); ?>">de <?php if(iconv_strlen($book->getAuthor()) > 20){ echo substr($book->getAuthor(), 0, 20)."..."; }else{ echo $book->getAuthor(); } ?> <br></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                   <?php }
            } else {
                   	?>
                   	<div class="alert alert-warning col-md-6 col-md-offset-3">
                   	<p class="text-center">Pas de livres pour l'instant!</p>
                   	</div>
                  <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- fin a la une -->

    <!-- barre -->
    <div class="col-md-12 style-seven"><hr class="col-md-10 col-md-offset-1"></div>
    <!-- fin barre -->

    <!-- contact -->
    <div class="col-md-10">
        <div class="col-md-9">
            <h1 class="titre-accueil">Nous contacter</h1>
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
                        <button type="submit" class="btn btn-default pull-right">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- fin contact -->

    <!-- menu flotant-->
    <div class="col-md-3 sidebar-offcanvas hidden-sm hidden-xs" id="sidebar">
        <div class="menu-flotant">
            <div id="inscription-flotant">
                <form class="form-horizontal" method="post" id="sub">
                    <span id="insc-flotant">Inscrivez-vous:</span>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Envoyer</button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="prochain-salon">
                <h4>Prochain salon:</h4>
                <span>27/03/2017 - 16h</span>
                <span>22 ru du Faubourg Saint Antoine</span>
                <span>75011 Paris</span>
            </div>

        </div>
    </div><!--/.sidebar-offcanvas-->
</div><!--/row-->
