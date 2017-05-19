<div class="omb_login">
    <h3 class="omb_authTitle">S'authentifier ou <a href="<?= base_url('login/registration') ?>">S'inscrire</a></h3>
    <div class="row omb_row-sm-offset-3 omb_socialButtons">
        <div class="col-xs-4 col-sm-2">
            <a href="#" class="btn btn-lg btn-block omb_btn-facebook">
                <i class="fa fa-facebook visible-xs"></i>
                <span class="hidden-xs">Facebook</span>
            </a>
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
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="Mail">
                </div>
                <span class="help-block"></span>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input  type="password" class="form-control" name="password" placeholder="Mot de passe">
                </div>
                <span class="help-block">L'identifiant ou le mot de passe est incorrect !!!</span>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
            </form>
        </div>
    </div>
    <div class="row omb_row-sm-offset-3">
        <div class="col-xs-12 col-sm-3">
            <label class="checkbox">
                <input type="checkbox" value="remember-me">Se souvenir de moi
            </label>
        </div>
        <div class="col-xs-12 col-sm-3">
            <p class="omb_forgotPwd">
                <a href="#">Mot de passe oublier?</a>
            </p>
        </div>
    </div>
</div>