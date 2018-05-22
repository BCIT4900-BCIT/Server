<?php

namespace App\Middleware;

/**
 * Middleware for validation.
 * 
 * @author Michael Navarro
 */
class ValidationErrorsMiddleware extends Middleware {

    /**
     * Adds a global session errors variable to be used in .twig forms to display
     * input errors.
     * 
     * @param type $request
     * @param type $response
     * @param type $next
     * @return $response
     */
    public function __invoke($request, $response, $next) {
        // ?? used here, worked
        $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors'] ?? '');
        unset($_SESSION['errors']);

        $response = $next($request, $response);
        return $response;
    }

}
