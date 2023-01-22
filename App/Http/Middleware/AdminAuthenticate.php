<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use App\Models\Admin\Admin;
use \Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists('adminId')) {
            session()->flush();
            http_response_code(Response::HTTP_UNAUTHORIZED);
            return redirect($_ENV['ADMIN_ROOT_PATH']."/login");
        }

        return $next($request);
    }
}
