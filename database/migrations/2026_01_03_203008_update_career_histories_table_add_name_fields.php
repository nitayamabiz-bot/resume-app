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
        Schema::table('career_histories', function (Blueprint $table) {
            // 既存のnameカラムから姓と名を抽出するため、まず新しいカラムを追加（既に存在する場合はスキップ）
            if (! Schema::hasColumn('career_histories', 'last_name_roman')) {
                $table->string('last_name_roman')->nullable()->after('user_id');
            }
            if (! Schema::hasColumn('career_histories', 'first_name_roman')) {
                $table->string('first_name_roman')->nullable()->after('last_name_roman');
            }
        });

        // 既存データの移行（nameフィールドがある場合、最初の単語を姓、残りを名とする）
        DB::table('career_histories')->whereNotNull('name')->orderBy('id')->each(function ($record) {
            $nameParts = explode(' ', $record->name, 2);
            $lastName = $nameParts[0] ?? '';
            $firstName = $nameParts[1] ?? '';
            
            DB::table('career_histories')
                ->where('id', $record->id)
                ->update([
                    'last_name_roman' => $lastName,
                    'first_name_roman' => $firstName,
                ]);
        });

        // 既存のnameカラムを削除（存在する場合のみ）
        if (Schema::hasColumn('career_histories', 'name')) {
            Schema::table('career_histories', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('career_histories', 'name')) {
                $table->string('name')->nullable()->after('user_id');
            }
        });

        // 姓と名を結合してnameに戻す
        DB::table('career_histories')->orderBy('id')->each(function ($record) {
            $name = trim(($record->last_name_roman ?? '').' '.($record->first_name_roman ?? ''));
            
            DB::table('career_histories')
                ->where('id', $record->id)
                ->update(['name' => $name ?: null]);
        });

        Schema::table('career_histories', function (Blueprint $table) {
            if (Schema::hasColumn('career_histories', 'last_name_roman')) {
                $table->dropColumn('last_name_roman');
            }
            if (Schema::hasColumn('career_histories', 'first_name_roman')) {
                $table->dropColumn('first_name_roman');
            }
        });
    }
};
