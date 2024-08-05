<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductionCenter;


// Define a route to Check Hashkey
Route::GET('/production_center', [ProductionCenter::class, 'Index'])->name('production_center');

// Define a route to Fetch Requeseted Order
Route::GET('/order_list', [ProductionCenter::class, 'orderList'])->name('order_list');

// Define a route to Fetch Requeseted Order Details
Route::GET('/order_details_list', [ProductionCenter::class, 'orderDetailsList'])->name('order_details_list');

// Define a route to Fetch OPM
Route::GET('/opm_list', [ProductionCenter::class, 'opmList'])->name('opm_list');

// Define a route to Send New Requeset
Route::POST('/new_order', [ProductionCenter::class, 'newOrder'])->name('new_order');

// Define a route to Fetch Requeset order History List
Route::GET('/order_history_list', [ProductionCenter::class, 'orderHistoryList'])->name('order_history_list');

// Define a route to Fetch Requeset Order Details History List
Route::GET('/order_details_history_list', [ProductionCenter::class, 'orderDetailsHistoryList'])->name('order_details_history_list');

// Define a route to Assign The Order To Factory (Update Order Status To Assigned)
Route::POST('/assign_oreder', [ProductionCenter::class, 'assignOreder'])->name('assign_oreder');

// Define a route to Fetch Factories
Route::GET('/get_factory', [ProductionCenter::class, 'getFactory'])->name('get_factory');

// Define a route to Update Order From Project
Route::POST('/edit_order', [ProductionCenter::class, 'editOrder'])->name('edit_order');

// Define a route to Update Order From The Factory 
Route::POST('/update_order', [ProductionCenter::class, 'updateOrder'])->name('update_order');

// Define a route to Confirm Order From The Project 
Route::POST('/confirm_order', [ProductionCenter::class, 'confirmOrder'])->name('confirm_order');
