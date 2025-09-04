<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
    use Laravel\Fortify\Contracts\LoginResponse;
    use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
    use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Route;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
        public function toResponse($request)
        {
            return redirect('/login');
        }
        });

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                $user = $request->user();
                if ($user && is_null($user->email_verified_at)) {
                    // 未認証ユーザーはメール認証ページへ
                    return redirect()->route('verification.notice')
                        ->with('message', 'メール認証が必要です。メールを確認してください。');
                }
                // 認証済みユーザーはホーム画面へ
                return redirect('/');
            }
        });

        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                 // 登録直後フラグをセッションにセット
                session(['just_registered' => true]);
                return redirect()->route('verification.notice')
                        ->with('status', '登録ありがとうございます。メール認証を完了してください。');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $request =\App::make(LoginRequest::class);
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });
    }
}
