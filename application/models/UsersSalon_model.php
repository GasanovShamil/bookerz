<?php
require_once (CLASSES_DIR . "UsersSalon_e.php");
class UsersSalon_model extends CI_Model
{
	private $table = "users_salon";

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function newUser($user, $room)
	{
		$now = date('Y-m-d H:i:s');
		$data = array(
			'id_user' => $user,
			'id_salon' => $room,
			'role' 	   => 1,
			'nb_signaled' => 0
		);

		return $this->db->insert($this->table, $data);
	}

	public function leftUser($user, $room)
	{

		$query = $this->db->from($this->table);
		$array = array('id_user' => $user, 'id_salon' => $room);
		$this->db->where($array);
		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$this->db->delete($this->table, $array);
		}
	}

	public function getUsersIn($id)
	{
		$this->db->from($this->table);
		$this->db->join("users", "users.id = users_salon.id_user");
		$this->db->where('id_salon', $id);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$usersIn[] = [
					new UsersSalon_e (
						$row->id,
						$row->id_user,
						$row->id_salon,
						$row->role,
						$row->nb_signaled
					),
					$row->first_name,
					$row->last_name
				];
			}
			return $usersIn;
		}
		return false;
	}

	public function isIn($userid, $room)
	{
		$this->db->from($this->table);
		$array = array('id_user' => $userid, 'id_salon' => $room);
		$this->db->where($array);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return true;
		}
		return false;
	}

	public function getNbUsers($id_salon) {
		$this->db->from($this->table);
		$this->db->where(array('id_salon' => $id_salon));
		$query = $this->db->get();

		// $result = $query->row_array();
		// $count = $result['COUNT(*)'];
		return $query->num_rows();
	}

}
