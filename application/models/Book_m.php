<?php
require_once(CLASSES_DIR  . "Book_e.php");

class Book_model extends CI_Model
{
	private $table = "BOOK";
	
	public function getBookById($id)
	{
		$query = $this->db->get_where($this->table, 'id = '.$id);
		$row = $query->row();
		
		if (isset($row)) {
			$book = new Book_e(
					$row->id,
					$row->title,
					$row->description,
					$row->date,
					$row->author,
					$row->published
					);
			
			return $book;
		}
		
		return null;
		
	}
	
	
	
}