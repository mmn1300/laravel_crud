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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            /* 이 안에 테이블 열 추가
            $table->열_형태(열_이름);

            */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void // DB 삭제
    {
        Schema::dropIfExists('boards');
    }
};
