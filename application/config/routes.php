<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';

$route['book/view/(:any)'] = 'book/view/$1';

$route['salon']                     = 'salon/index';
$route['salon/view/(:any)']         = 'salon/view/$1';
$route['salon/insertMessage']       = 'salon/insertMessage';
$route['salon/getMessages/(:any)']  = 'salon/getMessages/(:any)';

$route['mail/sub'] = 'mail/sub';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
