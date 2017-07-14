<?php
require_once (CLASSES_DIR . "Report_e.php");
class Report_model extends CI_Model
{
    private $table = "report";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addReport($id_user, $id_user_reported, $id_salon, $reason, $date)
    {
        $data = array(
            'id_user'          => $id_user,
            'id_user_reported' => $id_user_reported,
            'id_salon'         => $id_salon,
            'reason'           => $reason,
            'date'             => $date
        );

        return $this->db->insert($this->table, $data);
    }

    public function checkReport($id_user, $id_user_reported, $id_salon)
    {
        $this->db->from($this->table);

        $this->db->where(array('id_user' => $id_user));
        $this->db->where(array('id_user_reported' => $id_user_reported));
        $this->db->where(array('id_salon' => $id_salon));

        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
}
