<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Views\Twig as View;

/**
 * Controller for all home actions.
 * 
 * @author Michael Navarro
 */
class HomeController extends Controller {

    /*
     * Returns to home.twig.
     */
    public function index($request, $response) {
        return $this->view->render($response, 'Home.twig');
    }

}
