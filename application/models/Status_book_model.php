<?php
require_once (CLASSES_DIR . "Category_e.php");
class Status_book_model extends CI_Model
{
    private $table = "status_book";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getStatus()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }
}