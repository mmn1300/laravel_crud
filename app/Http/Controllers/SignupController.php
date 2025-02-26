<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use Exception;

class SignupController extends Controller
{

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
            $code = Member::orderBy('code', 'desc')->first();
            if($code == null){
                $num = 1;
            }else{
                $num = $code->code + 1;
            }
            $id = $request->input('id');
            $pw = $request->input('pw');
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            date_default_timezone_set('Asia/Seoul');
            $today = date("Y-m-d H:i:s");
    
            // 데이터 삽입
            Member::insert([
                'code' => $num,
                'id' => $id,
                'password' => $pw,
                'nickname' => $name,
                'email' => $email,
                'phone_number' => $phone,
                'regist_day' => $today,
                'level' => 1
            ]);

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
