<div class="content-wrapper">
<section class="content-header">
<h1>Modifier category</h1>
<p>Veuillez remplir les champs</p>
</section>
<section class="content">
<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>

      <p>
            <?php echo form_label('Nom de category:', 'name');?> <br />
            <?php echo form_input($name);?>
      </p>

      <p>
           <?php echo form_label('Description de category:', 'description');?> <br />
            <?php echo form_input($description);?>
      </p>
      <p><?php echo form_submit('submit', lang('edit_user_submit_btn'));?></p>

<?php echo form_close();?>
</section>
</div>