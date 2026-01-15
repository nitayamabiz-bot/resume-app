<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('allows authenticated users to upload and update profile photo from resume form', function (): void {
    Storage::fake('public');

    $user = User::factory()->create();

    $file = UploadedFile::fake()->image('photo.jpg', 600, 800);

    $payload = [
        'first_name_roman' => 'TARO',
        'last_name_roman' => 'YAMADA',
        'first_name_kana' => 'たろう',
        'last_name_kana' => 'やまだ',
        'birthday' => '1990-01-01',
        'gender' => '男',
        'phone' => '09012345678',
        'email' => 'test@example.com',
        'postal_code' => '1234567',
        'address' => '東京都渋谷区1-2-3',
        'address_kana' => 'とうきょうとしぶやく1-2-3',
        'school_name' => ['テスト高校'],
        'school_event_type' => ['入学'],
        'school_date' => ['2005-04'],
        'company_name' => ['テスト株式会社'],
        'job_event_type' => ['入社'],
        'job_date' => ['2015-04'],
        'license_name' => [],
        'license_event_type' => [],
        'license_date' => [],
    ];

    $response = actingAs($user)
        ->post(route('resume.confirm'), array_merge($payload, [
            'profile_photo' => $file,
        ]));

    $response->assertStatus(302);

    $user->refresh();

    expect($user->profile_photo_path)->not()->toBeNull();
    Storage::disk('public')->assertExists($user->profile_photo_path);

    $oldPath = $user->profile_photo_path;

    $newFile = UploadedFile::fake()->image('new_photo.png', 800, 600);

    $response = actingAs($user)
        ->post(route('resume.confirm'), array_merge($payload, [
            'profile_photo' => $newFile,
        ]));

    $response->assertStatus(302);

    $user->refresh();

    expect($user->profile_photo_path)->not()->toBe($oldPath);
    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($user->profile_photo_path);
});

it('does not require profile photo and works for guests without image', function (): void {
    $payload = [
        'first_name_roman' => 'TARO',
        'last_name_roman' => 'YAMADA',
        'first_name_kana' => 'たろう',
        'last_name_kana' => 'やまだ',
        'birthday' => '1990-01-01',
        'gender' => '男',
        'phone' => '09012345678',
        'email' => 'test@example.com',
        'postal_code' => '1234567',
        'address' => '東京都渋谷区1-2-3',
        'address_kana' => 'とうきょうとしぶやく1-2-3',
        'school_name' => ['テスト高校'],
        'school_event_type' => ['入学'],
        'school_date' => ['2005-04'],
        'company_name' => ['テスト株式会社'],
        'job_event_type' => ['入社'],
        'job_date' => ['2015-04'],
        'license_name' => [],
        'license_event_type' => [],
        'license_date' => [],
    ];

    $response = post(route('resume.confirm'), $payload);

    $response->assertStatus(302);
});
