<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// index
Route::get('/', function () {
    return view('boards/index');
})->name('index'); 

// index -> 로그인
Route::get('/login', function () {
    return view('boards/login_form');
})->name('login'); 

// index -> 로그인 -> 회원 가입
Route::get('/login/signup', function () {
    return view('boards/create_account');
}); 

// index -> 게시판
Route::get('/board', function (Request $request) {
    // 세션 유무 검사
    if($request->session()->has('code')){
        // 세션 존재시
        return view('boards/posts_list');
    }else{
        // 세션 미존재시
        return redirect()->route('login');
    }
})->name('board'); 

// index -> 게시판 -> 게시글 쓰기
Route::get('/post/write', function (Request $request) {
    // 세션 유무 검사
    if($request->session()->has('code')){
        // 세션 존재시
        return view('boards/write_post');
    }else{
        // 세션 미존재시
        return redirect()->route('login');
    }
}); 

// index -> 게시판 -> 게시글 읽기
Route::get('/post/read', function (Request $request) {
    // 세션 유무 검사
    if($request->session()->has('code')){
        // 세션 존재시
        return view('boards/read_post');
    }else{
        // 세션 미존재시
        return redirect()->route('login');
    }
}); 

// index -> 게시판 -> 게시글 쓰기 -> 게시글 수정
Route::get('/post/update/{postNum}', function (Request $request, $postNum) {
    // 세션 유무 검사
    if($request->session()->has('code')){
        // 세션 존재시
        try{
            $result = DB::select("SELECT subject, content FROM posts WHERE number=$postNum");
            return view('boards/update_post', [
                "number" => $request->session()->get('code'),
                "title" => $result[0]->subject,
                "content" => $result[0]->content
            ]);
        }catch(Exception $e){
            return view('boards/error', ["error" => $e->getMessage()]);
        }
    }else{
        // 세션 미존재시
        return redirect()->route('login');
    }
});

/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////

// index -> 세션 검사
Route::get('/session', function(Request $request) {
    // 세션 검사
    if($request->session()->has('code')){
        // 결과 JSON 응답 (접속된 사용자 정보)
        // { message(요청 처리 상태):bool, id:str, nickname:str }
        $code = $request->session()->get('code');
        try {
            $result = DB::select("SELECT id, nickname FROM members WHERE code=$code");
            $id = $result[0]->id;
            $nickname = $result[0]->nickname;
        }catch(Exception $e){
            return response()->json(["message" => false, "error" => $e->getMessage()]);
        }
    }else{
        return response()->json(["message" => false]);
    }

    return response()->json([
        "message" => true,
        "id" => $id,
        "nickname" => $nickname
    ]);
});


// index -> 로그인 -> 아이디 존재확인
Route::post('/login/id', function(Request $request) {
    // DB 질의 (id 존재 검사)
    $id = $request->input('id');
    $result = DB::select("SELECT 1 FROM members WHERE id='$id'");

    // 결과 JSON 응답
    if($result == null){
        return response()->json(['message' => false]);
    }else{
        return response()->json(['message' => true]);
    }
});


// index -> 로그인 -> 아이디 비밀번호 일치 확인
Route::post('/login/pw', function(Request $request) {
    // DB 질의 (id,pw 일치 검사)
    $id = $request->input('id');
    $pw = $request->input('pw');
    $result = DB::select("SELECT 1 FROM members WHERE id='$id' and password='$pw'");

    // 결과 JSON 응답
    if($result == null){
        return response()->json(['message' => false]);
    }else{
        return response()->json(['message' => true]);
    }
});


// index -> 로그인
Route::post('/login', function(Request $request) {
    // 세션 생성
    $id = $_POST['id'];
    try{
        $code = DB::select("SELECT distinct code From members WHERE id='$id'")[0]->code;
        $request->session()->put('id', $id);
        $request->session()->put('code', $code);
    }catch(Exception $e){
        return redirect()->route('login');
    }

    return redirect()->route('board');
});


// index -> 로그아웃
Route::delete('/logout', function(Request $request) {
    // 세션 제거
    try{
        $request->session()->forget('id');
        $request->session()->forget('code');
    }catch(Exception $e){
        return response()->json(["message" => false, "error" => $e->getMessage()]);
    }

    return response()->json(["message" => true]);
});


