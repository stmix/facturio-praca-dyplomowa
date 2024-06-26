<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;

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
Route::get('/invoices/{id}', [InvoicesController::class, 'showPdf'])->name('invoices.show');
Route::get('/invoices/{id}/download', [InvoicesController::class, 'downloadPdf'])->name('invoices.download');
Route::get('/invoices/delete/{id}', [InvoicesController::class, 'destroy']);
Route::get('/invoices/status/{id}', [InvoicesController::class, 'status']);

Route::get('/main', [PageController::class, 'index'])->name('main');

Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/products/add', [ProductsController::class, 'create']);
Route::post('/products/save', [ProductsController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductsController::class, 'destroy'])->name('products.delete');
Route::get('/products/{id}/edit', [ProductsController::class, 'edit']);
Route::put('/products/{id}/update', [ProductsController::class, 'update'])->name('products.update');

Route::get('/clients', [ClientsController::class, 'index'])->name('clients');
Route::get('/clients/add', [ClientsController::class, 'create']);
Route::get('/clients/add/api', [ClientsController::class, 'dataFromApi'])->name('clients.api');
Route::post('/clients/save', [ClientsController::class, 'store'])->name('clients.store');
Route::get('/clients/{id}', [ClientsController::class, 'destroy'])->name('clients.delete');
Route::get('/clients/{id}/edit', [ClientsController::class, 'edit']);
Route::put('/clients/{id}/update', [ClientsController::class, 'update'])->name('clients.update');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::get('/settings/api', [SettingsController::class, 'dataFromApi'])->name('settings.api');
Route::post('/settings/save', [SettingsController::class, 'store'])->name('settings.store');

Auth::routes();
