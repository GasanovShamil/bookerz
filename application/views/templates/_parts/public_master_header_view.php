<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Bookerz</title>
        <!-- Font axesome -->
        <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.min.css'); ?>">
        <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/bootstrap/css/offcanvas.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    </head>
    <body>
        <!-- navbar -->
        <!-- Menu -->
        <nav class="navbar navbar-fixed-top navbar-inverse">
            <div class="contain">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"></a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?= base_url('home') ?>">Accueil</a></li>
                        <li><a href="<?= base_url('content') ?>">Contenus</a></li>
                        <li><a href="<?= base_url('salon') ?>">Salons</a></li>
                    </ul>
                    <a id="logo" href="#"><img src="<?= base_url('assets/img/livre.png'); ?>"></a>
                    <ul class="nav navbar-nav pull-right">
                        <li><a href="<?= base_url('user/create_user') ?>">S'inscrire</a></li>
                        <li><a href="<?= base_url('user/login') ?>">Se connecter</a></li>
                    </ul>
                </div><!-- /.nav-collapse -->
            </div><!-- /.container -->
        </nav>

        <div class="container">
