<?php
class Category_e {
	
	private $id;
	private $name;
	
	
	
	public function __construct($id, $name) {
		$this->id = $id;
		$this->name = $name;
		
	}

	public function getName(){
		return $this->name;
	}
	
	public function getId(){
		return $this->id;
	}
}