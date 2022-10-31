<?php

use App\Http\Livewire\LiveCustomerView;
use App\Http\Livewire\LiveFbMenuView;
use App\Http\Livewire\LiveItemIndex;
use App\Http\Livewire\LivePurchaseCreate;
use App\Http\Livewire\LivePurchaseDetailReport;
use App\Http\Livewire\LivePurchaseIndex;
use App\Http\Livewire\LivePurchaseSummaryReport;
use App\Http\Livewire\LiveRoomInfo;
use App\Http\Livewire\LiveRoomView;
use App\Http\Livewire\LiveSalesDetailReport;
use App\Http\Livewire\LiveSalesSummaryReport;
use App\Http\Livewire\LiveServiceStaffCommissionDetailReport;
use App\Http\Livewire\LiveServiceStaffCommissionSummaryReport;
use App\Http\Livewire\LiveServiceStaffCreate;
use App\Http\Livewire\LiveServiceStaffEdit;
use App\Http\Livewire\LiveServiceStaffView;
use App\Http\Livewire\LiveSupplierIndex;
use App\Http\Livewire\LiveUserCreate;
use App\Http\Livewire\LiveUserEdit;
use App\Http\Livewire\LiveUserRolesAndPermissionView;
use App\Http\Livewire\LiveUserShow;
use App\Http\Livewire\LiveUserView;
use App\Models\Food;
use App\Models\Inhouse;
use App\Models\Room;
use App\Models\ServiceStaff;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', LiveRoomInfo::class)->name('home')->middleware('permission:view inhouses');

    Route::get('/food-and-beverage/setting', LiveFbMenuView::class)->name('fnb.menu-view')->middleware('permission:view food and beverages');

    Route::get('/rooms', LiveRoomView::class)->name('room.index')->middleware('permission:view food and beverages');

    Route::get('/service-staff', LiveServiceStaffView::class)->name('service-staff.index')->middleware('permission:view service staffs');
    // Route::get('/service-staff/create', LiveServiceStaffCreate::class)->name('service-staff.create');
    // Route::get('/service-staff/{serviceStaff}/edit', LiveServiceStaffEdit::class)->name('service-staff.edit');

    Route::get('/customer', LiveCustomerView::class)->name('customer.index')->middleware('permission:view customers');

    Route::get('/items', LiveItemIndex::class)->name('item.index')->middleware('permission:view items');

    Route::get('/suppliers', LiveSupplierIndex::class)->name('supplier.index')->middleware('permission:view suppliers');

    Route::get('/purchase', LivePurchaseIndex::class)->name('purchase.index')->middleware('permission:view purchases');

    Route::group(['middleware' => ['permission:view reports']], function () {
        Route::get('/reports', LiveSalesDetailReport::class)->name('report.sales-detail');
        Route::get('/reports/sales-summary', LiveSalesSummaryReport::class)->name('report.sales-summary');
        Route::get('/reports/purchase-details', LivePurchaseDetailReport::class)->name('report.purchase-details');
        Route::get('/reports/purchase-summary', LivePurchaseSummaryReport::class)->name('report.purchase-summary');
        Route::get('/reports/commission-details', LiveServiceStaffCommissionDetailReport::class)->name('report.commission-details');
        Route::get('/reports/commission-summary', LiveServiceStaffCommissionSummaryReport::class)->name('report.commission-summary');
    });

    // Route::get('/purchase', LivePurchaseCreate::class)->name('purchase.create');

    Route::group(['middleware' => ['permission:view any users']], function () {
        Route::get('/users', LiveUserView::class)->name('users');
        Route::get('/users/roles-and-permission', LiveUserRolesAndPermissionView::class)->name('users.roles-permission');
        Route::get('/users/create', LiveUserCreate::class)->name('users.create');
        Route::get('/users/{user}', LiveUserShow::class)->name('users.show');
        Route::get('/users/{user}/edit', LiveUserEdit::class)->name('users.edit');
    });
});

Route::get('/test', function () {
    return ServiceStaff::withSum('inhouseServices', 'session_hours')
    ->with('inhouseServices')
    ->get();
    return Inhouse::with([ 'viewInformationInvoices' => function ($query) {
        $query->whereIn('group_no', [1, 2, 3]);
    } ])->where('operation_date', app('OperationDate'))->where('checked_out', true)->get();
    return Food::select('id')->with('recipes:food_id,item_id,qty', 'recipes.item:id,current_qty')->find(41);
    // return Food::has('recipes', '>', 0)->with('recipes')->get();
    return Food::with(['recipes', 'foodType'])->get();

    return Room::select('id', 'room_type_id', 'room_no')->whereNotIn('id', function ($query) {
        $query->select('room_id as id')->from('inhouses')->where('checked_out', false);
    })
    ->with('type:id,room_type_name,room_rate')
    ->get();

    // return $inhouse->viewInformationInvoices;
});


require __DIR__.'/auth.php';
