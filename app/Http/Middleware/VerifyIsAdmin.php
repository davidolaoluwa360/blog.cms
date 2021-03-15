<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\WebResponser;

class VerifyIsAdmin
{
    use WebResponser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->isAdmin()){
            return $next($request);
        }
        $this->flashMessage("info", "You are not Authorized to access the users, Please contact your administrator");
        return $this->redirectBack();
    }
}
