<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="omb_login">
    <h3 class="omb_authTitle">Authentification</h3>

    <div class="row omb_row-sm-offset-3 omb_loginOr">
        <div class="col-xs-12 col-sm-6">
            <hr class="omb_hrOr">
        </div>
    </div>

    <div class="row omb_row-sm-offset-3">
        <div class="col-xs-12 col-sm-6">
            <form class="omb_loginForm" action="" autocomplete="off" method="POST">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="Nom">
                </div>
                <span class="help-block"></span>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="Prenom">
                </div>
                <span class="help-block"></span>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="Mail">
                </div>
                <span class="help-block"></span>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input  type="password" class="form-control" name="password" placeholder="Mot de passe">
                </div>
                <span class="help-block"></span>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input  type="password" class="form-control" name="password" placeholder="Confirmer mot de passe">
                </div>
                <span class="help-block">Message d'erreur !!!</span>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Inscription</button>
            </form>
        </div>
    </div>
</div>