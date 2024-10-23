<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VendasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'Login']);


Route::get('/usuarios', [UsuariosController::class, 'index']);
Route::post('/usuarios', [UsuariosController::class, 'store']);
Route::put('/usuarios/{id}', [UsuariosController::class, 'update']);
Route::delete('/usuarios/{id}', [UsuariosController::class, 'delete']);


Route::get('/produtos', [ProdutosController::class, 'index']);
Route::post('/produtos', [ProdutosController::class, 'store']);
Route::put('/produtos/{id}', [ProdutosController::class, 'update']);
Route::delete('/produtos/{id}', [ProdutosController::class, 'delete']);


Route::get('/clientes', [ClientesController::class, 'index']);
Route::post('/clientes', [ClientesController::class, 'store']);
Route::put('/clientes/{id}', [ClientesController::class, 'update']);
Route::delete('/clientes/{id}', [ClientesController::class, 'delete']);


Route::get('/vendas', [VendasController::class, 'index']);
Route::post('/vendas', [VendasController::class, 'store']);
Route::put('/vendas/{id}', [VendasController::class, 'update']);
Route::delete('/vendas/{id}', [VendasController::class, 'delete']);
