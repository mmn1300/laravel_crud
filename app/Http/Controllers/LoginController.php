<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class LoginController extends Controller
{
    public function checkId(Request $request) {
        $id = $request->input('id');

        // DB 질의 (id가 DB에 존재하는지 검사)
        $result = DB::select("SELECT 1 FROM members WHERE id='$id'");

        // 결과 JSON 응답
        if($result == null){
            return response()->json(['message' => false]);
        }else{
            return response()->json(['message' => true]);
        }
    }

    public function checkAccount(Request $request) {
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
    }

    public function login(Request $request) {
        $id = $_POST['id'];
        try{
            // 세션 생성
            $code = DB::select("SELECT distinct code From members WHERE id='$id'")[0]->code;
            $request->session()->put('id', $id);
            $request->session()->put('code', $code);
        }
        catch(Exception $e){
            return redirect()->route('login');
        }
        return redirect()->route('board');
    }

    public function logout(Request $request) {
        try{
            // 세션 제거
            $request->session()->forget('id');
            $request->session()->forget('code');
        }
        catch(Exception $e){
            return response()->json(["message" => false, "error" => $e->getMessage()]);
        }
        return response()->json(["message" => true]);
    }
}
