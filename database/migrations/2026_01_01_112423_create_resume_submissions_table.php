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
        Schema::create('resume_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('first_name_roman', 25);
            $table->string('last_name_roman', 25);
            $table->string('first_name_kana', 25);
            $table->string('last_name_kana', 25);
            $table->date('birthday');
            $table->string('gender', 10);
            $table->string('phone', 20);
            $table->string('email', 255);
            $table->string('postal_code', 10);
            $table->string('address', 150);
            $table->string('address_kana', 200);
            $table->json('education')->nullable();
            $table->json('work_history')->nullable();
            $table->json('licenses')->nullable();
            $table->text('appeal_points')->nullable();
            $table->text('self_request')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('created_at');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_submissions');
    }
};
