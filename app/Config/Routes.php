<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Web');
$routes->setDefaultMethod('main');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Web::main');
$routes->get('/home', 'Web::home');
$routes->get('/login', 'Web::login');
$routes->post('/login', 'Web::validateUser');
$routes->get('/signup', 'Web::signup');
$routes->post('/signup', 'Web::registerUser');
$routes->get('/logout', 'Web::logout');
$routes->get('/artists', 'Web::artists');
$routes->get('/shareset','Web::shareset');
$routes->post('/shareset','Web::saveset');
$routes->get('/sharetrack','Web::sharetrack');
$routes->post('/sharetrack','Web::savetrack');
$routes->get("/artist/(:any)","Web::artist/$1");
$routes->post('/addfavorites','Web::addfavorites');
$routes->get('/mysets','Web::mysets');
$routes->get('/mytracks','Web::mytracks');
$routes->get('/profile','Web::profile');
$routes->post('/profile','Web::saveprofile');
$routes->get('/track/(:any)','Web::track/$1');
$routes->get('/search/(:any)','Web::search/$1');
$routes->get('/gettags','Web::getTags');
$routes->post('/addevent','Web::addEvent');
$routes->get('/events/(:any)/(:any)','Web::events/$1/$2');
$routes->get('/about','Web::about');
$routes->post('/savebio','Web::savebio');
$routes->get('/recovery','Web::recovery');
$routes->post('/sendrecovery','Web::sendrecovery');
$routes->get('/confirmsendemail','Web::confirmsendemail');
$routes->get('/checktoken/(:any)','Web::checktoken/$1');
$routes->get('/expiratedtoken','Web::expiratedtoken');
$routes->get('/resetpassword/(:any)','Web::resetpassword/$1');
$routes->post('/newpassword','Web::newpassword');
$routes->post('/updatefileimg','Web::updatefileimg');
$routes->get('/delete/(:any)','Web::delete/$1');
$routes->post('/saveplayercookies','Web::saveplayercookies');
$routes->post('/chooseAvatar','Web::chooseAvatar');
$routes->get('/deleteevent/(:any)','Web::deleteEvent/$1');
$routes->get('/policy','Web::policy');
$routes->get('/acceptcookies','Web::acceptcookies');
$routes->get('/deleteFavorites/(:any)','Web::deleteFavorites/$1');
$routes->get('/genres/(:any)','Web::genres/$1');



/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
