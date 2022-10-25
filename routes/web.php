<?php

use App\Http\Livewire\LiveCustomerView;
use App\Http\Livewire\LiveFbMenuView;
use App\Http\Livewire\LiveRoomInfo;
use App\Http\Livewire\LiveRoomView;
use App\Http\Livewire\LiveServiceStaffCreate;
use App\Http\Livewire\LiveServiceStaffEdit;
use App\Http\Livewire\LiveServiceStaffView;
use App\Models\Inhouse;
use App\Models\Room;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', LiveRoomInfo::class)->name('home');

    Route::get('/food-and-beverage/setting', LiveFbMenuView::class)->name('fnb.menu-view');

    Route::get('/rooms', LiveRoomView::class)->name('room.index');

    Route::get('/service-staff', LiveServiceStaffView::class)->name('service-staff.index');
    // Route::get('/service-staff/create', LiveServiceStaffCreate::class)->name('service-staff.create');
    // Route::get('/service-staff/{serviceStaff}/edit', LiveServiceStaffEdit::class)->name('service-staff.edit');

    Route::get('/customer', LiveCustomerView::class)->name('customer.index');
});

Route::get('/test', function () {
    return Room::select('id', 'room_type_id', 'room_no')->whereNotIn('id', function ($query) {
        $query->select('room_id as id')->from('inhouses')->where('checked_out', false);
    })
    ->with('type:id,room_type_name,room_rate')
    ->get();

    // return $inhouse->viewInformationInvoices;
});


require __DIR__.'/auth.php';
