<?php

namespace App\Middleware;

/**
 * Middleware for cross-site request forgery library.
 * 
 * @author Michael Navarro
 */
class CsrfViewMiddleware extends Middleware {

    /**
     * Adds global variables for token name and value to be used in
     * forms.
     * 
     * @param type $request
     * @param type $response
     * @param type $next
     * @return $response
     */
    public function __invoke($request, $response, $next) {
        $this->container->view->getEnvironment()->addGlobal('csrf', [
            'field' => ' 
                        <input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" value="' . $this->container->csrf->getTokenName() . '">
                        <input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" value="' . $this->container->csrf->getTokenValue() . '">
                    ',
        ]);

        $response = $next($request, $response);
        return $response;
    }

}
