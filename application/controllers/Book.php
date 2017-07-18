<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Book extends MY_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->model('Book_model');
	}

	public function view($id = NULL)
	{

		$this->data['book'] = $this->Book_model->getBookById($id);

		// vérifier les salons, voir si ils ont atteints leur limite d'utilisateur
		// Si c'est le cas, générer un nouveau salon

		// Obligé de faire ça sinon on a un tableau dans un tableau
		$this->data['book'] = $this->data['book'][0];
		$this->render('book/view', $this->data, null);
	}

	public function getAllBook(){
	    $data["data"] = $this->Book_model->getAllBook();
        echo json_encode($data);
    }

    public function addBookToUser(){
        $hasbook = $this->Book_model->checkUserHasBook($_POST['id'], $this->session->userdata('user_id'));
        if (!empty($hasbook)){
            //json_encode("error" => "he has this book");
            echo "Vous avez déjà ce livre";
        }else{
            $data['id_book'] = $_POST['id'];
            $data['id_user'] = $this->session->userdata('user_id');
            if($this->Book_model->addBookToUser($data)) {
                echo "livre ajouter avec succes";
            }
        }
    }

    public function addPropositionUser()
    {
        if($this->Book_model->checkBookExist($_POST['isbn13'])){
            echo json_encode("existe");
        }else{
            //ajout de du livre
            $data['title'] = $_POST['title'];
            $data['description'] = $_POST['description'];
            $date = new DateTime();
            $data['date'] = $date->format('Y-m-d');
            $data['author'] = $_POST['author'];
            $data['published'] = $_POST['published'];
            $data['editor'] = $_POST['editor'];
            $data['isbn10'] = $_POST['isbn10'];
            $data['isbn13'] = $_POST['isbn13'];
            $data['accepted'] = 0;
            $data['cover'] = $_POST['linkimg'];
            $id_book_insert = $this->Book_model->addBook($data);

            if($id_book_insert) {
                //ajout dans la table proposition
                $data['id_user'] = $this->session->userdata('user_id');
                $data['id_book'] = $id_book_insert;
                if($this->Book_model->addBookSuggest($data)) {
                    echo json_encode($this->Book_model->getJsonBook($id_book_insert));
                }else{
                    echo json_encode("erroraddsuggest");
                }
            }else{
                echo json_encode("erroradbook");
            }
        }
    }

	public function getJsonBook()
	{
		if(isset($_GET['id'])) {
			$this->load->model('Book_model');
			$data = $this->Book_model->getJsonBook($_GET['id']);
			echo json_encode($data);
		}
	}


}
