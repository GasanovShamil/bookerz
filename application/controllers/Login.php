<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function log()
    {
        $this->load->view('templates/header');
        $this->load->view('login/login.php');
        $this->load->view('templates/footer');
    }

    public function registration()
    {
        $this->load->view('templates/header');
        $this->load->view('login/registration.php');
        $this->load->view('templates/footer');
    }

}