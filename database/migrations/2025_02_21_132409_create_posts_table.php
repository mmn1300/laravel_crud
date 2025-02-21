<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void // DB 생성
    {
        // 게시글을 저장할 테이블
        Schema::create('posts', function (Blueprint $table) {
            /* 이 안에 테이블 열 추가
            $table->열_형태(열_이름);
            */
            $table->integer('number')->primary();
            $table->string('id', 15);
            $table->string('nickname', 10);
            $table->string('subject', 200);
            $table->text('content');
            $table->string('regist_day', 20);
            $table->integer('view');
            $table->string('file_name', 40)->nullable();
            $table->string('file_type', 40)->nullable();
            $table->string('file_copied', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void // DB 삭제
    {
        Schema::dropIfExists('posts');
    }
};