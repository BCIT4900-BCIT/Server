<?php

namespace App\Middleware;

use App\Models\User;

/**
 * Middleware for authentication.
 * 
 * @author Michael Navarro
 */
class AuthMiddleware extends Middleware {

    /**
     * Override of Middleware invoke method. Calls auth class check()
     * method and displays error Flash message and redirects to signin.twig
     * if check() fails. Returns $response if check() succeeds.
     * 
     * @param type $request
     * @param type $response
     * @param type $next
     * @return $response
     */
    public function __invoke($request, $response, $next) {
        if (!$this->container->auth->check()) {
            $this->container->flash->addMessage('error', 'Not signed in');
            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }

        $response = $next($request, $response);
        return $response;
    }

}
