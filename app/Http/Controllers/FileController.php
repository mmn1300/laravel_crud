<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Exception;


class FileController extends Controller
{
    public function fileExists($postNum) {
        try{
            $result = Post::where('number', $postNum)
            ->get(['file_name'])
            ->first();
            return response()->json(["message" => true, "fileName" => $result->file_name]);
        }
        catch(Exception $e){
            return response()->json(["message" => false, "error" => $e->getMessage()]);
        }
    }


    public function download($postNum) {
        try{
            $result = Post::where('number', $postNum)
            ->get(['file_name', 'file_copied'])
            ->first();

            $fileName = $result->file_name;
            $copoedFileName = $result->file_copied;
            $filePath = storage_path('app\\private\\'.$copoedFileName); // 절대 경로
        
            if($fileName != ''){
                // 파일 존재시
                if(is_file($filePath) && file_exists($filePath)){
                    return response()->download($filePath, $fileName);
                }
            }
        }
        catch(Exception $e){
            return view('boards/error', ["error" => $e->getMessage()]);
        }
    }
}
