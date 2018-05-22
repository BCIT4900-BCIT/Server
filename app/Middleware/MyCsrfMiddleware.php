<?php

namespace App\Middleware;

use Slim\Csrf\Guard;

/**
 * This class extends Csrf's Guard and was designed to allow
 * certain routes to bypass Csrf checks. This was the "hacky"
 * solution to allow REST API calls within the Slim application.
 * 
 * @author Michael Navarro
 */
class MyCsrfMiddleware extends Guard
{

    /**
     * On every request, checks if the route is an exempted route and
     * if so, returns the next callable in the chain. If not, continues on
     * with Csrf chain.
     * 
     * @param type $request
     * @param type $response
     * @param type $next
     * @return $response
     */
    public function processRequest($request, $response, $next) {

        $route = $request->getAttribute('route')->getName();

        if ($route == 'addtask' || $route == 'deletetask' || $route == 'deleteall' || $route == 'addall') {

            return $next($request, $response);
        } else {

            return $this($request, $response, $next);
        }
    }
}
