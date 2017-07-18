<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Book Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <?php echo anchor('admin/create_book', '<i class="fa fa-plus"></i> Add New', array('class' => 'btn btn-primary'))?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Books List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>bookListing" method="POST" id="searchList" class="form-inline">
                            <div class="input-group">
                             <?php echo form_dropdown('category', $categories, $category,  'class="form-control input-sm pull-right" style="width: 150px;"'); ?>
                           	<?php echo form_dropdown('status', $statuses, $status,  'class="form-control input-sm pull-right" style="width: 150px;"'); ?>
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                           
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Cover</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Date</th>
                      <th>Author</th>
                      <th>Published</th>
                      <th>Editor</th>
                      <th>Categories</th>
                      <th>ISBN10</th>
                      <th>ISBN13</th>
                      <th>Accepted</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($bookRecords))
                    {
                    	foreach($bookRecords as $book)
                        {
                    ?>
                    <tr>
                      <td><img src="<?php echo $book->getCover(); ?>"></td>
                      <td><?php echo $book->getTitle(); ?></td>
                      <td><?php echo $book->getDescription();?></td>
                      <td><?php echo $book->getDate(); ?></td>
                      <td><?php echo $book->getAuthor(); ?></td>
                      <td><?php echo $book->getPublished(); ?></td>
                      <td><?php echo $book->getEditor(); ?></td>
                      <td><?php foreach ($book->getCategories()as $cat):?>
								<?php echo '<span class="label label-primary">'.htmlspecialchars($cat->getName(),ENT_QUOTES,'UTF-8').'</span>';?><br />
			                <?php endforeach?></td>
                      <td><?php echo $book->getISBN10(); ?></td>
                      <td><?php echo $book->getISBN13(); ?></td>
                      <td class="text-center"><?php if($book->isAccepted()){ 
                      	echo '<i class="fa fa-check-square fa-2x" aria-hidden="true" style="color:green"></i>'; 
                      }else{
                      	echo '<i class="fa fa-minus-square fa-2x" aria-hidden="true" style="color:red"></i>';
                        }?></td>
                      <td class="text-center">
                        <a class="btn btn-sm btn-info" href="<?php echo base_url().'admin/editBook/'.$book->getId();?>"><i class="fa fa-pencil"></i></i></a>
                        <a class="btn btn-sm btn-danger deleteBook" href="#" data-bookid="<?php echo $book->getId(); ?>"><i class="fa fa-trash"></i></a>
                        
                      </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
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
