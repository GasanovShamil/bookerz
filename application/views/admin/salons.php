<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Salon Management
        <small> Edit, Close, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Salon List</h3>
                    
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
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
				                        <td><?php echo $book->getTitle(); ?> closed : <?php echo $infoRoom->getClosed(); ?></td>
				                        <td><?php echo $infoRoom->getStart_date()." / ".$infoRoom->getEnd_date(); ?></td>
				                        <td><?php echo $infoRoom->getName(); ?></td>
				                        <td>
				                           
				
				                            <?php if ($infoRoom->getClosed()): ?>
				                                <?php echo form_open('/admin/reopenSalon/'.$infoRoom->getId()) ?>
				                                    <input type="submit" value="Re open" class="btn btn-warning">
				                                </form>
				                            <?php else: ?>
				                                <?php echo form_open('/admin/deleteSalon/'.$infoRoom->getId()) ?>
				                                    <input type="submit" value="Delete" class="btn btn-danger">
				                                </form>
				                            <?php endif; ?>
				                        </td>
				                    </tr>
				                <?php endforeach; ?>
				        <?php endif; ?>
						<?php if(!empty($closedRooms)): ?>
						        <tr>
						            <td colspan="4" class="full-row"><h3>Salons fermés par un administrateur</h3></td>
						        </tr>
						        <?php foreach ($closedRooms as $room): ?>
						            <?php
						            $infoRoom = $room[0];
						            $book = $room[1];
						            ?>
						            <tr>
						                <td><?php echo $book->getTitle(); ?> closed : <?php echo $infoRoom->getClosed(); ?></td>
						                <td><?php echo $infoRoom->getStart_date()." / ".$infoRoom->getEnd_date(); ?></td>
						                <td><?php echo $infoRoom->getName(); ?></td>
						                <td>
						                     <?php if ($infoRoom->getClosed()): ?>
						                        <?php echo form_open('/admin/reopenSalon/'.$infoRoom->getId()) ?>
						                            <input type="submit" value="Re open" class="btn btn-warning">
						                        </form>
						                    <?php else: ?>
						                        <?php echo form_open('/admin/deleteSalon/'.$infoRoom->getId()) ?>
						                            <input type="submit" value="Delete" class="btn btn-danger">
						                        </form>
						                    <?php endif; ?>
						                </td>
						            </tr>
						        <?php endforeach; ?>
						    </tbody>
						<?php endif; ?>
						</table>
                </div><!-- /.box-body -->
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
<?php if (isset($endedRooms) && !empty($endedRooms)): ?>
    <h1>Anciens salons :</h1>
    <?php foreach ($endedRooms as $room): ?>
        <?php echo $room[1]->getTitle(); ?>
        <br>
        le <?php echo $room[0]->getStart_date(); ?>
    <?php endforeach; ?>
<?php else: ?>
    <h1>Aucun ancien salon trouvé</h1>
<?php endif; ?> 
              </div><!-- /.box -->
            </div>
        </div>
        <!-- Modal -->
		<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		               <p></p>
		            </div>
		            <div class="modal-body">
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		                <a class="btn btn-danger btn-ok" id="confirm"></a>
		            </div>
		        </div>
		    </div>
		</div>
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
    </section>
    
</div>
 
<script type="text/javascript">
    $(document).ready(function(){
        $('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = $(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            $("#searchList").attr("action", baseURL + "bookListing/" + value);
            $("#searchList").submit();
        });

        $(document).on("click", ".deleteBook", function(){
        	var currentRow = $(this);
        	var bookid = currentRow.data("bookid");
			var hitURL = baseURL + "deleteBook";
			currentRow = $(this);
        	$('#confirm-modal .modal-header p').html('Confirmation');
			$('#confirm-modal .modal-body').html('Vous etes sur de vouloir supprimer ce livre ?');
			$('#confirm-modal .modal-footer').show();
			$('#confirm-modal .modal-footer a').html('Delete');
            $('#confirm-modal').modal('show');   
            $('#confirm').click(function(e){
                $.ajax({
        			type : "POST",
        			dataType : "json",
        			url : hitURL,
        			data : { bookid : bookid } 
        			}).done(function(data){
        				   				
        				if(data.status == true) { 
            				//alert("User successfully deleted");
        					$('#confirm-modal .modal-header p').html('Success');
        					$('#confirm-modal .modal-body').html(data.message);
        					currentRow.parents('tr').remove();
            			}
        				else if(data.status == false) { 
            				$('#confirm-modal .modal-header p').html('Fail');
        					$('#confirm-modal .modal-body').html(data.message);
            			}
        				else { 
            				alert("Access denied..!"); 
            				$('#confirm-modal .modal-header p').html('Error');
        					$('#confirm-modal .modal-body').html('Access denied..!');
            			}
        				$('#confirm-modal .modal-footer').hide();
        			});
            });
            return false;
        });        
    });
</script>
