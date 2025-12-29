<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Mail\AdvertisementApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdvertisementController extends Controller
{
    /**
     * 広告募集フォームを表示
     */
    public function create(): View
    {
        return view('advertisement.create');
    }

    /**
     * 広告募集フォームを送信
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'representative_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'site_url' => 'required|url|max:500',
        ]);

        // データベースに保存
        $advertisement = Advertisement::create([
            'service_name' => $validated['service_name'],
            'representative_name' => $validated['representative_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'site_url' => $validated['site_url'],
            'ctime' => now(),
        ]);

        // メール送信
        $this->sendEmail($advertisement);

        return redirect()->route('advertisement.create')
            ->with('success', '広告募集の申請を受け付けました。ありがとうございます。');
    }

    /**
     * メール送信
     */
    private function sendEmail(Advertisement $advertisement)
    {
        try {
            Mail::to('nitayama.biz@gmail.com')
                ->send(new AdvertisementApplication($advertisement));
        } catch (\Exception $e) {
            // メール送信エラーはログに記録するが、処理は続行
            \Log::error('広告募集メール送信エラー: ' . $e->getMessage());
        }
    }
}
