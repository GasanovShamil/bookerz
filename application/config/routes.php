<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';

$route['book/(:any)'] = 'book/view/$1';

$route['salon/(:any)'] = 'salon/view/$1';

$route['mail/sub'] = 'mail/sub';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
