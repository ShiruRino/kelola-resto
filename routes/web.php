<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::middleware('auth')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/dashboard', function() {
        $productCount = Product::count();
        $customerCount = Customer::count();
        $orderCount = Order::count();
        $transactionCount = Transaction::count();
        return view('index', compact(['productCount', 'customerCount', 'orderCount', 'transactionCount']));
    })->name('index');
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
    Route::put('orders/{id}',[ OrderController::class, 'complete'])->name('orders.complete');
    Route::resource('orders', OrderController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('histories', HistoryController::class);
});
