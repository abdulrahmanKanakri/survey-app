<?php

namespace App\Http\Middleware\Api;

use App\Classes\ApiResponse;
use Closure;

class Employee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(employee() == null) {
            return ApiResponse::error([
                'error' => 'This user is not an employee'
            ], 'Unauthorized', 401);
        }
        return $next($request);
    }
}
