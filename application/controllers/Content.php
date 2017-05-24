<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends MY_Controller {

    public function index()
    {
        
        $this->render('content/index');
        
    }
}