<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Member;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     * 게시판 목록 form 리턴
     */
    public function index(Request $request)
    {
        // 세션 유무 검사
        if($request->session()->has('code')){
            // 세션 존재시
            return view('boards/posts_list');
        }else{
            // 세션 미존재시
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     * 게시글 쓰기 form 리턴
     */
    public function create(Request $request)
    {
        // 세션 유무 검사
        if($request->session()->has('code')){
            // 세션 존재시
            try{
                $code = $request->session()->get('code');
                $result = Member::where('code', $code)
                ->get(['nickname', 'id'])
                ->first();

                return view('boards/write_post', [
                    'user' => $result->nickname.' ('.substr($result->id, 0, 4).'****)',
                ]);
            }
            catch(Exception $e){
                return view('boards/error', ["error" => $e->getMessage()]);
            }
        }else{
            // 세션 미존재시
            return redirect()->route('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     * 새로운 게시글 저장
     */
    public function store(Request $request)
    {
        // 세션에서 code 가져오기
        $code = $request->session()->get('code');
        $member = Member::where('code', $code)->first();
        
        // 회원 미존재시
        if (!$member) {
            return view('boards/error', ['error' => 'Member not found']);
        }

        $id = $member->id;
        $nickname = $member->nickname;
        $subject = $request->input('title');
        $content = $request->input('content');
        date_default_timezone_set('Asia/Seoul');
        $today = date("Y-m-d H:i:s");
        $view = 0;

        // 게시글 마지막 번호 조회
        $lastPost = Post::orderBy('number', 'desc')->first();
        $num = $lastPost ? $lastPost->number + 1 : 1; // 마지막 번호가 없으면 1로 시작

        // 파일 존재시
        if ($request->hasFile('file')) {
            $newFileName = now()->format('Y_m_d_H_i_s');

            // 파일 정보 가져오기
            $fileName = $request->file('file')->getClientOriginalName();
            $fileType = $request->file('file')->extension();
            $copiedFileName = $newFileName . '.' . $fileType;
            
            // 파일 저장
            $request->file('file')->storeAs('', $copiedFileName);
        } else {
            // 파일 미존재시 빈 값 설정
            $fileName = '';
            $fileType = '';
            $copiedFileName = '';
        }

        // 데이터 입력
        try {
            // Eloquent를 사용하여 게시물 생성
            Post::create([
                'number' => $num,
                'id' => $id,
                'nickname' => $nickname,
                'subject' => $subject,
                'content' => $content,
                'regist_day' => $today,
                'view' => $view,
                'file_name' => $fileName,
                'file_type' => $fileType,
                'file_copied' => $copiedFileName
            ]);

            return redirect()->route('board');
        } catch (Exception $e) {
            return view('boards.error', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     * 게시글 읽기 form 리턴
     */
    public function show(Board $board, Request $request, $postNum)
    {
        // 세션 유무 검사
        if($request->session()->has('code')){
            // 세션 존재시
            try{
                $id = $request->session()->get('id');
                $result = Post::where('number', $postNum)
                ->get(['subject', 'content', 'nickname', 'id', 'regist_day', 'view'])->first();

                if($id == $result->id){
                    $isOwnPost = 'true';
                }else{
                    $isOwnPost = '';
                }
            }catch(Exception $e){
                return view('boards/error', ['error' => $e->getMessage()]);
            }

            // DB에 데이터 존재시
            if($result == null){
                return redirect()->route('board');
            }else{
                $user = $result->nickname.' ('.substr($result->id, 0, 4).'****)';

                return view('boards/read_post', [
                    'number' => $postNum,
                    'title' => $result->subject,
                    'user' => $user,
                    'views' => $result->view,
                    'recommends' => 0,
                    'regist_day' => $result->regist_day,
                    'content' => $result->content,
                    'isOwnPost' => $isOwnPost
                ]);
            }
        }else{
            // 세션 미존재시
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * 게시글 수정 form 리턴
     */
    public function edit(Board $board, Request $request, $postNum)
    {
        // 세션 유무 검사
        if($request->session()->has('code')){
            // 세션 존재시
            try{
                $code = $request->session()->get('code');
                $result = Member::where('code', $code)
                ->get(['nickname', 'id'])
                ->first();
                $user = $result->nickname.' ('.substr($result->id, 0, 4).'****)';

                $result = Post::where('number', $postNum)
                ->get(['subject', 'content'])
                ->first();
                
                return view('boards/update_post', [
                    "number" => $postNum,
                    "title" => $result->subject,
                    "content" => $result->content,
                    "user" => $user
                ]);
            }
            catch(Exception $e){
                return view('boards/error', ["error" => $e->getMessage()]);
            }
        }else{
            // 세션 미존재시
            return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     * 게시글 수정
     */
    public function update(Request $request, Board $board)
    {
        $postNum = $request->input('number');
        $subject = $request->input('title');
        $content = $request->input('content');
        date_default_timezone_set('Asia/Seoul');
        $today = date("Y-m-d H:i:s");
    
        // 트랜잭션 시작
        DB::beginTransaction();
        try {
            // 포스트 조회
            $post = Post::find($postNum);
            $file = $post->file_copied;  // 기존 파일 이름
    
            // 요청 파일 존재시
            if ($request->hasFile('file')) {
                $newFileName = now()->format('Y_m_d_H_i_s');
    
                // 파일 처리
                $fileName = $request->file('file')->getClientOriginalName();
                $fileType = $request->file('file')->extension();
                $copiedFileName = $newFileName . '.' . $fileType;
                $request->file('file')->storeAs('', $copiedFileName); // 스토리지에 파일 저장
    
                // 데이터 업데이트
                $post->update([
                    'subject' => $subject,
                    'content' => $content,
                    'regist_day' => $today,
                    'file_name' => $fileName,
                    'file_type' => $fileType,
                    'file_copied' => $copiedFileName,
                ]);
    
                // 기존 파일 삭제
                if ($file != '') {
                    $filePath = storage_path('app/private/' . $file);
                    if (is_file($filePath) && file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            } else {
                // 파일이 없는 경우
                if ($file == '') {
                    // 파일이 없는 경우 그냥 업데이트
                    $post->update([
                        'subject' => $subject,
                        'content' => $content,
                        'regist_day' => $today,
                    ]);
                } else {
                    // 기존 파일 비우고 업데이트
                    $post->update([
                        'subject' => $subject,
                        'content' => $content,
                        'regist_day' => $today,
                        'file_name' => '',
                        'file_type' => '',
                        'file_copied' => '',
                    ]);
    
                    // 기존 파일 삭제
                    $filePath = storage_path('app/private/' . $file);
                    if (is_file($filePath) && file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }
    
            // 트랜잭션 커밋
            DB::commit();
    
            // 리디렉션
            return redirect("/post/read/{$postNum}");
    
        } catch (Exception $e) {
            // 트랜잭션 롤백
            DB::rollBack();
            return view('boards.error', ["error" => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * 게시글 삭제
     */
    public function destroy(Board $board, Request $request)
    {
        $postNum = $request->input('number');
        $lastPost = Post::orderBy('number', 'desc')->first();  // 가장 최근의 게시물 가져오기
        $post = Post::find($postNum);  // 삭제할 게시물 조회
    
        if ($lastPost !== null && $post !== null) {
            // 게시물 존재시
            $lastNum = $lastPost->number;
    
            // 트랜잭션 시작
            DB::beginTransaction();
            try {
                // 데이터(게시물) 삭제
                $post->delete();
    
                // 이후 번호를 가진 게시물들 번호 앞당기기
                if ($postNum < $lastNum) {
                    Post::where('number', '>', $postNum)
                    ->decrement('number'); // number값 1씩 감소
                }
    
                // 파일 존재시 함께 삭제
                if ($post->file_copied != '') {
                    $filePath = storage_path('app/private/' . $post->file_copied);
                    if (is_file($filePath) && file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
    
                // 트랜잭션 커밋
                DB::commit();
    
                return response()->json(["message" => true]);
    
            } catch (Exception $e) {
                // 트랜잭션 롤백
                DB::rollBack();
                return response()->json(["message" => false, "error" => $e->getMessage()]);
            }
        }
    
        return response()->json(["message" => false, "error" => "Post not found"]);
    }
}
