<?php

namespace App\Controllers\Task;

use App\Models\User;
use App\Models\Task;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;

class TasksController extends Controller {

    //Populate task list
    public function getTasksList($request, $response) {

        $email = $this->request->getParam('email');
        $data = Task::where('email', $email)->orderBy('start', 'ASC')->orderBy('end', 'ASC')->get();
        $params = array('data' => $data, 'email' => $email);

        return $this->view->render($response, 'task/taskslist.twig', $params);
    }

    public function postTasksList($request, $response) {
        $email = $this->request->getParam('email');
        $description = $this->request->getParam('description');
        $start = $this->request->getParam('start');
        $end = $this->request->getParam('end');
        /*
          $description = $this->request->getParam('d');
          $task = Task::where('description', $description)->delete();
         */

        $task = Task::where('email', $email)->where('description', $description)->where('start', $start)->where('end', $end)->delete();

        $data = Task::where('email', $email)->get();
        $params = array('data' => $data, 'email' => $email);

        return $this->view->render($response, 'task/taskslist.twig', $params);
    }

}
