<?php

use Illuminate\Support\Facades\Route;

// index
Route::get('/', function () {
    return view('boards/index');
}); 

// index -> 게시판
Route::get('/post', function () {
    return view('boards/posts_list');
}); 

// index -> 게시판 -> 게시판 글 쓰기
Route::get('/post/write', function () {
    return view('boards/write_post');
}); 

// index -> 게시판 -> 게시판 글 읽기
Route::get('/post/read', function () {
    return view('boards/read_post');
}); 


// php artisan serve 입력으로 서버 실행. 포트 번호: 8000