<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Book extends MY_Controller {


	public function __construct()
	{
		parent::__construct();
	}

	public function view($id = NULL)
	{
		$this->data['book'] = $this->Book_model->getBookById($id);

		$this->render('book/view', $this->data, null);
	}


}
