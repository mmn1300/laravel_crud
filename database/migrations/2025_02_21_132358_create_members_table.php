<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 회원 정보를 저장할 테이블
        Schema::create('members', function (Blueprint $table) {
            $table->integer('code')->primary();
            $table->string('id', 15)->unique();
            $table->string('password', 15);
            $table->string('nickname', 10);
            $table->string('email', 80)->nullable();
            $table->string('phone_number', 13)->nullable()->unique();
            $table->timestamp('regist_day');
            $table->integer('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};