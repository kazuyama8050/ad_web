<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use App\Models\Admin\Admin;
use \Symfony\Component\HttpFoundation\Response;

class AdminAuthenticateRedirector extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        $path = explode('/', $request->path());
        if (end($path) == "login" && $request->session()->exists('adminId')) {
            http_response_code(Response::HTTP_FOUND);
            return redirect($_ENV['ADMIN_ROOT_PATH']."/home");
        }

        return $next($request);
    }
}
