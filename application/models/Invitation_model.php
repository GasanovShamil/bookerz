<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require_once (CLASSES_DIR . "Invitation_e.php");
Class Invitation_model extends CI_Model
{
    private $table = "invitation";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function sendInvitation($email, $url, $room)
    {
        $data = array(
            'email' => $email,
            'url' => $url,
            'chatroom_id' => $room
        );

        return $this->db->insert($this->table, $data);
    }

    public function getInvitation($url)
    {
        $this->db->from($this->table);
        $this->db->where(array('url' => $url));
        $query = $this->db->get();

        $res = $query->row();
        $invitation = new Invitation_e(
            $row->id,
            $row->email,
            $row->url,
            $row->chatroom_id
        );
        return $invitation;

    }

    public function userIsInvited($user, $room)
    {
        $this->db->from($this->table);
        $this->db->join("users", "invitation.email = users.email");
        $this->db->where(array('invitation.chatroom_id' => $room));
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
}
