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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name_roman')->nullable();
            $table->string('name_kana')->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('address')->nullable();
            $table->text('education')->nullable(); // JSON形式で学歴を保存
            $table->text('work_history')->nullable(); // JSON形式で職歴を保存
            $table->text('licenses')->nullable(); // JSON形式で免許・資格を保存
            $table->text('appeal_points')->nullable();
            $table->text('self_request')->nullable();
            $table->string('photo_path')->nullable();
            $table->enum('status', ['draft', 'completed'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
