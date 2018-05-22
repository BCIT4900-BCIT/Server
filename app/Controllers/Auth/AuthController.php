<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

/**
 * The controller for the authentication actions.
 * 
 * @author Michael Navarro
 */
class AuthController extends Controller {

    /**
     * Signs out the current user and redirects
     * them to the home page.
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
    public function getSignOut($request, $response) {
        $this->auth->signout();

        return $response->withRedirect($this->router->pathFor('home'));
    }

    /**
     * Returns signin.twig.
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
    public function getSignIn($request, $response) {

        return $this->view->render($response, 'auth/signin.twig');
    }

    /**
     * Authenticates or denies a sign in attempt. Returns childlist.twig
     * upon success, or signin.twig on failure.
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
    public function postSignIn($request, $response) {
        $auth = $this->auth->attempt(
                $request->getParam('email'), $request->getParam('password'));

        if (!$auth) {
            $this->flash->addMessage('error', 'Failed');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }

        return $response->withRedirect($this->router->pathFor('child.childlist'));
    }

    /**
     * Returns signup.twig
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
    public function getSignUp($request, $response) {
        return $this->view->render($response, 'auth/signup.twig');
    }

    /**
     * Validates a signup form. If form contains valid inputs
     * it creates inserts a row into the user table, signs the user on
     * with the entered inputs, and redirects to the childlist.twig page.
     * If validation fails, it will redirect to the same page with
     * form error messages.
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
    public function postSignUp($request, $response) {
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        $user = User::create([
                    'email' => $request->getParam('email'),
                    'password' => $request->getParam('password'),
        ]);

        $this->flash->addMessage('info', 'Success');

        $this->auth->attempt($user->email, $request->getParam('password'));

        return $response->withRedirect($this->router->pathFor('child.childlist'));
    }

}
