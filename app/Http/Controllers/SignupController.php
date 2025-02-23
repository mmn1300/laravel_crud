<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class SignupController extends Controller
{
    public function checkId(Request $request) {
        $id = $request->input('id');

        // DB 질의
        $result = DB::select("SELECT 1 FROM members WHERE id='$id'");

        // 결과 JSON 응답
        if($result == null){
            return response()->json(['message' => true]);
        }else{
            return response()->json(['message' => false]);
        }
    }

    public function signup(Request $request) {
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
    }
}
