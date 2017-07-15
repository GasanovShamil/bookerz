<?php
require_once (CLASSES_DIR . "Chatroom_to_salon_e.php");
class chatroom_to_salon_model extends CI_Model
{
    private $table = "chatroom_to_salon";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getChatroomsForBook($id_salon)
    {
        $this->db->from($this->table);
        $this->db->where(array('id_salon' => $id_salon));

        $query = $this->db->get();

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $chatrooms[] = new Chatroom_to_salon_e(
                    $row->id,
                    $row->id_user,
                    $row->id_salon
                );
            }
            return $chatrooms;
        }
        return null;
    }

    public function newChatroomForBook($id_salon)
    {
        $data = array(
            'id_user' => $_SESSION['user_id'],
            'id_salon' => $id_salon
        );

        return $this->db->insert($this->table, $data);
    }

    public function getSalon($id_chatroom)
    {
        $this->db->from($this->table);
        $this->db->where(array('id' => $id_chatroom));

        $query = $this->db->get();
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $chatroom = new Chatroom_to_salon_e(
                    $row->id,
                    $row->id_user,
                    $row->id_salon
                );
                return $chatroom;
            }
        }
        return false;
    }

}
