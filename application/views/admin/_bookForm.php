<div class="content-wrapper">
<section class="content-header">
<h1>Livre</h1>
<p>Create/Update un livre</p>
</section>
<section class="content">
<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>

      <p>
      		<?php echo form_label('Page de couverture: ', 'cover');?> <br />
            <?php echo form_input($cover);?>
      </p>

      <p>
            <?php echo form_label('Titre:', 'title');?> <br />
            <?php echo form_input($title);?>
      </p>

      <p>
            <?php echo form_label('Description:', 'description');?> <br />
            <?php echo form_input($description);?>
      </p>

      <p>
            <?php echo form_label('Auteur:', 'author');?> <br />
            <?php echo form_input($author);?>
      </p>

      <p>
            <?php echo form_label('Date de publication:', 'published');?> <br />
            <?php echo form_input($published);?>
      </p>
      <p>
            <?php echo form_label('L\'editeur:', 'editor');?> <br />
            <?php echo form_input($editor);?>
      </p>
      
      
      <div class="checkbox">
		<label> <input type="checkbox" name="accepted" value="1"<?php echo $accepted;?>> Accepted </label>			
		</div>
      
     
      
      <p>
		<?php echo form_label('Categorie:', 'category');?> <br />
     		 <?php echo form_multiselect('category[]', $categories, $bookcategories,  'multiple required'); ?>
		</p>
		
      <?php echo form_hidden('id', $id);?>
     

      <p><?php echo form_submit('submit', lang('edit_user_submit_btn'));?></p>

<?php echo form_close();?>
</section>
</div>