<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use App\Models\User\User;
use \Symfony\Component\HttpFoundation\Response;

class DelivelerAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        if (!session()->exists('user')) {
            $this->redirectLoginPage();
        }
        $sessionUser = session()->get('user');
        if (empty($sessionUser->getId()) || empty($sessionUser->getEmail()) || 
            empty($sessionUser->getLastName())|| empty($sessionUser->getFirstName())) {

            $this->redirectLoginPage();
        }

        return $next($request);
    }

    private function redirectLoginPage() {
        session()->flush();
        http_response_code(Response::HTTP_UNAUTHORIZED);
        header( "Location: /deliveler/login" );
        exit();
    }
}
