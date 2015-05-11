<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site";
$route['404_override'] = '';



//dashboard defaults to coupons
$route['dashboard'] = "dashboard/coupons";
$route['motelapp/dashboard'] = "dashboard/coupons";

//admin defaults to users
$route['admin'] = "admin/users";
$route['admin/users/(:num)'] = "admin/users";
$route['admin/organisations/(:num)'] = "admin/organisations";


//coupons
$route['motelapp/dashboard/coupon'] = "dashboard/coupons";
$route['motelapp/dashboard/coupon/(:num)'] = "dashboard/coupons";
$route['motelapp/dashboard/coupon/add_edit'] = "dashboard/coupons/add_edit";
$route['motelapp/dashboard/coupon/add_edit/(:num)'] = "dashboard/coupons/add_edit/$1";
$route['motelapp/dashboard/coupon/delete/(:num)'] = "dashboard/coupons/delete/$1";
$route['motelapp/dashboard/coupon/detail/(:num)'] = "dashboard/coupons/detail/$1";

//deals
$route['motelapp/dashboard/deal'] = "dashboard/deals";
$route['motelapp/dashboard/deal/(:num)'] = "dashboard/deals";
$route['motelapp/dashboard/deal/add_edit'] = "dashboard/deals/add_edit";
$route['motelapp/dashboard/deal/add_edit/(:num)'] = "dashboard/deals/add_edit/$1";
$route['motelapp/dashboard/deal/delete/(:num)'] = "dashboard/deals/delete/$1";
$route['motelapp/dashboard/deal/detail/(:num)'] = "dashboard/deals/detail/$1";

//deals
$route['motelapp/dashboard/news_item'] = "dashboard/news_items";
$route['motelapp/dashboard/news_item/(:num)'] = "dashboard/news_items";
$route['motelapp/dashboard/news_item/add_edit'] = "dashboard/news_items/add_edit";
$route['motelapp/dashboard/news_item/add_edit/(:num)'] = "dashboard/news_items/add_edit/$1";
$route['motelapp/dashboard/news_item/delete/(:num)'] = "dashboard/news_items/delete/$1";
$route['motelapp/dashboard/news_item/detail/(:num)'] = "dashboard/news_items/detail/$1";


/* End of file routes.php */
/* Location: ./application/config/routes.php */