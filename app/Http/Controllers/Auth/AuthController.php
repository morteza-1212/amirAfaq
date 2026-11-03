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

            'full_name' => [
                'required',
                'string',
                'min:3',
                'max:150',
            ],

            'phone' => [
                'nullable',
                'string',
                'regex:/^09\d{9}$/',          // شماره موبایل ایران: 09xxxxxxxxx
                Rule::unique('users', 'phone'),
            ],

            'email' => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('users', 'email'),
            ],

            'password' => [
                'required',
                'string',
                Password::min(8),
                'confirmed',                   // نیاز به فیلد password_confirmation
            ],
        ], [
            'name.required' => 'وارد کردن نام کاربری الزامی است.',
            'name.string' => 'نام کاربری باید به‌صورت متن باشد.',
            'name.min' => 'نام کاربری باید حداقل ۳ کاراکتر باشد.',
            'name.max' => 'نام کاربری نباید بیشتر از ۱۰۰ کاراکتر باشد.',
            'name.regex' => 'نام کاربری فقط می‌تواند شامل حروف، اعداد و علامت‌های نقطه، زیرخط و خط تیره باشد.',
            'name.unique' => 'این نام کاربری قبلاً ثبت شده است.',

            'full_name.required' => 'وارد کردن نام و نام خانوادگی الزامی است.',
            'full_name.string' => 'نام و نام خانوادگی باید به‌صورت متن باشد.',
            'full_name.min' => 'نام و نام خانوادگی باید حداقل ۳ کاراکتر باشد.',
            'full_name.max' => 'نام و نام خانوادگی نباید بیشتر از ۱۵۰ کاراکتر باشد.',

            'phone.required' => 'وارد کردن شماره موبایل الزامی است.',
            'phone.string' => 'شماره موبایل باید به‌صورت متن باشد.',
            'phone.regex' => 'شماره موبایل باید با ۰۹ شروع شده و ۱۱ رقم باشد.',
            'phone.unique' => 'این شماره موبایل قبلاً ثبت شده است.',

            'email.email' => 'فرمت ایمیل صحیح نیست.',
            'email.max' => 'ایمیل نباید بیشتر از ۱۵۰ کاراکتر باشد.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'password.required' => 'وارد کردن رمز عبور الزامی است.',
            'password.string' => 'رمز عبور باید به‌صورت متن باشد.',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
            'password.confirmed' => 'تکرار رمز عبور با رمز عبور مطابقت ندارد.',
        ]);

        // ایجاد کاربر جدید — همه ستون‌های NOT NULL پر می‌شوند
        $user = User::create([
            'name' => $validated['name'],
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
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
