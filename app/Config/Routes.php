<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// auth login
$routes->get('/', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'MainController::dashboard');

    // produk
    $routes->get('produk', 'ProdukController::index');
    $routes->post('produk/store', 'ProdukController::store');
    $routes->get('produk/getdata', 'ProdukController::get_data');
    $routes->get('produk/edit', 'ProdukController::edit');
    $routes->post('produk/update', 'ProdukController::update');
    $routes->post('produk/delete', 'ProdukController::delete');

    // transaksi
    $routes->get('user', 'UserController::index');
    $routes->post('user/store', 'UserController::store');
    $routes->get('user/getdata', 'UserController::get_data');
    $routes->get('user/edit', 'UserController::edit');
    $routes->post('user/update', 'UserController::update');
    $routes->post('user/delete', 'UserController::delete');

    // pelanggan
    $routes->get('pelanggan', 'PelangganController::index');
    $routes->post('pelanggan/store', 'PelangganController::store');
    $routes->get('pelanggan/getdata', 'PelangganController::get_data');
    $routes->get('pelanggan/edit', 'PelangganController::edit');
    $routes->post('pelanggan/update', 'PelangganController::update');
    $routes->post('pelanggan/delete', 'PelangganController::delete');

    // transaksi
    $routes->get('transaksi', 'TransaksiController::index');
});