// index -> 로그인 -> 회원가입 -> 아이디 중복 확인
Route::post('/signup/id', function (Request $request) {
    $id = $request->input('id');

    // DB 질의
    $result = DB::select("SELECT 1 FROM members WHERE id='$id'");

    // 결과 JSON 응답
    if($result == null){
        return response()->json(['message' => true]);
    }else{
        return response()->json(['message' => false]);
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

    try{
        // DB 질의 (가장 마지막 회원 코드 조회)
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

        // 데이터 삽입
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


// index -> 게시판 -> 게시글 읽어오기
Route::get('/post/list/{page?}', function(Request $request, $page=1){
    $maxPage = 16;
    $start = (($page - 1) * $maxPage) + 1;
    $end = $page * $maxPage;

    try{
        $result = DB::select("SELECT number, subject, nickname, id, regist_day FROM posts WHERE number BETWEEN $start AND $end");
    }catch(Exception $e){
        return response()->json(["message" => false, "error" => $e->getMessage()]);
    }

    if($result == null){
        return response()->json(["message" => true, "rows" => 0]);
    }else{
        // 질의 데이터를 연관배열의 배열 형태로 변환
        $response = [];
        foreach($result as $row){
            array_push($response, [
                "number" => $row->number,
                "subject" => $row->subject,
                "nickname" => $row->nickname,
                "id" => $row->id,
                "regist_day" => $row->regist_day
            ]);
        }
    }
    return response()->json(["message" => true, "posts" => $response, "rows" => count($response)]);
});


// index -> 게시판 -> 게시글 쓰기 -> 글쓰기, 임시저장
Route::post('/post/write', function(Request $request) {
    $code = $request->session()->get('code');
    $result = DB::select("SELECT id, nickname FROM members WHERE code=$code");
    $id = $result[0]->id;
    $nickname = $result[0]->nickname;
    $subject = $request->input('title');
    $content = $request->input('content');
    $today = date("Y-m-d H:i:s");
    $view = 0;

    $num = DB::select("SELECT number FROM posts ORDER BY number desc LIMIT 1");
    if($num == null){
        $num = 1;
    }else{
        $num = $num[0]->number + 1;
    }

    try{
        DB::insert("INSERT INTO posts VALUES ($num, '$id', '$nickname', '$subject', '$content', '$today', $view, '', '', '')");
    }catch(Exception $e){
        return response()->json(["message" => false, "error" => $e->getMessage()]);
    }
    return response()->json(["message" => true]);
});

// index -> 게시판 -> 게시글 읽기
Route::get('/post/read/{number}', function (Request $request, $num) {
    // 세션 유무 검사
    if($request->session()->has('code')){
        // 세션 존재시
        try{
            $id = $request->session()->get('id');
            $result = DB::select("SELECT subject, content, nickname, id, regist_day, view FROM posts WHERE number=$num");
            if($id == $result[0]->id){
                $isOwnPost = 'true';
            }else{
                $isOwnPost = '';
            }
        }catch(Exception $e){
            return view('boards/error', ['error' => $e->getMessage()]);
        }
        if($result == null){
            return redirect()->route('board');
        }else{
            return view('boards/read_post', [
                'number' => $num,
                'title' => $result[0]->subject,
                'user' => $result[0]->nickname.' ('.substr($result[0]->id, 0, 4).'***)',
                'views' => $result[0]->view,
                'recommends' => 0,
                'regist_day' => $result[0]->regist_day,
                'content' => $result[0]->content,
                'isOwnPost' => $isOwnPost
            ]);
        }
    }else{
        // 세션 미존재시
        return redirect()->route('login');
    }
}); 

// index -> 게시판 -> 게시글 읽기 -> 게시글 수정(view) -> 게시글 수정(model)
Route::put('/post/update', function(Request $request) {
    //
    // 다른 글이 수정되는 오류 해결할 것
    //
    $postNum = $request->input('number');
    $subject = $request->input('title');
    $content = $request->input('content');
    $today = date("Y-m-d H:i:s");

    try{
        DB::update("UPDATE posts SET subject='$subject', content='$content', regist_day='$today' WHERE number=$postNum");
        return response()->json(["message" => true]);
    }catch(Exception $e){
        return response()->json(["message" => false, "error" => $e->getMessage()]);
    }
});

// index -> 게시판 -> 게시글 읽기 -> 게시글 삭제
Route::delete('/post/delete', function(Request $request) {
    $postNum = $request->input('number');
    $lastNum = DB::select("SELECT number FROM posts ORDER BY number DESC LIMIT 1");

    if($lastNum != null){
        $lastNum = $lastNum[0]->number;
        DB::beginTransaction();
        try{
            DB::delete("DELETE FROM posts WHERE number=$postNum");
            if($postNum<$lastNum){
                for($i=$postNum+1; $i<=$lastNum; $i++){
                    DB::update("UPDATE posts SET number=$i-1 WHERE number=$i");
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(["message" => false, "error" => $e->getMessage()]);
        }
    }
    return response()->json(["message" => true]);
});