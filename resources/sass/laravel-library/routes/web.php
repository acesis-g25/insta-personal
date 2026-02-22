<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;


Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');

    #Author
    Route::group(['prefix'=> 'author','as'=>'author.'], function () {
        Route::get('/',[AuthorController::class,'index'])->name('index');
        Route::post('/store',[AuthorController::class,'store'])->name('store');
        Route::get('/{id}/edit',[AuthorController::class,'edit'])->name('edit');
        Route::patch('/{id}/update',[AuthorController::class,'update'])->name('update');
        Route::get('/{id}/delete',[AuthorController::class,'delete'])->name('delete');
        Route::delete('/{id}/destroy',[AuthorController::class,'destroy'])->name('destroy');
    });
    Route::group(['prefix'=> 'book','as'=>'book.'], function () {
        Route::get('/',[BookController::class,'index'])->name('index');
        Route::post('/store',[BookController::class,'store'])->name('store');
        Route::get('/{id}/show',[BookController::class,'show'])->name('show');
        Route::get('/{id}/edit',[BookController::class,'edit'])->name('edit');
        Route::patch('/{id}/update',[BookController::class,'update'])->name('update');
        Route::get('/{id}/delete',[BookController::class,'delete'])->name('delete');
        Route::delete('/{id}/destroy',[BookController::class,'destroy'])->name('destroy');
    });
});

