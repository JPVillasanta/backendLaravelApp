<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes receive the /api prefix in bootstrap/app.php.
| Example: GET http://127.0.0.1:8000/api/products
|
*/

Route::apiResource('products', ProductController::class);
