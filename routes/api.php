<?php
use Illuminate\Support\Facades\Route;

Route::prefix("xxl-job-api")->middleware([\Soen\XxlExecutor\XxlJobMiddle::class])->group(function (){
    Route::get('beat',[\Soen\XxlExecutor\Controllers\XxlJobController::class,'beat']);
    Route::post('run',[\Soen\XxlExecutor\Controllers\XxlJobController::class,'run']);
});

