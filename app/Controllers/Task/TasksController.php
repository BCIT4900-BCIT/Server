<?php

namespace App\Controllers\Task;

use App\Models\User;
use App\Models\Task;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;

/**
 * The controller for the tasks actions.
 * 
 * @author Michael Navarro
 */
class TasksController extends Controller {

    /**
     * Retrieves data for task list and returns it 
     * with tasklist.twig.
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
    public function getTasksList($request, $response) {


        $data = Task::where('groupid', $_SESSION['user'])->orderBy('email')->orderBy('day')->orderBy('start')->get();
        $params = array('data' => $data);

        return $this->view->render($response, 'task/taskslist.twig', $params);
    }

    /**
     * Deletes task on button click and returns to tasklist.twig.
     * 
     * @param type $request
     * @param type $response
     * @return view
     */
    public function postTasksList($request, $response) {
        $email = $this->request->getParam('email');
        $description = $this->request->getParam('description');
        $start = $this->request->getParam('start');
        $end = $this->request->getParam('end');
        $day = $this->request->getParam('day');
        /*
          $description = $this->request->getParam('d');
          $task = Task::where('description', $description)->delete();
         */

        $task = Task::where('email', $email)->where('description', $description)->where('start', $start)->where('end', $end)->where('day', $day)->delete();

        $data = Task::where('groupid', $_SESSION['user'])->orderBy('email')->orderBy('description')->orderBy('day')->get();
        $params = array('data' => $data);

        return $this->view->render($response, 'task/taskslist.twig', $params);
    }

}
