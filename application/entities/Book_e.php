<?php
class Book_class {
	private $id;
	private $title;
	private $description;
	private $date;
	private $author;
	private $published;
	
	
	public function __construct($id, $title, $description, $date, $author, $published) {
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;
		$this->date = $date;
		$this->author = $author;
		$this->published = $published;
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
	
	public function isPublished(){
		return $this->published;
	}
	
}