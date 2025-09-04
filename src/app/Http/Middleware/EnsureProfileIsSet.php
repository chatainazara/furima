<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileIsSet
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // ログイン済み かつ プロフィール未設定 の場合
        if ($user && !$user->profile) {
            // ただしプロフィール設定画面に行こうとしてるときは除外
            if (!$request->is('/mypage/profile')) {
                return redirect('/mypage/profile')
                                ->with('warning', 'プロフィールを設定してください。');
            }
        }

        return $next($request);
    }
}
