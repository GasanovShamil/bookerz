<?php
require_once (CLASSES_DIR . "Book_note_e.php");
class Book_note_model extends CI_Model
{
    private $table = "book_note";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function checkNote($id_user, $id_book)
    {
        $this->db->from($this->table);
        $this->db->where(array('id_user' => $id_user));
        $this->db->where(array('id_book' => $id_book));

        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function giveGrade($user, $book, $grade)
    {
        $data = array(
            'id_user' => $user,
            'id_book' => $book,
            'note'    => $grade,
            'date'    => date("Y-m-d H:i:s")
        );

        return $this->db->insert($this->table, $data);
    }
}
