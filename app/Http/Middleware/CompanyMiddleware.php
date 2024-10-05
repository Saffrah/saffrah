<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->tokenCan('role:company')) {
            return $next($request);
        }
        return response()->json([
            'response_code'    => 401, 
            'response_message' => 'This user type is Not Authorized for this action',
            'response_data'    => NULL
        ], 401);
    }
}
