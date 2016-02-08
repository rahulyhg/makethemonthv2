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

$route['default_controller'] = "home";
$route['404_override'] = '';
$route['map'] = "home/map";
$route['Calgary'] = "home/cities/1";
$route['calgary'] = "home/cities/1";
$route['vancouver'] = "home/cities/2";
$route['Vancouver'] = "home/cities/2";
$route['torontoYork'] = "home/cities/3";
$route['TorontoYork'] = "home/cities/3";
$route['Torontoyork'] = "home/cities/3";
$route['York'] = "home/cities/3";
$route['york'] = "home/cities/3";
$route['toronto'] = "home/cities/3";
$route['Toronto'] = "home/cities/3";
$route['victoria'] = "home/cities/6";
$route['Victoria'] = "home/cities/6";
$route['saskatoon'] = "home/cities/7";
$route['Saskatoon'] = "home/cities/7";
$route['winnipeg'] = "home/cities/8";
$route['Winnipeg'] = "home/cities/8";
$route['peel-region'] = "home/cities/10";
$route['Peel-region'] = "home/cities/10";
$route['peel-Region'] = "home/cities/10";
$route['Peel-Region'] = "home/cities/10";
$route['kitchener-waterloo'] = "home/cities/12";
$route['Kitchener-waterloo'] = "home/cities/12";
$route['kitchener-Waterloo'] = "home/cities/12";
$route['Kitchener-Waterloo'] = "home/cities/12";
$route['london-middlesex'] = "home/cities/13";
$route['London-middlesex'] = "home/cities/13";
$route['london-Middlesex'] = "home/cities/13";
$route['London-Middlesex'] = "home/cities/13";
$route['halifax'] = "home/cities/14";
$route['Halifax'] = "home/cities/14";
$route['edmonton'] = "home/cities/15";
$route['Edmonton'] = "home/cities/15";
$route['ottawa'] = "home/cities/16";
$route['Ottawa'] = "home/cities/16";
$route['Brampton'] = "home/cities/17";
$route['brampton'] = "home/cities/17";
$route['Caledon'] = "home/cities/18";
$route['caledon'] = "home/cities/18";
$route['Mississauga'] = "home/cities/19";
$route['mississauga'] = "home/cities/19";
$route['win'] = "home/win";
$route['lose'] = "home/lose";
$route['superadmin/custom-questions'] = "superadmin/custom_questions";
$route['admin/custom-questions'] = "admin/custom_questions";
$route['404_override'] = 'home/not_found';

/* demo route */
$route['calgary/demo'] = "demo/city/1";
$route['vancouver/demo'] = "demo/city/2";
$route['toronto/demo'] = "demo/city/3";
$route['victoria/demo'] = "demo/city/6";
$route['saskatoon/demo'] = "demo/city/7";
$route['winnipeg/demo'] = "demo/city/8";
$route['peel-region/demo'] = "demo/city/10";
$route['kitchener-waterloo/demo'] = "demo/city/12";
$route['london-middlesex/demo'] = "demo/city/13";
$route['halifax/demo'] = "demo/city/14";
$route['edmonton/demo'] = "demo/city/15";
$route['ottawa/demo'] = "demo/city/16";
$route['brampton/demo'] = "demo/city/17";
$route['caledon/demo'] = "demo/city/18";
$route['mississauga/demo'] = "demo/city/19";

/* End of file routes.php */
/* Location: ./application/config/routes.php */