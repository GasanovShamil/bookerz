<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Bookerz</title>
        <!-- Font axesome -->
        <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.min.css'); ?>">
        <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" />
        <link href="<?= base_url('assets/bootstrap/css/offcanvas.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
        <!-- <link rel="stylesheet" href="<?= base_url('assets/css/emojionearea.min.css'); ?>"> -->
    </head>
    <body>
        <!-- navbar -->
        <!-- Menu -->
        <div id="status-message"></div>
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
                         <?php 
                        if ($this->ion_auth->is_admin())
                        {?>
                        <li><a href="<?= base_url('dashboard') ?>">Administration</a></li>
                       <?php
                        }
                        ?>
                    </ul>
                    <a id="logo" href="#"><img src="<?= base_url('assets/img/livre.png'); ?>"></a>
                    <ul class="nav navbar-nav pull-right">
                        <li><a href="<?= base_url('profil') ?>">Mon Compte</a></li>
                        <li><a href="<?= base_url('user/logout') ?>">Se deconnecter</a></li>
                    </ul>
                </div><!-- /.nav-collapse -->
            </div><!-- /.container -->
        </nav>

        <div class="container">
