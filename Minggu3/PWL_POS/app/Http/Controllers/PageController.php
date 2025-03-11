<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index() {
        return 'Selamat Datang';
    }

    public function about() {
        return 'Nama dan NIM';
    }

    public function articles($id) {
        return 'PageController : articles - Halaman Artikel dengan ID ' . $id;
    }
}
