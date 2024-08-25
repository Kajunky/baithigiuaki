<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookPropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

// Hiển thị danh sách
Route::get('/book_properties', [BookPropertyController::class, 'index'])->name('book_properties.index');

// Thêm
Route::get('/book_properties/create', [BookPropertyController::class, 'create'])->name('book_properties.create');
Route::post('/book_properties', [BookPropertyController::class, 'store'])->name('book_properties.store');

// Sửa
Route::get('/book_properties/{id}/edit', [BookPropertyController::class, 'edit'])->name('book_properties.edit');
Route::put('/book_properties', [BookPropertyController::class, 'update'])->name('book_properties.update');

// Xoá
Route::get('/book_properties/{book_property}/delete', [BookPropertyController::class, 'delete'])->name('book_properties.delete');
Route::delete('/book_properties/{book_property}', [BookPropertyController::class, 'destroy'])->name('book_properties.destroy');
