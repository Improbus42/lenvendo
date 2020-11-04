<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});
Route::post('/p', [App\Http\Controllers\DataController::class, 'formSubmit'])->name('form-submit');
Route::get('/bookmark/{number}', [App\Http\Controllers\DataController::class, 'viewBookmark'])->name('view-bookmark');
Route::get('/bookmarks/{sortBy}', [App\Http\Controllers\DataController::class, 'allBookmarks'])->name('all-bookmarks');
Route::get('/export', [App\Http\Controllers\DataController::class, 'export'])->name('export-excel');
Route::post('/delete/{id}', [App\Http\Controllers\DataController::class, 'delete'])->name('delete-bookmark');
