<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| 여기에서 애플리케이션의 웹 경로를 등록할 수 있습니다.
| 이 라우트들은 "web" 미들웨어 그룹을 포함하는 그룹 내에서 RouteServiceProvider에 의해 로드됩니다.
| 
*/


// index
Route::get('/', [ViewController::class, 'index'])->name('index'); 

// index -> 로그인
Route::get('/login', [ViewController::class, 'login'])->name('login'); 

// index -> 로그인 -> 회원 가입
Route::get('/login/signup', [ViewController::class, 'signup'])->name('signup'); 

// index -> 게시판
Route::get('/board', [ViewController::class, 'board'])->name('board'); 

// index -> 게시판 -> 게시글 쓰기
Route::get('/post/write', [ViewController::class, 'writePost']); 

// index -> 게시판 -> 게시글 읽기
Route::get('/post/read', [ViewController::class, 'readPost']); 

// index -> 게시판 -> 게시글 쓰기 -> 게시글 수정
Route::get('/post/update/{postNum}', [ViewController::class, 'updatePost']);

/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////

// index -> 세션 검사
Route::get('/session', [SessionController::class, 'getUserInfo']);

// index -> 로그인 -> 아이디 존재확인
Route::post('/login/id', [LoginController::class, 'checkId']);

// index -> 로그인 -> 아이디 비밀번호 일치 확인
Route::post('/login/pw', [LoginController::class, 'checkAccount']);

// index -> 로그인
Route::post('/login', [LoginController::class, 'login']);

// index -> 로그아웃
Route::delete('/logout', [LoginController::class, 'logout']);

// index -> 로그인 -> 회원가입 -> 아이디 중복 확인
Route::post('/signup/id', [SignupController::class, 'checkId']);

// index -> 로그인 -> 회원가입 -> 계정 생성
Route::post('/signup', [SignupController::class, 'signup']);

// index -> 게시판 -> 게시글 읽어오기
Route::get('/post/list/{page?}', [BoardController::class, 'loadPosts']);

// index -> 게시판 -> 게시글 쓰기 -> 글쓰기
Route::post('/post/write', [BoardController::class, 'writePost'])->name('write');

// index -> 게시판 -> 게시글 읽기
Route::get('/post/read/{number}', [BoardController::class, 'readPost']); 

// index -> 게시판 -> 게시글 읽기-> 파일 존재 여부 확인
Route::get('/post/check/{postNum}', [FileController::class, 'fileExists']);

// index -> 게시판 -> 게시글 읽기-> 파일 다운로드
Route::get('/post/download/{postNum}', [FileController::class, 'download']);

// index -> 게시판 -> 게시글 읽기 -> 게시글 수정(view) -> 게시글 수정(model)
Route::put('/post/update', [BoardController::class, 'updatePost'])->name('update');

// index -> 게시판 -> 게시글 읽기 -> 게시글 삭제
Route::delete('/post/delete', [BoardController::class, 'deletePost']);