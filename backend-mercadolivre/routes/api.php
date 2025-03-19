<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\MercadoLivreController;
use App\Http\Controllers\ProdutoController;


Route::get('/listaToken', [MercadoLivreController::class, 'getToken']);
Route::get('/token/{id}', [MercadoLivreController::class, 'buscaToken']);
Route::put('/token/{id}', [MercadoLivreController::class, 'updateToken']);
Route::delete('/token/{id}', [MercadoLivreController::class, 'deleteToken']);;

Route::get('/mercadolivre/auth', [MercadoLivreController::class, 'redirectToAuth']);
Route::get('/mercadolivre/callback', [MercadoLivreController::class, 'handleCallback']);

Route::get('/refrsh-token',[MercadoLivreController::class, 'refreshAccessToken'] );

Route::get('/produto/{item_id}', [MercadoLivreController::class, 'getProduct']);



Route::post('/produtos', [ProdutoController::class, 'publicarProduto']);
Route::get('/listaprodutos', [ProdutoController::class, 'getAllProduct']);
Route::get('/produtos/{item_id}', [ProdutoController::class, 'cadastraProduto']);
Route::get('/produtos/busca/{item_id}', [ProdutoController::class, 'buscarProduto']);
Route::put('/produtos/alterar/{item_id}', [ProdutoController::class, 'updateProduto']);
Route::delete('/produtos/apagar/{item_id}', [ProdutoController::class, 'deletarProduto']);

