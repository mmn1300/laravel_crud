<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class SessionController extends Controller
{
    public function getUserInfo(Request $request) {
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
    }
}
