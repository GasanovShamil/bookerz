<div class="content-wrapper">
<section class="content-header">
<h1>Les salons</h1>
<p>Editez les salons</p>
</section>
<section class="content">
   
        <div class="error">
            <?php echo validation_errors(); ?>
        </div>
        
        <div id="addSalonModal" class="hiddenDiv">
           <?php echo form_open_multipart('admin/createSalon/'.$book_id); ?>
            <label>Nom du salon</label><br>
            <input type="text" name="name" placeholder="Nom du salon">
            <br>
            <label>Date et heure d'ouverture du salon</label><br>
            <input type="date" name="start_date_day" value="<?php echo date('Y-m-d'); ?>">
            <input type="time" name="start_date_hour" value="<?php echo date('H:i:s'); ?>">
            <br>
            <label>Date et heure de fin</label><br>
            <input type="date" name="end_date_day">
            <input type="time" name="end_date_hour">
            <br>
            <label>Id livre</label><br>
            <input type="text" name="tmp" value="<?php echo $book_id;?>" disabled="disabled">
            <input type="hidden" name="id_livre" value="<?php echo $book_id;?>">
            <br>
            <label>Nombre d'utilisateurs maximum </label><br>
            <input type="number" class="number" name="nb_max_user" value="10">
            <br>
            <label>Nombre de signalement requis à partir duquel un utilisateur sera expulsé du salon</label><br>
            <input type="number" class="number" name="nb_max_report_needed" value="3">
            <br><br>
            <button type="submit" class="btn btn-default">Enregistrer le salon</button><br>
        <?php echo form_close();?>
    </div>

</section>
</div>
