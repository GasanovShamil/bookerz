<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require_once (CLASSES_DIR . "Salon_e.php");
require_once (CLASSES_DIR . "Book_e.php");
class Admin extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->database ();
		$this->load->model ( 'Book_model' );
		$this->load->model ( 'Salon_model' );
		$this->load->model ( 'User_model' );
		$this->load->model ( 'Category_model' );
		$this->load->model ( 'Config_model' );
		$this->load->model ( 'Salon_model' );
		$this->load->helper ( "url", 'language' );
		$this->load->library ( 'pagination' );
		$this->load->library ( array (
				'ion_auth',
				'form_validation',
				'pagination' 
		) );
		$this->form_validation->set_error_delimiters ( $this->config->item ( 'error_start_delimiter', 'ion_auth' ), $this->config->item ( 'error_end_delimiter', 'ion_auth' ) );
		
		$this->lang->load ( 'auth' );
	}
	public function index() {
		$this->render ( 'admin/dashboard' );
	}
	
	// START CONFIG ADMINISTRATION
	public function configListing() {
	}
	public function setConfig() {
	}
	// END CONFIG ADMINISTRATION
	
	// START STATIC PAGES ADMINISTRATION
	public function staticPageListing() {
		$searchText = $this->input->post ( 'searchText' );
		$this->data ['searchText'] = $searchText;
		
		$count = $this->Page_model->staticPageListingCount ( $searchText );
		$returns = $this->paginationCompress ( "staticPageListing/", $count, 5 );
		
		$this->data ['staticPageRecords'] = $this->Page_model->staticPageListing ( $searchText, $returns ["page"], $returns ["segment"] );
		
		$this->render ( 'admin/staticPages', $this->data );
	}
	
	// END STATIC PAGES ADMINISTRATION
	
	// START USER ADMINISTRATION
	public function userListing() {
		$searchText = $this->input->post ( 'searchText' );
		$this->data ['searchText'] = $searchText;
		$status = $this->input->post ( 'status' );
		$this->data ['status'] = $status;
		
		$count = $this->User_model->userListingCount ( $searchText, $status );
		$returns = $this->paginationCompress ( "userListing/", $count, 5 );
		
		$this->data ['userRecords'] = $this->User_model->userListing ( NULL, $searchText, $status, $returns ["page"], $returns ["segment"] )->result ();
		
		foreach ( $this->data ['userRecords'] as $k => $user ) {
			$this->data ['userRecords'] [$k]->groups = $this->User_model->get_users_groups ( $user->id )->result ();
		}
		
		// here is status search dropdown
		$this->data ['statuses'] = array (
				'-1' => 'Status all',
				'1' => 'Active',
				'0' => 'Inactive' 
		);
		// end of status search dropdown
		
		$this->render ( 'admin/users', $this->data );
	}
	function deleteUser() {
		$userId = $this->input->post ( 'userId' );
		$result = $this->User_model->delete_user ( $userId );
		
		if ($result === true) {
			echo (json_encode ( array (
					'status' => TRUE 
			) ));
		} else {
			echo (json_encode ( array (
					'status' => FALSE 
			) ));
		}
	}
	public function create_user() {
		$this->data ['title'] = $this->lang->line ( 'create_user_heading' );
		
		// if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		// {
		// redirect('user', 'refresh');
		// }
		
		$tables = $this->config->item ( 'tables', 'ion_auth' );
		$identity_column = $this->config->item ( 'identity', 'ion_auth' );
		$this->data ['identity_column'] = $identity_column;
		
		// validate form input
		$this->form_validation->set_rules ( 'first_name', $this->lang->line ( 'create_user_validation_fname_label' ), 'required' );
		$this->form_validation->set_rules ( 'last_name', $this->lang->line ( 'create_user_validation_lname_label' ), 'required' );
		if ($identity_column !== 'email') {
			$this->form_validation->set_rules ( 'identity', $this->lang->line ( 'create_user_validation_identity_label' ), 'required|is_unique[' . $tables ['users'] . '.' . $identity_column . ']' );
			$this->form_validation->set_rules ( 'email', $this->lang->line ( 'create_user_validation_email_label' ), 'required|valid_email' );
		} else {
			$this->form_validation->set_rules ( 'email', $this->lang->line ( 'create_user_validation_email_label' ), 'required|valid_email|is_unique[' . $tables ['users'] . '.email]' );
		}
		$this->form_validation->set_rules ( 'phone', $this->lang->line ( 'create_user_validation_phone_label' ), 'trim' );
		$this->form_validation->set_rules ( 'password', $this->lang->line ( 'create_user_validation_password_label' ), 'required|min_length[' . $this->config->item ( 'min_password_length', 'ion_auth' ) . ']|max_length[' . $this->config->item ( 'max_password_length', 'ion_auth' ) . ']|matches[password_confirm]' );
		$this->form_validation->set_rules ( 'password_confirm', $this->lang->line ( 'create_user_validation_password_confirm_label' ), 'required' );
		
		if ($this->form_validation->run () == true) {
			$email = strtolower ( $this->input->post ( 'email' ) );
			$identity = ($identity_column === 'email') ? $email : $this->input->post ( 'identity' );
			$password = $this->input->post ( 'password' );
			
			$additional_data = array (
					'first_name' => $this->input->post ( 'first_name' ),
					'last_name' => $this->input->post ( 'last_name' ),
					'phone' => $this->input->post ( 'phone' ) 
			);
		}
		if ($this->form_validation->run () == true && $this->ion_auth->register ( $identity, $password, $email, $additional_data )) {
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->set_flashdata ( 'message', $this->ion_auth->messages () );
			redirect ( "userListing", 'refresh' );
		} else {
			// display the create user form
			// set the flash data error message if there is one
			$this->data ['message'] = (validation_errors () ? validation_errors () : ($this->ion_auth->errors () ? $this->ion_auth->errors () : $this->session->flashdata ( 'message' )));
			
			$this->data ['first_name'] = array (
					'name' => 'first_name',
					'id' => 'first_name',
					'type' => 'text',
					'value' => $this->form_validation->set_value ( 'first_name' ) 
			);
			$this->data ['last_name'] = array (
					'name' => 'last_name',
					'id' => 'last_name',
					'type' => 'text',
					'value' => $this->form_validation->set_value ( 'last_name' ) 
			);
			$this->data ['identity'] = array (
					'name' => 'identity',
					'id' => 'identity',
					'type' => 'text',
					'value' => $this->form_validation->set_value ( 'identity' ) 
			);
			$this->data ['email'] = array (
					'name' => 'email',
					'id' => 'email',
					'type' => 'text',
					'value' => $this->form_validation->set_value ( 'email' ) 
			);
			$this->data ['phone'] = array (
					'name' => 'phone',
					'id' => 'phone',
					'type' => 'text',
					'value' => $this->form_validation->set_value ( 'phone' ) 
			);
			$this->data ['password'] = array (
					'name' => 'password',
					'id' => 'password',
					'type' => 'password',
					'value' => $this->form_validation->set_value ( 'password' ) 
			);
			$this->data ['password_confirm'] = array (
					'name' => 'password_confirm',
					'id' => 'password_confirm',
					'type' => 'password',
					'value' => $this->form_validation->set_value ( 'password_confirm' ) 
			);
			
			// $this->_render_page('auth/create_user', $this->data);
			$this->render ( 'admin/create_user', $this->data );
		}
	}
	public function edit_user($id) {
		$this->data ['title'] = $this->lang->line ( 'edit_user_heading' );
		
		if (! $this->ion_auth->logged_in () || (! $this->ion_auth->is_admin () && ! ($this->ion_auth->user ()->row ()->id == $id))) {
			redirect ( 'user', 'refresh' );
		}
		
		$user = $this->ion_auth->user ( $id )->row ();
		$groups = $this->ion_auth->groups ()->result_array ();
		$currentGroups = $this->ion_auth->get_users_groups ( $id )->result ();
		
		// validate form input
		$this->form_validation->set_rules ( 'first_name', $this->lang->line ( 'edit_user_validation_fname_label' ), 'required' );
		$this->form_validation->set_rules ( 'last_name', $this->lang->line ( 'edit_user_validation_lname_label' ), 'required' );
		$this->form_validation->set_rules ( 'phone', $this->lang->line ( 'edit_user_validation_phone_label' ), 'required' );
		
		if (isset ( $_POST ) && ! empty ( $_POST )) {
			// do we have a valid request?
			if ($this->_valid_csrf_nonce () === FALSE || $id != $this->input->post ( 'id' )) {
				show_error ( $this->lang->line ( 'error_csrf' ) );
			}
			
			// update the password if it was posted
			if ($this->input->post ( 'password' )) {
				$this->form_validation->set_rules ( 'password', $this->lang->line ( 'edit_user_validation_password_label' ), 'required|min_length[' . $this->config->item ( 'min_password_length', 'ion_auth' ) . ']|max_length[' . $this->config->item ( 'max_password_length', 'ion_auth' ) . ']|matches[password_confirm]' );
				$this->form_validation->set_rules ( 'password_confirm', $this->lang->line ( 'edit_user_validation_password_confirm_label' ), 'required' );
			}
			
			if ($this->form_validation->run () === TRUE) {
				$data = array (
						'first_name' => $this->input->post ( 'first_name' ),
						'last_name' => $this->input->post ( 'last_name' ),
						'phone' => $this->input->post ( 'phone' ) 
				);
				
				// update the password if it was posted
				if ($this->input->post ( 'password' )) {
					$data ['password'] = $this->input->post ( 'password' );
				}
				
				// Update the groups user belongs to
				$groupData = $this->input->post ( 'groups' );
				
				if (isset ( $groupData ) && ! empty ( $groupData )) {
					
					$this->ion_auth->remove_from_group ( '', $id );
					
					foreach ( $groupData as $grp ) {
						$this->ion_auth->add_to_group ( $grp, $id );
					}
				}
				
				// check to see if we are updating the user
				if ($this->ion_auth->update ( $user->id, $data )) {
					$this->session->set_flashdata ( 'message', $this->ion_auth->messages () );
					redirect ( 'userListing', 'refresh' );
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata ( 'message', $this->ion_auth->errors () );
					redirect ( 'user', 'refresh' );
				}
			}
		}
		
		// display the edit user form
		$this->data ['csrf'] = $this->_get_csrf_nonce ();
		
		// set the flash data error message if there is one
		$this->data ['message'] = (validation_errors () ? validation_errors () : ($this->ion_auth->errors () ? $this->ion_auth->errors () : $this->session->flashdata ( 'message' )));
		
		// pass the user to the view
		$this->data ['user'] = $user;
		$this->data ['groups'] = $groups;
		$this->data ['currentGroups'] = $currentGroups;
		
		$this->data ['first_name'] = array (
				'name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'first_name', $user->first_name ) 
		);
		$this->data ['last_name'] = array (
				'name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'last_name', $user->last_name ) 
		);
		$this->data ['phone'] = array (
				'name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'phone', $user->phone ) 
		);
		$this->data ['password'] = array (
				'name' => 'password',
				'id' => 'password',
				'type' => 'password' 
		);
		$this->data ['password_confirm'] = array (
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password' 
		);
		
		// $this->_render_page('auth/edit_user', $this->data);
		$this->render ( 'admin/edit_user', $this->data );
	}
	
	// activate the user
	public function activate() {
		$id = $this->input->post ( 'userId' );
		$activation = $this->ion_auth->activate ( $id );
		
		if ($activation === true) {
			echo (json_encode ( array (
					'status' => TRUE,
					'mode' => 'active',
					'message' => $this->ion_auth->messages () 
			) ));
		} else {
			echo (json_encode ( array (
					'status' => FALSE,
					'message' => $this->ion_auth->errors () 
			) ));
		}
	}
	
	// deactivate the user
	public function deactivate() {
		$id = $this->input->post ( 'userId' );
		$desactivation = $this->ion_auth->deactivate ( $id );
		
		if ($desactivation === true) {
			echo (json_encode ( array (
					'status' => TRUE,
					'mode' => 'inactive',
					'message' => $this->ion_auth->messages () 
			) ));
		} else {
			echo (json_encode ( array (
					'status' => FALSE,
					'message' => $this->ion_auth->errors () 
			) ));
		}
	}
	
	// END USER ADMINISTRATION
	
	// START CATEGORY ADMINISTRATION
	public function categoryListing() {
		$searchText = $this->input->post ( 'searchText' );
		$this->data ['searchText'] = $searchText;
		
		$count = $this->Category_model->categoryListingCount ( $searchText );
		$returns = $this->paginationCompress ( "categoryListing/", $count, 5 );
		
		$this->data ['categoryRecords'] = $this->Category_model->categoryListing ( $searchText, $returns ["page"], $returns ["segment"] );
		$this->render ( 'admin/categories', $this->data );
	}
	public function editCategory($id) {
		$category = $this->Category_model->getCategory ( $id );
		
		// validate form input
		$this->form_validation->set_rules ( 'name', 'Nom de category', 'required' );
		$this->form_validation->set_rules ( 'description', 'Description de category', 'required' );
		
		if (isset ( $_POST ) && ! empty ( $_POST )) {
			if ($this->form_validation->run () === TRUE) {
				$data = array (
						'name' => $this->input->post ( 'name' ),
						'description' => $this->input->post ( 'description' ) 
				);
				
				if ($this->Category_model->updateCategory ( $data, $id )) {
					$this->session->set_flashdata ( 'message', 'Category cree!' );
					redirect ( 'categoryListing', 'refresh' );
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata ( 'message', 'erreur' );
					redirect ( 'categoryListing', 'refresh' );
				}
			}
		}
		
		// set the flash data error message if there is one
		$this->data ['message'] = (validation_errors () ? validation_errors () : ($this->ion_auth->errors () ? $this->ion_auth->errors () : $this->session->flashdata ( 'message' )));
		
		// pass the user to the view
		$this->data ['id'] = $category->getId ();
		
		$this->data ['name'] = array (
				'name' => 'name',
				'id' => 'name',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'name', $category->getName () ) 
		);
		$this->data ['description'] = array (
				'name' => 'description',
				'id' => 'description',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'last_name', $category->getDescription () ) 
		);
		
		// $this->_render_page('auth/edit_user', $this->data);
		$this->render ( 'admin/edit_category', $this->data );
	}
	public function create_category() {
		
		// validate form input
		$this->form_validation->set_rules ( 'name', 'Nom de category', 'required' );
		$this->form_validation->set_rules ( 'description', 'Description de category', 'required' );
		
		if (isset ( $_POST ) && ! empty ( $_POST )) {
			if ($this->form_validation->run () === TRUE) {
				$data = array (
						'name' => $this->input->post ( 'name' ),
						'description' => $this->input->post ( 'description' ) 
				);
				
				if ($this->Category_model->createCategory ( $data )) {
					$this->session->set_flashdata ( 'message', 'Category cree!' );
					redirect ( 'categoryListing', 'refresh' );
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata ( 'message', 'erreur' );
					redirect ( 'categoryListing', 'refresh' );
				}
			}
		}
		
		// set the flash data error message if there is one
		$this->data ['message'] = (validation_errors () ? validation_errors () : ($this->ion_auth->errors () ? $this->ion_auth->errors () : $this->session->flashdata ( 'message' )));
		
		$this->data ['name'] = array (
				'name' => 'name',
				'id' => 'name',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'name' ) 
		);
		$this->data ['description'] = array (
				'name' => 'description',
				'id' => 'description',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'description' ) 
		);
		
		// $this->_render_page('auth/edit_user', $this->data);
		$this->render ( 'admin/create_category', $this->data );
	}
	function deleteCategory() {
		$categoryId = $this->input->post ( 'categoryId' );
		
		if ($this->Category_model->isCategoryUsed ( $categoryId )) {
			echo (json_encode ( array (
					'status' => FALSE,
					'message' => 'Category used in book' 
			) ));
		} else {
			$result = $this->Category_model->deleteCategory ( $categoryId );
			
			if ($result === true) {
				echo (json_encode ( array (
						'status' => TRUE,
						'message' => 'Categorie successfully deleted' 
				) ));
			} else {
				echo (json_encode ( array (
						'status' => FALSE,
						'message' => 'Unknown error' 
				) ));
			}
		}
	}
	
	// END CATEGORY ADMINISTRATION
	
	// START SALON ADMINISTRATION
	public function salonListing() {	
		$this->data['rooms'] = $this->Salon_model->getSalon();
		$this->data['nextRooms'] = $this->Salon_model->getSalon("next");
		$this->data['endedRooms'] = $this->Salon_model->getSalon("finished");
		$this->data['closedRooms'] = $this->Salon_model->getSalon("closed");
		
		$this->render ( 'admin/salons', NULL );
	}
	
	
	public function createSalon($id)
	{
		
		$this->data['book_id'] = $id;
		
		$this->form_validation->set_rules('name', 'nom du salon', 'required');
		$this->form_validation->set_rules('start_date_day', 'jour d\'ouverture du salon', 'required');
		$this->form_validation->set_rules('start_date_hour','champs heure d\'ouverture du salon','required');
		$this->form_validation->set_rules('end_date_day','jour de fin du salon','required');
		$this->form_validation->set_rules('end_date_hour','champs heure de fin du salon','required');
		$this->form_validation->set_rules('id_livre','livre','required');
		$this->form_validation->set_rules('nb_max_report_needed','nombre de signalement maximal par utilisateur','required');
		
		if($this->form_validation->run() === FALSE) {
			$this->render('admin/createSalon', $this->data);
		} else {
			$start_date = $this->input->post('start_date_day') . " " . $this->input->post('start_date_hour');
			$end_date = $this->input->post('end_date_day') . " " . $this->input->post('end_date_hour');
			
			if($start_date <= date('Y-m-d H:i:s')) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$salon = new Salon_e(
					0,
					$this->input->post('name'),
					$start_date,
					$end_date,
					$this->input->post('id_livre'),
					$this->input->post('nb_max_user'),
					$status,
					$this->input->post('nb_max_report_needed'),
					0
					);
			$this->Salon_model->createSalon($salon);
			$this->data['success'] = "Le salon vient d'être crée";
			redirect ( 'salonListing', 'refresh' );
		}
	}
	
	public function deleteSalon($id)
	{
		$this->Salon_model->delete($id);
		redirect('salonListing');
	}
	
	public function reopenSalon($id)
	{
		$this->Salon_model->reopen($id);
		redirect('salonListing');
	}
	
	public function checkSalon()
	{
		$this->Salon_model->checkSalonstatus();
	}
	
	// END SALON ADMINISTRATION
	
	// START BOOK ADMINISTRATION
	public function bookListing() {
		$searchText = $this->input->post ( 'searchText' );
		$this->data ['searchText'] = $searchText;
		$category = $this->input->post ( 'category' );
		$this->data ['category'] = $category;
		$status = $this->input->post ( 'status' );
		$this->data ['status'] = $status;
		$order = $this->input->post ( 'order' );
		$this->data ['order'] = $order;
		
		$count = $this->Book_model->bookListingCount ( $searchText, $category, $order, $status );
		$returns = $this->paginationCompress ( "bookListing/", $count, 5 );
		
		$this->data ['bookRecords'] = $this->Book_model->bookListing ( $searchText, $category, $order, $status, $returns ["page"], $returns ["segment"] );
		if ($this->data ['bookRecords']) {
			foreach ( $this->data ['bookRecords'] as $k => $book ) {
				$this->data ['bookRecords'] [$k]->setCategories ( $this->Category_model->getBookCategories ( $book->getId () ) );
			}
		}
		
		// here is status search dropdown
		$this->data ['statuses'] = array (
				'-1' => 'Status all',
				'1' => 'Accepted',
				'0' => 'Not accepted' 
		);
		// end of status search dropdown
		
		// here is order by search dropdown
		$this->data ['orders'] = array (
				'id' => 'Order by',
				'title' => 'Title',
				'author' => 'Author' 
		);
		
		// here is category search dropdown
		$catArray = $this->Category_model->getCategories ();
		$categories ['0'] = 'All categories';
		foreach ( $catArray as $cat ) {
			$categories [$cat->getId ()] = $cat->getName ();
		}
		// end category search dropdown
		
		$this->data ['categories'] = $categories;
		
		$this->render ( 'admin/books', $this->data );
	}
	public function editBook($id) {
		$book = $this->Book_model->getBookById ( $id );
		
		// here is category search dropdown
		$catArray = $this->Category_model->getCategories ();
		
		foreach ( $catArray as $cat ) {
			$categories [$cat->getId ()] = $cat->getName ();
		}
		// end category search dropdown
		
		$this->data ['categories'] = $categories;
		$accepted = $this->input->post ( 'accepted' );
		
		// validate form input
		$this->form_validation->set_rules ( 'cover', 'Page de couverture', 'valid_url' );
		$this->form_validation->set_rules ( 'title', 'Le titre', 'required' );
		$this->form_validation->set_rules ( 'description', 'Description', 'required' );
		$this->form_validation->set_rules ( 'author', 'L\'auteur', 'required' );
		$this->form_validation->set_rules ( 'published', 'Date de publication', 'required' );
		$this->form_validation->set_rules ( 'editor', 'L\'editeur', 'required' );
		
		if (isset ( $_POST ) && ! empty ( $_POST )) {
			if ($this->form_validation->run () === TRUE) {
				$data = array (
						'cover' => $this->input->post ( 'cover' ),
						'title' => $this->input->post ( 'title' ),
						'description' => $this->input->post ( 'description' ),
						'author' => $this->input->post ( 'author' ),
						'published' => $this->input->post ( 'published' ),
						'editor' => $this->input->post ( 'editor' ),
						'accepted' => ($accepted) ? true : false 
				);
				
				// Update the groups user belongs to
				$categoryData = $this->input->post ( 'category' );
				
				if (isset ( $categoryData ) && ! empty ( $categoryData )) {
					
					$this->Category_model->updateBookCategories ( $id, $categoryData );
				}
				
				if ($this->Book_model->updateBook ( $data, $id )) {
					$this->session->set_flashdata ( 'message', 'Book  edited!' );
					redirect ( 'bookListing', 'refresh' );
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata ( 'message', 'erreur' );
					redirect ( 'bookListing', 'refresh' );
				}
			}
		}
		
		// set the flash data error message if there is one
		$this->data ['message'] = (validation_errors () ? validation_errors () : ($this->ion_auth->errors () ? $this->ion_auth->errors () : $this->session->flashdata ( 'message' )));
		
		// pass the user to the view
		$this->data ['id'] = $id;
		$bookcategories = $this->Category_model->getBookCategories ( $id );
		if ($bookcategories) {
			foreach ( $bookcategories as $cat ) {
				$selected_cat [] = $cat->getId ();
			}
			$this->data ['bookcategories'] = $selected_cat;
		}else{
			$this->data ['bookcategories'] = '';
		}
		
		$this->data ['cover'] = array (
				'name' => 'cover',
				'id' => 'cover',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'cover', $book->getCover () ) 
		);
		$this->data ['title'] = array (
				'name' => 'title',
				'id' => 'title',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'title', $book->getTitle () ) 
		);
		$this->data ['description'] = array (
				'name' => 'description',
				'id' => 'description',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'description', $book->getDescription () ) 
		);
		$this->data ['author'] = array (
				'name' => 'author',
				'id' => 'author',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'author', $book->getAuthor () ) 
		);
		$this->data ['published'] = array (
				'name' => 'published',
				'id' => 'published',
				'type' => 'date',
				'value' => $this->form_validation->set_value ( 'published', $book->getPublished () ) 
		);
		$this->data ['editor'] = array (
				'name' => 'editor',
				'id' => 'editor',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'editor', $book->getEditor () ) 
		);
		
		$this->data ['accepted'] = ($book->isAccepted ()) ? 'checked="checked"' : '';
		
		// $this->_render_page('auth/edit_user', $this->data);
		$this->render ( 'admin/_bookForm', $this->data );
	}
	function deleteBook() {
		$bookId = $this->input->post ( 'bookid' );
		
		if ($this->Book_model->hasOpenRoom ( $bookId )) {
			echo (json_encode ( array (
					'status' => FALSE,
					'message' => 'Can not delete book with opened room' 
			) ));
		} else {
			$result = $this->Book_model->deleteBook ( $bookId );
			
			if ($result === true) {
				echo (json_encode ( array (
						'status' => TRUE,
						'message' => 'Book successfully deleted' 
				) ));
			} else {
				echo (json_encode ( array (
						'status' => FALSE,
						'message' => 'Unknown error' 
				) ));
			}
		}
	}
	// END BOOK ADMINISTRATION
	
	// help functions
	public function _get_csrf_nonce() {
		$this->load->helper ( 'string' );
		$key = random_string ( 'alnum', 8 );
		$value = random_string ( 'alnum', 20 );
		$this->session->set_flashdata ( 'csrfkey', $key );
		$this->session->set_flashdata ( 'csrfvalue', $value );
		
		return array (
				$key => $value 
		);
	}
	public function _valid_csrf_nonce() {
		$csrfkey = $this->input->post ( $this->session->flashdata ( 'csrfkey' ) );
		if ($csrfkey && $csrfkey == $this->session->flashdata ( 'csrfvalue' )) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function getInfoUser() {
		$infouser = $this->User_model->getInfoUser ( $_POST ['id'] );
		echo json_encode ( $infouser );
	}
	public function updateInfoUser() {
		if ($_POST ['lastname'] == "") {
			$infousers = $this->User_model->getInfoUser ( $_POST ['id'] );
			$data ["lastname"] = $infousers [0]->last_name;
		} else {
			$data ["lastname"] = $_POST ['lastname'];
		}
		if ($_POST ['firstname'] == "") {
			$infouser = $this->User_model->getInfoUser ( $_POST ['id'] );
			$data ["firstname"] = $infouser [0]->first_name;
		} else {
			$data ["firstname"] = $_POST ['firstname'];
		}
		if ($_POST ['phone'] == "") {
			$infouser = $this->User_model->getInfoUser ( $_POST ['id'] );
			$data ["phone"] = $infouser [0]->phone;
		} else {
			$data ["phone"] = $_POST ['phone'];
		}
		if ($this->User_model->updateInfoUser ( $data, $_POST ['id'] ) == true) {
			echo json_encode ( "success" );
		} else {
			echo json_encode ( "error" );
		}
	}
	public function updatePwd() {
		var_dump ( $_POST );
		$infousers = $this->User_model->getInfoUser ( $_POST ['id'] );
		if ($this->ion_auth->change_password ( $infousers [0]->email, $_POST ['ancienmdp'], $_POST ['nvmdp'] )) {
			echo json_encode ( "success" );
		} else {
			echo json_encode ( "error" );
		}
	}
}