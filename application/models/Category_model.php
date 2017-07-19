<?php
require_once (CLASSES_DIR . "Category_e.php");
class Category_model extends CI_Model {
	private $table = "category";
	
	public function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	
	public function getCategories() {
		$query = $this->db->get ( $this->table );
		if ($query->num_rows () > 0) {
			foreach ( $query->result () as $row ) {
				$categories [] = new Category_e ( $row->id, $row->name, $row->description );
			}
			return $categories;
		}
		return false;
	}
	
	public function getCategory($id = NULL) {
		$id = isset ( $id ) ? $id : $this->session->userdata ( 'user_id' );
		
		$this->db->select ( 'id, name, description' );
		$this->db->from ( $this->table );
		$this->db->where ( 'id', $id );
		$this->db->limit ( 1 );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			$row = $query->row();
			$category = new Category_e ( $row->id, $row->name, $row->description );
			
			return $category;
		} else {
			
			return false;
		}
	}
	
	public function getBookCategories($book_id = NULL) {		
		
	
		
		$this->db->select('c.id,c.name,c.description')
		->from('category c')
		->join('book_category bc', 'bc.id_category = c.id', 'inner')
		->where('bc.id_book', $book_id);
		
		$query= $this->db->get();
		
		if ($query->num_rows () > 0) {
			foreach ( $query->result () as $row ) {
				$categories [] = new Category_e ( $row->id, $row->name, $row->description );
			}
			return $categories;
		}else{
			return false;
		}
	}
	
	public function updateBookCategories($id_book = NULL, $data) {
		
		$this->db->where('id_book', $id_book);
		$this->db->delete('book_category');
		
		foreach ($data as $cat){	
			$this->db->insert('book_category', array('id_book'=> $id_book, 'id_category' => $cat));	
		}
		return  $this->db->affected_rows () > 0;
	}
	
	public function isCategoryUsed($id = NULL) {
		
		$this->db->select ( '*' );
		$this->db->from ( 'book_category' );
		$this->db->where ( 'id_book', $id );
		$query = $this->db->get ();
		return $query->num_rows () > 0;
	}
	
	public function updateCategory($data, $id){
		$id = isset ( $id ) ? $id : $this->session->userdata ( 'user_id' );
		$this->db->where('id',$id);
		$this->db->update($this->table, $data);
		return  $this->db->affected_rows () == 1;
	}
	
	public function createCategory($data){
		$this->db->insert($this->table, $data);
		return  $this->db->affected_rows () == 1;
	}
	
	public function deleteCategory($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table);
		return  $this->db->affected_rows () > 0;
	}
	
	function categoryListingCount($searchText = '') {
		$this->db->select ( 'id, name, description' );
		$this->db->from ( $this->table );
		if (! empty ( $searchText )) {
			$likeCriteria = "(name  LIKE '%" . $searchText . "%'
							 OR  description  LIKE '%" . $searchText . "%')";
			$this->db->where ( $likeCriteria );
		}
		
		$query = $this->db->get ();
		
		return count ( $query->result () );
	}
	
	function categoryListing($searchText = '', $page, $segment) {
		$this->db->select ( 'id, name, description' );
		$this->db->from ( $this->table );
		if (! empty ( $searchText )) {
			$likeCriteria = "(name  LIKE '%" . $searchText . "%'
							 OR  description  LIKE '%" . $searchText . "%')";
			$this->db->where ( $likeCriteria );
		}
		
		$this->db->limit ( $page, $segment );
		
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			foreach ( $query->result () as $row ) {
				$categories [] = new Category_e ( $row->id, $row->name, $row->description );
			}
			return $categories;
		}
		return false;
	}
}