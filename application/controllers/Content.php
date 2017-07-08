<?php
use phpDocumentor\Reflection\Types\Null_;

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Content extends MY_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'Book_model' );
		$this->load->model ( 'Category_model' );
		$this->load->helper ( "url" );
		$this->load->library ( "pagination" );
	}
	public function index() {
		$filter_session_data = array ();
		$config = array ();
		$config ["base_url"] = base_url () . 'content/index';
		$config ["total_rows"] = $this->Book_model->record_count ();
		$config ["per_page"] = 8;
		$config ["uri_segment"] = 3;
		
		// Twitter integration
		$config ['full_tag_open'] = "<ul class='pagination'>";
		$config ['full_tag_close'] = "</ul>";
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config ['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config ['next_tag_open'] = "<li>";
		$config ['next_tagl_close'] = "</li>";
		$config ['prev_tag_open'] = "<li>";
		$config ['prev_tagl_close'] = "</li>";
		$config ['first_tag_open'] = "<li>";
		$config ['first_tagl_close'] = "</li>";
		$config ['last_tag_open'] = "<li>";
		$config ['last_tagl_close'] = "</li>";
		
		$this->pagination->initialize ( $config );
		$page = ($this->uri->segment ( 3 )) ? $this->uri->segment ( 3 ) : 0;
		
		// ==============================
		
		$search_string = $this->input->post ( 'search_string' );
		$order = $this->input->post ( 'order' );
		$order_type = $this->input->post ( 'order_type' );
		$category = $this->input->post('category');
		
		// if order type was changed
		if ($order_type) {
			$filter_session_data ['order_type'] = $order_type;
		} else {
			// we have something stored in the session?
			if ($this->session->userdata ( 'order_type' )) {
				$order_type = $this->session->userdata ( 'order_type' );
			} else {
				// if we have nothing inside session, so it's the default "Asc"
				$order_type = 'acs';
			}
		}
		if($category){
			$filter_session_data['category'] = $category;
		} else {
			if ($this->session->userdata('category')){
				$category = $this->session->userdata('category');
			}else{
				$category = 'all';
			}
		}
		// make the data type var avaible to our view
		$data ['order_type_selected'] = $order_type;
		$data ['category_selected'] = $category;
		
		if ($search_string !== false && $order !== false || $this->uri->segment ( 3 ) == true) {
			
			/*
			 * if post is not null, we store it in session data array
			 * if is null, we use the session data already stored
			 * we save order into the the var to load the view with the param already selected
			 */
			
			if ($search_string) {
				$filter_session_data ['search_string_selected'] = $search_string;
			}
			$data ['search_string_selected'] = $search_string;
			
			
			if ($order) {
				$filter_session_data ['order'] = $order;
			} else {
				$order = $this->session->userdata ( 'order' );
			}
			$data ['order'] = $order;
			
			// save session data into the session
			$this->session->set_userdata ( $filter_session_data );
			
			$data['categories'] = $this->Category_model->getCategories();
			
			// fetch sql data into arrays
			
			$data ['books'] = $this->Book_model->getBooks ( $search_string, NULL, $order, $order_type, $config ['per_page'], $page );
			$config ["total_rows"] = count($this->Book_model->getBooks ( $search_string, NULL, $order, $order_type, NULL, NULL ));
			var_dump(count($data ['books']));
			$this->pagination->initialize ( $config );

			
			// $data['books'] = $this->Book_model->getBooks('Test title',NULL,NULL,'acs',$config["per_page"],$limit_end);
			$data ['links'] = $this->pagination->create_links ();
			$this->render ( 'content/index', $data );
		} else {
			// clean filter data inside section
			$filter_session_data ['search_string_selected'] = null;
			$filter_session_data ['order'] = null;
			$filter_session_data ['order_type'] = null;
			$this->session->set_userdata ( $filter_session_data );
			// pre selected options
			$data ['search_string_selected'] = '';
			$data ['order'] = 'id';
			// fetch sql data into arrays
// 			$data ['books'] = $this->Book_model->getBooks ( 'Test title', NULL, NULL, 'acs', $config ["per_page"], $page );
			$data ['books'] = $this->Book_model->getBooks ( $search_string, NULL, $order, $order_type, $config ['per_page'], $page );
			$config ["total_rows"] = count($this->Book_model->getBooks ( $search_string, NULL, $order, $order_type, NULL, NULL ));
			$this->pagination->initialize ( $config );
			
			$data ['links'] = $this->pagination->create_links ();
			$this->render ( 'content/index', $data );
			// $config['total_rows'] = $data['count_products'];
		} // !isset($manufacture_id) && !isset($search_string) && !isset($order)
			  
		// ==============================
			  
		// $data['books']= $this->Book_model->getBooks('Test title',NULL,NULL,'acs',$config["per_page"], $page);
			  // $data['links']=$this->pagination->create_links();
			  // $this->render('content/index', $data);
	}
}