<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class User extends MY_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->library ( 'ion_auth' );
	}
	public function index() {
		$this->load->view ( 'welcome_message' );
	}
	public function registration() {		
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'first_name', 'First name', 'trim|required' );
		$this->form_validation->set_rules ( 'last_name', 'Last name', 'trim|required' );
		$this->form_validation->set_rules ( 'username', 'Username', 'trim|required|is_unique[users.username]' );
		$this->form_validation->set_rules ( 'email', 'Email', 'trim|valid_email|required' );
		$this->form_validation->set_rules ( 'password', 'Password', 'trim|min_length[8]|max_length[20]|required' );
		$this->form_validation->set_rules ( 'confirm_password', 'Confirm password', 'trim|matches[password]|required' );
		
		if ($this->form_validation->run () === FALSE) {
			$this->render ( 'user/registrationtest.php' );
		} else {
			$first_name = $this->input->post ( 'first_name' );
			$last_name = $this->input->post ( 'last_name' );
			$username = $this->input->post ( 'username' );
			$email = $this->input->post ( 'email' );
			$password = $this->input->post ( 'password' );

			$additional_data = array (
					'first_name' => $first_name,
					'last_name' => $last_name 
			);
			
			if ($this->ion_auth->register ( $username, $password, $email, $additional_data )) {
				$_SESSION ['auth_message'] = 'The account has been created. You may now login.';
				$this->session->mark_as_flash ( 'auth_message' );
				redirect ( 'user/login' );
			} else {
				$_SESSION ['auth_message'] = $this->ion_auth->errors ();
				$this->session->mark_as_flash ( 'auth_message' );
				redirect ( 'user/registration' );
			}
		}
	}
	public function login() {
		if ($this->ion_auth->logged_in () === TRUE) {
			redirect ( 'profil' );
		}
		$this->data ['title'] = "Login";
		
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'email', 'Email', 'required|valid_email' );
		$this->form_validation->set_rules ( 'password', 'Password', 'required' );
		if ($this->form_validation->run () === FALSE) {
			$this->render ( 'user/login.php', null, 'public_master' );
		} else {
			$remember = ( bool ) $this->input->post ( 'remember' );
			if ($this->ion_auth->login ( $this->input->post ( 'email' ), $this->input->post ( 'password' ), $remember )) {
				redirect ( 'profil' );
			} else {
				$_SESSION ['auth_message'] = $this->ion_auth->errors ();
				$this->session->mark_as_flash ( 'auth_message' );
				redirect ( 'user/login' );
			}
		}
	}
	public function logout() {
		$this->ion_auth->logout ();
		redirect ( '/' );
	}
}