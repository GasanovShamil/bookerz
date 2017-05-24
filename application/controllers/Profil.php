<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends Auth_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
    {
        $this->render('profil/index');
    }
}