<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\LogController;

//  Inicio y Dashboard (requieren login)
Route::get('/', [HomeController::class, 'home'])->middleware('auth');
/*Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');*/

Route::get('/dashboard', [LogController::class, 'dashboard'])->name('dashboard')->middleware('auth');

//Cambie esta ruta para que reciba el index de CommandController, que muestra el control de dispositivos
/*Route::get('/control-dispositivos', function () {
    return view('control-dispositivos');
})->name('control.dispositivos')->middleware('auth');*/

Route::get('/control-dispositivos', [CommandController::class, 'index'])->name('control.dispositivos')->middleware('auth');

//Route::get('/bitacora', function () {
//    return view('bitacora');
//})->name('bitacora.index')->middleware('auth');

Route::get('/bitacora', [LogController::class, 'bitacora'])->name('bitacora.index')->middleware('auth');

//  Perfil de usuario (requiere login)
Route::get('/profile', function () {
    return view('profile');
})->name('profile')->middleware('auth');

Route::get('/user-profile', [InfoUserController::class, 'create'])->middleware('auth');
Route::post('/user-profile', [InfoUserController::class, 'store'])->middleware('auth');

//  Logout (requiere login)
Route::get('/logout', [SessionsController::class, 'destroy'])->middleware('auth');

//  Productos (CRUD completo, requiere login)
Route::resource('Products', ProductController::class)->middleware('auth');

//  Reportes (solo crear/guardar, públicos)
Route::resource('Reports', ReportController::class)->middleware('auth');

Route::get('/reports/{id}/charly', [ReportController::class, 'generateCharlyPdf'])->name('reports.charly.pdf');

//Comando para el microcontrolador (requiere login)
Route::post('/commands', [CommandController::class, 'store'])->name('commands.store');

//  Rutas de invitados (NO requieren login)
Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/login', [SessionsController::class, 'create'])->name('login');
Route::post('/session', [SessionsController::class, 'store']);
Route::get('/login/forgot-password', [ResetController::class, 'create']);
Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
