<?php

use App\Http\Controllers\Socialite\GitHubController;
use App\Http\Controllers\TagController;
use App\Livewire\ShowProducts;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    //Esta ruta es la que me muestra cuando no estoy logeado, vamos a mostrar los productos
    //disponibles y su usuario (usamos el with para evitar problemas de carga ansiosa)
    $productos = Product::with('user')->where('disponible', 'SI')->paginate(5);
    return view('welcome', compact('productos'));
})->name('inicio');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('productos', ShowProducts::class)->name('productos.index');

    //Ruta 1:N
    Route::resource('tags', TagController::class)->except('show');
});

Route::get('/auth/github/redirect', [GitHubController::class, 'redirect'])->name('github.redirect');
Route::get('/auth/github/callback',[GitHubController::class, 'callback'])->name('github.callback');