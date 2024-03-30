
<?php

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


use App\Http\Controllers\TaskController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\AnalyzeController;

Route::resources([
    'task' => TaskController::class
]);
Route::resource('relation', RelationController::class, ['only' => ['show', 'store', 'update']]);
Route::resource('analyze', AnalyzeController::class, ['only' => ['index']]);
Route::post('/analyze', [AnalyzeController::class, 'showAnalyze'])->name('showAnalyze');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


