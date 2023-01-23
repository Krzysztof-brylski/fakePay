<?php

namespace App\Http\Middleware;

use App\Models\Payments;
use Closure;
use Illuminate\Http\Request;

class PaymentPrivacy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
//        if(!$request->has('token')){
//            abort(403);
//        }
//        if(!Payments::find(['token'=>$request->token])){
//            abort(403);
//        }
        return $next($request);
    }
}
