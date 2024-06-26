<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use App\Models\User\User;
use \Symfony\Component\HttpFoundation\Response;

class UserAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->exists('userId') && $request->session()->exists('userEmail')) {
            $request->merge(['userId' => $request->session()->get('userId')]);
            $request->merge(['userEmail' => $request->session()->get('userEmail')]);

            return $next($request);
        }

        http_response_code(Response::HTTP_UNAUTHORIZED);
        return redirect($_ENV['USER_ROOT_PATH']."/login");        
    }
}
