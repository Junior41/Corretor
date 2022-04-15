<?php

use App\Http\Controllers\mainController;
use Illuminate\Support\Facades\Route;


Route::get("/paginacao/{inicio}/{fim}/{porcentagemErro}", [mainController::class, 'paginacao'])->name('paginacao');
Route::resource("/", mainController::class);
