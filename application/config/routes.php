<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';

$route['book/view/(:any)'] = 'book/view/$1';

$route['salon']                     = 'salon/index';
$route['salon/view/(:any)']         = 'salon/view/$1';
$route['salon/insertMessage']       = 'salon/insertMessage';
$route['salon/userState']           = 'salon/userState';
$route['salon/chatroomToSelect/(:any)'] = 'salon/chatroomToSelect/$1';

$route['admin/salon/create'] = 'createsalontempo/create';

$route['note/check'] = 'book_note/check';

$route['mail/sub'] = 'mail/sub';

// A changer pour la personnaliser
$route['404_override'] = 'templates/index';
$route['translate_uri_dashes'] = FALSE;

// ADMIN ROUTES

$route['dashboard'] = 'admin/index';
$route['userListing'] = 'admin/userListing';
$route['userListing/(:num)'] = 'admin/userListing/$1';
$route['categoryListing'] = 'admin/categoryListing';
$route['categoryListing/(:num)'] = 'admin/categoryListing/$1';
$route['bookListing'] = 'admin/bookListing';
$route['bookListing/(:num)'] = 'admin/bookListing/$1';
$route['deleteUser'] = 'admin/deleteUser';
$route['deleteCategory'] = 'admin/deleteCategory';
$route['activateUser'] = 'admin/activate';
$route['desactivateUser'] = 'admin/deactivate';
$route['deleteBook'] = 'admin/deleteBook';

// STATIC PAGES ROUTE
$route['pages/(:any)'] = 'templates/index/$1';
$route['static/(:any)'] = 'pages/index/$1';

