<?php
class Page_e {
	public $id;
	public $name;
	public $label;
	public $title;
	public $text;
	
	public function __construct($id = 0, $name = '',$label= '',$title= '',$text= '') {
		$this->id = $id;
		$this->name = $name;
		$this->label = $label;
		$this->title = $title;
		$this->text = $text;
	}
	public function getUrl() {
		return base_url().'site/'.$this->name;
	}
}
?>