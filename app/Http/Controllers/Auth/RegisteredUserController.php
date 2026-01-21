<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\RecaptchaHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'recaptcha_site_key' => config('recaptcha.site_key'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => ['required', 'string'],
        ]);

        // reCAPTCHA検証
        if (! RecaptchaHelper::verify($request->input('g-recaptcha-response'))) {
            return redirect()->back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['g-recaptcha-response' => 'セキュリティチェックの検証に失敗しました。再度お試しください。 / सुरक्षा जाँच प्रमाणीकरण असफल भयो। कृपया पुन: प्रयास गर्नुहोस्।']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // セッションに履歴書データがある場合は保存
        if (session('pending_resume')) {
            $resumeController = new \App\Http\Controllers\ResumeController();
            return $resumeController->saveResume();
        }

        return redirect(route('home', absolute: false));
    }
}
