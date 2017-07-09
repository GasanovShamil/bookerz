<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin extends Admin_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'Book_model' );
		$this->load->model ( 'Salon_model' );
		$this->load->model ( 'User_model' );
		$this->load->helper ( "url" );
		$this->load->library ( "pagination" );
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
			
			$this->data['userRecords'] = $this->User_model->userListing($searchText, $returns["page"], $returns["segment"]);
				
			$this->render ( 'admin/users', $this->data);		
	}
	
	function deleteUser()
	{
			
			$userId = $this->input->post('userId');
			$result = $this->User_model->delete_user($userId);
			
			if ($result === true) { echo(json_encode(array('status'=>TRUE))); }
			else { echo(json_encode(array('status'=>FALSE))); }
		
	}
	
}