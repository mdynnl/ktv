<?php

use App\Http\Livewire\LiveFbMenuView;
use App\Http\Livewire\LiveRoomInfo;
use App\Models\Inhouse;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', LiveRoomInfo::class)->name('home');

    Route::get('/food-and-beverage/setting', LiveFbMenuView::class)->name('fnb.menu-view');
});

Route::get('/test', function () {
    $inhouse = Inhouse::find(1);

    return $inhouse->viewInformationInvoices;
});


require __DIR__.'/auth.php';
