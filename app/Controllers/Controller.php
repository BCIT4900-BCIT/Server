<?php

namespace App\Controllers;

/**
 * Base controller class.
 * 
 * @author Michael Navarro
 */
class Controller {

    protected $container;

    /**
     * Constructor and sets in container.
     * 
     * @param type $container
     */
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * 
     * @param type $property
     * @return $property
     */
    public function __get($property) {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }

}
