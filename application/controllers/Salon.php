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
		if($id == null) {
			redirect('/salon', 'refresh');
		}
		$this->load->model('Book_model');
		$this->load->model('MessagesSalon_model');
		$this->load->model('UsersSalon_model');
		$this->load->model('Salon_model');
		$this->load->model('Chatroom_to_salon_model');
		$this->load->model('Book_note_model');
		$this->load->model('Invitation_model');

		$book = $this->Book_model->getBookById($id);
		$chatroom = $this->Chatroom_to_salon_model->getChatroomsForBook($id);
		$check_note = $this->Book_note_model->checkNote($_SESSION['user_id'], $book->getId());

		if(!$this->Invitation_model->userIsInvited($_SESSION['user_id'], $id)) {
			if($check_note) {
				$this->load->model('Report_model');
				$check_ban = $this->Report_model->checkBan($_SESSION['user_id'], $chatroom[0]->getId_salon());
				$max_report = $this->Salon_model->getMaxReport($chatroom[0]->getId_salon());
				if($check_ban >= $max_report) {
					redirect('/salon', 'refresh');
				}


				$salon = $this->Salon_model->getSalon($chatroom[0]->getId_salon());
				$max_user = $salon[0][0]->getNb_max_user();
				$nbUser = $this->UsersSalon_model->getNbUsers($chatroom[0]->getId_salon());
				if($nbUser >= $max_user) {
					redirect('/salon', 'refresh');
				}
			}
		}

		$this->data['book'] = $book;
		$this->data['messages'] = $this->MessagesSalon_model->getMessagesForRoom($id);
		$this->data['id_salon'] = $id;
		$this->data['usersIn'] = $this->UsersSalon_model->getUsersIn($id);
		$this->data['chatroom'] = $chatroom;


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
			echo json_encode('success : true');
		} else {
			echo json_encode('error : true');
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

			echo json_encode('success : true');
		} else {
			echo json_encode('error : true');
		}
	}

	public function addReport()
	{
		$this->load->model('Report_model');

		if(isset($_POST['id_user_reported']) && isset($_POST['id_salon']) && isset($_POST['reason'])) {
			if(!$this->Report_model->checkReport($_SESSION['user_id'], $_POST['id_user_reported'], $_POST['id_salon'])) {

				if($this->Report_model->addReport($_SESSION['user_id'], $_POST['id_user_reported'], $_POST['id_salon'], $_POST['reason'], date("Y-m-d H:i:s"))) {
					echo json_encode('success : true');
				} else {
					echo json_encode('error : true');
				}
			}
		}
	}

	public function checkReport()
	{
		if(isset($_POST['id_user_reported']) && isset($_POST['id_salon'])) {
			$this->load->model('Report_model');
			$check = $this->Report_model->checkReport($_SESSION['user_id'], $_POST['id_user_reported'], $_POST['id_salon']);

			if($check) {
				$response['status'] = 'success';
			} else {
				$response['status'] = 'error';
			}
			echo json_encode($response);
		}
	}

	public function checkBan()
	{
		if(isset($_POST['id_salon_parent'])) {
			$this->load->model('Report_model');
			$check = $this->Report_model->checkBan($_SESSION['user_id'], $_POST['id_salon_parent']);

			$this->load->model('Salon_model');
			$max_report = $this->Salon_model->getMaxReport($_POST['id_salon_parent']);

			if($check >= $max_report) {
				$response['status'] = 'success';
			} else {
				$response['status'] = 'error';
			}
			echo json_encode($response);
		}
	}

	public function newInvitation()
	{
		if(isset($_POST['email']) && isset($_POST['url']) && isset($_POST['room'])){
			$this->load->model('Invitation_model');
			$this->load->library('email');

			$this->email->from('bookerz.project@gmail.com', 'Club des lectures');
			$this->email->to($_POST['email']);

			$this->email->subject('Invitation à un salon de chat !');
			$this->email->message('Quelqu\'un vous a envoyé une invitation pour rejoindre un chat ! Pour le rejoindre utilisez ce lien : http://bookerz.dev/salon/view/'.$_POST['room'].'?invitation='.$_POST['url']);


			if($this->Invitation_model->sendInvitation($_POST['email'], $_POST['url'], $_POST['room']) && $this->email->send()) {
				$response['status'] = 'success';
			} else {
				$response['status'] = 'error';
			}

		} else {
			$response['status'] = 'error';
		}

		echo json_encode($response);
	}

}
