<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller {

    public function getSignOut($request, $response) {
        $this->auth->signout();

        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getSignIn($request, $response) {

        return $this->view->render($response, 'auth/signin.twig');
    }

    public function postSignIn($request, $response) {
        $auth = $this->auth->attempt(
                $request->getParam('email'), $request->getParam('password'));

        if (!$auth) {
            $this->flash->addMessage('error', 'Failed');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }

        return $response->withRedirect($this->router->pathFor('child.childlist'));
    }

    public function getSignUp($request, $response) {
        return $this->view->render($response, 'auth/signup.twig');
    }

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
