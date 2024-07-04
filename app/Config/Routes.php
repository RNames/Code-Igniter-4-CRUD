<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Home Mahasiswa
$routes->get('/', 'Mahasiswa::index');
// Halaman Tambah
$routes->get('Mahasiswa/tambah', 'Mahasiswa::tambah');
// Halaman Edit
$routes->get('Mahasiswa/edit/(:any)', 'Mahasiswa::edit/$1');
// Proses CRUD
// Insert
$routes->post('Mahasiswa/add', 'Mahasiswa::add');
// Update
$routes->post('baraMahasiswang/update', 'Mahasiswa::update');
// Hapus
$routes->get('Mahasiswa/hapus/(:any)', 'Mahasiswa::hapus/$1');
$routes->setAutoRoute(true);
