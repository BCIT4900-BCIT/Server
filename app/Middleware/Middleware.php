<?php

namespace App\Middleware;

 /**
 * Base middleware class.
 * 
 * @author Michael Navarro
 */
class Middleware {

    protected $container;

    /**
     * Adds middleware to $container.
     * 
     * @param type $container
     */
    public function __construct($container) {
        $this->container = $container;
    }

}
