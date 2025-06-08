<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

/* ROUTER CRUD TBL PEGAWAI*/
$routes->get('/', 'Home::index');
$routes->get('/crud', 'Crud::index', ['filter'=>'permission:data-pegawai']);
$routes->get('/create-crud', 'Crud::create',['filter'=>'permission:data-pegawai']);
$routes->post('/create-crud', 'Crud::save',['filter'=>'permission:data-pegawai']);
$routes->get('/crud-edit/(:num)', 'Crud::edit/$1',['filter'=>'permission:data-pegawai']);
$routes->post('/crud-edit/(:num)', 'Crud::update/$1',['filter'=>'permission:data-pegawai']);
$routes->get('/crud-hapus/(:num)', 'Crud::delete/$1',['filter'=>'permission:data-pegawai']);
/* ROUTUER CRUD TBL DEPARTEMEN */
$routes->get('/departemen', 'Departemen::index',['filter'=>'permission:data-pegawai']);
$routes->get('/create-departemen', 'Departemen::create',['filter'=>'permission:data-pegawai']);
$routes->post('/create-departemen', 'Departemen::save',['filter'=>'permission:data-pegawai']);
$routes->get('/departemen-edit/(:num)', 'Departemen::edit/$1',['filter'=>'permission:data-pegawai']);
$routes->post('/departemen-edit/(:num)', 'Departemen::update/$1',['filter'=>'permission:data-pegawai']);
$routes->get('/departemen-hapus/(:num)', 'Departemen::delete/$1',['filter'=>'permission:data-pegawai']);


/* ROUTUER CRUD TBL PENILAIAN 
$routes->get('/', 'Home::index');
$routes->get('/create-penilaian', 'Penilaian::create');
$routes->post('/create-penilaian', 'Penilaian::save');
$routes->get('/penilaian-edit/(:num)', 'Penilaian::edit/$1');
$routes->post('/penilaian-update/(:num)', 'Penilaian::update/$1');
$routes->get('/penilaian-hapus/(:num)', 'Penilaian::delete/$1');
*/
$routes->get('/penilaian', 'Penilaian::index',['filter'=>'permission:data-penilaian']);
$routes->get('/create-penilaian', 'Penilaian::create',['filter'=>'permission:data-penilaian']);
$routes->post('/create-penilaian', 'Penilaian::save',['filter'=>'permission:data-penilaian']);
$routes->get('/penilaian-edit/(:num)', 'Penilaian::edit/$1',['filter'=>'permission:data-penilaian']);
$routes->post('/penilaian-edit/(:num)', 'Penilaian::update/$1',['filter'=>'permission:data-penilaian']);
$routes->get('/penilaian-hapus/(:num)', 'Penilaian::delete/$1',['filter'=>'permission:data-pegawai']);

$routes->get('/exportword','Penilaian::exportword');

$routes->get('/users', 'Users::index',['filter'=>'permission:data-penilaian']);
$routes->get('/create-users', 'Users::create',['filter'=>'permission:data-penilaian']);
$routes->post('/create-users', 'Users::save',['filter'=>'permission:data-penilaian']);
$routes->post('/users-hapus/(:num)', 'Users::delete/$1',['filter'=>'permission:data-pegawai']);


$routes->post('/reset-password-users/(:num)', 'Users::resetPassword/$1',['filter'=>'permission:data-pegawai']);

$routes->get('/profil', 'Profil::index');
$routes->post('/profil/(:num)', 'Profil::updateProfil/$1');
$routes->get('/password', 'Profil::ubahPassword');
$routes->post('/password/(:num)', 'Profil::updatePassword/$1');







/*
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
