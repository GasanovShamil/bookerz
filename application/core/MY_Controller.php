  <?php
		defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
		class MY_Controller extends CI_Controller {
			protected $data = array ();
			public $fb;
			function __construct() {
				parent::__construct ();
				$this->fb = new Facebook\Facebook ( [ 
						'app_id' => $this->config->item ( 'facebook_app_id' ),
						'app_secret' => $this->config->item ( 'facebook_app_secret' ),
						'default_graph_version' => 'v2.5' 
				] );
				$this->data ['page_title'] = 'BOOKERZ';
				$this->data ['page_description'] = 'CI_App';
				$this->data ['before_closing_head'] = '';
				$this->data ['before_closing_body'] = '';
			}
			protected function render($the_view = NULL, $mydata = NULL, $template = NULL) {
				if ($template == 'json' || $this->input->is_ajax_request ()) {
					header ( 'Content-Type: application/json' );
					echo json_encode ( $this->mydata);
				} else if (is_null ( $template )) {
					$template = ($this->ion_auth->logged_in () === true) ? 'auth_master' : 'public_master';
					$this->data = (is_null ( $mydata )) ? $this->data : array_merge ( $this->data, $mydata );
					$this->data ['the_view_content'] = (is_null ( $the_view )) ? '' : $this->load->view ( $the_view, $this->data, TRUE );
					$this->load->view ( 'templates/' . $template . '_view', $this->data );
				} else {
					$this->data ['the_view_content'] = (is_null ( $the_view )) ? '' : $this->load->view ( $the_view, $this->data, TRUE );
					$this->load->view ( 'templates/' . $template . '_view', $this->data );
				}
			}
			function paginationCompress($link, $count, $perPage = 10) {
				$this->load->library ( 'pagination' );
				
				$config ['base_url'] = base_url () . $link;
				$config ['total_rows'] = $count;
				$config ['uri_segment'] = 2;
				$config ['per_page'] = $perPage;
				$config ['num_links'] = 5;
				$config ['full_tag_open'] = '<nav><ul class="pagination">';
				$config ['full_tag_close'] = '</ul></nav>';
				$config ['first_tag_open'] = '<li class="arrow">';
				$config ['first_link'] = 'First';
				$config ['first_tag_close'] = '</li>';
				$config ['prev_link'] = 'Previous';
				$config ['prev_tag_open'] = '<li class="arrow">';
				$config ['prev_tag_close'] = '</li>';
				$config ['next_link'] = 'Next';
				$config ['next_tag_open'] = '<li class="arrow">';
				$config ['next_tag_close'] = '</li>';
				$config ['cur_tag_open'] = '<li class="active"><a href="#">';
				$config ['cur_tag_close'] = '</a></li>';
				$config ['num_tag_open'] = '<li>';
				$config ['num_tag_close'] = '</li>';
				$config ['last_tag_open'] = '<li class="arrow">';
				$config ['last_link'] = 'Last';
				$config ['last_tag_close'] = '</li>';
				
				$this->pagination->initialize ( $config );
				$page = $config ['per_page'];
				$segment = $this->uri->segment ( 2 );
				
				return array (
						"page" => $page,
						"segment" => $segment 
				);
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
				parent::render ( $the_view, $mydata, $template );
			}
		}
		class Admin_Controller extends MY_Controller {
			function __construct() {
				parent::__construct ();
				if ($this->ion_auth->is_admin () === FALSE) {
					if ($this->input->is_ajax_request ()) {
						echo(json_encode(array('status'=>'access')));
					} else {
						redirect ( 'home' );
					}
				}
			}
			protected function render($the_view = NULL, $mydata = NULL, $template = 'admin_master') {
				parent::render ( $the_view, $mydata, $template );
			}
		}