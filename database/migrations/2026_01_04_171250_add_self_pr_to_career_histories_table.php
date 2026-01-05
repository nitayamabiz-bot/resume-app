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
        Schema::table('career_histories', function (Blueprint $table) {
            $table->text('self_pr')->nullable()->after('job_summary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_histories', function (Blueprint $table) {
            $table->dropColumn('self_pr');
        });
    }
};
