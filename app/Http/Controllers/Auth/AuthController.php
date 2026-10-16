<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * نمایش فرم ثبت‌نام
     */
    public function showRegister(Request $request)
    {
        return view('auth.register', [
            'locale' => $this->getLocale($request),
        ]);
    }

    /**
     * ثبت‌نام کاربر جدید
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[\p{L}\p{N}\_.-]+$/u',
                Rule::unique('users', 'name'),
            ],

            'password' => [
                'required',
                'string',
                Password::min(8),
            ],
        ], [
            'name.required' => 'وارد کردن نام کاربری الزامی است.',
            'name.string' => 'نام کاربری باید به‌صورت متن باشد.',
            'name.min' => 'نام کاربری باید حداقل ۳ کاراکتر باشد.',
            'name.max' => 'نام کاربری نباید بیشتر از ۱۰۰ کاراکتر باشد.',
            'name.regex' => 'نام کاربری فقط می‌تواند شامل حروف، اعداد و علامت‌های نقطه، زیرخط و خط تیره باشد.',
            'name.unique' => 'این نام کاربری قبلاً ثبت شده است.',

            'password.required' => 'وارد کردن رمز عبور الزامی است.',
            'password.string' => 'رمز عبور باید به‌صورت متن باشد.',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
        ]);

        // ایجاد کاربر جدید
        $user = User::create([
            'name' => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        // ورود خودکار کاربر پس از ثبت‌نام
        Auth::login($user);

        // بازسازی شناسه نشست
        $request->session()->regenerate();

        // تعیین زبان فعلی
        $locale = $this->getLocale($request);

        // انتقال به صفحه اصلی با حفظ زبان
        return redirect()->route('home', [
            'locale' => $locale,
        ])->with('success', 'ثبت‌نام شما با موفقیت انجام شد.');
    }

    /**
     * نمایش فرم ورود
     */
    public function showLogin(Request $request)
    {
        return view('auth.login', [
            'locale' => $this->getLocale($request),
        ]);
    }

    /**
     * ورود کاربر
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
            ],
        ], [
            'name.required' => 'نام کاربری را وارد کنید.',
            'name.string' => 'نام کاربری باید به‌صورت متن باشد.',

            'password.required' => 'رمز عبور را وارد کنید.',
            'password.string' => 'رمز عبور باید به‌صورت متن باشد.',
        ]);

        // تلاش برای ورود کاربر
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            // بازسازی شناسه نشست
            $request->session()->regenerate();

            // حفظ زبان فعلی سایت
            $locale = $this->getLocale($request);

            // انتقال به صفحه اصلی
            return redirect()->route('home', [
                'locale' => $locale,
            ])->with('success', 'با موفقیت وارد حساب کاربری شدید.');
        }

        // اطلاعات ورود نامعتبر است
        return back()
            ->withErrors([
                'name' => 'نام کاربری یا رمز عبور صحیح نیست.',
            ])
            ->onlyInput('name');
    }

    /**
     * خروج کاربر
     */
    public function logout(Request $request)
    {
        // خروج از حساب کاربری
        Auth::logout();

        // باطل کردن نشست قبلی
        $request->session()->invalidate();

        // تولید مجدد توکن CSRF
        $request->session()->regenerateToken();

        // تعیین زبان فعلی
        $locale = $this->getLocale($request);

        // انتقال به صفحه اصلی با حفظ زبان
        return redirect()->route('home', [
            'locale' => $locale,
        ])->with('success', 'از حساب کاربری خارج شدید.');
    }

    /**
     * دریافت زبان فعلی سایت
     */
    private function getLocale(Request $request): string
    {
        $locale = $request->route('locale')
            ?? app()->getLocale();

        // فقط زبان‌های پشتیبانی‌شده مجاز هستند
        if (! in_array($locale, ['fa', 'en', 'ar'], true)) {
            return 'fa';
        }

        return $locale;
    }
}
