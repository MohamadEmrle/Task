<?php

use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::get('/index' ,[SiteController::class,'index'])->name('site.index');
});
?>
