<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function login_with_facebook($email, $username)
	{
		$this->db->where('email',$email);
		$this->db->limit(1);
		$users = $this->db->count_all_results('users');
		if(!isset($users) || $users<1)
		{
			$this->load->helper('string');
			$password = random_string('alnum',10); // we create a random password for the user...
			$register_id = $this->ion_auth->register($username,$password,$email,array(),array('2'));
			if($register_id)
			{
				$this->ion_auth->activate($register_id);
				$this->ion_auth->login($username,$password, TRUE);
			}
		}
		else
		{
			$user = $this->db->where(array('email'=>$email))->limit(1)->get('users')->row();
			$_SESSION['identity'] = $user->username;
			$_SESSION['username'] = $user->username;
			$_SESSION['email'] = $user->email;
			$_SESSION['user_id'] = $user->id; //everyone likes to overwrite id so we'll use user_id
			$_SESSION['old_last_login'] = $user->last_login;
		}
		return TRUE;
	}
}