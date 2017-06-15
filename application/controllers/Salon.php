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
		$this->load->model('MessagesSalon_model');
        //  'MessagesSalon_model', 'UsersSalon_model', 'Salon_model'

        $this->data['book'] = $this->Book_model->getBookById($id);
		$this->data['messages'] = $this->MessagesSalon_model->getMessagesForRoom($id);
		$this->data['id_salon'] = $id;

		$this->data['book'] = $this->data['book'];
        $this->render('salon/view', $this->data, null);
    }

    public function insertMessage()
    {
		$this->load->model('MessagesSalon_model');

		// Vérification à venir
		if(isset($_POST['message']) && isset($_POST['room']) && isset($_POST['userid'])) {
			$message = $_POST['message'];
			$room = $_POST['room'];
			$userid = $_POST['userid'];

			$this->MessagesSalon_model->insertMessage($message, $room, $userid);
			echo json_encode('success:true');
		} else {
			json_encode('error:true');
		}




    }

}
