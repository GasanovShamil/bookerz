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
	
	public function facebook()
	{
		$helper = $this->fb->getRedirectLoginHelper();
		try
		{
			$accessToken = $helper->getAccessToken();
		}
		catch(Facebook\Exceptions\FacebookResponseException $e)
		{
			// When Graph returns an error
			echo 'There was an error while trying to login using Facebook: ' . $e->getMessage();
			exit;
		}
		catch(Facebook\Exceptions\FacebookSDKException $e)
		{
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
		
		if (isset($accessToken))
		{
			$this->fb->setDefaultAccessToken($accessToken);
			try
			{
				$response = $this->fb->get('/me?fields=id,name,email');
				$user = $response->getGraphUser(); // we retrieve the user data
			}
			catch(Facebook\Exceptions\FacebookResponseException $e)
			{
				// When Graph returns an error
				echo 'Could not retrieve user data: ' . $e->getMessage();
				exit;
			}
			catch(Facebook\Exceptions\FacebookSDKException $e)
			{
				// When validation fails or other local issues
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}
			
			//we do not actually need to verify if the user email address is correct... but we should make sure
			if($this->form_validation->valid_email($user['email']))
			{
				$this->load->model('user_model');
				if($this->user_model->login_with_facebook($user['email'], $user['name']))
				{
					redirect('/');
				}
				else
				{
					redirect('user/login');
				}
			}
		}
		else
		{
			echo 'oups... where is the access token???';
		}
	}
	
	public function logout() {
		$this->ion_auth->logout ();
		redirect ( '/' );
		
		
	}
}