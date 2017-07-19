<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-md-12">
            <div class="col-md-12">
                <h1 class="titre-accueil text-center">Contenus</h1>
            </div>
        </div>
        <!-- section filtre -->
         <div class="well col-md-12">
          <div class="col-md-8 col-md-offset-3">
          
          <form action="<?php echo base_url() ?>content" method="POST" id="searchList" class="form-inline">
			  <div class="form-group">
			   <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control" placeholder="Search"/>
			  </div>
			  <div class="form-group">
			     <?php echo form_dropdown('order', $orders, $order,  'class="form-control"'); ?>
			  </div>
			  <div class="form-group">
			     <?php echo form_dropdown('category', $categories, $category,  'class="form-control"'); ?>
			  </div>
			  
			  <button type="submit" class="btn btn-default">Search</button>
			</form>
 		
       
        </div>
        </div>
        
        <!-- section livre -->
        <div class="col-md-12" id="alaune">
            <div class="col-md-10 col-md-offset-1">

                <div class="row bloc">
            <?php 
            if(! empty($bookRecords)){
            	foreach ($bookRecords as $book){?>
                   
                    <article class="col-lg-3 col-md-4 col-sm-4 col-xs-6 min-height-bloc-img">
                    <div class="thumb-pad2 maxheight1"><div class="box_inner">
                        <div class="thumbnail">
                            <figure><a href="#"><img class="max-height-img" src="<?php echo $book->getCover(); ?>" alt=""></a></figure>
                                <div class="caption">
                                    <a href="#"><?php echo $book->getTitle(); ?></a>
                                    <p class="title" title="<?php echo $book->getAuthor(); ?>">de <?php echo $book->getAuthor(); ?> <br></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                   <?php }
            } else {
                   	?>
                   	<div class="alert alert-warning col-md-6 col-md-offset-3">
                   	<p class="text-center">Pas de resultat pour votre recherche!</p>
                   	</div>
                  <?php } ?>
                </div>
                <div class="box-footer clearfix text-center">
                    <?php echo $this->pagination->create_links(); ?>
                </div>	
            </div>
        </div>
        <!-- fin a la une -->
    </div><!--/row-->
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--Fourth column-->
                    <div class="col-md-4 col-sm-6">
                        <!--Collection card-->
                        <div class="card collection-card">
                            <!--Card image-->
                            <div class="view">
                                <img src="http://s2.lemde.fr/image/2016/01/21/534x0/4850777_6_a70a_premiere-de-couverture-du-livre-une-colere_3f1256ec4c3ff75e75caefd3cfc193d9.jpg" class="img-fluid" alt="">
                            </div>
                            <!--/.Card image-->
                        </div>
                        <!--/.Collection card-->
                    </div>
                    <!--/Fourth column-->

                    <!--Details-->
                    <div class="col-md-8 col-sm-6">
                        <h3>Titre</h3>
                        <h5>Auteur</h5>
                        <p>Resumé (peut contenir des liens).</p>
                    </div>
                </div><br />

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h3>Autres suggestions</h3>
                        <!--Fourth column-->
                        <div class="col-md-4 col-sm-6">
                            <!--Collection card-->
                            <div class="card collection-card">
                                <!--Card image-->
                                <div class="view  hm-zoom">
                                    <img src="http://s2.lemde.fr/image/2016/01/21/534x0/4850777_6_a70a_premiere-de-couverture-du-livre-une-colere_3f1256ec4c3ff75e75caefd3cfc193d9.jpg" class="img-fluid" alt="">
                                    <div class="stripe dark">
                                        <a>
                                            <p>Title <br> Auteur <br> <i class="fa fa-chevron-right"></i></p>
                                        </a>
                                    </div>
                                </div>
                                <!--/.Card image-->
                            </div>
                            <!--/.Collection card-->
                        </div>
                        <!--/Fourth column-->
                        <!--Fourth column-->
                        <div class="col-md-4 col-sm-6">
                            <!--Collection card-->
                            <div class="card collection-card">
                                <!--Card image-->
                                <div class="view  hm-zoom">
                                    <img src="http://s2.lemde.fr/image/2016/01/21/534x0/4850777_6_a70a_premiere-de-couverture-du-livre-une-colere_3f1256ec4c3ff75e75caefd3cfc193d9.jpg" class="img-fluid" alt="">
                                    <div class="stripe dark">
                                        <a>
                                            <p>Title <br> Auteur <br> <i class="fa fa-chevron-right"></i></p>
                                        </a>
                                    </div>
                                </div>
                                <!--/.Card image-->
                            </div>
                            <!--/.Collection card-->
                        </div>
                        <!--/Fourth column-->
                        <!--Fourth column-->
                        <div class="col-md-4 col-sm-6">
                            <!--Collection card-->
                            <div class="card collection-card">
                                <!--Card image-->
                                <div class="view  hm-zoom">
                                    <img src="http://s2.lemde.fr/image/2016/01/21/534x0/4850777_6_a70a_premiere-de-couverture-du-livre-une-colere_3f1256ec4c3ff75e75caefd3cfc193d9.jpg" class="img-fluid" alt="">
                                    <div class="stripe dark">
                                        <a>
                                            <p>Title <br> Auteur <br> <i class="fa fa-chevron-right"></i></p>
                                        </a>
                                    </div>
                                </div>
                                <!--/.Card image-->
                            </div>
                            <!--/.Collection card-->
                        </div>
                        <!--/Fourth column-->
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = $(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            $("#searchList").attr("action", baseURL + "content/" + value);
            $("#searchList").submit();
        });
    });
    </script>