<?php

namespace App\Controllers\Child;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;

class ChildController extends Controller {

    public function getChildUp($request, $response) {
        return $this->view->render($response, 'child/childup.twig');
    }

    public function postChildUp($request, $response) {
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('child.childup'));
        }

        $user = User::create([
                    'email' => $request->getParam('email'),
                    'groupid' => $_SESSION['user'],
                    'password' => $request->getParam('password'),
        ]);

        return $response->withRedirect($this->router->pathFor('child.childlist'));
    }

    public function getChildList($request, $response) {
        $data = User::where('groupid', $_SESSION['user'] ?? '')->get();
        $params = array('data' => $data);

        return $this->view->render($response, 'child/childlist.twig', $params);
    }

    public function postChildList($request, $response) {
        $email = $this->request->getParam('email');
        $user = User::where('email', $email)->delete();

        $data = User::where('groupid', $_SESSION['user'] ?? '')->get();
        $params = array('data' => $data);

        return $this->view->render($response, 'child/childlist.twig', $params);
    }

}
