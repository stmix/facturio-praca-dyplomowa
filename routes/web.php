<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SettingsController;

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
// Route::post('/signin', [UserController::class, 'signin']);
// Route::post('/signup', [UserController::class, 'signup']);
Route::get('/', function () {
    if(Auth::check()) {
        return redirect('/main');
    } else {
        return redirect('/login');
    }
});

Route::get('/invoices', [InvoicesController::class, 'index'])->name('invoices.index');
Route::get('invoices/add', [InvoicesController::class, 'create'])->name('invoices.create');
Route::post('/invoices/save', [InvoicesController::class, 'store'])->name('invoices.store');
Route::get('/invoices/print/{id}', [InvoicesController::class, 'print']);
Route::get('/invoices/delete/{id}', [InvoicesController::class, 'destroy']);
Route::get('/invoices/status/{id}', [InvoicesController::class, 'status']);

Route::get('/main', [PageController::class, 'index'])->name('main');

Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/products/add', [ProductsController::class, 'create']);
Route::post('/products/save', [ProductsController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductsController::class, 'destroy']);

Route::get('/clients', [ClientsController::class, 'index'])->name('clients');
Route::get('/clients/add', [ClientsController::class, 'create']);
Route::post('/clients/save', [ClientsController::class, 'store'])->name('clients.store');
Route::get('/clients/{id}', [ClientsController::class, 'destroy']);

Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('/settings/save', [SettingsController::class, 'store'])->name('settings.store');

Auth::routes();