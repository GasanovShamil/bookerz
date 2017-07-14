<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin extends Admin_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->load->database();
		$this->load->model ( 'Book_model' );
		$this->load->model ( 'Salon_model' );
		$this->load->model ( 'User_model' );
		$this->load->helper ( "url",'language');
		$this->load->library(array('ion_auth','form_validation','pagination'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		$this->lang->load('auth');
	}
	
	public function index()
	{	
		$this->render ( 'admin/dashboard');
	}
	
	
	public function userListing()
	{		
			$searchText = $this->input->post('searchText');
			$this->data['searchText'] = $searchText;
			
			$this->load->library('pagination');
			
			$count = $this->User_model->userListingCount($searchText);
			$returns = $this->paginationCompress ( "userListing/", $count, 5 );
			
			$this->data['userRecords'] = $this->User_model->userListing(NULL, $searchText, $returns["page"], $returns["segment"])->result();
				
			foreach ($this->data['userRecords'] as $k => $user)
			{
				$this->data['userRecords'][$k]->groups = $this->User_model->get_users_groups($user->id)->result();
			}
			
			$this->render ( 'admin/users', $this->data);		
	}
	
	function deleteUser()
	{
			
			$userId = $this->input->post('userId');
			$result = $this->User_model->delete_user($userId);
			
			if ($result === true) { echo(json_encode(array('status'=>TRUE))); }
			else { echo(json_encode(array('status'=>FALSE))); }
		
	}
	
	public function create_user()
	{
		$this->data['title'] = $this->lang->line('create_user_heading');
		
		//         if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
			//         {
			//             redirect('user', 'refresh');
			//         }
		
		$tables = $this->config->item('tables','ion_auth');
		$identity_column = $this->config->item('identity','ion_auth');
		$this->data['identity_column'] = $identity_column;
		
		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
		if($identity_column!=='email')
		{
			$this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
		}
		else
		{
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
		
		if ($this->form_validation->run() == true)
		{
			$email    = strtolower($this->input->post('email'));
			$identity = ($identity_column==='email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');
			
			$additional_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'phone'      => $this->input->post('phone'),
			);
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
		{
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("userListing", 'refresh');
		}
		else
		{
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->data['first_name'] = array(
					'name'  => 'first_name',
					'id'    => 'first_name',
					'type'  => 'text',
					'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
					'name'  => 'last_name',
					'id'    => 'last_name',
					'type'  => 'text',
					'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['identity'] = array(
					'name'  => 'identity',
					'id'    => 'identity',
					'type'  => 'text',
					'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['email'] = array(
					'name'  => 'email',
					'id'    => 'email',
					'type'  => 'text',
					'value' => $this->form_validation->set_value('email'),
			);
			$this->data['phone'] = array(
					'name'  => 'phone',
					'id'    => 'phone',
					'type'  => 'text',
					'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['password'] = array(
					'name'  => 'password',
					'id'    => 'password',
					'type'  => 'password',
					'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
					'name'  => 'password_confirm',
					'id'    => 'password_confirm',
					'type'  => 'password',
					'value' => $this->form_validation->set_value('password_confirm'),
			);
			
			//             $this->_render_page('auth/create_user', $this->data);
			$this->render('admin/create_user', $this->data);
		}
	}
	
	public function edit_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');
		
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('user', 'refresh');
		}
		
		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
		
		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		
		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}
			
			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}
			
			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
						'first_name' => $this->input->post('first_name'),
						'last_name'  => $this->input->post('last_name'),
						'phone'      => $this->input->post('phone'),
				);
				
				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}
				
				
				
				
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');
					
					if (isset($groupData) && !empty($groupData)) {
						
						$this->ion_auth->remove_from_group('', $id);
						
						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}
						
					}
				
				
				// check to see if we are updating the user
				if($this->ion_auth->update($user->id, $data))
				{
					$this->session->set_flashdata('message', $this->ion_auth->messages() );
						redirect('userListing', 'refresh');					
				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors() );
						redirect('user', 'refresh');		
				}
				
			}
		}
		
		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();
		
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		
		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;
		
		$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['password'] = array(
				'name' => 'password',
				'id'   => 'password',
				'type' => 'password'
		);
		$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id'   => 'password_confirm',
				'type' => 'password'
		);
		
		// 		$this->_render_page('auth/edit_user', $this->data);
		$this->render('admin/edit_user', $this->data);
	}
	
	// activate the user
	public function activate()
	{
		$id = $this->input->post('userId');
		$activation = $this->ion_auth->activate($id);
		
		
			
			if ($activation=== true) { echo(json_encode(array('status'=>TRUE,'mode'=>'active', 'message' => $this->ion_auth->messages()))); }
			else { echo(json_encode(array('status'=>FALSE, 'message'=> $this->ion_auth->errors()))); }
	}
	
	// deactivate the user
	public function deactivate()
	{	
		$id = $this->input->post('userId');
		$desactivation = $this->ion_auth->deactivate($id);
		
		if ($desactivation=== true) { echo(json_encode(array('status'=>TRUE,'mode'=>'inactive','message' => $this->ion_auth->messages()))); }
		else { echo(json_encode(array('status'=>FALSE, 'message'=> $this->ion_auth->errors()))); }
	}
	
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
		
		return array($key => $value);
	}
	
	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function getInfoUser(){
		$infouser = $this->User_model->getInfoUser($_POST['id']);
		echo json_encode($infouser);
	}
	
	public function updateInfoUser(){
		if($_POST['lastname'] == ""){
			$infousers = $this->User_model->getInfoUser($_POST['id']);
			$data["lastname"] = $infousers[0]->last_name;
		}else{
			$data["lastname"] = $_POST['lastname'];
		}
		if($_POST['firstname'] == ""){
			$infouser = $this->User_model->getInfoUser($_POST['id']);
			$data["firstname"] = $infouser[0]->first_name;
		}else{
			$data["firstname"] = $_POST['firstname'];
		}
		if($_POST['phone'] == ""){
			$infouser = $this->User_model->getInfoUser($_POST['id']);
			$data["phone"] = $infouser[0]->phone;
		}else{
			$data["phone"] = $_POST['phone'];
		}
		if($this->User_model->updateInfoUser($data, $_POST['id']) == true){
			echo json_encode("success");
		}else{
			echo json_encode("error");
		}
	}
	
	public function updatePwd(){
		var_dump($_POST);
		$infousers = $this->User_model->getInfoUser($_POST['id']);
		if($this->ion_auth->change_password($infousers[0]->email, $_POST['ancienmdp'], $_POST['nvmdp'])){
			echo json_encode("success");
		}else{
			echo json_encode("error");
		}
	}
	
}