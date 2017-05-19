<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller {

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('content/index');
        $this->load->view('templates/footer');
    }
}