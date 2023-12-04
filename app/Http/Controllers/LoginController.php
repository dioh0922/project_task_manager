<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    // ログイン画面の表示
    public function index(){
        return view('auth.login',[
            'title' => 'ログイン',
            'check' => Auth::check()
        ]);
    }

    // ログイン処理
    public function login(Request $request){
        $validate = $this->validate($request, [
            'userID' => ['required'],
            'password' => ['required']
        ]);

        if(Auth::attemptWhen($validate, function(User $user){
            if($user !== null && $user->accept === 1){
                return true;
            }else{
                return false;
            }
        })){
            $request->session()->regenerate();
            return redirect('task');
        }else{
            return back()->withErrors([
                'userID' => 'ログイン情報が不正です',
            ])->onlyInput('userID');
        }

    }

    // ログアウト処理
    public function logout(){
        Auth::logout();
        return view('auth.logout_done',[
            'title' => 'ログアウト'
        ]);
    }

}
