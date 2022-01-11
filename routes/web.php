<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware'=>['auth','estado'] ],
function(){
    Route::get('/admin','HomeController@index')->name('dashboard');

    Route::get('user/getJson' , 'UsersController@getJson' )->name('users.getJson');
    Route::get('users' , 'UsersController@index' )->name('users.index');
    Route::post('users' , 'UsersController@store' )->name('users.store');
    Route::delete('users/{user}' , 'UsersController@destroy' );
    Route::post('users/update/{user}' , 'UsersController@update' );
    Route::get('users/{user}/edit', 'UsersController@edit' );
    Route::post('users/reset/tercero' , 'UsersController@resetPasswordTercero')->name('users.reset.tercero');
    Route::post('users/reset' , 'UsersController@resetPassword')->name('users.reset');
    Route::get( '/users/cargar' , 'UsersController@cargarSelect')->name('users.cargar');
    Route::get( '/users/cargarA' , 'UsersController@cargarSelectApertura')->name('users.cargarA');

    Route::get( '/users/creaperfil/{user}' , 'UsersController@creaperfil')->name('users.creaperfil');
    Route::post( '/users/agregaperfil/' , 'UsersController@agregaperfil')->name('users.agregaperfil');
    Route::get('/users/usernameDisponible' , 'UsersController@usernameDisponible')->name('users.usernameDisponible');

    Route::get( '/negocio/{negocio}/edit' , 'NegocioController@edit')->name('negocio.edit');
    Route::put( '/negocio/{negocio}/update' , 'NegocioController@update')->name('negocio.update');

    Route::get( '/proveedores' , 'ProveedoresController@index')->name('proveedores.index');
    Route::get( '/proveedores/getJson/' , 'ProveedoresController@getJson')->name('proveedores.getJson');
    Route::get( '/proveedores/new' , 'ProveedoresController@create')->name('proveedores.new');
    Route::post( '/proveedores/save/' , 'ProveedoresController@store')->name('proveedores.save');
    Route::get( '/proveedores/edit/{proveedor}' , 'ProveedoresController@edit')->name('proveedores.edit');
    Route::get('/proveedores/show/{proveedor}' , 'ProveedoresController@show')->name('proveedores.show');
    Route::put( '/proveedores/{proveedor}/update' , 'ProveedoresController@update')->name('proveedores.update');
    Route::post('/proveedores/{proveedor}/delete' , 'ProveedoresController@destroy');
    Route::post('/proveedores/{proveedor}/desactivar' , 'ProveedoresController@desactivar');
    Route::post('/proveedores/{proveedor}/activar' , 'ProveedoresController@activar');
    Route::get('/proveedores/nitDisponible/', 'ProveedoresController@nitDisponible')->name('proveedores.nitDisponible');

    Route::get( '/empresas' , 'EmpresasController@index')->name('empresas.index');
    Route::get( '/empresas/getJson/' , 'EmpresasController@getJson')->name('empresas.getJson');
    Route::get( '/empresas/new' , 'EmpresasController@create')->name('empresas.new');
    Route::post( '/empresas/save/' , 'EmpresasController@store')->name('empresas.save');
    Route::get( '/empresas/edit/{empresa}' , 'EmpresasController@edit')->name('empresas.edit');
    Route::put( '/empresas/{empresa}/update' , 'EmpresasController@update')->name('empresas.update');
    Route::post('/empresas/{empresa}/delete' , 'EmpresasController@destroy');
    Route::post('/empresas/{empresa}/desactivar' , 'EmpresasController@desactivar');
    Route::post('/empresas/{empresa}/activar' , 'EmpresasController@activar');

    Route::get( '/perfiles' , 'PerfilesController@index')->name('perfiles.index');
    Route::get( '/perfiles/getJson/' , 'PerfilesController@getJson')->name('perfiles.getJson');
    Route::get( '/perfiles/new' , 'PerfilesController@create')->name('perfiles.new');
    Route::post( '/perfiles/save/' , 'PerfilesController@store')->name('perfiles.save');
    Route::get( '/perfiles/edit/{perfil}' , 'PerfilesController@edit')->name('perfiles.edit');
    Route::put( '/perfiles/{perfil}/update' , 'PerfilesController@update')->name('perfiles.update');
    Route::post('/perfiles/{perfil}/delete' , 'PerfilesController@destroy');
    Route::post('/perfiles/{perfil}/desactivar' , 'PerfilesController@desactivar');
    Route::post('/perfiles/{perfil}/activar' , 'PerfilesController@activar');

    Route::get( '/bodegas' , 'BodegasController@index')->name('bodegas.index');
    Route::get( '/bodegas/getJson/' , 'BodegasController@getJson')->name('bodegas.getJson');
    Route::get( '/bodegas/new' , 'BodegasController@create')->name('bodegas.new');
    Route::post( '/bodegas/save/' , 'BodegasController@store')->name('bodegas.save');
    Route::get( '/bodegas/edit/{bodega}' , 'BodegasController@edit')->name('bodegas.edit');
    Route::put( '/bodegas/{bodega}/update' , 'BodegasController@update')->name('bodegas.update');
    Route::post('/bodegas/{bodega}/delete' , 'BodegasController@destroy');
    Route::post('/bodegas/{bodega}/desactivar' , 'BodegasController@desactivar');
    Route::post('/bodegas/{bodega}/activar' , 'BodegasController@activar');

    Route::get( '/documentos' , 'DocumentosController@index')->name('documentos.index');
    Route::get( '/documentos/getJson/' , 'DocumentosController@getJson')->name('documentos.getJson');
    Route::get( '/documentos/new' , 'DocumentosController@create')->name('documentos.new');
    Route::post( '/documentos/save/' , 'DocumentosController@store')->name('documentos.save');
    Route::get( '/documentos/edit/{documento}' , 'DocumentosController@edit')->name('documentos.edit');
    Route::put( '/documentos/{documento}/update' , 'DocumentosController@update')->name('documentos.update');
    Route::post('/documentos/{documento}/delete' , 'DocumentosController@destroy');
    Route::post('/documentos/{documento}/desactivar' , 'DocumentosController@desactivar');
    Route::post('/documentos/{documento}/activar' , 'DocumentosController@activar');

    Route::get( '/articulos' , 'ArticulosController@index')->name('articulos.index');
    Route::get( '/articulos/getJson/' , 'ArticulosController@getJson')->name('articulos.getJson');
    Route::get( '/articulos/new' , 'ArticulosController@create')->name('articulos.new');
    Route::post( '/articulos/save/' , 'ArticulosController@store')->name('articulos.save');
    Route::get( '/articulos/edit/{articulo}' , 'ArticulosController@edit')->name('articulos.edit');
    Route::put( '/articulos/{articulo}/update' , 'ArticulosController@update')->name('articulos.update');
    Route::get('/articulos/show/{articulo}' , 'ArticulosController@show')->name('articulos.show');
    Route::post('/articulos/{articulo}/delete' , 'ArticulosController@destroy');
    Route::post('/articulos/{articulo}/desactivar' , 'ArticulosController@desactivar');
    Route::post('/articulos/{articulo}/activar' , 'ArticulosController@activar');

    Route::get( '/series' , 'SeriesController@index')->name('series.index');
    Route::get( '/series/getJson/' , 'SeriesController@getJson')->name('series.getJson');
    Route::get( '/series/new' , 'SeriesController@create')->name('series.new');
    Route::post( '/series/save/' , 'SeriesController@store')->name('series.save');
    Route::get( '/series/edit/{serie}' , 'SeriesController@edit')->name('series.edit');
    Route::put( '/series/{serie}/update' , 'SeriesController@update')->name('series.update');
    Route::get('/series/show/{serie}' , 'SeriesController@show')->name('series.show');
    Route::post('/series/{serie}/delete' , 'SeriesController@destroy');
    Route::post('/series/{serie}/desactivar' , 'SeriesController@desactivar');
    Route::post('/series/{serie}/activar' , 'SeriesController@activar');

    Route::get( '/perfiles/asignarol/{perfil}' , 'PerfilesController@asignarol')->name('perfiles.asignarol');
    Route::post( '/perfiles/guardarol/' , 'PerfilesController@guardarol')->name('perfiles.guardarol');
    Route::delete('/perfil_rol/{perfil_rol}/delete' , 'PerfilesController@destroyRol');

    Route::get( '/roles' , 'RolesController@index')->name('roles.index');
    Route::get( '/roles/getJson/' , 'RolesController@getJson')->name('roles.getJson');
    Route::get( '/roles/new' , 'RolesController@create')->name('roles.new');
    Route::post( '/roles/save/' , 'RolesController@store')->name('roles.save');
    Route::get( '/roles/edit/{rol}' , 'RolesController@edit')->name('roles.edit');
    Route::put( '/roles/{rol}/update' , 'RolesController@update')->name('roles.update');
    Route::post('/roles/{rol}/delete' , 'RolesController@destroy');
    Route::post('/roles/{rol}/desactivar' , 'RolesController@desactivar');
    Route::post('/roles/{rol}/activar' , 'RolesController@activar');

    Route::get( '/territorios' , 'TerritoriosController@index')->name('territorios.index');
    Route::get( '/territorios/getJson/' , 'TerritoriosController@getJson')->name('territorios.getJson');
    Route::get( '/territorios/new' , 'TerritoriosController@create')->name('territorios.new');
    Route::get( '/territorios/edit/{territorio}' , 'TerritoriosController@edit')->name('territorios.edit');
    Route::put( '/territorios/{territorio}/update' , 'TerritoriosController@update')->name('territorios.update');
    Route::post( '/territorios/save/' , 'TerritoriosController@store')->name('territorios.save');
    Route::post('/territorios/{territorio}/delete' , 'TerritoriosController@destroy');
    Route::post('/territorios/{territorio}/activar' , 'TerritoriosController@activar');

    Route::get('/movimientos/getArticulo/{articulo}' , 'MovimientosController@getArticulo')->name('movimientos.getArticulo');
    Route::get('/movimientos/getSerie/{serie}' , 'MovimientosController@getSerie')->name('movimientos.getSerie');
    Route::get('/movimientos' , 'MovimientosController@index')->name('movimientos.index');
    Route::get('/movimientos/getJson/' , 'MovimientosController@getJson')->name('movimientos.getJson');
    Route::get('/movimientos/new' , 'MovimientosController@create')->name('movimientos.new');
    Route::post( '/movimientos/save/' , 'MovimientosController@store')->name('movimientos.save');
    Route::get('/movimientos/show/{movimientoMaestro}' , 'MovimientosController@show')->name('movimientos.show');
    Route::post('/movimientos/{movimientoMaestro}/delete' , 'MovimientosController@destroy');
    Route::post('/movimientos/{movimientoDetalle}/deleteDetalle' , 'MovimientosController@destroyDetalle');
    Route::get('/movimientos/{movimientoMaestro}/getDetalles' , 'MovimientosController@getDetalles')->name('movimientos.getDetalles');

    Route::get('/importaciones/getArticulo/{articulo}' , 'ImportacionesController@getArticulo')->name('importaciones.getArticulo');
    Route::get('/importaciones' , 'ImportacionesController@index')->name('importaciones.index');
    Route::get('/importaciones/getJson/' , 'ImportacionesController@getJson')->name('importaciones.getJson');
    Route::get('/importaciones/new' , 'ImportacionesController@create')->name('importaciones.new');
    Route::post( '/importaciones/save/' , 'ImportacionesController@store')->name('importaciones.save');
    Route::get('/importaciones/show/{importacion_maestro}' , 'ImportacionesController@show')->name('importaciones.show');
    Route::post('/importaciones/{importacion_maestro}/delete' , 'ImportacionesController@destroy');
    Route::post('/importaciones/{importacion_detalle}/deleteDetalle' , 'ImportacionesController@destroyDetalle');
    Route::get('/importaciones/{importacion_maestro}/getDetalles' , 'ImportacionesController@getDetalles')->name('importaciones.getDetalles');
    Route::get( '/importaciones/pdf/{importacion_maestro}', 'ImportacionesController@pdfImportacion');

    Route::get('/cotizaciones/getArticulo/{articulo}' , 'CotizacionesController@getArticulo')->name('cotizaciones.getArticulo');
    Route::get('/cotizaciones/getSerie/{serie}' , 'CotizacionesController@getSerie')->name('cotizaciones.getSerie');
    Route::get('/cotizaciones/getCliente/{cliente}' , 'CotizacionesController@getCliente')->name('cotizaciones.getCliente');
    Route::get('/cotizaciones' , 'CotizacionesController@index')->name('cotizaciones.index');
    Route::get('/cotizaciones/getJson/' , 'CotizacionesController@getJson')->name('cotizaciones.getJson');
    Route::get('/cotizaciones/new' , 'CotizacionesController@create')->name('cotizaciones.new');
    Route::post( '/cotizaciones/save/' , 'CotizacionesController@store')->name('cotizaciones.save');
    Route::get('/cotizaciones/show/{cotizacion_maestro}' , 'CotizacionesController@show')->name('cotizaciones.show');
    Route::get( '/cotizaciones/edit/{cotizacion_maestro}' , 'CotizacionesController@edit')->name('cotizaciones.edit');
    Route::post( '/cotizaciones/{cotizacion_maestro}/update' , 'CotizacionesController@update')->name('cotizaciones.update');
    Route::post('/cotizaciones/{cotizacion_maestro}/delete' , 'CotizacionesController@destroy');
    Route::post('/cotizaciones/{cotizacion_detalle}/deleteDetalle' , 'CotizacionesController@destroyDetalle');
    Route::get('/cotizaciones/{cotizacion_maestro}/getDetalles' , 'CotizacionesController@getDetalles')->name('cotizaciones.getDetalles');
    Route::get( '/cotizaciones/pdf/{cotizacion_maestro}', 'CotizacionesController@pdfCotizacion');

    Route::get( '/cotizaciones/getdetalle/{cotizacion_maestro}' , 'CotizacionesController@getdetalle')->name('cotizaciones.getdetalle');
    Route::get( '/cotizaciones/editdetalle/{cotizacion_detalle}' , 'CotizacionesController@editdetalle')->name('cotizaciones.editdetalle');
    Route::post( '/cotizaciones/{cotizacion_detalle}/updatedetalle' , 'CotizacionesController@updatedetalle')->name('cotizaciones.updatedetalle');
    Route::get('/cotizaciones/deletedetalle/{cotizacion_detalle}' , 'CotizacionesController@destroydetalle');

    Route::get('/facturas/getSerie/{serie}' , 'FacturasController@getSerie')->name('facturas.getSerie');
    Route::get('/facturas/getCotizacion/{serie_id}/{num_coti}' , 'FacturasController@getCotizacion')->name('facturas.getCotizacion');
    Route::get('/facturas' , 'FacturasController@index')->name('facturas.index');
    Route::get('/facturas/getJson/' , 'FacturasController@getJson')->name('facturas.getJson');
    Route::get('/facturas/new' , 'FacturasController@create')->name('facturas.new');
    Route::get('/facturas/new2' , 'FacturasController@create2')->name('facturas.new2');
    Route::post( '/facturas/save/' , 'FacturasController@store')->name('facturas.save');
    Route::post( '/facturas/save2/' , 'FacturasController@store2')->name('facturas.save2');
    Route::get('/facturas/show/{factura_maestro}' , 'FacturasController@show')->name('facturas.show');
    Route::post('/facturas/{factura_maestro}/delete' , 'FacturasController@destroy');
    Route::post('/facturas/{factura_detalle}/deleteDetalle' , 'FacturasController@destroyDetalle');
    Route::get('/facturas/{factura_maestro}/getDetalles' , 'FacturasController@getDetalles')->name('facturas.getDetalles');
    Route::get( '/facturas/pdf_factura/{factura_maestro}', 'FacturasController@pdfFactura');
    Route::get( '/facturas/pdf_factura_cambiaria/{factura_maestro}', 'FacturasController@pdfFacturaCambiaria');
    Route::get('/facturasv' , 'FacturasController@indexv')->name('facturas.indexv');
    Route::get('/facturas/getJsonv/' , 'FacturasController@getJsonv')->name('facturas.getJsonv');
    Route::post('/facturas/{factura_maestro}/autorizar' , 'FacturasController@autorizar');
    Route::get('/facturas/getCliente/{nit}' , 'FacturasController@getCliente')->name('facturas.getCliente');
    Route::post('/facturas/{factura_maestro}/eliminar' , 'FacturasController@eliminar');

    Route::get('/facturasexport' , 'FacturasController@indexexport')->name('facturas.indexexport');
    Route::get('/facturas/getJsonexport/' , 'FacturasController@getJsonexport')->name('facturas.getJsonexport');
    Route::get('/facturas/generatxt' , 'FacturasController@generatxt')->name('facturas.generatxt');
    Route::post( '/facturas/savegeneratxt/' , 'FacturasController@storegeneratxt')->name('facturas.savegeneratxt');

    Route::get('/abonos/getSerie/{serie}' , 'AbonosController@getSerie')->name('abonos.getSerie');
    Route::get('/abonos' , 'AbonosController@index')->name('abonos.index');
    Route::get('/abonos/getJson/' , 'AbonosController@getJson')->name('abonos.getJson');
    Route::get('/abonos/new' , 'AbonosController@create')->name('abonos.new');
    Route::post( '/abonos/save/' , 'AbonosController@store')->name('abonos.save');
    Route::get('/abonos/show/{abono_maestro}' , 'AbonosController@show')->name('abonos.show');
    Route::post('/facturas/{abono_maestro}/delete' , 'AbonosController@destroy');
    Route::post('/facturas/{abono_detalle}/deleteDetalle' , 'AbonosController@destroyDetalle');
    Route::get('/abonos/{abono_maestro}/getDetalles' , 'AbonosController@getDetalles')->name('abonos.getDetalles');
    Route::get( '/abonos/pdf_notacredito/{abono_maestro}', 'AbonosController@pdfnotacredito');
    Route::get('/abonos/getCliente/{cliente}' , 'AbonosController@getCliente')->name('abonos.getCliente');
    Route::get('/abonos/getFacturas/{factura_maestro}' , 'AbonosController@getFacturas')->name('abonos.getFacturas');
    Route::post('/abonos/{abono_maestro}/delete' , 'AbonosController@destroy');

    Route::get('/ordenes_compras/getArticulo/{articulo}' , 'OrdenesComprasController@getArticulo')->name('ordenes_compras.getArticulo');
    Route::get('/ordenes_compras/getSerie/{serie}' , 'OrdenesComprasController@getSerie')->name('ordenes_compras.getSerie');
    Route::get('/ordenes_compras/getProveedor/{proveedor}' , 'OrdenesComprasController@getProveedor')->name('ordenes_compras.getProveedor');
    Route::get('/ordenes_compras' , 'OrdenesComprasController@index')->name('ordenes_compras.index');
    Route::get('/ordenes_compras/getJson/' , 'OrdenesComprasController@getJson')->name('ordenes_compras.getJson');
    Route::get('/ordenes_compras/new' , 'OrdenesComprasController@create')->name('ordenes_compras.new');
    Route::post( '/ordenes_compras/save/' , 'OrdenesComprasController@store')->name('ordenes_compras.save');
    Route::get('/ordenes_compras/show/{orden_compra_maestro}' , 'OrdenesComprasController@show')->name('ordenes_compras.show');
    Route::post('/ordenes_compras/{orden_compra_maestro}/delete' , 'OrdenesComprasController@destroy');
    Route::post('/ordenes_compras/{orden_compra_detalle}/deleteDetalle' , 'OrdenesComprasController@destroyDetalle');
    Route::get('/ordenes_compras/{orden_compra_maestro}/getDetalles' , 'OrdenesComprasController@getDetalles')->name('ordenes_compras.getDetalles');
    Route::get( '/ordenes_compras/pdf/{orden_compra_maestro}', 'OrdenesComprasController@pdfOrdenCompra');

    Route::get( '/ordenes_compras/edit/{orden_compra_maestro}' , 'OrdenesComprasController@edit')->name('ordenes_compras.edit');
    Route::post( '/ordenes_compras/{orden_compra_maestro}/update' , 'OrdenesComprasController@update')->name('ordenes_compras.update');

    Route::get( '/ordenes_compras/getdetalle/{orden_compra_maestro}' , 'OrdenesComprasController@getdetalle')->name('ordenes_compras.getdetalle');
    Route::get( '/ordenes_compras/editdetalle/{orden_compra_detalle}' , 'OrdenesComprasController@editdetalle')->name('ordenes_compras.editdetalle');
    Route::post( '/ordenes_compras/{orden_compra_detalle}/updatedetalle' , 'OrdenesComprasController@updatedetalle')->name('ordenes_compras.updatedetalle');
    Route::get('/ordenes_compras/deletedetalle/{orden_compra_detalle}' , 'OrdenesComprasController@destroydetalle');

    Route::get( '/vendedores' , 'VendedoresController@index')->name('vendedores.index');
    Route::get( '/vendedores/getJson/' , 'VendedoresController@getJson')->name('vendedores.getJson');
    Route::get( '/vendedores/new' , 'VendedoresController@create')->name('vendedores.new');
    Route::post( '/vendedores/save/' , 'VendedoresController@store')->name('vendedores.save');
    Route::get( '/vendedores/edit/{vendedor}' , 'VendedoresController@edit')->name('vendedores.edit');
    Route::put( '/vendedores/{vendedor}/update' , 'VendedoresController@update')->name('vendedores.update');
    Route::get('/vendedores/show/{vendedor}' , 'VendedoresController@show')->name('vendedores.show');
    Route::post('/vendedores/{vendedor}/delete' , 'VendedoresController@destroy');
    Route::post('/vendedores/{vendedor}/desactivar' , 'VendedoresController@desactivar');
    Route::post('/vendedores/{vendedor}/activar' , 'VendedoresController@activar');

    Route::get( '/clientes' , 'ClientesController@index')->name('clientes.index');
    Route::get( '/clientes/getJson/' , 'ClientesController@getJson')->name('clientes.getJson');
    Route::get( '/clientes/new' , 'ClientesController@create')->name('clientes.new');
    Route::post( '/clientes/save/' , 'ClientesController@store')->name('clientes.save');
    Route::get( '/clientes/edit/{cliente}' , 'ClientesController@edit')->name('clientes.edit');
    Route::put( '/clientes/{cliente}/update' , 'ClientesController@update')->name('clientes.update');
    Route::get('/clientes/show/{cliente}' , 'ClientesController@show')->name('clientes.show');
    Route::get('/clientes/show/{cliente}' , 'ClientesController@show')->name('clientes.show');
    Route::post('/clientes/{cliente}/delete' , 'ClientesController@destroy');
    Route::post('/clientes/{cliente}/desactivar' , 'ClientesController@desactivar');
    Route::post('/clientes/{cliente}/activar' , 'ClientesController@activar');

    Route::get( '/reportes/fac_emitidas' , 'ReportesController@fac_emitidas')->name('reportes.fac_emitidas');
    Route::post( '/reportes/rpt_fac_emitidas' , 'ReportesController@rpt_fac_emitidas')->name('reportes.rpt_fac_emitidas');
    Route::get( '/reportes/lib_ventas' , 'ReportesController@lib_ventas')->name('reportes.lib_ventas');
    Route::post( '/reportes/rpt_lib_ventas' , 'ReportesController@rpt_lib_ventas')->name('reportes.rpt_lib_ventas');
    Route::get( '/reportes/val_inventario' , 'ReportesController@val_inventario')->name('reportes.val_inventario');
    Route::post( '/reportes/rpt_val_inventario' , 'ReportesController@rpt_val_inventario')->name('reportes.rpt_val_inventario');
    Route::get( '/reportes/ventas_prods' , 'ReportesController@ventas_prods')->name('reportes.ventas_prods');
    Route::post( '/reportes/rpt_ventas_prods' , 'ReportesController@rpt_ventas_prods')->name('reportes.rpt_ventas_prods');
    Route::get( '/reportes/ant_saldos' , 'ReportesController@ant_saldos')->name('reportes.ant_saldos');
    Route::post( '/reportes/rpt_ant_saldos' , 'ReportesController@rpt_ant_saldos')->name('reportes.rpt_ant_saldos');
    
    


});


Route::get('/', function () {
    $negocio = App\Negocio::all();
    return view('welcome', compact('negocio'));
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home')->middleware(['estado']);

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/user/get/' , 'Auth\LoginController@getInfo')->name('user.get');
Route::post('/user/contador' , 'Auth\LoginController@Contador')->name('user.contador');
Route::post('/password/reset2' , 'Auth\ForgotPasswordController@ResetPassword')->name('password.reset2');
Route::get('/user-existe/', 'Auth\LoginController@userExiste')->name('user.existe');

//Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
/*Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/


// Route::get('/fel/{factura_maestro}/test' , 'FacturasController@generarFEL');
// Route::get('/fel/{factura_maestro}/anular' , 'FacturasController@anularFEL');
