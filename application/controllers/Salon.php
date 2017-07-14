<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Salon extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function index()
	{
		$this->load->model('Salon_model');
		$this->data['rooms'] = $this->Salon_model->getSalon();

		$this->data['nextRooms'] = $this->Salon_model->getSalon("next");

		$this->render('salon/index');
	}

	public function chatroomToSelect($id_book)
	{
		$this->load->model('Chatroom_to_salon_model');
		$this->load->model('Salon_model');
		$this->load->model('UsersSalon_model');

		$salon = $this->Salon_model->getSalonByBook($id_book);
		// check si le salon existe bien
		if($salon != null) {
			// récupère toutes les chatrooms du salon
			$chatroomsForBook = $this->Chatroom_to_salon_model->getChatroomsForBook($salon->getId());
			// aucune chatroom n'est crée
			if($chatroomsForBook == null) {

				// On en crée une et on en récupère l'id
				$this->Chatroom_to_salon_model->newChatroomForBook($salon->getId());
				$chatroom = $this->Chatroom_to_salon_model->getChatroomsForBook($salon->getId());
				$finalId = $chatroom[0]->getId();
				echo json_encode($finalId);

			} else {
				// Sinon on les parcours
				foreach ($chatroomsForBook as $chatroom) {
					// On vérifie pour chaque itéation si la chatroom convient
					if($this->UsersSalon_model->getNbUsers($chatroom->getId()) < $salon->getNb_max_user()) {

						// Si oui on récupere son id
						$finalId = $chatroom->getId();
						echo json_encode($finalId);
					}
				}
				// Si aucune chatroom ne convient on en crée une
				if(!isset($finalId)) {
					$this->Chatroom_to_salon_model->newChatroomForBook($salon->getId());
					$chatroom = $this->Chatroom_to_salon_model->getChatroomsForBook($salon->getId());
					echo json_encode($chatroom);
					// $finalId = $chatroom->getId();
					// echo json_encode($finalId);
				}
			}
		}
		// Si il n'y a pas de salon
		if(!isset($finalId)) {
			echo json_encode("0");
		}
	}

	public function view($id = NULL)
    {
        $this->load->model('Book_model');
		$this->load->model('MessagesSalon_model');
		$this->load->model('UsersSalon_model');
        //  'MessagesSalon_model', 'UsersSalon_model', 'Salon_model'

        $this->data['book'] = $this->Book_model->getBookById($id);
		$this->data['messages'] = $this->MessagesSalon_model->getMessagesForRoom($id);
		$this->data['id_salon'] = $id;
		$this->data['book'] = $this->data['book'];
		$this->data['usersIn'] = $this->UsersSalon_model->getUsersIn($id);

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
				echo json_encode('error:true');
		}
    }

	public function userState()
	{
		$this->load->model('UsersSalon_model');

		if(isset($_POST['userid']) && isset($_POST['room']) && isset($_POST['state'])) {
			$room = $_POST['room'];
			$userid = $_POST['userid'];

			if($_POST['state'] == "new") {
				if(!$this->UsersSalon_model->isIn($userid, $room)) {
					$this->UsersSalon_model->newUser($userid, $room);
				}
			} elseif ($_POST['state'] == "left") {
				$this->UsersSalon_model->leftUser($userid, $room);
			}

			echo json_encode('success:true');
		} else {
			echo json_encode('error: true');
		}
	}

}
