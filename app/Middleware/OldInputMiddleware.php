<?php

namespace App\Middleware;

/**
 * Middleware for old data sessions.
 * 
 * @author Michael Navarro
 */
class OldInputMiddleware extends Middleware {

    /**
     * Adds an old global session variable to contain old form
     * data so that it persists after redirects.
     * 
     * @param type $request
     * @param type $response
     * @param type $next
     * @return $response
     */
    public function __invoke($request, $response, $next) {
        $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old'] ?? '');
        $_SESSION['old'] = $request->getParams();

        $response = $next($request, $response);
        return $response;
    }

}
