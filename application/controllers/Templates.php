<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (CLASSES_DIR . "Page_e.php");
class Templates extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Template_model');
		$this->load->model('Book_model');
	}
	public function index($name = NULL) {
		$page = $this->Template_model->getTemplateByName($name);
		$this->data["on_top"] = $this->Book_model->getBooksOnTop();
		if ($page == NULL){
			$page = $this->Template_model->getTemplateByName('error-page');
		}
		$data['page'] = $page;
		$this->render('templates/'.$page->name, $data);
	}
}
?>