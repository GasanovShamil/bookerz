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
          <div class="col-md-10 col-md-offset-1">
          
          
 <?php
           
            $attributes = array('id' => 'myform');
            $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
            $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
            //save the columns names in a array that we will use as filter   
            $options_order = array('title' => 'title', 'author' => 'author');
            $options_category = array();    
            if(! empty($categories)){
            foreach ($categories as $array) {
            	$options_category[$array->getName()] = $array->getName();
            }
            }
            echo form_open('content/index', $attributes);
           ?> <div class="filtre"> <?php 
            echo form_label('Search:', 'search_string');
            echo form_input('search_string', $search_string_selected, ['class' => 'form-control']);
            ?></div>   <?php 
            echo form_label('Order by:', 'order');
            echo form_dropdown('order', $options_order, $order, ['class' => 'form-control']);
            echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');
            echo form_submit($data_submit);
            echo form_close();
        ?>
        </div>
        </div>
        
        <!-- section livre -->
        <div class="col-md-12" id="alaune">
            <div class="col-md-10 col-md-offset-1">

                <div class="row bloc">
            <?php 
            if(! empty($books)){
            foreach ($books as $book){?>
                    <div class="col-md-3 col-sm-6"	>
                        <!--Collection card-->
                        <div class="card collection-card">
                            <!--Card image-->
                            <div class="view  hm-zoom">
                                <img src="http://s2.lemde.fr/image/2016/01/21/534x0/4850777_6_a70a_premiere-de-couverture-du-livre-une-colere_3f1256ec4c3ff75e75caefd3cfc193d9.jpg" class="img-fluid" alt="">
                                <div class="stripe dark">
                                    <a data-toggle="modal" data-target="#myModal">
                                        <p><?php echo $book->getTitle();?><br> <?php echo $book->getId();?> <br> <i class="fa fa-chevron-right"></i></p>
                                    </a>
                                </div>
                            </div>
                            <!--/.Card image-->
                        </div>
                        <!--/.Collection card-->
                    </div>
                   <?php }
            } else {
                   	?>
                   	<div class="alert alert-warning col-md-6 col-md-offset-3">
                   	<p class="text-center">Pas de resultat pour votre recherche!</p>
                   	</div>
                  <?php } ?>
                </div>
                 <div class="pagination">
    				<ul>
                		<?php echo $links; ?>
                	</ul>    
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