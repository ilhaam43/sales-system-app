<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class Authorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $auth = Auth::user();
        $user = User::with('usersRole')->where('role_id', $auth->role_id)->first();
        $user = json_decode($user, true);

        if($user['users_role']['role'] == $role){
            return $next($request);
        }

        return redirect('/')->with('error',"You don't have access");
    }
}
