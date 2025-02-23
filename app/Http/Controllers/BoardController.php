<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class BoardController extends Controller
{
    public function loadPosts($page) {
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
    }


    public function writePost(Request $request) {
        $code = $request->session()->get('code');
        $result = DB::select("SELECT id, nickname FROM members WHERE code=$code");
        $id = $result[0]->id;
        $nickname = $result[0]->nickname;
        $subject = $_POST['title'];
        $content = $_POST['content'];
        $today = date("Y-m-d H:i:s");
        $view = 0;
    
        $num = DB::select("SELECT number FROM posts ORDER BY number desc LIMIT 1");
        if($num == null){
            $num = 1;
        }else{
            $num = $num[0]->number + 1;
        }
    
        if($request->hasFile('file')){
            $newFileName = date("Y_m_d_H_i_s");
        
            // // /storage/app/private
            $fileName = $request->file->getClientOriginalName();
            $fileType = $request->file->extension();
            $copiedFileName = $newFileName.'.'.$fileType;
            $request->file->storeAs('', $copiedFileName);
        }else{
            $fileName = '';
            $fileType = '';
            $copiedFileName = '';
        }
        try{
            DB::insert("INSERT INTO posts VALUES (
                $num, '$id', '$nickname', '$subject', '$content', '$today', $view, '$fileName', '$fileType', '$copiedFileName'
                )");
            return redirect()->route('board');
        }catch(Exception $e){
            return view('boards/error', ['error' => $e->getMessage()]);
        }
    }


    public function readPost(Request $request, $num) {
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
                    'user' => $result[0]->nickname.' ('.substr($result[0]->id, 0, 4).'****)',
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
    }


    public function updatePost(Request $request) {
        $postNum = $request->input('number');
        $subject = $request->input('title');
        $content = $request->input('content');
        $today = date("Y-m-d H:i:s");
        
        try{
            if($request->hasFile('file')){
                $newFileName = date("Y_m_d_H_i_s");
            
                // /storage/app/private
                $fileName = $request->file->getClientOriginalName();
                $fileType = $request->file->extension();
                $copiedFileName = $newFileName.'.'.$fileType;
                $request->file->storeAs('', $copiedFileName);
                DB::update("UPDATE posts SET subject='$subject', content='$content', regist_day='$today',
                                    file_name='$fileName', file_type='$fileType', file_copied='$copiedFileName'
                                    WHERE number=$postNum");
            }else{
                DB::update("UPDATE posts SET subject='$subject', content='$content', regist_day='$today' WHERE number=$postNum");
            }
            return redirect('/post/read/'.$postNum);
        }catch(Exception $e){
            return view('boards/error', ["error" => $e->getMessage()]);
        }
    }


    public function deletePost(Request $request) {
        $postNum = $request->input('number');
        $lastNum = DB::select("SELECT number, file_copied FROM posts ORDER BY number DESC LIMIT 1");
        $result = DB::select("SELECT file_copied FROM posts WHERE number=$postNum");
    
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
    
                $copoedFileName = $result[0]->file_copied;
                if($copoedFileName != ''){
                    $filePath = storage_path('app\\private\\'.$copoedFileName);
                    if(is_file($filePath) && file_exists($filePath)){
                        unlink($filePath);
                    }
                }
                DB::commit();
    
            }catch(Exception $e){
                DB::rollBack();
                return response()->json(["message" => false, "error" => $e->getMessage()]);
            }
        }
        return response()->json(["message" => true]);
    }
}
