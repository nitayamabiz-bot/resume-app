<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // カラムが既に存在するかチェック
        if (Schema::hasColumn('resumes', 'address_kana')) {
            return;
        }
        
        Schema::table('resumes', function (Blueprint $table) {
            $table->string('address_kana')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('resumes', 'address_kana')) {
            Schema::table('resumes', function (Blueprint $table) {
                $table->dropColumn('address_kana');
            });
        }
    }
};
