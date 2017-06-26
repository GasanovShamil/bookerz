<?php
class Book_e {
	
	private $id;
	private $title;
	private $description;
	private $date;
	private $author;
	private $published;
	private $editor;
	private $collection;
	private $ISBN10;
	private $ISBN13;
	
	
	public function __construct($id, $title, $description, $date, $author, $published, $editor, $collection, $ISBN10 = NULL, $ISBN13 = NULL) {
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;
		$this->date = $date;
		$this->author = $author;
		$this->published = $published;
		$this->editor= $editor;
		$this->collection= $collection;
		$this->ISBN10= $ISBN10;
		$this->ISBN13= $ISBN13;
	}
	
	
	public function getId(){
		return $this->id;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public function getDate(){
		return $this->date;
	}
	
	public function getAuthor(){
		return $this->author;
	}
	
	public function getPublished(){
		return $this->published;
	}
	
	public function getEditor(){
		return $this->editor;
	}
	public function getCollection(){
		return $this->collection;
	}
	public function getISBN10(){
		return $this->ISBN10;
	}
	public function getISBN13(){
		return $this->ISBN13;
	}
}