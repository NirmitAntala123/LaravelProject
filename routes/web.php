<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyCRUDController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;


use Symfony\Component\Console\Input\Input;
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

// Route::resource('companies', CompanyCRUDController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/companies', [CompanyCRUDController::class, 'index'])->name('companies');
// Route::get('/companies', [CompanyCRUDController::class, 'search'])->name('search');
Route::get('companies/create', [CompanyCRUDController::class, 'create'])->name('companies.create');
Route::post('companies', [CompanyCRUDController::class, 'store'])->name('companies.store');
Route::get('companies/{company}/edit', [CompanyCRUDController::class, 'edit'])->name('companies.edit');
// Route::get('companies/{companies}', [CompanyCRUDController::class, 'show']);
Route::put('companies/{companies}', [CompanyCRUDController::class, 'update'])->name('companies.update');
Route::delete('companies/{company}', [CompanyCRUDController::class, 'destroy'])->name('companies.destroy');
Route::get('generate-pdf', [CompanyCRUDController::class, 'generatePDF'])->name('generatePDF');
Route::get('generate-csv',[CompanyCRUDController::class, 'generateCSV'])->name('generateCSV');
Route::post('import-csv', [CompanyCRUDController::class, 'importCSV'])->name('importCSV');
Route::delete('myproductsDeleteAll', [CompanyCRUDController::class, 'deleteAll']);

Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
Route::get('/refresh-captcha', [CustomAuthController::class, 'refreshCaptcha']);
Route::get('auth/facebook', [CustomAuthController::class, 'redirectToFB']);
Route::get('callback/facebook', [CustomAuthController::class, 'handleCallback']);

Route::get('sendbasicemail',[MailController::class, 'basic_email']);
Route::get('sendhtmlemail',[MailController::class, 'html_email']);
Route::get('sendattachmentemail',[MailController::class, 'attachment_email']);

Route::resource('roles',  RolesController::class, ['names' => 'roles']);
Route::resource('admins', AdminsController::class, ['names' => 'admins']);
Route::get('userChangeStatus', [AdminsController::class, 'userChangeStatus'])->name('userChangeStatus'); 
Route::resource('profile', ProfileController::class, ['names' => 'profile']);
