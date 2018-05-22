<?php

namespace App\Middleware;

/**
 * Middleware for guest sessions.
 * 
 * @author Michael Navarro
 */
class GuestMiddleware extends Middleware {

    /**
     * Calls the auth class' check() function and returns home.twig
     * on success.
     * 
     * @param type $request
     * @param type $response
     * @param type $next
     * @return $response
     */
    public function __invoke($request, $response, $next) {
        if ($this->container->auth->check()) {
            return $response->withRedirect($this->container->router->pathFor('home'));
        }

        $response = $next($request, $response);
        return $response;
    }

}
