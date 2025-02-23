<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;


class FileController extends Controller
{
    public function fileExists($postNum) {
        try{
            $result = DB::select("SELECT file_name FROM posts WHERE number=$postNum");
            return response()->json(["message" => true, "fileName" => $result[0]->file_name]);
        }catch(Exception $e){
            return response()->json(["message" => false, "error" => $e->getMessage()]);
        }
    }


    public function download($postNum) {
        try{
            $result = DB::select("SELECT file_name, file_copied FROM posts WHERE number=$postNum");
        
            $fileName = $result[0]->file_name;
            $copoedFileName = $result[0]->file_copied;
            $filePath = storage_path('app\\private\\'.$copoedFileName);
        
            if($fileName != ''){
                if(is_file($filePath) && file_exists($filePath)){
                    return response()->download($filePath, $fileName);
                }
            }
        }catch(Exception $e){
            return view('boards/error', ["error" => $e->getMessage()]);
        }
    }
}
