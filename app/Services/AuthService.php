<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthService
{
    public function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role_id == 1) {
                return redirect()->intended('superadmin');
            } elseif ($user->role_id == 2) {
                return redirect()->intended('admin');
            }
            return back()->withError('Email or password invalid');
        }
        
        return back()->withError('Email or password invalid');
    }
}

?>