<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinancesController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
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




Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login-account');



Route::middleware('auth')->group(function () {

    Route::get('/register', [AuthController::class, 'index'])->name('register');
    
    Route::post('/register', [AuthController::class,'store'])->name('register-account');


    //TEACHER MENU
    Route::get('/menu-professor', [ManagementController::class, 'index'])->name('menu-professor');

    Route::post('/aulas/{id}', [ManagementController::class, 'store'])->name('quantidade-aulas');

    Route::post('/pagamento-aluno/{id}', [ManagementController::class, 'updatePayment'])->name('pagamento-aluno');

    Route::post('/anotacao-aluno/{id}', [ManagementController::class, 'studentDescription'])->name('anotacao-aluno');

    Route::put('/anotacoes-aluno', [ManagementController::class, 'resetDescription'])->name('resetar-anotacoes');

    Route::put('/resetar-status', [ManagementController::class, 'resetStatus'])->name('resetar-pago');

    Route::get('/gerar-planilha', [ManagementController::class, 'generateTable'])->name('gerar-planilha');

    Route::get('/resetar-presenca', [ManagementController::class, 'resetClasses'])->name('resetar-presenca');


    //STUDENTS
    Route::get('/meus-alunos', [StudentController::class, 'index'])->name('meus-alunos');

    Route::get('/adicionar-aluno', [StudentController::class, 'indexRegisterStudent'])->name('adicionar-aluno');
    Route::post('/cadastrar-aluno', [StudentController::class, 'store'])->name('cadastrar-aluno');
    
    Route::get('/editar-aluno/{id}', [StudentController::class, 'indexUpdateStudent'])->name('editar-aluno');
    Route::put('/aluno/{id}', [StudentController::class, 'update'])->name('submit-editar-aluno');

    Route::delete('/remover-aluno/{id}', [StudentController::class, 'delete'])->name('remover-aluno');


    //FINANCES
    Route::get('/financas', [FinancesController::class, 'index'])->name('financas');
    Route::get('/gerar-pix', [FinancesController::class, 'rentGeneratePix'])->name('gerar-codigo-pix');
    Route::get('/gerar-pix-responsavel/{id}', [FinancesController::class, 'generatePix'])->name('gerar-codigo-pix-responsavel');


    //PROFILE
    Route::get('/perfil', [UserController::class, 'index'])->name('perfil');
    Route::post('/cadastrar-pix', [UserController::class, 'addPix'])->name('adicionar-chave-pix');
    Route::put('/atualizar-dados', [UserController::class, 'updateUserName'])->name('atualizar-nome');
    Route::put('/mudar-senha', [AuthController::class, 'changePassword'])->name('mudar-senha');
    
    //LOGOUT
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});


Route::middleware(['admin'])->group(function(){

    //ADMIN 
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin-menu');

    Route::get('/admin-professor', [AdminController::class, 'teachers'])->name('admin-professor');

    Route::get('/gerar-planilha-admin', [AdminController::class, 'generateTable'])->name('gerar-planilha-admin');

    Route::get('/admin-editar-professor/{id}', [AdminController::class, 'indexTeacher'])->name('admin-editar-professor');

    Route::put('/admin-editar-professor/{id}', [AdminController::class, 'editTeacher'])->name('submit-editar-professor');
    
    Route::delete('/admin-remover-professor/{id}', [AdminController::class, 'removeTeacher'])->name('admin-remover-professor');

});