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

	public function newUser($user)
	{
		$add = new UsersSalon_e(
			$id_user = $user['id_user'],
			$pseudo_user = $user['pseudo_user'],
			$id_salon = $user['id_salon'],
			$role = $user['role'],
			$nb_signaled = $user['nb_signaled']
		;)

		// TODO : insert en base + ajax
	}

}
