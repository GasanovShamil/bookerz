<?php
require_once (CLASSES_DIR . "MessagesSalon_e.php");
class MessagesSalon_model extends CI_Model
{
	// CLASSE A CHANGER TOTALEMENT SI ON A LE TEMPS
	private $table = "messages_salon";
	public $id_salon;
	public $id_user;
	public $message;
	public $date;

	public function getMessagesForRoom($id)
	{
		$this->db->order_by("date", "asc");
		$this->db->join('users', 'users.id = messages_salon.id_user');
		$query = $this->db->get_where($this->table, array('id_salon' => $id));

		return $query->result_array();
	}

	public function insertMessage($message, $room, $user)
	{
		$date = date('Y-m-d H:i:s');

		$data = array(
			'id_salon'  => $room,
			'id_user'   => $user,
			'message'   => $message,
			'date'		=> $date
		);

		return $this->db->insert($this->table, $data);
	}

}
