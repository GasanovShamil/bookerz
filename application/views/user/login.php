<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="omb_login">
    <h3 class="omb_authTitle">S'authentifier ou <a href="<?= base_url('user/create_user') ?>">S'inscrire</a></h3>
    <div class="row omb_row-sm-offset-3 omb_socialButtons">
        <div class="col-xs-4 col-sm-2">
        
        <?php
			$helper = $this->fb->getRedirectLoginHelper();
			$permissions = ['public_profile','email']; // these are the permissions we ask from the Facebook user's profile 
			echo anchor($helper->getLoginUrl('http://bookerz.dev/user/facebook', $permissions),'<i class="fa fa-facebook visible-xs"></i><span class="hidden-xs">Facebook</span>',array('class' => 'btn btn-lg btn-block omb_btn-facebook'));
		?>
        </div>
    </div>
    
	
	
    <div class="row omb_row-sm-offset-3 omb_loginOr">
        <div class="col-xs-12 col-sm-6">
            <hr class="omb_hrOr">
            <span class="omb_spanOr">ou</span>
        </div>
    </div>

    <div class="row omb_row-sm-offset-3">
        <div class="col-xs-12 col-sm-6">
            <form class="omb_loginForm" action="" autocomplete="off" method="POST">
            
                   <span class="help-block" style="color: red"> <?php  echo form_error('identity'); ?></span>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" class="form-control" name="identity" placeholder="Mail">
                </div>
                <span class="help-block"></span>
				<span class="help-block" style="color: red"> <?php  echo form_error('password'); ?></span>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input  type="password" class="form-control" name="password" placeholder="Mot de passe">
                </div>
				<span class="help-block" style="color: red"><?php echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;?></span>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
            </form>
        </div>
    </div>
    <div class="row omb_row-sm-offset-3">
        <div class="col-xs-12 col-sm-3">
            <label class="checkbox">
                <input type="checkbox" name="remember" value="1">Se souvenir de moi
            </label>
        </div>
        <div class="col-xs-12 col-sm-3">
            <p class="omb_forgotPwd">
                <a href="#">Mot de passe oublier?</a>
            </p>
        </div>
    </div>
</div>