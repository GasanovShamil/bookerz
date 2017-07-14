<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends Auth_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->model('Book_model');
	}
	
	public function index()
    {
        $idUser = $this->session->userdata('user_id');
        $this->data["has_book"] = $this->Book_model->getAllBookUser($idUser, 1);
        $this->data["non_validate_book"] = $this->Book_model->getAllBookUser($idUser, 0);
        $this->render('profil/index', $this->data);
    }
}