  <?php
		defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
		class MY_Controller extends CI_Controller {
			protected $data = array ();
			function __construct() {
				parent::__construct ();
				$this->data ['page_title'] = 'CI App';
				$this->data ['page_description'] = 'CI_App';
				$this->data ['before_closing_head'] = '';
				$this->data ['before_closing_body'] = '';
			}
			protected function render($the_view = NULL,$mydata = NULL, $template = NULL) {
				if ($template == 'json' || $this->input->is_ajax_request ()) {
					header ( 'Content-Type: application/json' );
					echo json_encode ( $this->data );
				} elseif (is_null ( $template )) {
					$template = ($this->ion_auth->logged_in () === true) ? 'auth_master' : 'public_master';
					$this->data = (is_null($mydata))?$this->data:array_merge($this->data, $mydata);
					$this->data ['the_view_content'] = (is_null ( $the_view )) ? '' : $this->load->view ( $the_view, $this->data, TRUE );
					$this->load->view ( 'templates/' . $template . '_view', $this->data );
				} else {
					$this->data ['the_view_content'] = (is_null ( $the_view )) ? '' : $this->load->view ( $the_view, $this->data, TRUE );
					$this->load->view ( 'templates/' . $template . '_view', $this->data );
				}
			}
		}
		class Auth_Controller extends MY_Controller {
			function __construct() {
				parent::__construct ();
				if ($this->ion_auth->logged_in () === FALSE) {
					redirect ( 'user/login' );
				}
			}
			protected function render($the_view = NULL, $mydata = NULL, $template = 'auth_master') {
				parent::render ( $the_view,$mydata, $template );
			}
		}