<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\TicketTracking;

Route::get('/', Home::class)->name('home');
Route::get('/track/{id?}', TicketTracking::class)->name('tracking');

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/users', \App\Livewire\Admin\UserList::class)->name('users');
    Route::get('/orders', \App\Livewire\Admin\OrderList::class)->name('orders');
    Route::get('/orders/create', \App\Livewire\Admin\CreateOrder::class)->name('orders.create');
    Route::get('/tickets/{id}', \App\Livewire\Admin\TicketDetail::class)->name('tickets.show');
    Route::get('/tickets/{id}/invoice', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('tickets.invoice');
    Route::get('/tickets/{id}/invoice/pdf', [\App\Http\Controllers\InvoiceController::class, 'downloadPdf'])->name('tickets.invoice.pdf');
    Route::get('/spareparts', \App\Livewire\Admin\SparepartList::class)->name('spareparts');
    Route::get('/spare-part-types', \App\Livewire\Admin\SparePartTypeList::class)->name('spare-part-types');
    Route::get('/coupons', \App\Livewire\Admin\CouponList::class)->name('coupons');
    Route::get('/landing-page', \App\Livewire\Admin\LandingPageEditor::class)->name('landing-page');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::post('logout', function (\App\Livewire\Actions\Logout $logout) {
    $logout();
    return redirect('/');
})->middleware('auth')->name('logout');
