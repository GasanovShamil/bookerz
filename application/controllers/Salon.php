<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Salon extends MY_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function view($id = NULL)
    {
        $this->load->model('Book_model');
        //  'MessagesSalon_model', 'UsersSalon_model', 'Salon_model'

        $this->data['book'] = $this->Book_model->getBookById($id);

        $this->data['book'] = $this->data['book'][0];
        $this->render('salon/view', $this->data, null);
    }

    public function sendMessage()
    {
        // Fonction qui servira a ajax pour envoyer les messages
    }

    public function getMessages()
    {
        // Fonction qui servira a ajax pour recevoir les messages
    }

}
