<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
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
    return view('home');
})->name('home');

// Route::get('/login', function () {
//     return view('login');
// })->name('login');



Route::get('/register', [AuthController::class, 'index'])->name('register');
Route::post('/register', [AuthController::class,'store'])->name('register-account');

Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login-account');



Route::middleware('auth')->group(function () {
    //TEACHER MENU
    Route::get('/menu-professor', function(){
        return view('menu');
    })->name('menu-professor');

    //STUDENTS
    Route::get('/meus-alunos', [StudentController::class, 'index'])->name('meus-alunos');

    Route::get('/adicionar-aluno', [StudentController::class, 'indexRegisterStudent'])->name('adicionar-aluno');
    Route::post('/cadastrar-aluno', [StudentController::class, 'store'])->name('cadastrar-aluno');
    
   
    Route::get('/editar-aluno/{id}', [StudentController::class, 'indexUpdateStudent'])->name('editar-aluno');
    Route::put('/aluno/{id}', [StudentController::class, 'update'])->name('submit-editar-aluno');

    Route::delete('/remover-aluno/{id}', [StudentController::class, 'delete'])->name('remover-aluno');

    //LOGOUT
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});