<?php

Route::get('/', function () {
    return view('inicio');
});

// ======================== RUTAS DESPROTEGIDAS ======================== //
Route::get('/', 'InicioController@index')->name('inicio.index');

Route::get('/cotizacion_dolar', 'CotizacionDolarController@index')->name('cotizacion.index');

Route::get('/login', 'Auth\LoginController@ShowLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::resource('catalogo_articulos', 'CatalogoArticuloController')->except('create', 'destroy', 'edit', 'store', 'update');
Route::get('/catalogo_articulos_list', 'CatalogoArticuloController@list')->name('catalogo_articulos.list');

Route::resource('nosotros', 'NosotrosController')->except('create', 'destroy', 'edit', 'store', 'update');
Route::get('/contacto', 'MensajeController@index')->name('contacto.index');
Route::get('/contacto_captcha', 'MensajeController@captcha')->name('contacto.captcha');
Route::post('/contacto', 'MensajeController@store')->name('contacto.store');

// ========================= RUTAS PROTEGIDAS ========================== //
Route::resource('rubros', 'RubroController')->except('create', 'edit')->middleware(['auth', 'administrador']);
Route::get('/rubros_list', 'RubroController@list')->name('rubros.list')->middleware(['auth', 'administrador']);
Route::get('/rubros_desplegable', 'RubroController@desplegable')->name('rubros.desplegable');

Route::resource('articulos', 'ArticuloController')->except('create', 'edit')->middleware(['auth', 'administrador']);
Route::get('/articulos_list', 'ArticuloController@list')->name('articulos.list')->middleware(['auth', 'administrador']);
Route::post('/articulos_upload', 'ArticuloController@upload')->name('articulos.upload')->middleware(['auth', 'administrador']);

Route::resource('clientes', 'ClienteController')->except('create', 'edit')->middleware(['auth', 'administrador']);
Route::get('/clientes_list', 'ClienteController@list')->name('clientes.list')->middleware(['auth', 'administrador']);

Route::resource('proveedores', 'ProveedorController')->except('create', 'edit')->middleware(['auth', 'administrador']);
Route::get('/proveedores_list', 'ProveedorController@list')->name('proveedores.list')->middleware(['auth', 'administrador']);

Route::resource('usuarios', 'UsuarioController')->except('create', 'edit')->middleware(['auth', 'administrador']);
Route::get('/usuarios_list', 'UsuarioController@list')->name('usuarios.list')->middleware(['auth', 'administrador']);

Route::resource('ventas', 'VentaController')->except('create', 'edit')->middleware(['auth', 'administrador']);
Route::get('/ventas_list', 'VentaController@list')->name('ventas.list')->middleware(['auth', 'administrador']);
Route::resource('venta_detalles', 'VentaDetalleController')->except('create', 'edit')->middleware(['auth', 'administrador']);

Route::resource('mensajes', 'MensajeController')->middleware(['auth', 'administrador']);
Route::get('/mensajes_list', 'MensajeController@list')->name('mensajes.list')->middleware(['auth', 'administrador']);