<?php

use App\Http\Controllers\Site\AbouttController;
use App\Http\Controllers\Site\CategoryeController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\ServiceController;
use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'site'],function(){
    Route::resources(['services' => ServiceController::class]);
    Route::resources(['categories' => CategoryeController::class]);
    Route::resources(['abouts' => AbouttController::class]);
    Route::resources(['contacts' => ContactController::class]);
});

?>
