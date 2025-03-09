<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk halaman utama
Route::get('/', function () { 
    return 'Selamat Datang';
});

// Route untuk menampilkan "Hello World"
Route::get('/hello', function () { 
    return 'Hello World';
});

// Route untuk menampilkan "World"
Route::get('/world', function () { 
    return 'World';
});

Route::get('/user/{name}', function ($name) { 
    return 'Nama saya '.$name;
});

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
    });

Route::get('/articles/{id}', function ($id) { 
        return 'Halaman Artikel dengan ID '.$id; 
    });
    
    Route::get('/user/{name?}', function ($name='John') { 
        return 'Nama saya '.$name;
    });