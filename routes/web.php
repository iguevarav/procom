<?php


use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrdenCompraController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


//Route::get('admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
  //  ->middleware('auth')
    //->name('admin.dashboard');


Route::group(['prefix'=>'productos'], function(){
    Route::get('/index', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/store', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/edit/{id}', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/update/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/destroy/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::get('/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');
});


Route::group(['prefix'=>'categorias'], function(){
  Route::get('/index', [CategoriaController::class, 'index'])->name('categorias.index');
  Route::post('/store', [CategoriaController::class, 'store'])->name('categorias.store');
  Route::get('/edit/{id}', [CategoriaController::class, 'edit'])->name('categorias.edit');
  Route::put('/update/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
  Route::delete('/destroy/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
  Route::get('/show/{id}', [CategoriaController::class, 'show'])->name('categorias.show');
  Route::get('/buscar', [CategoriaController::class, 'buscar'])->name('categorias.buscar');
});

Route::group(['prefix'=>'marcas'], function(){
  Route::get('/index', [MarcaController::class, 'index'])->name('marcas.index');
  Route::post('/store', [MarcaController::class, 'store'])->name('marcas.store');
  Route::get('/edit/{id}', [MarcaController::class, 'edit'])->name('marcas.edit');
  Route::put('/update/{id}', [MarcaController::class, 'update'])->name('marcas.update');
  Route::delete('/destroy/{id}', [MarcaController::class, 'destroy'])->name('marcas.destroy');
  Route::get('/show/{id}', [MarcaController::class, 'show'])->name('marcas.show');
  Route::get('/buscar', [MarcaController::class, 'buscar'])->name('marcas.buscar');

});

Route::group(['prefix'=>'unidades'], function(){
  Route::get('/index', [UnidadController::class, 'index'])->name('unidades.index');
  Route::post('/store', [UnidadController::class, 'store'])->name('unidades.store');
  Route::get('/edit/{id}', [UnidadController::class, 'edit'])->name('unidades.edit');
  Route::put('/update/{id}', [UnidadController::class, 'update'])->name('unidades.update');
  Route::delete('/destroy/{id}', [UnidadController::class, 'destroy'])->name('unidades.destroy');
  Route::get('/show/{id}', [UnidadController::class, 'show'])->name('unidades.show');
  Route::get('/buscar', [UnidadController::class, 'buscar'])->name('unidades.buscar');

});

Route::group(['prefix'=>'clientes'], function(){
  Route::get('/index', [ClienteController::class, 'index'])->name('clientes.index');
  Route::get('/create', [ClienteController::class, 'create'])->name('clientes.create');
  Route::post('/store', [ClienteController::class, 'store'])->name('clientes.store');
  Route::get('/edit/{id}', [ClienteController::class, 'edit'])->name('clientes.edit');
  Route::put('/update/{id}', [ClienteController::class, 'update'])->name('clientes.update');
  Route::delete('/destroy/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
  Route::get('/show/{id}', [ClienteController::class, 'show'])->name('clientes.show');
  Route::get('/buscar', [CLienteController::class, 'buscar'])->name('clientes.buscar');

});

Route::group(['prefix'=>'cargos'], function(){
  Route::get('/index', [CargoController::class, 'index'])->name('cargos.index');
  Route::post('/store', [CargoController::class, 'store'])->name('cargos.store');
  Route::get('/edit/{id}', [CargoController::class, 'edit'])->name('cargos.edit');
  Route::put('/update/{id}', [CargoController::class, 'update'])->name('cargos.update');
  Route::delete('/destroy/{id}', [CargoController::class, 'destroy'])->name('cargos.destroy');
  Route::get('/show/{id}', [CargoController::class, 'show'])->name('cargos.show');
  Route::get('/buscar', [CargoController::class, 'buscar'])->name('cargos.buscar');

});

Route::group(['prefix'=>'empleados'], function(){
  Route::get('/index', [EmpleadoController::class, 'index'])->name('empleados.index');
  Route::get('/create', [EmpleadoController::class, 'create'])->name('empleados.create');
  Route::post('/store', [EmpleadoController::class, 'store'])->name('empleados.store');
  Route::get('/edit/{id}', [EmpleadoController::class, 'edit'])->name('empleados.edit');
  Route::put('/update/{id}', [EmpleadoController::class, 'update'])->name('empleados.update');
  Route::delete('/destroy/{id}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');
  Route::get('/show/{id}', [EmpleadoController::class, 'show'])->name('empleados.show');
  Route::get('/buscar', [EmpleadoController::class, 'buscar'])->name('empleados.buscar');

});


Route::group(['prefix'=>'proveedores'], function(){
  Route::get('/index', [ProveedorController::class, 'index'])->name('proveedores.index');
  Route::get('/create', [ProveedorController::class, 'create'])->name('proveedores.create');
  Route::post('/store', [ProveedorController::class, 'store'])->name('proveedores.store');
  Route::get('/edit/{id}', [ProveedorController::class, 'edit'])->name('proveedores.edit');
  Route::put('/update/{id}', [ProveedorController::class, 'update'])->name('proveedores.update');
  Route::delete('/destroy/{id}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');
  Route::get('/show/{id}', [ProveedorController::class, 'show'])->name('proveedores.show');
  Route::get('/buscar', [ProveedorController::class, 'buscar'])->name('proveedores.buscar');

});

Route::group(['prefix' => 'orden_compra'], function () {
    Route::get('/index', [OrdenCompraController::class, 'index'])->name('orden_compra.index');
    Route::get('/create', [OrdenCompraController::class, 'create'])->name('orden_compra.create');
    Route::post('/store', [OrdenCompraController::class, 'store'])->name('orden_compra.store');
    Route::get('/show/{id}', [OrdenCompraController::class, 'show'])->name('orden_compra.show');
    Route::get('/edit/{id}', [OrdenCompraController::class, 'edit'])->name('orden_compra.edit');
    Route::put('/update/{id}', [OrdenCompraController::class, 'update'])->name('orden_compra.update');
    Route::delete('/destroy/{id}', [OrdenCompraController::class, 'destroy'])->name('orden_compra.destroy');
    Route::get('/buscar', [OrdenCompraController::class, 'buscar'])->name('orden_compra.buscar');


});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
