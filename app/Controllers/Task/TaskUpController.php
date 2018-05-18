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

        if ($request->getParam('monday'))
        {
            $task = Task::create([
                    'email' => $request->getParam('email'),
                    'groupid' => $_SESSION['user'],
                    'description' => $request->getParam('description'),
                    'start' => $request->getParam('start'),
                    'end' => $request->getParam('end'),
                    'day' => 0,
                    'alarm' => $request->getParam('alarm'),
            ]);
        }

        if ($request->getParam('tuesday'))
        {
            
            $task = Task::create([
                    'email' => $request->getParam('email'),
                    'groupid' => $_SESSION['user'],
                    'description' => $request->getParam('description'),
                    'start' => $request->getParam('start'),
                    'end' => $request->getParam('end'),
                    'day' => 1,
                    'alarm' => $request->getParam('alarm'),
        ]);
        }

        if ($request->getParam('wednesday'))
        {
            $task = Task::create([
                    'email' => $request->getParam('email'),
                    'groupid' => $_SESSION['user'],
                    'description' => $request->getParam('description'),
                    'start' => $request->getParam('start'),
                    'end' => $request->getParam('end'),
                    'day' => 2,
                    'alarm' => $request->getParam('alarm'),
        ]);
            
        }

        if ($request->getParam('thursday'))
        {
            $task = Task::create([
                    'email' => $request->getParam('email'),
                    'groupid' => $_SESSION['user'],
                    'description' => $request->getParam('description'),
                    'start' => $request->getParam('start'),
                    'end' => $request->getParam('end'),
                    'day' => 3,
                    'alarm' => $request->getParam('alarm'),
        ]);
            
        }

        if ($request->getParam('friday'))
        {
            $task = Task::create([
                    'email' => $request->getParam('email'),
                    'groupid' => $_SESSION['user'],
                    'description' => $request->getParam('description'),
                    'start' => $request->getParam('start'),
                    'end' => $request->getParam('end'),
                    'day' => 4,
                    'alarm' => $request->getParam('alarm'),
        ]);
            
        }

        if ($request->getParam('saturday'))
        {
            $task = Task::create([
                    'email' => $request->getParam('email'),
                    'groupid' => $_SESSION['user'],
                    'description' => $request->getParam('description'),
                    'start' => $request->getParam('start'),
                    'end' => $request->getParam('end'),
                    'day' => 5,
                    'alarm' => $request->getParam('alarm'),
            ]);
        }

        if ($request->getParam('sunday'))
        {
            $task = Task::create([
                    'email' => $request->getParam('email'),
                    'groupid' => $_SESSION['user'],
                    'description' => $request->getParam('description'),
                    'start' => $request->getParam('start'),
                    'end' => $request->getParam('end'),
                    'day' => 6,
                    'alarm' => $request->getParam('alarm'),
        ]);
            
        }


        return $response->withRedirect($this->router->pathFor('child.childlist'));
    }

}
