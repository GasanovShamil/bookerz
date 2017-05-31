<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Book extends MY_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function view($id = NULL)
	{
		$this->load->model('Book_model');
		$this->data['book'] = $this->Book_model->getBookById($id);

		// vérifier les salons, voir si ils ont atteints leur limite d'utilisateur
		// Si c'est le cas, générer un nouveau salon

		// Obligé de faire ça sinon on a un tableau dans un tableau
		$this->data['book'] = $this->data['book'][0];
		$this->render('book/view', $this->data, null);
	}


}
