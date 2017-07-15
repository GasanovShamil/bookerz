<?php
class Category_e {
	
	private $id;
	private $name;
	private $description;
	
	
	public function __construct($id, $name, $description) {
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
	}

	public function getName(){
		return $this->name;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getDescription(){
		return $this->description;
	}
}