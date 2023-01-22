<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use App\Models\Advertiser\Advertiser;
use \Symfony\Component\HttpFoundation\Response;

class AdvertiserAuthenticateRedirector extends Middleware
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
        if (end($path) == "login" && $request->session()->exists('advertiserId')) {
            http_response_code(Response::HTTP_FOUND);
            return redirect($_ENV['ADVERTISER_ROOT_PATH']."/home");
        }

        return $next($request);
    }
}
