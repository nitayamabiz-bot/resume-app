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
        Schema::table('resumes', function (Blueprint $table) {
            // 既存のデータを一時的に保持するため、新しいカラムを追加
            $table->string('first_name_roman')->nullable()->after('name_roman');
            $table->string('last_name_roman')->nullable()->after('first_name_roman');
            $table->string('first_name_kana')->nullable()->after('name_kana');
            $table->string('last_name_kana')->nullable()->after('first_name_kana');
        });

        // 既存データの移行（name_romanとname_kanaを姓名に分割）
        // スペースで分割、ない場合は全体をlast_nameとする
        DB::table('resumes')->get()->each(function ($resume) {
            $nameRoman = $resume->name_roman ?? '';
            $nameKana = $resume->name_kana ?? '';
            
            // スペースで分割を試みる
            $romanParts = explode(' ', $nameRoman, 2);
            $kanaParts = explode(' ', $nameKana, 2);
            
            $lastNameRoman = $romanParts[0] ?? '';
            $firstNameRoman = $romanParts[1] ?? '';
            
            $lastNameKana = $kanaParts[0] ?? '';
            $firstNameKana = $kanaParts[1] ?? '';
            
            // 分割できない場合は全体をlast_nameとする
            if (empty($firstNameRoman) && !empty($nameRoman)) {
                $lastNameRoman = $nameRoman;
                $firstNameRoman = '';
            }
            if (empty($firstNameKana) && !empty($nameKana)) {
                $lastNameKana = $nameKana;
                $firstNameKana = '';
            }
            
            DB::table('resumes')
                ->where('id', $resume->id)
                ->update([
                    'first_name_roman' => $firstNameRoman,
                    'last_name_roman' => $lastNameRoman,
                    'first_name_kana' => $firstNameKana,
                    'last_name_kana' => $lastNameKana,
                ]);
        });

        // 古いカラムを削除
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn(['name_roman', 'name_kana']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->string('name_roman')->nullable();
            $table->string('name_kana')->nullable();
        });

        // データを統合して戻す
        DB::table('resumes')->get()->each(function ($resume) {
            $nameRoman = trim(($resume->first_name_roman ?? '') . ' ' . ($resume->last_name_roman ?? ''));
            $nameKana = trim(($resume->first_name_kana ?? '') . ' ' . ($resume->last_name_kana ?? ''));
            
            DB::table('resumes')
                ->where('id', $resume->id)
                ->update([
                    'name_roman' => $nameRoman,
                    'name_kana' => $nameKana,
                ]);
        });

        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn(['first_name_roman', 'last_name_roman', 'first_name_kana', 'last_name_kana']);
        });
    }
};
