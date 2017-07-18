<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (CLASSES_DIR . "Page_e.php");
class Pages extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Page_model');
		$this->load->model('Template_model');
	}
	public function index($name = NULL) {
		$page = $this->Page_model->getPageByName($name);
		if ($page == NULL){
			$page = $this->Template_model->getTemplateByName('error-page');
			$data['page'] = $page;
			$this->render('templates/'.$page->name, $data);
		}else{
			$data['page'] = $page;
			$this->render('pages/index', $data);
		}
	}
}
?>