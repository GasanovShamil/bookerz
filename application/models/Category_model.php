<?php
require_once (CLASSES_DIR . "Category_e.php");
class Category_model extends CI_Model {
	private $table = "category";
	
	public function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	
	public function getCategories(){
		$query = $this->db->get($this->table);
		if ($query->num_rows () > 0) {
			foreach ( $query->result () as $row ) {
				$categories [] = new Category_e (
						$row->id,
						$row->name
						);
			}
			return $categories;
		}
		
		return false; 
	}
}