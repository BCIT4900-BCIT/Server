<?php

namespace App\Controllers\Child;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;

/**
 * The controller for the child actions.
 * 
 * @author Michael Navarro
 */
class ChildController extends Controller {

    /**
     * Returns childup.twig
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
    public function getChildUp($request, $response) {
        return $this->view->render($response, 'child/childup.twig');
    }

    /**
     * Validates a child creation form and adds the child to the database
     * upon success, or redirects to the form page upon failure.
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
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

    /**
     * Returns childlist.twig
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
    public function getChildList($request, $response) {
        $data = User::where('groupid', $_SESSION['user'] ?? '')->get();
        $params = array('data' => $data);

        return $this->view->render($response, 'child/childlist.twig', $params);
    }

    /**
     * Deletes a child from the child list and refreshes
     * chidlist.twig.
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
    public function postChildList($request, $response) {
        $email = $this->request->getParam('email');
        $user = User::where('email', $email)->delete();

        $data = User::where('groupid', $_SESSION['user'] ?? '')->get();
        $params = array('data' => $data);

        return $this->view->render($response, 'child/childlist.twig', $params);
    }

}
