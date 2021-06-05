<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\User;


class AuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function login(Request $request)
    {
        request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role_id == 1) {
                return redirect()->intended('superadmin');
            } elseif ($user->role_id == 2) {
                return redirect()->intended('admin');
            }
            return redirect('/')->intended('/');
        }
        
        return redirect('/')->withSuccess('Oppes! please check your input data');
    }
    public function logout(Request $request) {
        $request->session()->flush();
        Auth::logout();
        return Redirect('/');
    }
}