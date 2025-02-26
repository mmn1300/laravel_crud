<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Exception;


class BoardController extends Controller
{
    public function loadPosts($page) {
        $maxPage = 16;
        $start = (($page - 1) * $maxPage) + 1;
        $end = $page * $maxPage;

        try{
            $result = Post::whereBetween('number', [$start, $end])
            ->get(['number', 'subject', 'nickname', 'id', 'regist_day']);
        }
        catch(Exception $e){
            return response()->json(["message" => false, "error" => $e->getMessage()]);
        }

        if($result == null){
            // 데이터가 없을 시
            return response()->json(["message" => true, "rows" => 0]);
        }else{
            // 데이터를 연관배열 형태로 변환
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

    // 아래 함수 BoardsController로 이동함
    // write() -> store()

    // public function writePost(Request $request) {
    //     $code = $request->session()->get('code');
    //     $result = DB::select("SELECT id, nickname FROM members WHERE code=$code");
    //     $id = $result[0]->id;
    //     $nickname = $result[0]->nickname;
    //     $subject = $_POST['title'];
    //     $content = $_POST['content'];
    //     date_default_timezone_set('Asia/Seoul');
    //     $today = date("Y-m-d H:i:s");
    //     $view = 0;
    
    //     // 게시글 마지막 번호 조회
    //     $num = DB::select("SELECT number FROM posts ORDER BY number desc LIMIT 1");
    //     if($num == null){
    //         $num = 1;
    //     }else{
    //         $num = $num[0]->number + 1;
    //     }
    
    //     // 파일 존재시
    //     if($request->hasFile('file')){
    //         $newFileName = date("Y_m_d_H_i_s");
        
    //         // /storage/app/private
    //         $fileName = $request->file->getClientOriginalName();
    //         $fileType = $request->file->extension();
    //         $copiedFileName = $newFileName.'.'.$fileType;
    //         $request->file->storeAs('', $copiedFileName);
    //     }
    //     // 파일 미존재시
    //     else{
    //         $fileName = '';
    //         $fileType = '';
    //         $copiedFileName = '';
    //     }

    //     // 데이터 입력
    //     try{
    //         DB::insert("INSERT INTO posts VALUES (
    //             $num, '$id', '$nickname', '$subject', '$content', '$today', $view, '$fileName', '$fileType', '$copiedFileName'
    //             )");
    //         return redirect()->route('board');
    //     }catch(Exception $e){
    //         return view('boards/error', ['error' => $e->getMessage()]);
    //     }
    // }


    // 아래 함수 BoardsController로 이동함
    // readPost() -> show()

    // public function readPost(Request $request, $postNum) {
    //     // 세션 유무 검사
    //     if($request->session()->has('code')){
    //         // 세션 존재시
    //         try{
    //             $id = $request->session()->get('id');
    //             $result = DB::select("SELECT subject, content, nickname, id, regist_day, view FROM posts WHERE number=$postNum");
    //             if($id == $result[0]->id){
    //                 $isOwnPost = 'true';
    //             }else{
    //                 $isOwnPost = '';
    //             }
    //         }catch(Exception $e){
    //             return view('boards/error', ['error' => $e->getMessage()]);
    //         }

    //         // DB에 데이터 존재시
    //         if($result == null){
    //             return redirect()->route('board');
    //         }else{
    //             $user = $result[0]->nickname.' ('.substr($result[0]->id, 0, 4).'****)';
    //             return view('boards/read_post', [
    //                 'number' => $postNum,
    //                 'title' => $result[0]->subject,
    //                 'user' => $user,
    //                 'views' => $result[0]->view,
    //                 'recommends' => 0,
    //                 'regist_day' => $result[0]->regist_day,
    //                 'content' => $result[0]->content,
    //                 'isOwnPost' => $isOwnPost
    //             ]);
    //         }
    //     }else{
    //         // 세션 미존재시
    //         return redirect()->route('login');
    //     }
    // }


    // 아래 함수 BoardsController로 이동함
    // updatePost() -> update()

    // public function updatePost(Request $request) {
    //     $postNum = $request->input('number');
    //     $subject = $request->input('title');
    //     $content = $request->input('content');
    //     date_default_timezone_set('Asia/Seoul');
    //     $today = date("Y-m-d H:i:s");
        
    //     // 트랜잭션 시작
    //     DB::beginTransaction();
    //     try{
    //         $file = DB::select("SELECT file_copied FROM posts WHERE number=$postNum")[0]->file_name;

    //         // 요청 파일 존재시
    //         if($request->hasFile('file')){
    //             $newFileName = date("Y_m_d_H_i_s");

    //             // /storage/app/private 에 저장됨
    //             $fileName = $request->file->getClientOriginalName();
    //             $fileType = $request->file->extension();
    //             $copiedFileName = $newFileName.'.'.$fileType;
    //             $request->file->storeAs('', $copiedFileName);
    //             DB::update("UPDATE posts SET
    //                                 subject='$subject', content='$content', regist_day='$today',
    //                                 file_name='$fileName', file_type='$fileType', file_copied='$copiedFileName'
    //                                 WHERE number=$postNum");

    //             if($file != ''){
    //                 // 기존 파일 존재시 삭제
    //                 $filePath = storage_path('app\\private\\'.$file);
    //                 if(is_file($filePath) && file_exists($filePath)){
    //                     unlink($filePath);
    //                 }
    //             }
    //         }

    //         // 요청 파일 미존재시
    //         else{
    //             if($file == ''){
    //                 DB::update("UPDATE posts SET subject='$subject', content='$content', regist_day='$today' WHERE number=$postNum");
    //             }else{
    //                 // 기존 파일 존재시 삭제
    //                 DB::update("UPDATE posts SET
    //                     subject='$subject', content='$content', regist_day='$today',
    //                     file_name='', file_type='', file_copied=''
    //                     WHERE number=$postNum");
    //                 $filePath = storage_path('app\\private\\'.$file);
    //                 if(is_file($filePath) && file_exists($filePath)){
    //                     unlink($filePath);
    //                 }
    //             }
    //         }

    //         DB::commit();
    //         return redirect('/post/read/'.$postNum);

    //     }catch(Exception $e){
    //         DB::rollBack();
    //         return view('boards/error', ["error" => $e->getMessage()]);
    //     }
    // }


    // 아래 함수 BoardsController로 이동함
    // deletePost() -> destory()

    // public function deletePost(Request $request) {
    //     $postNum = $request->input('number');
    //     $lastNum = DB::select("SELECT number, file_copied FROM posts ORDER BY number DESC LIMIT 1");
    //     $result = DB::select("SELECT file_copied FROM posts WHERE number=$postNum");
    
    //     if($lastNum != null){
    //         // 게시물 존재시
    //         $lastNum = $lastNum[0]->number;

    //         // 트랜잭션 시작
    //         DB::beginTransaction();
    //         try{

    //             // 데이터(게시물) 삭제
    //             DB::delete("DELETE FROM posts WHERE number=$postNum");

    //             // 이후 번호를 가진 게시물들 번호 앞당기기
    //             if($postNum<$lastNum){
    //                 for($i=$postNum+1; $i<=$lastNum; $i++){
    //                     DB::update("UPDATE posts SET number=$i-1 WHERE number=$i");
    //                 }
    //             }
    
    //             // 파일 존재시 함께 삭제
    //             $copoedFileName = $result[0]->file_copied;
    //             if($copoedFileName != ''){
    //                 $filePath = storage_path('app\\private\\'.$copoedFileName);
    //                 if(is_file($filePath) && file_exists($filePath)){
    //                     unlink($filePath);
    //                 }
    //             }

    //             DB::commit();
    
    //         }catch(Exception $e){
    //             DB::rollBack();
    //             return response()->json(["message" => false, "error" => $e->getMessage()]);
    //         }
    //     }
    //     return response()->json(["message" => true]);
    // }
}
