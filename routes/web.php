<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use FontLib\Table\Type\name;
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
    return redirect()->route('login');
});

// Route::resource()

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('company', CompanyController::class);
    Route::resource('employee', EmployeeController::class);

    Route::get('/pdf-employee', [EmployeeController::class, 'export_pdf'])->name('pdf.employee');
    Route::get('/pdf', [CompanyController::class, 'export_pdf'])->name('pdf.company');
    Route::post('/import', [EmployeeController::class, 'import_excel'])->name('import.employee');
});
