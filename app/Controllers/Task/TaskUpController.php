<?php

namespace App\Controllers\Task;

use App\Models\User;
use App\Models\Task;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;

class TaskUpController extends Controller {

    public function getTaskUp($request, $response) {
        $data = $request->getParam('email');
        $params = array('data' => $data);
        return $this->view->render($response, 'task/taskup.twig', $params);
    }

    public function postTaskUp($request, $response) {

          $validation = $this->validator->validate($request, [
            'description' => v::notEmpty(),
            'start' => v::notEmpty()->max($request->getParam('end')),
            'end' => v::notEmpty(),
        ]);

          if ($validation->failed()) {
            $data = $request->getParam('email');
            $params = array('data' => $data);
            return $this->view->render($response, 'task/taskup.twig', $params);
        }

        $task = Task::create([
                    'email' => $request->getParam('email'),
                    'groupid' => $_SESSION['user'],
                    'description' => $request->getParam('description'),
                    'start' => $request->getParam('start'),
                    'end' => $request->getParam('end'),
                    'monday' => $request->getParam('monday'),
                    'tuesday' => $request->getParam('tuesday'),
                    'wednesday' => $request->getParam('wednesday'),
                    'thursday' => $request->getParam('thursday'),
                    'friday' => $request->getParam('friday'),
                    'saturday' => $request->getParam('saturday'),
                    'sunday' => $request->getParam('sunday'),
                    'alarm' => $request->getParam('alarm'),
        ]);

        return $response->withRedirect($this->router->pathFor('child.childlist'));
    }

}
