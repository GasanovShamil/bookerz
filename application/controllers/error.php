<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login (LoginController)
 * Login class to control to authenticate user credentials and starts user's session.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Error extends MY_Controller
{
	/**
	 * This is default constructor of the class
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$this->isLoggedIn();
	}
	
	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn()
	{
		
		
		if($this->ion_auth->logged_in () === FALSE)
		{
			redirect(base_url()."user/login");
		}
		else
		{
			redirect('pageNotFound');
		}
	}
}

?>