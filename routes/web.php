<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoiceAttachmentssController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
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
    return view('auth.login');
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// },[HomeController::class,'index'])->middleware(['auth', 'verified'])->name('/dashboard');


// Route::get('/home', [HomeController::class,'index'])->name('home');
Route::get('/dashboard', [HomeController::class,'index'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('invoices', InvoicesController::class);
Route::resource('sections', SectionsController::class);
Route::resource('products', ProductsController::class);
Route::get('/section/{id}', [InvoicesController::class,'getproducts']);
Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class,'edit']);
Route::get('/MarkAsRead/{invoiceId}/{notificationId}', [InvoicesDetailsController::class,'MarkAsRead']);
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'get_file']);

Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'open_file']);

Route::post('delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::resource('InvoiceAttachments', InvoiceAttachmentssController::class);
Route::get('/edit_invoice/{id}', [InvoicesController::class,'edit']);
Route::get('/Status_show/{id}', [InvoicesController::class,'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class,'status_update'])->name('status_update');
Route::get('Invoice_Paid',[InvoicesController::class,'Invoice_Paid']);

Route::get('Invoice_UnPaid',[InvoicesController::class,'Invoice_UnPaid']);

Route::get('Invoice_Partial',[InvoicesController::class,'Invoice_Partial']);
Route::resource('Archive', InvoiceArchiveController::class);
Route::get('Print_invoice/{id}',[InvoicesController::class,'Print_invoice']);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    
});

Route::get('invoices_report', [Invoices_Report::class,'index']);
Route::post('Search_invoices', [Invoices_Report::class,'Search_invoices']);
Route::get('customers_report', [Customers_Report::class,'index'])->name('customers_report');
Route::post('Search_customers', [Customers_Report::class,'Search_customers']);
Route::get('MarkAsRead_all',[InvoicesController::class,'MarkAsRead_all'])->name('MarkAsRead_all');



Route::get('unreadNotifications_count', [InvoicesController::class,'unreadNotifications_count'])->name('unreadNotifications_count');

Route::get('unreadNotifications', [InvoicesController::class,'unreadNotifications'])->name('unreadNotifications');


Route::get('/{page}', [AdminController::class,'index']);


