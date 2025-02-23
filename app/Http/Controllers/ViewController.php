<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ViewController extends Controller
{
    public function index() {
        return view('boards/index');
    }

    public function login() {
        return view('boards/login_form');
    }

    public function signup() {
        return view('boards/create_account');
    }

    public function board(Request $request) {
        // 세션 유무 검사
        if($request->session()->has('code')){
            // 세션 존재시
            return view('boards/posts_list');
        }else{
            // 세션 미존재시
            return redirect()->route('login');
        }
    }

    public function writePost(Request $request) {
        // 세션 유무 검사
        if($request->session()->has('code')){
            // 세션 존재시
            try{
                $code = $request->session()->get('code');
                $result = DB::select("SELECT nickname, id FROM members WHERE code=$code");
                return view('boards/write_post', [
                    'user' => $result[0]->nickname.' ('.substr($result[0]->id, 0, 4).'****)',
                ]);
            }catch(Exception $e){
                return view('boards/error', ["error" => $e->getMessage()]);
            }
        }else{
            // 세션 미존재시
            return redirect()->route('login');
        }
    }

    public function readPost(Request $request) {
        // 세션 유무 검사
        if($request->session()->has('code')){
            // 세션 존재시
            return view('boards/read_post');
        }else{
            // 세션 미존재시
            return redirect()->route('login');
        }
    }

    public function updatePost(Request $request, $postNum) {
        // 세션 유무 검사
        if($request->session()->has('code')){
            // 세션 존재시
            try{
                $code = $request->session()->get('code');
                $result = DB::select("SELECT nickname, id FROM members WHERE code=$code");
                $user = $result[0]->nickname.' ('.substr($result[0]->id, 0, 4).'****)';
                $result = DB::select("SELECT subject, content FROM posts WHERE number=$postNum");
                return view('boards/update_post', [
                    "number" => $postNum,
                    "title" => $result[0]->subject,
                    "content" => $result[0]->content,
                    "user" => $user
                ]);
            }catch(Exception $e){
                return view('boards/error', ["error" => $e->getMessage()]);
            }
        }else{
            // 세션 미존재시
            return redirect()->route('login');
        }
    }
}
