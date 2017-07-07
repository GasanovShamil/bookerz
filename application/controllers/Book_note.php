<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Book_note extends Auth_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function check()
    {
        if(isset($_GET['id_book'])) {

            $id_user = $_SESSION['user_id'];
            $id_book = $_GET['id_book'];

            $this->load->model('Book_note_model');
            $check = $this->Book_note_model->checkNote($id_user, $id_book);

            if($check) {
                echo json_encode('success');
            } else {
                echo json_encode('error');
            }

        } else {
            echo 'no';
        }
    }

}
