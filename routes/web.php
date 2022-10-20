<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyCRUDController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\MailController;
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

Route::get('/companies', [CompanyCRUDController::class, 'index'])->name('companies');
// Route::get('/companies', [CompanyCRUDController::class, 'search'])->name('search');
Route::get('companies/create', [CompanyCRUDController::class, 'create'])->name('companies.create');
Route::post('companies', [CompanyCRUDController::class, 'store'])->name('companies.store');
Route::get('companies/{company}/edit', [CompanyCRUDController::class, 'edit'])->name('companies.edit');
// Route::get('companies/{companies}', [CompanyCRUDController::class, 'show']);
Route::put('companies/{companies}', [CompanyCRUDController::class, 'update'])->name('companies.update');
Route::delete('companies/{company}', [CompanyCRUDController::class, 'destroy'])->name('companies.destroy');

Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
Route::get('/refresh-captcha', [CustomAuthController::class, 'refreshCaptcha']);

Route::get('sendbasicemail',[MailController::class, 'basic_email']);
Route::get('sendhtmlemail',[MailController::class, 'html_email']);
Route::get('sendattachmentemail',[MailController::class, 'attachment_email']);

Route::get('/json', function() {
    $url = 'https://jsonplaceholder.typicode.com/posts';

    // $response = file_get_contents($url);
    // $newsData = json_decode($response);
    $json = json_decode(file_get_contents($url), true);
    dd($json[0]["userId"]);
    // return response()->json($json);  
});