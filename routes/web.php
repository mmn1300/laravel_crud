<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// index
Route::get('/', function () {
    return view('boards/index');
}); 

// index -> 로그인
Route::get('/login', function () {
    return view('boards/login_form');
}); 

// index -> 로그인 -> 회원 가입
Route::get('/login/signup', function () {
    return view('boards/create_account');
}); 

// index -> 게시판
Route::get('/board', function () {
    // 세션 유무 검사
    // 세션 존재시
    return view('boards/posts_list');

    // 세션 미존재시
    // return view('boards/login_form');
}); 

// index -> 게시판 -> 게시글 쓰기
Route::get('/post/write', function () {
    // 세션 유무 검사
    // 세션 존재시
    return view('boards/write_post');

    // 세션 미존재시
    // return view('boards/login_form');
}); 

// index -> 게시판 -> 게시글 읽기
Route::get('/post/read', function () {
    // 세션 유무 검사
    // 세션 존재시
    return view('boards/read_post');

    // 세션 미존재시
    // return view('boards/login_form');
}); 

/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////

// index -> 세션 검사
Route::get('/session', function() {
    // DB 질의 (세션 검사)
    // 결과 JSON 응답 (접속된 사용자 정보)
    // { message(세션생성유무):bool, id:str, nickname:str }
    return response()->json();
});

// index -> 로그인
Route::post('/login', function() {
    // DB 질의 (id,pw 검사)
    // 세션 생성
    // 결과 JSON 응답
    return response()->json();
});

// index -> 로그아웃
Route::delete('/logout', function() {
    // 세션 제거
    // 결과 JSON 응답
    return response()->json();
});

// index -> 로그인 -> 회원가입 -> 아이디 중복 확인
Route::post('/signup/id', function (Request $request) {
    $id = $request->input('id');

    // DB 질의
    $result = DB::select("SELECT 1 FROM members WHERE id='$id'");

    // 결과 JSON 응답
    if($result == null){
        return response()->json(['message'=>true]);
    }else{
        return response()->json(['message'=>false]);
    }
});

// index -> 로그인 -> 회원가입 -> 계정 생성
Route::post('/signup', function (Request $request) {
    $request->validate([
        'id' => ['required', 'string', 'max:15'],
        'pw' => ['required', 'string', 'max:15'],
        'name' => ['required', 'string', 'max:10'],
        'email' => ['string', 'max:80'],
        'phone' => ['string', 'max:13']
    ]);

    $code = DB::select("SELECT code FROM members ORDER BY code desc LIMIT 1");
    if($code == null){
        $num = 1;
    }else{
        $num = $code[0]->code + 1;
    }
    $id = $request->input('id');
    $pw = $request->input('pw');
    $name = $request->input('name');
    $email = $request->input('email');
    $phone = $request->input('phone');
    $today = date("Y-m-d H:i:s");

    try{
        DB::insert("INSERT INTO members VALUES ($num, '$id', '$pw', '$name', '$email', '$phone', '$today', 1)");
    }catch(Exception $e){
        return response()->json([
            'message' => false,
            'error' => $e->getMessage()
        ]);
    }

    // 결과 JSON 응답
    return response()->json(['message' => true]);
});


// php artisan serve 입력으로 서버 실행. 포트 번호: 8000