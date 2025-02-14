<?php

use Illuminate\Support\Facades\Route;

// index
Route::get('/', function () {
    return view('boards/index');
}); 


// php artisan serve 입력으로 서버 실행. 포트 번호: 8000