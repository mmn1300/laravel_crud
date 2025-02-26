<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use Exception;

class LoginController extends Controller
{
    public function checkId(Request $request) {
        $id = $request->input('id');

        // DB 질의 (id가 DB에 존재하는지 검사)
        $result = Member::where('id', $id)->exists(); // 부울형 리턴

        // 결과 JSON 응답
        if($result){
            return response()->json(['message' => true]);
        }else{
            return response()->json(['message' => false]);
        }
    }

    public function checkAccount(Request $request) {
        // DB 질의 (id,pw 일치 검사)
        $id = $request->input('id');
        $pw = $request->input('pw');
        $result = Member::where('id', $id)
        ->where('password', $pw)
        ->exists();

        // 결과 JSON 응답
        if($result){
            return response()->json(['message' => true]);
        }else{
            return response()->json(['message' => false]);
        }
    }

    public function login(Request $request) {
        $id = $_POST['id'];
        try{
            // 세션 생성
            $code = Member::where('id', $id)
            ->get(['code'])
            ->first()
            ->code;
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
