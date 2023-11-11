<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFromRequest;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // return view
    public function show_login()
    {
        return view('login.login_form');
    }

    //request
    //  App\Http\Requests\LoginFromRequest;
    public function login(LoginFromRequest $request)
    {
        // ここでバリデーションする
        // $credentials = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);

        // onlyを使ってバリデーションの緩い版
        // $credentials = $request->only('email','password');

        // 別ページにバリデーション書いている場合
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();
        if (!is_null($user)) {
            if ($user->locked_flg === 1) {

                return back()->withErrors([
                    'login_error' => 'アカウントがロックされています。',
                ]);
            }

            // attrmptが認証関連全てやってる
            // vendor/lalavel/src/Auth/SessionGurrd->attemptが何してるか書いてある
            // vendor/lalavel/src/Auth/EloquentUserProvider->↑確認したらこれも出てくる
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                if ($user->error_count > 0) {
                    $user->error_count = 0;
                    $user->save();
                }


                return redirect()->route('home')->with('login_success', 'ログインが成功しました');
            }

            $user->error_count =  $user->error_count + 1;

            if ($user->error_count > 5) {
                $user->locked_flg = 1;
                $user->save();
                return back()->withErrors([
                    'login_error' => '不正アクセスの可能性があります。あなたのアカウントはロックされました。運営までお問い合わせください。（03-xxxxxxxx）',
                ]);
            }
            $user->save();
        }

        return back()->withErrors([
            'login_error' => 'メールアドレスかパスワードが違います。',
        ]);
    }


    /**
     * ユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('show_login');
    }
}
