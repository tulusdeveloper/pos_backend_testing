<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerBillController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

// Route::get('/categories', [CategoryController::class, 'index']);


//this is not seri
Route::post('/categories/{category}/products', [ProductController::class, 'store']);
Route::get('/categories/{category}/products', [CategoryController::class, 'getProducts']);
Route::put('/categories/{category}/products/{product}', [ProductController::class, 'update']);
Route::delete('/categories/{category}/products/{product}', [ProductController::class, 'destroy']);
// Route::post('/categories/{category}/uploadIcon', [CategoryController::class, 'uploadIcon']);




// Route::group(['middleware' => ['auth:sanctum']], function () {
    // Customer Orders
    Route::get('/customer-orders', [CustomerOrderController::class, 'index']);
    Route::post('/customer-orders', [CustomerOrderController::class, 'store']);
    Route::get('/customer-orders/{customerOrder}', [CustomerOrderController::class, 'show']);
    Route::put('/customer-orders/{customerOrder}', [CustomerOrderController::class, 'update']);
    Route::delete('/customer-orders/{customerOrder}', [CustomerOrderController::class, 'destroy']);

    // Customer Bills
    Route::get('/customer-bills', [CustomerBillController::class, 'index']);
    Route::post('/customer-bills', [CustomerBillController::class, 'store']);
    Route::get('/customer-bills/{customerBill}', [CustomerBillController::class, 'show']);
    Route::put('/customer-bills/{customerBill}', [CustomerBillController::class, 'update']);
    Route::delete('/customer-bills/{customerBill}', [CustomerBillController::class, 'destroy']);

    // Receipts
    Route::get('/receipts', [ReceiptController::class, 'index']);
    Route::post('/receipts', [ReceiptController::class, 'store']);
    Route::get('/receipts/{receipt}', [ReceiptController::class, 'show']);
    Route::put('/receipts/{receipt}', [ReceiptController::class, 'update']);
    Route::delete('/receipts/{receipt}', [ReceiptController::class, 'destroy']);
// });