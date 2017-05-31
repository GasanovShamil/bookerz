<?php

class Book_model extends CI_Model
{
	private $table = "book";
	public $title;
	public $description;
	public $date;
	public $author;
	public $published;
	public $editor;
	public $collection;
	public $ISBN10;
	public $ISBN13;

	public function getBookById($id)
	{
		$query = $this->db->get_where($this->table, array('id' => $id));

		return $query->result_array();
	}



}
