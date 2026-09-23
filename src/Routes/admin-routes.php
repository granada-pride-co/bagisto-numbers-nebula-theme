<?php

use Illuminate\Support\Facades\Route;
use NumbersNebula\NebulaCosmetics\Http\Controllers\Admin\CategoryPickerController;
use NumbersNebula\NebulaCosmetics\Http\Controllers\Admin\ProductPickerController;
use NumbersNebula\NebulaCosmetics\Http\Controllers\Admin\SeederController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    Route::get('nebula-cosmetics/products/search', [ProductPickerController::class, 'search'])
        ->name('admin.nebula-cosmetics.products.search');

    Route::get('nebula-cosmetics/categories/search', [CategoryPickerController::class, 'search'])
        ->name('admin.nebula-cosmetics.categories.search');

    Route::post('nebula-cosmetics/seed-demo-data', [SeederController::class, 'run'])
        ->name('admin.nebula-cosmetics.seed-demo-data');
});
