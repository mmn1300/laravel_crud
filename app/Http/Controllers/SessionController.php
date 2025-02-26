<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use Exception;


class SessionController extends Controller
{
    public function getUserInfo(Request $request) {
        // 세션 검사
        if($request->session()->has('code')){
            // 결과 JSON 응답 (접속된 사용자 정보)
            $code = $request->session()->get('code');
            try {
                $result = Member::where('code', $code)
                ->get(['id', 'nickname'])
                ->first();
                $id = $result->id;
                $nickname = $result->nickname;
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
