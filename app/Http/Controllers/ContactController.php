<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * お問い合わせフォームを表示
     */
    public function create(): View
    {
        $user = Auth::user();
        return view('contact.create', [
            'user' => $user,
        ]);
    }

    /**
     * お問い合わせフォームを送信
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'name' => $user ? 'nullable|string|max:255' : 'required|string|max:255',
            'email' => $user ? 'nullable|email|max:255' : 'required|email|max:255',
        ]);

        // ログインしている場合はユーザー情報を使用
        $name = $user ? $user->name : $validated['name'];
        $email = $user ? $user->email : $validated['email'];
        $userId = $user ? $user->id : null;

        // メール送信
        $this->sendEmail(
            $validated['title'],
            $validated['message'],
            $name,
            $email,
            $userId
        );

        return redirect()->route('contact.create')
            ->with('success', 'お問い合わせを受け付けました。ありがとうございます。');
    }

    /**
     * メール送信
     */
    private function sendEmail($title, $message, $name, $email, $userId)
    {
        try {
            \Log::info('お問い合わせメール送信開始', [
                'to' => 'info@hamro-life-japan.com',
                'email' => $email,
                'title' => $title,
            ]);
            
            Mail::to('info@hamro-life-japan.com')
                ->send(new ContactInquiry($title, $message, $name, $email, $userId));
            
            \Log::info('お問い合わせメール送信成功');
        } catch (\Exception $e) {
            // メール送信エラーはログに記録するが、処理は続行
            \Log::error('お問い合わせメール送信エラー', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'email' => $email,
                'title' => $title,
            ]);
        }
    }
}
