<?php

namespace App\Http\Middleware\Api;

use App\Classes\ApiResponse;
use Closure;

class StandardUser
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
        if(standard() == null) {
            return ApiResponse::error([
                'error' => 'This user is not a standard user'
            ], 'Unauthorized', 401);
        }
        return $next($request);
    }
}
