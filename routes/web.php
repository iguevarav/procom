<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');


//Route::get('admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
  //  ->middleware('auth')
    //->name('admin.dashboard');


Route::group(['prefix'=>'productos'], function(){
    Route::get('/index', [App\Http\Controllers\ProductoController::class, 'index'])->name('productos.index');
    Route::get('/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('productos.create');
    Route::post('/store', [App\Http\Controllers\ProductoController::class, 'store'])->name('productos.store');
    Route::get('/edit/{id}', [App\Http\Controllers\ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/update/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/destroy/{id}', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('productos.destroy');
});


Route::group(['prefix'=>'categorias'], function(){
  Route::get('/index', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categorias.index');
  // Route::get('/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('categorias.create');
  Route::post('/store', [App\Http\Controllers\CategoriaController::class, 'store'])->name('categorias.store');
  Route::get('/edit/{id}', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('categorias.edit');
  Route::put('/update/{id}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('categorias.update');
  Route::delete('/destroy/{id}', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('categorias.destroy');
  Route::get('/show/{id}', [App\Http\Controllers\CategoriaController::class, 'show'])->name('categorias.show');
});

Route::group(['prefix'=>'marcas'], function(){
  Route::get('/index', [App\Http\Controllers\MarcaController::class, 'index'])->name('marcas.index');
  // Route::get('/create', [App\Http\Controllers\MarcaController::class, 'create'])->name('marcas.create');
  Route::post('/store', [App\Http\Controllers\MarcaController::class, 'store'])->name('marcas.store');
  Route::get('/edit/{id}', [App\Http\Controllers\MarcaController::class, 'edit'])->name('marcas.edit');
  Route::put('/update/{id}', [App\Http\Controllers\MarcaController::class, 'update'])->name('marcas.update');
  Route::delete('/destroy/{id}', [App\Http\Controllers\MarcaController::class, 'destroy'])->name('marcas.destroy');
  Route::get('/show/{id}', [App\Http\Controllers\MarcaController::class, 'show'])->name('marcas.show');

});

Route::group(['prefix'=>'unidades'], function(){
  Route::get('/index', [App\Http\Controllers\UnidadController::class, 'index'])->name('unidades.index');
  // Route::get('/create', [App\Http\Controllers\UnidadController::class, 'create'])->name('unidades.create');
  Route::post('/store', [App\Http\Controllers\UnidadController::class, 'store'])->name('unidades.store');
  Route::get('/edit/{id}', [App\Http\Controllers\UnidadController::class, 'edit'])->name('unidades.edit');
  Route::put('/update/{id}', [App\Http\Controllers\UnidadController::class, 'update'])->name('unidades.update');
  Route::delete('/destroy/{id}', [App\Http\Controllers\UnidadController::class, 'destroy'])->name('unidades.destroy');
  Route::get('/show/{id}', [App\Http\Controllers\UnidadController::class, 'show'])->name('unidades.show');

});


Route::group(['prefix'=>'clientes'], function(){
  Route::get('/index', [App\Http\Controllers\ClienteController::class, 'index'])->name('clientes.index');
  Route::get('/create', [App\Http\Controllers\ClienteController::class, 'create'])->name('clientes.create');
  Route::post('/store', [App\Http\Controllers\ClienteController::class, 'store'])->name('clientes.store');
  Route::get('/edit/{id}', [App\Http\Controllers\ClienteController::class, 'edit'])->name('clientes.edit');
  Route::put('/update/{id}', [App\Http\Controllers\ClienteController::class, 'update'])->name('clientes.update');
  Route::delete('/destroy/{id}', [App\Http\Controllers\ClienteController::class, 'destroy'])->name('clientes.destroy');
  Route::get('/show/{id}', [App\Http\Controllers\ClienteController::class, 'show'])->name('clientes.show');

});

